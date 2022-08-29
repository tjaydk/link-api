<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC API Routes
|--------------------------------------------------------------------------
|
| This is public routes which does not include protected API routes.
|
*/
Route::middleware('public')->group(function () {


    /**
     * AUTHENTICATION ENDPOINTS
     * =================================
     */
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('reset/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::post('translate', [GoogleController::class, 'translate'])->name('google.translate');
    Route::post('detect', [GoogleController::class, 'imageDetection'])->name('google.image.detection');

    /**
     * VERIFICATION ENDPOINTS
     * =================================
     */
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
});
