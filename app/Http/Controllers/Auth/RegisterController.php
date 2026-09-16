<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function showBuyerRegisterForm()
    {
        return Inertia::render('Auth/RegisterBuyer');
    }

    public function registerBuyer(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['required', 'integer', 'min:12', 'max:100'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,other'],
        ]);

        $user = User::create([
            'nik' => $validated['nik'],
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pembeli',
            'age' => $validated['age'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'status' => 'active',
            'loyalty_points' => 10, // Initial bonus points
        ]);

        Auth::login($user);

        ActivityLog::create([
            'user_id' => $user->id,
            'role' => 'pembeli',
            'action' => 'register',
            'description' => 'New buyer account registered',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('buyer.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Daebak.Tix.');
    }

    public function showSellerRegisterForm()
    {
        return Inertia::render('Auth/RegisterSeller');
    }

    public function registerSeller(Request $request)
    {
        // 3-Step Onboarding validation
        $validated = $request->validate([
            // Step 1: Data Diri Owner
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:17'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,other'],
            
            // Step 2: Data Toko
            'store_name' => ['required', 'string', 'max:255'],
            'store_description' => ['required', 'string'],
            'store_address' => ['required', 'string'],
            'store_email' => ['required', 'email', 'unique:seller_profiles,store_email'],
            'store_email_password' => ['required', 'string', 'min:8'],
            
            // Step 3: Verification & Terms
            'terms' => ['accepted'],
        ]);

        $accountCode = 'SELLER-' . strtoupper(Str::random(6));

        // Create Seller Owner User Account
        $user = User::create([
            'nik' => $validated['nik'],
            'name' => $validated['name'],
            'username' => strtolower(Str::slug($validated['store_name'])) . '_' . rand(100, 999),
            'email' => $validated['store_email'],
            'password' => Hash::make($validated['store_email_password']),
            'role' => 'penjual',
            'age' => $validated['age'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'status' => 'active', // Approved by admin code verification
        ]);

        // Create Seller Profile
        SellerProfile::create([
            'user_id' => $user->id,
            'store_name' => $validated['store_name'],
            'store_description' => $validated['store_description'],
            'store_address' => $validated['store_address'],
            'store_email' => $validated['store_email'],
            'store_email_password' => $validated['store_email_password'],
            'account_code' => $accountCode,
            'status' => 'approved',
            'subscription_type' => 'none',
        ]);

        Auth::login($user);

        ActivityLog::create([
            'user_id' => $user->id,
            'role' => 'penjual',
            'action' => 'seller_register',
            'description' => "New seller store '{$validated['store_name']}' registered",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('seller.dashboard')->with('success', "Toko {$validated['store_name']} berhasil didaftarkan! Kode akun Anda: {$accountCode}");
    }
}
