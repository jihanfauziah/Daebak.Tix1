<?php

use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/payment/callback', [PaymentCallbackController::class, 'handleCallback']);
