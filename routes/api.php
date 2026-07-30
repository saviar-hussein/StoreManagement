<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. PUBLIC ROUTES (No login required)
// ==========================================
Route::post('/auth/login', [AuthController::class, 'login']);


// ==========================================
// 2. PROTECTED ROUTES (Must be logged in)
// ==========================================
// 'auth:sanctum' ensures the user has a valid API token.
// It will return a 401 JSON error (not a redirect) if the token is missing.
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);


    // CATEGORY ROUTES
    // READ: Both Admin and Cashier can view categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    
    // MODIFY: Admin ONLY (enforced by 'role:admin' middleware)
    //admin acheta naw middleware y role
    Route::middleware('role:admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });


    // DASHBOARD ROUTES
    // Admin ONLY
    //role is the name of the CheckRole middleware
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});