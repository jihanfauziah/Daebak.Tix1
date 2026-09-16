<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-DUMMYKEY123456'));
        
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        // Verify SHA512 signature
        $expectedSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey && $signatureKey !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 444);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'challenge') {
                $order->update(['payment_status' => 'pending']);
            } else {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => $request->input('payment_type', 'midtrans_sandbox'),
                ]);

                // Award buyer loyalty points
                if ($order->buyer) {
                    $points = (int) floor($order->total_amount / 10000);
                    $order->buyer->increment('loyalty_points', $points);
                }
            }
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $order->update(['payment_status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['payment_status' => 'pending']);
        }

        ActivityLog::create([
            'user_id' => $order->user_id,
            'role' => 'pembeli',
            'action' => 'webhook_callback',
            'description' => "Midtrans webhook callback for order {$orderId}: {$transactionStatus}",
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Webhook processed']);
    }
}
