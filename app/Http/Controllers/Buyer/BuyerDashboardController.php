<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myOrdersCount = Order::where('user_id', $user->id)->count();
        $myTicketsCount = Ticket::where('user_id', $user->id)->count();
        $wishlistsCount = Wishlist::where('user_id', $user->id)->count();

        $featuredEvents = Event::where('status', 'active')
            ->with(['seller.sellerProfile', 'categories'])
            ->latest()
            ->take(6)
            ->get();

        $myRecentTickets = Ticket::where('user_id', $user->id)
            ->with(['event', 'category'])
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('Buyer/Dashboard', [
            'user' => $user,
            'stats' => [
                'myOrders' => $myOrdersCount,
                'myTickets' => $myTicketsCount,
                'wishlists' => $wishlistsCount,
                'loyaltyPoints' => $user->loyalty_points,
            ],
            'featuredEvents' => $featuredEvents,
            'myRecentTickets' => $myRecentTickets,
        ]);
    }

    public function tickets(Request $request)
    {
        $query = Event::where('status', 'active')->with(['seller.sellerProfile', 'categories']);

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $events = $query->latest()->get();

        return Inertia::render('Buyer/Tickets/Index', [
            'events' => $events,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function showEvent($slug)
    {
        $event = Event::where('slug', $slug)
            ->with(['seller.sellerProfile', 'categories'])
            ->firstOrFail();

        $isWishlisted = Auth::check() ? Wishlist::where('user_id', Auth::id())->where('event_id', $event->id)->exists() : false;

        return Inertia::render('Buyer/Tickets/Show', [
            'event' => $event,
            'isWishlisted' => $isWishlisted,
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'category_id' => ['required', 'exists:ticket_categories,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:4'], // Limit per event
        ]);

        $event = Event::findOrFail($validated['event_id']);
        $category = TicketCategory::findOrFail($validated['category_id']);

        if ($category->available_quota < $validated['quantity']) {
            return back()->with('error', 'Maaf, kuota tiket untuk kategori ini telah habis.');
        }

        $totalAmount = $category->price * $validated['quantity'];
        $orderNumber = 'DBK-' . date('YmdHis') . '-' . rand(100, 999);

        // Configure Midtrans parameters
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-DUMMYKEY123456'));
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderNumber,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $category->id,
                    'price' => (int) $category->price,
                    'quantity' => $validated['quantity'],
                    'name' => substr($event->title . ' - ' . $category->name, 0, 50),
                ]
            ]
        ];

        $snapToken = null;
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Fallback token for simulator mode testing
            $snapToken = 'SIMULATED-SNAP-TOKEN-' . Str::random(20);
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'seller_id' => $event->seller_id,
            'event_id' => $event->id,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        // Decrement available quota
        $category->decrement('available_quota', $validated['quantity']);

        // Generate tickets for the order
        for ($i = 0; $i < $validated['quantity']; $i++) {
            $ticketCode = 'TIX-' . strtoupper(Str::random(10));

            // Generate QR Code SVG string
            $qrSvg = QrCode::size(250)
                ->color(101, 113, 102)
                ->margin(1)
                ->generate($ticketCode);

            Ticket::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'ticket_category_id' => $category->id,
                'ticket_code' => $ticketCode,
                'qr_code_svg' => (string) $qrSvg,
                'status' => 'valid',
            ]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'pembeli',
            'action' => 'checkout',
            'description' => "Created order {$orderNumber} for event {$event->title}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan tuntaskan pembayaran.');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['event', 'tickets.category', 'seller.sellerProfile'])
            ->latest()
            ->get();

        return Inertia::render('Buyer/Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function showOrder($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['event', 'tickets.category', 'seller.sellerProfile'])
            ->findOrFail($id);

        return Inertia::render('Buyer/Orders/Show', [
            'order' => $order,
            'midtransClientKey' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-DUMMYKEY123456'),
        ]);
    }

    public function simulatePaymentSuccess(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->payment_status === 'pending') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'payment_method' => $request->input('payment_method', 'QRIS Sandbox'),
            ]);

            // Award loyalty points (10% of purchase)
            $points = (int) floor($order->total_amount / 10000);
            Auth::user()->increment('loyalty_points', $points);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'role' => 'pembeli',
                'action' => 'payment_success',
                'description' => "Simulated payment success for order {$order->order_number}",
                'ip_address' => $request->ip(),
            ]);
        }

        return back()->with('success', 'Pembayaran Berhasil! Tiket digital dengan QR code telah aktif.');
    }

    public function myTickets()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->with(['event', 'category', 'order'])
            ->latest()
            ->get();

        return Inertia::render('Buyer/MyTickets', [
            'tickets' => $tickets,
        ]);
    }

    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with(['event.seller.sellerProfile', 'event.categories'])
            ->latest()
            ->get();

        return Inertia::render('Buyer/Wishlist', [
            'wishlists' => $wishlists,
        ]);
    }

    public function toggleWishlist(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
        ]);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Dihapus dari wishlist.');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'event_id' => $validated['event_id'],
            ]);
            return back()->with('success', 'Ditambahkan ke wishlist!');
        }
    }

    public function loyalty()
    {
        $user = Auth::user();
        return Inertia::render('Buyer/Loyalty', [
            'user' => $user,
        ]);
    }

    public function profile()
    {
        return Inertia::render('Buyer/Profile', [
            'user' => Auth::user(),
        ]);
    }
}
