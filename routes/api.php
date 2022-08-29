<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    /**
     * AUCTION ENDPOINTS
     * =================================
     */
    Route::resource('auction', AuctionController::class);
    Route::prefix('auction')->group(function () {
        Route::post('', [AuctionController::class, 'index'])->name('auction.index');
        Route::post('image', [AuctionController::class, 'indexFromImage'])->name('auction.image');
    });

    /**
     * DEEP LEARNING ENDPOINTS
     * =================================
     */
    Route::prefix('image')->group(function () {
        Route::post('label', [GoogleController::class, 'labelDetectionFromImage']);
    });

    /**
     * Authentication endpoints
     * ===================================
     */
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('user', [AuthController::class, 'user'])->name('auth.user');
});
