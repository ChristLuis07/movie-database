<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('https://7ba0-103-179-71-33.ngrok-free.app/api/transaction/payment/callback', [TransactionController::class, 'callback'])->name('payment.callback');
