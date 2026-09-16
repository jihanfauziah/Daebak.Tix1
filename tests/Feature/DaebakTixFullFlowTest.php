<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Order;
use App\Models\SellerProfile;
use App\Models\StaffAccount;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DaebakTixFullFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_page_loads_normally()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_invalid_credentials_returns_indonesian_error()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(
            'Email atau password salah.',
            session('errors')->get('email')[0]
        );
    }

    public function test_buyer_login_redirects_to_buyer_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'buyer@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_seller_login_redirects_to_seller_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'seller@kpopmaster.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/seller/dashboard');
    }

    public function test_admin_login_redirects_to_admin_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'admin@daebaktix.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_staff_login_redirects_to_staff_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'staff@kpopmaster.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/staff/dashboard');
    }

    public function test_unauthenticated_access_to_dashboard_redirects_to_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response2 = $this->get('/seller/dashboard');
        $response2->assertRedirect('/login');
    }

    public function test_buyer_cannot_access_admin_dashboard()
    {
        $buyer = User::where('role', 'pembeli')->first();
        $response = $this->actingAs($buyer)->get('/admin/dashboard');
        $response->assertRedirect('/dashboard');
    }

    public function test_checkout_midtrans_simulation_qr_generation_and_staff_scan_flow()
    {
        $buyer = User::where('role', 'pembeli')->first();
        $event = Event::first();
        $category = TicketCategory::where('event_id', $event->id)->first();

        // 1. Buyer Checkout
        $checkoutResponse = $this->actingAs($buyer)->post('/checkout', [
            'event_id' => $event->id,
            'category_id' => $category->id,
            'quantity' => 1,
        ]);

        $order = Order::where('user_id', $buyer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->payment_status);

        // 2. Simulate Payment Success
        $paymentResponse = $this->actingAs($buyer)->post("/orders/{$order->id}/simulate-payment", [
            'payment_method' => 'QRIS Sandbox',
        ]);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);

        // 3. Verify Generated Digital Ticket & QR Code
        $ticket = Ticket::where('order_id', $order->id)->first();
        $this->assertNotNull($ticket);
        $this->assertNotEmpty($ticket->ticket_code);
        $this->assertNotEmpty($ticket->qr_code_svg);
        $this->assertEquals('valid', $ticket->status);

        // 4. Staff Scans Ticket First Time -> Valid ✅
        $staffUser = User::where('role', 'staf')->first();
        $scanResponse1 = $this->actingAs($staffUser)->postJson('/staff/scan/validate', [
            'ticket_code' => $ticket->ticket_code,
            'event_id' => $event->id,
        ]);

        $scanResponse1->assertJson([
            'status' => 'success',
        ]);
        $this->assertStringContainsString('Tiket Valid', $scanResponse1->json('message'));

        $ticket->refresh();
        $this->assertEquals('used', $ticket->status);

        // 5. Staff Scans Ticket Second Time -> Blocked / Already Used ❌
        $scanResponse2 = $this->actingAs($staffUser)->postJson('/staff/scan/validate', [
            'ticket_code' => $ticket->ticket_code,
            'event_id' => $event->id,
        ]);

        $scanResponse2->assertJson([
            'status' => 'warning',
        ]);
        $this->assertStringContainsString('sudah digunakan', $scanResponse2->json('message'));
    }

    public function test_staff_cannot_scan_ticket_of_another_seller()
    {
        $otherSeller = User::create([
            'name' => 'Other Seller',
            'email' => 'otherseller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
        ]);

        $otherEvent = Event::create([
            'seller_id' => $otherSeller->id,
            'title' => 'Other Seller Concert',
            'slug' => 'other-seller-concert',
            'status' => 'active',
        ]);

        $otherCat = TicketCategory::create([
            'event_id' => $otherEvent->id,
            'name' => 'CAT 1',
            'price' => 1000000,
            'quota' => 10,
            'available_quota' => 10,
        ]);

        $buyer = User::where('role', 'pembeli')->first();
        $order = Order::create([
            'order_number' => 'DBK-OTHER-001',
            'user_id' => $buyer->id,
            'seller_id' => $otherSeller->id,
            'event_id' => $otherEvent->id,
            'total_amount' => 1000000,
            'payment_status' => 'paid',
        ]);

        $ticket = Ticket::create([
            'order_id' => $order->id,
            'user_id' => $buyer->id,
            'event_id' => $otherEvent->id,
            'ticket_category_id' => $otherCat->id,
            'ticket_code' => 'TIX-OTHER-SELLER',
            'status' => 'valid',
        ]);

        // Staff of K-Events ID tries to scan Other Seller's ticket
        $staffUser = User::where('role', 'staf')->first();
        $scanResponse = $this->actingAs($staffUser)->postJson('/staff/scan/validate', [
            'ticket_code' => $ticket->ticket_code,
        ]);

        $scanResponse->assertJson([
            'status' => 'error',
        ]);
        $this->assertStringContainsString('Bukan milik event dari seller ini', $scanResponse->json('message'));
    }
}
