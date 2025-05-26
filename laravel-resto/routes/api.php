<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Category routes - public
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/chart', [CategoryController::class, 'chart']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);

// Menu routes - public
Route::get('/menu', [MenuController::class, 'index']);

// Order routes - protected
Route::middleware(['auth:sanctum', 'api.token'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});

// Protected routes
Route::middleware(['auth:sanctum', 'api.token'])->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Customer routes
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/print', [CustomerController::class, 'print']);
    Route::get('/customers/chart', [CustomerController::class, 'chart']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::patch('/customers/{id}', [CustomerController::class, 'update']);
    Route::get('/laporan', [CustomerController::class, 'laporan']);

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        // Add admin-only routes here
        Route::get('/users', [\App\Http\Controllers\AuthController::class, 'getUsers']);
        Route::delete('/users/{id}', [\App\Http\Controllers\AuthController::class, 'deleteUser']);
    });
});
