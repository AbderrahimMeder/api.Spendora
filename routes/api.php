<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\BudgesController;
use App\Http\Controllers\Auth\GoogleController;

// auth
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class , 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/verify-email', [AuthController::class, 'verifieEmailToken']);
Route::post('/send-email-verification', [AuthController::class, 'SendEmailVerification']);
Route::middleware('auth:sanctum')->group(function () {
    //get currect user for verifie user and route permission and role 
    Route::get('/current-user',[AuthController::class , 'getCurrentUser']);
    //transactions
    Route::get('/transactions',[TransactionController::class , 'index']);
    Route::post('/transactions',[TransactionController::class , 'POST']);
    Route::get('/transactions/{id}',[TransactionController::class , 'show']);
    Route::patch('/transactions/{id}',[TransactionController::class , 'update']);
    Route::delete('/transactions/{id}/delete',[TransactionController::class , 'delete']);
    //categories
    Route::get('/categories',[CategoriesController::class , 'index']);
    //payment methods
    Route::get('/payment-methods',[PaymentMethodController::class , 'index']);
    //budgets
    Route::get('/budgets',[BudgesController::class , 'index']);
    Route::get('/budget/{id}', [BudgesController::class , 'show']);
    Route::post('/budget', [BudgesController::class , 'store']);
    Route::patch('/budget/{id}', [BudgesController::class , 'update']);
    Route::delete('/budget/{id}', [BudgesController::class , 'delete']);
});
