<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StageController;

// login e forgot
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// reset password
Route::get('/resetPasswordEmail/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/resetPassword', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('password.reset');

//rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Funnel
    Route::prefix('/funnels')->group(function () {
        Route::get('/', [FunnelController::class, 'index']);
        Route::get('/search', [FunnelController::class, 'search']);
        Route::post('/', [FunnelController::class, 'store']);
        Route::delete('/{id}', [FunnelController::class, 'destroy']);

        //relatorios
        Route::get('/{funnelId}/Relatories', [StageController::class, 'totalContactsValue']);

        // Stages
        Route::prefix('{funnel_id}/stages')->group(function () {
            Route::get('/', [StageController::class, 'index']);
            Route::post('/', [StageController::class, 'store']);
            Route::put('/{stage_id}', [StageController::class, 'swapOrder']);
            Route::delete('/{stage_id}', [StageController::class, 'destroy']);
        });
    });

    // Contacts
    Route::prefix('contacts')->group(function () {
        Route::get('/{funnel_id}/', [ContactController::class, 'index']);
        Route::post('/{funnel_id}/', [ContactController::class, 'store']);
        Route::get('/{contact}', [ContactController::class, 'show']);
        Route::put('/{contact}', [ContactController::class, 'update']);
        Route::delete('/{contact}', [ContactController::class, 'destroy']);
        Route::post('/search', [ContactController::class, 'search']);
        Route::put('/swap/{contact_id}', [ContactController::class, 'swap']);
        Route::put('/swap-phase/{contact_id}', [ContactController::class, 'swapPhase']);
    });
});
