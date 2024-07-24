<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StageController;

// login e forgot
Route::post('/register',     [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');

// reset password
Route::get('/resetPasswordEmail/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/resetPassword', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {
    // Funnel
    Route::prefix('funnels')->group(function () {
        Route::get('/', [FunnelController::class, 'index']);
        Route::get('/search', [FunnelController::class, 'search']);
        Route::post('/', [FunnelController::class, 'store']);
        Route::delete('/{id}', [FunnelController::class, 'destroy']);
        Route::get('/{funnelId}/total-value', [StageController::class, 'totalContactsValue']);

        // Stages
        Route::prefix('{funnel}/stages')->group(function () {
            Route::get('/', [StageController::class, 'index']);
            Route::post('/', [StageController::class, 'store']);
            Route::put('/{stage}', [StageController::class, 'update']);
            Route::delete('/{stage}', [StageController::class, 'destroy']);
            Route::put('/update-order', [StageController::class, 'updateOrder']);
            Route::get('/{stage}/contacts/average-value', [StageController::class, 'averageContactsValue']);
        });
    });

    // Contacts
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/{contact}', [ContactController::class, 'show']);
        Route::put('/{contact}', [ContactController::class, 'update']);
        Route::delete('/{contact}', [ContactController::class, 'destroy']);
        Route::post('/search', [ContactController::class, 'search']);
    });
});
