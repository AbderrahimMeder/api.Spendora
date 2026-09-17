<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PaymentMethodController;
// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class , 'login']);
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
