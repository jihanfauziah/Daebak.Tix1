<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Order;
use App\Models\SellerProfile;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalBuyers = User::where('role', 'pembeli')->count();
        $totalSellers = User::where('role', 'penjual')->count();
        
        $activeTicketsCount = Ticket::where('status', 'valid')->count();
        $usedTicketsCount = Ticket::where('status', 'used')->count();
        $totalEventsCount = Event::count();

        $recentSellers = SellerProfile::with('user')->latest()->take(5)->get();
        $recentOrders = Order::with(['buyer', 'event'])->latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalSales' => (float) $totalSales,
                'totalOrders' => $totalOrders,
                'totalBuyers' => $totalBuyers,
                'totalSellers' => $totalSellers,
                'activeTickets' => $activeTicketsCount,
                'usedTickets' => $usedTicketsCount,
                'totalEvents' => $totalEventsCount,
            ],
            'recentSellers' => $recentSellers,
            'recentOrders' => $recentOrders,
            'recentLogs' => $recentLogs,
        ]);
    }

    public function sellers()
    {
        $sellers = SellerProfile::with(['user', 'user.events'])->latest()->get();
        return Inertia::render('Admin/Sellers', [
            'sellers' => $sellers,
        ]);
    }

    public function generateSellerAccount(Request $request)
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_email' => ['required', 'email', 'unique:users,email', 'unique:seller_profiles,store_email'],
            'owner_name' => ['required', 'string', 'max:255'],
        ]);

        $defaultPassword = 'Password123!';
        $accountCode = 'SELLER-' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['store_email'],
            'password' => Hash::make($defaultPassword),
            'role' => 'penjual',
            'status' => 'active',
        ]);

        $sellerProfile = SellerProfile::create([
            'user_id' => $user->id,
            'store_name' => $validated['store_name'],
            'store_email' => $validated['store_email'],
            'store_email_password' => $defaultPassword,
            'account_code' => $accountCode,
            'status' => 'approved',
            'subscription_type' => 'none',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'role' => 'admin',
            'action' => 'generate_seller',
            'description' => "Generated seller account code {$accountCode} for {$validated['store_name']}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Akun Penjual Berhasil Dibuat!\nEmail: {$validated['store_email']}\nPassword Default: {$defaultPassword}\nKode Akun: {$accountCode}");
    }

    public function updateSellerStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected,pending']);
        $seller = SellerProfile::findOrFail($id);
        $seller->update(['status' => $request->status]);

        return back()->with('success', 'Status penjual berhasil diperbarui.');
    }

    public function buyers()
    {
        $buyers = User::where('role', 'pembeli')->withCount('orders')->latest()->get();
        return Inertia::render('Admin/Buyers', [
            'buyers' => $buyers,
        ]);
    }

    public function events()
    {
        $events = Event::with(['seller.sellerProfile', 'categories', 'tickets'])->latest()->get();
        return Inertia::render('Admin/Events', [
            'events' => $events,
        ]);
    }

    public function transactions()
    {
        $transactions = Order::with(['buyer', 'seller.sellerProfile', 'event', 'tickets'])->latest()->get();
        return Inertia::render('Admin/Transactions', [
            'transactions' => $transactions,
        ]);
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        return Inertia::render('Admin/Logs', [
            'logs' => $logs,
        ]);
    }

    public function reports()
    {
        $reports = [
            'salesByMonth' => Order::selectRaw('MONTHNAME(created_at) as month, SUM(total_amount) as total')
                ->where('payment_status', 'paid')
                ->groupBy('month')
                ->get(),
            'ticketsCategoryDistribution' => Ticket::selectRaw('ticket_category_id, count(*) as total')
                ->groupBy('ticket_category_id')
                ->with('category')
                ->get(),
        ];

        return Inertia::render('Admin/Reports', [
            'reports' => $reports,
        ]);
    }

    public function settings()
    {
        return Inertia::render('Admin/Settings');
    }
}
