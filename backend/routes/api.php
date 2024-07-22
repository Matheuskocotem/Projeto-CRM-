<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StageController;


//login e forgot
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');


// resetpassword
Route::get('/resetPasswordEmail/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/resetPassword', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('password.reset');

//funnel
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funnels', [FunnelController::class, 'index']);
    Route::get('/funnels/search', [FunnelController::class, 'search']);
    Route::post('/funnel', [FunnelController::class, 'store']);
    Route::delete('/funnel/{id}', [FunnelController::class, 'destroy']);
});


//stages
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funnels/{funnel}/stages', [StageController::class, 'index']);
    Route::post('/funnels/{funnel}/stages', [StageController::class, 'store']);
    Route::put('/funnels/{funnel}/stages/{stage}', [StageController::class, 'update']);
    Route::delete('/funnels/{funnel}/stages/{stage}', [StageController::class, 'destroy']);
    Route::post('/funnels/{funnel}/stages/update-order', [StageController::class, 'updateOrder']);
    Route::get('/funnels/{funnel}/stages/{stage}/contacts/average-value', [StageController::class, 'averageContactsValue']);
});


//contacts
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts/{contact}', [ContactController::class, 'show']);
    Route::put('/contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
    Route::post('/contacts/search', [ContactController::class, 'search']);

});

