<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RazorpayController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay');
Route::post('razorpaypayment', [RazorpayController::class, 'payment'])->name('payment');
