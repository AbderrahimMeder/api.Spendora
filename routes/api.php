<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

// auth
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class , 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/current-user',[AuthController::class , 'getCurrentUser']);
    Route::get('/transactions',[TransactionController::class , 'index']);
    Route::post('/transactions',[TransactionController::class , 'POST']);
    Route::get('/transactions/{id}',[TransactionController::class , 'show']);
    Route::patch('/transactions/{id}',[TransactionController::class , 'update']);
    Route::delete('/transactions/{id}/delete',[TransactionController::class , 'delete']);
    Route::get('/categories',[CategoriesController::class , 'index']);
    Route::get('/payment-methods',[PaymentMethodController::class , 'index']);
});
