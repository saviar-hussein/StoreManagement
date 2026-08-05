<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
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

        // READ: Both Admin and Cashier can view products (needed for POS)
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);


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

        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    });


    // DASHBOARD ROUTES
    // Admin ONLY
    //role is the name of the CheckRole middleware
    Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    });

});