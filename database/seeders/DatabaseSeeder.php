<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Order;
use App\Models\SellerProfile;
use App\Models\StaffAccount;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        $admin = User::create([
            'nik' => '3171010000000001',
            'name' => 'Admin Daebak.Tix',
            'username' => 'admin_daebak',
            'email' => 'admin@daebaktix.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'age' => 28,
            'dob' => '1998-05-12',
            'gender' => 'male',
            'status' => 'active',
        ]);

        // 2. Seller Account
        $sellerUser = User::create([
            'nik' => '3171020000000002',
            'name' => 'Park Min Young (K-Events ID)',
            'username' => 'kevents_official',
            'email' => 'seller@kpopmaster.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
            'age' => 32,
            'dob' => '1994-03-22',
            'gender' => 'female',
            'status' => 'active',
        ]);

        $sellerProfile = SellerProfile::create([
            'user_id' => $sellerUser->id,
            'store_name' => 'K-Events Indonesia Official',
            'store_description' => 'Promotor Resmi Konser & Fanmeeting K-Pop Terpercaya di Indonesia',
            'store_address' => 'Gedung Wisma K-Culture Lt. 5, Jl. Jend. Sudirman, Jakarta Selatan',
            'store_email' => 'seller@kpopmaster.com',
            'store_email_password' => 'password',
            'account_code' => 'SELLER-KPOP01',
            'status' => 'approved',
            'subscription_type' => 'paid_1m',
            'subscription_expires_at' => now()->addMonth(),
        ]);

        // 3. Staff Account
        $staffUser = User::create([
            'name' => 'Staff Gate 1 (K-Events)',
            'email' => 'staff@kpopmaster.com',
            'password' => Hash::make('password'),
            'role' => 'staf',
            'status' => 'active',
        ]);

        StaffAccount::create([
            'seller_id' => $sellerUser->id,
            'user_id' => $staffUser->id,
            'created_by_seller_id' => $sellerUser->id,
        ]);

        // 4. Buyer Account
        $buyer = User::create([
            'nik' => '3171030000000003',
            'name' => 'Jihan Fauziah',
            'username' => 'jihan_fauziah',
            'email' => 'buyer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'age' => 22,
            'dob' => '2004-08-15',
            'gender' => 'female',
            'status' => 'active',
            'loyalty_points' => 150,
        ]);

        // Sample Korean Events
        $event1 = Event::create([
            'seller_id' => $sellerUser->id,
            'title' => 'BLACKPINK WORLD TOUR [BORN PINK] JAKARTA',
            'slug' => 'blackpink-world-tour-born-pink-jakarta',
            'category' => 'concert',
            'description' => 'Konser megah girl group K-Pop terbesar di Stadion Utama Gelora Bung Karno Jakarta! Rasakan sensasi panggung spektakuler BORN PINK.',
            'location' => 'Stadion Utama Gelora Bung Karno (GBK), Jakarta',
            'event_date' => now()->addDays(20),
            'banner_image' => 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=1200&q=80',
            'duration_days' => 15,
            'status' => 'active',
            'expires_at' => now()->addDays(15),
        ]);

        $cat1 = TicketCategory::create([
            'event_id' => $event1->id,
            'name' => 'VIP Soundcheck (Seating)',
            'price' => 3800000,
            'quota' => 500,
            'available_quota' => 495,
            'description' => 'Termasuk akses Soundcheck, Lanyard VIP, Layanan Jalur Khusus Merchandise.',
        ]);

        $cat2 = TicketCategory::create([
            'event_id' => $event1->id,
            'name' => 'CAT 1 (Standing)',
            'price' => 2400000,
            'quota' => 1000,
            'available_quota' => 998,
            'description' => 'Area festival dekat panggung utama.',
        ]);

        $event2 = Event::create([
            'seller_id' => $sellerUser->id,
            'title' => '2026 NCT 127 FANMEETING IN JAKARTA : HOME PARTY',
            'slug' => 'nct-127-fanmeeting-jakarta-home-party',
            'category' => 'fanmeeting',
            'description' => 'Fanmeeting eksklusif bareng NCT 127! Games seru, hi-touch, photo session, dan penampilan lagu-lagu hits terpilih.',
            'location' => 'Indonesia Convention Exhibition (ICE BSD) Hall 5-6',
            'event_date' => now()->addDays(35),
            'banner_image' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?w=1200&q=80',
            'duration_days' => 12,
            'status' => 'active',
            'expires_at' => now()->addDays(12),
        ]);

        TicketCategory::create([
            'event_id' => $event2->id,
            'name' => 'ROYAL PASS (Hi-Touch + Photo)',
            'price' => 2900000,
            'quota' => 300,
            'available_quota' => 300,
            'description' => 'Termasuk sesi Hi-Touch dan Foto Grup bersama member NCT 127.',
        ]);

        // Sample Completed Order for Buyer
        $order = Order::create([
            'order_number' => 'DBK-20260916-888',
            'user_id' => $buyer->id,
            'seller_id' => $sellerUser->id,
            'event_id' => $event1->id,
            'total_amount' => 3800000,
            'payment_status' => 'paid',
            'payment_method' => 'QRIS Sandbox',
            'paid_at' => now(),
        ]);

        $ticketCode = 'TIX-BP-VIP-9901';
        $qrSvg = QrCode::size(250)
            ->color(101, 113, 102)
            ->margin(1)
            ->generate($ticketCode);

        Ticket::create([
            'order_id' => $order->id,
            'user_id' => $buyer->id,
            'event_id' => $event1->id,
            'ticket_category_id' => $cat1->id,
            'ticket_code' => $ticketCode,
            'qr_code_svg' => (string) $qrSvg,
            'status' => 'valid',
        ]);
    }
}
