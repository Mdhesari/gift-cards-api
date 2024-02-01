<?php

use App\Http\Controllers\GiftCard\GiftCardController;
use App\Http\Controllers\Wallet\WalletDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('gifts/{gift_card:key}/submit', [GiftCardController::class, 'submit'])->name('gifts.submit');

Route::get('wallets/{user:mobile}/details', WalletDetailController::class)->name('wallets.details');
