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
Route::post('/login', [AuthController::class, 'login'])->name('login');

// reset password
Route::get('/resetPasswordEmail/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/resetPassword', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('password.reset');

//rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Funnel
    Route::prefix('funnels')->group(function () {
        Route::get('/{user_id}', [FunnelController::class, 'index']);
        Route::get('/search', [FunnelController::class, 'search']);
        Route::post('/', [FunnelController::class, 'store']);
        Route::delete('/{id}', [FunnelController::class, 'destroy']);
        //relatorios
        Route::get('/{funnelId}/total-value', [StageController::class, 'totalContactsValue']);

        // Stages
        Route::prefix('{funnel}/stages')->group(function () {
            Route::get('/', [StageController::class, 'index']);
            Route::post('/', [StageController::class, 'store']);
            Route::put('/{stage}', [StageController::class, 'update']);
            Route::delete('/{stage}', [StageController::class, 'destroy']);
            Route::put('/update-order', [StageController::class, 'updateOrder']);
        });
    });

    Route::get('/funnels/{funnel}/stages', [StageController::class, 'index']);
    Route::post('/funnels/{funnel}/stages', [StageController::class, 'store']);
    Route::put('/funnels/{funnel}/stages/{stage}', [StageController::class, 'update']);
    Route::delete('/funnels/{funnel}/stages/{stage}', [StageController::class, 'destroy']);
    // Rota para atualização da ordem dos estágios

    Route::post('/funnels/{funnel}/stages/update-order', [StageController::class, 'updateOrder']);
    Route::get('/funnels/{funnel}/stages/{stage}/contacts/average-value', [StageController::class, 'averageContactsValue']);

    //contatos
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts/{contact}', [ContactController::class, 'show']);
    Route::put('/contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
});
