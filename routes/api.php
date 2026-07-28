<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// 1. Public Route: Anyone can try to log in
Route::post('/auth/login', [AuthController::class, 'login']);

// 2. Protected Routes: User MUST be logged in (has a valid token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout route
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // --- CATEGORY ROUTES ---
    
    // A. READ ONLY: Both Admin and Cashier can view categories (needed for POS)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    // B. MODIFY ONLY: Only Admin can Create, Update, or Delete
    Route::middleware('role:admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
});