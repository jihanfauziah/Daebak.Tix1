<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Order;
use App\Models\SellerProfile;
use App\Models\StaffAccount;
use App\Models\Subscription;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();

        $totalSales = Order::where('seller_id', $seller->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $totalOrders = Order::where('seller_id', $seller->id)->count();
        
        $myEvents = Event::where('seller_id', $seller->id)
            ->with(['categories', 'tickets'])
            ->latest()
            ->get();

        $staffAccounts = StaffAccount::where('seller_id', $seller->id)->with('user')->get();

        return Inertia::render('Seller/Dashboard', [
            'profile' => $profile,
            'stats' => [
                'totalSales' => (float) $totalSales,
                'totalOrders' => $totalOrders,
                'activeEvents' => $myEvents->where('status', 'active')->count(),
                'totalStaff' => $staffAccounts->count(),
            ],
            'myEvents' => $myEvents,
            'staffAccounts' => $staffAccounts,
        ]);
    }

    public function events()
    {
        $seller = Auth::user();
        $events = Event::where('seller_id', $seller->id)->with('categories')->latest()->get();
        return Inertia::render('Seller/Events/Index', [
            'events' => $events,
        ]);
    }

    public function createEventForm()
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();

        return Inertia::render('Seller/Events/Create', [
            'subscription' => $profile,
        ]);
    }

    public function storeEvent(Request $request)
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:concert,fanmeeting,cultural,other'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'banner_image' => ['nullable', 'string'],
            'initial_duration_days' => ['required', 'in:7,12'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*.name' => ['required', 'string'],
            'categories.*.price' => ['required', 'numeric', 'min:10000'],
            'categories.*.quota' => ['required', 'integer', 'min:1'],
        ]);

        // Expiry date computation
        $expiresAt = now()->addDays((int) $validated['initial_duration_days']);

        $event = Event::create([
            'seller_id' => $seller->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(1000, 9999),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'banner_image' => $validated['banner_image'] ?? 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&q=80',
            'duration_days' => (int) $validated['initial_duration_days'],
            'status' => 'active',
            'expires_at' => $expiresAt,
        ]);

        foreach ($validated['categories'] as $cat) {
            TicketCategory::create([
                'event_id' => $event->id,
                'name' => $cat['name'],
                'price' => $cat['price'],
                'quota' => $cat['quota'],
                'available_quota' => $cat['quota'],
                'description' => $cat['description'] ?? null,
            ]);
        }

        ActivityLog::create([
            'user_id' => $seller->id,
            'role' => 'penjual',
            'action' => 'create_event',
            'description' => "Created event '{$event->title}' for {$validated['initial_duration_days']} days",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('seller.events')->with('success', "Event '{$event->title}' berhasil dibuat dan dipublikasikan!");
    }

    public function extendEvent(Request $request, $id)
    {
        $validated = $request->validate([
            'extension_days' => ['required', 'in:5,7'],
        ]);

        $event = Event::where('seller_id', Auth::id())->findOrFail($id);
        $days = (int) $validated['extension_days'];

        $event->expires_at = ($event->expires_at && $event->expires_at->isFuture() ? $event->expires_at : now())->addDays($days);
        $event->extension_days += $days;
        $event->status = 'active';
        $event->save();

        return back()->with('success', "Durasi event berhasil diperpanjang {$days} hari!");
    }

    public function subscription()
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();
        $history = Subscription::where('seller_id', $seller->id)->latest()->get();

        return Inertia::render('Seller/Subscription', [
            'profile' => $profile,
            'history' => $history,
        ]);
    }

    public function purchaseSubscription(Request $request)
    {
        $validated = $request->validate([
            'package' => ['required', 'in:paid_1m,paid_3m,free_per_event'],
        ]);

        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();

        if ($validated['package'] === 'paid_1m') {
            $profile->subscription_type = 'paid_1m';
            $profile->subscription_expires_at = now()->addMonth();
            $price = 499000;
        } elseif ($validated['package'] === 'paid_3m') {
            $profile->subscription_type = 'paid_3m';
            $profile->subscription_expires_at = now()->addMonths(3);
            $price = 1299000;
        } else {
            $profile->subscription_type = 'free';
            $profile->subscription_expires_at = null;
            $price = 0;
        }

        $profile->save();

        Subscription::create([
            'seller_id' => $seller->id,
            'package_name' => $validated['package'],
            'price' => $price,
            'duration_months' => str_contains($validated['package'], '1m') ? 1 : (str_contains($validated['package'], '3m') ? 3 : 0),
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => $profile->subscription_expires_at,
        ]);

        return back()->with('success', 'Paket langganan berhasil diperbarui!');
    }

    public function staff()
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();
        $staffAccounts = StaffAccount::where('seller_id', $seller->id)->with('user')->get();

        return Inertia::render('Seller/Staff', [
            'profile' => $profile,
            'staffAccounts' => $staffAccounts,
        ]);
    }

    public function createStaffAccount(Request $request)
    {
        $seller = Auth::user();
        $profile = SellerProfile::where('user_id', $seller->id)->first();

        $validated = $request->validate([
            'staff_name' => ['required', 'string', 'max:255'],
        ]);

        // Staff login uses the SAME store credentials (store_email, store_email_password, account_code)
        // We create a staff user record linked to seller_id
        $staffUser = User::create([
            'name' => $validated['staff_name'],
            'email' => strtolower(Str::slug($validated['staff_name'])) . '_' . rand(100, 999) . '@staff.' . $profile->store_email,
            'password' => Hash::make($profile->store_email_password ?? 'StaffPassword123'),
            'role' => 'staf',
            'status' => 'active',
        ]);

        StaffAccount::create([
            'seller_id' => $seller->id,
            'user_id' => $staffUser->id,
            'created_by_seller_id' => $seller->id,
        ]);

        return back()->with('success', "Akun Staf '{$validated['staff_name']}' berhasil dibuat! Staf dapat login PWA menggunakan Email Toko: {$profile->store_email} & Kode Akun: {$profile->account_code}");
    }

    public function orders()
    {
        $orders = Order::where('seller_id', Auth::id())->with(['buyer', 'event', 'tickets'])->latest()->get();
        return Inertia::render('Seller/Orders', [
            'orders' => $orders,
        ]);
    }

    public function profile()
    {
        $profile = SellerProfile::where('user_id', Auth::id())->with('user')->first();
        return Inertia::render('Seller/Profile', [
            'profile' => $profile,
        ]);
    }

    public function settings()
    {
        return Inertia::render('Seller/Settings');
    }
}
