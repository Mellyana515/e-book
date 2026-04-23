<?php

use App\Http\Controllers\Api\GoogleAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth routes
Route::prefix('auth')->group(function () {
    // Google OAuth
    Route::get('/google/url', [GoogleAuthController::class, 'getGoogleAuthUrl']);
    Route::post('/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    Route::get('/logout', [GoogleAuthController::class, 'logout']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [GoogleAuthController::class, 'getCurrentUser']);
});
