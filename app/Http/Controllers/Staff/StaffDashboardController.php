<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\SellerProfile;
use App\Models\StaffAccount;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffUser = Auth::user();
        
        // Find staff account mapping to seller
        $staffAccount = StaffAccount::where('user_id', $staffUser->id)->first();
        $sellerId = $staffAccount ? $staffAccount->seller_id : $staffUser->id;

        // Get seller profile
        $sellerProfile = SellerProfile::where('user_id', $sellerId)->first();

        // Get active events belonging ONLY to this seller
        $events = Event::where('seller_id', $sellerId)
            ->where('status', 'active')
            ->get();

        // Get count of scanned tickets for this staff/seller
        $scannedCount = Ticket::whereHas('event', function($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })->where('status', 'used')->count();

        return Inertia::render('Staff/Dashboard', [
            'staffUser' => $staffUser,
            'sellerProfile' => $sellerProfile,
            'events' => $events,
            'scannedCount' => $scannedCount,
        ]);
    }

    public function validateTicket(Request $request)
    {
        $validated = $request->validate([
            'ticket_code' => ['required', 'string'],
            'event_id' => ['nullable', 'exists:events,id'],
        ]);

        $staffUser = Auth::user();
        $staffAccount = StaffAccount::where('user_id', $staffUser->id)->first();
        $sellerId = $staffAccount ? $staffAccount->seller_id : $staffUser->id;

        $ticket = Ticket::where('ticket_code', $validated['ticket_code'])
            ->with(['event', 'category', 'buyer'])
            ->first();

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket tidak valid / Kode tidak ditemukan ❌',
                'ticket' => null,
            ]);
        }

        // Scope check: must belong to this staff's seller!
        if ($ticket->event->seller_id != $sellerId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket tidak valid (Bukan milik event dari seller ini) ❌',
                'ticket' => null,
            ]);
        }

        // Check if ticket is already used
        if ($ticket->status === 'used' || $ticket->used_at !== null) {
            return response()->json([
                'status' => 'warning',
                'message' => "Tiket sudah digunakan pada {$ticket->used_at->format('d M Y H:i')} ❌",
                'ticket' => $ticket,
            ]);
        }

        // Update ticket to used
        $ticket->update([
            'status' => 'used',
            'scanned_by_staff_id' => $staffUser->id,
            'used_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => $staffUser->id,
            'role' => 'staf',
            'action' => 'scan_ticket',
            'description' => "Scanned valid ticket {$ticket->ticket_code} for event {$ticket->event->title}",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tiket Valid ✅ Selamat menikmati acara!',
            'ticket' => $ticket->fresh(['event', 'category', 'buyer']),
        ]);
    }
}
