<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
Jika menggunakan Route::apiResource, tidak perlu menambahkan rute GET, POST, PUT, dan DELETE 
secara manual, karena apiResource secara otomatis membuatkan rute CRUD (Create, Read, Update, Delete)
*/

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Product routes
    Route::apiResource('products', ProductController::class);
});