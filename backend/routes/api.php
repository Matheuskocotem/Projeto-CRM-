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
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('password.reset');

// resetpassword
Route::get('/resetPasswordEmail/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/resetPassword/{token}', [ResetPasswordController::class, 'reset'])->name('password.update');

//funnel
Route::middleware('auth:sanctum')->get('/funnels', [FunnelController::class, 'index']);
Route::middleware('auth:sanctum')->get('/funnels/search', [FunnelController::class, 'search']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/funnel', [FunnelController::class, 'store']);
    Route::delete('/funnel/{id}', [FunnelController::class, 'destroy']);
});

// relatorios
Route::get('/funnels/reports/completedContacts', [ContactController::class, 'completedContactsReport']);
Route::get('/funnels/reports/contactsValue', [ContactController::class, 'contactsValueReport']);
Route::get('/funnels/reports/createdContacts', [ContactController::class, 'createdContactsReport']);


//stages
Route::middleware('auth:sanctum')->group(function () {
    // Rotas para CRUD de estágios de um funil específico
    Route::get('/funnels/{funnel}/stages', [StageController::class, 'index']);
    Route::post('/funnels/{funnel}/stages', [StageController::class, 'store']);
    Route::put('/funnels/{funnel}/stages/{stage}', [StageController::class, 'update']);
    Route::delete('/funnels/{funnel}/stages/{stage}', [StageController::class, 'destroy']);

    // Rota para atualização da ordem dos estágios
    Route::post('/funnels/{funnel}/stages/update-order', [StageController::class, 'updateOrder']);
});


//contacts
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts/{contact}', [ContactController::class, 'show']);
    Route::put('/contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);

});
