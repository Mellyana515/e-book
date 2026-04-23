<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookController as AdminEbookController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/two-factor-challenge', [AuthController::class, 'showTwoFactorChallenge'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [AuthController::class, 'verifyTwoFactorChallenge'])->name('two-factor.verify');
    Route::post('/two-factor-challenge/resend', [AuthController::class, 'resendTwoFactorCode'])->name('two-factor.resend');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/users/{user}/avatar', [UserAvatarController::class, 'show'])->name('users.avatar');


// Public routes
Route::get('/', function () {
    return view('spa');
})->name('home');
Route::get('/ebooks/{ebook:slug}', [EbookController::class, 'show'])->name('ebooks.show');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::get('/library/download/{ebook}', [LibraryController::class, 'download'])->name('library.download');
    Route::get('/purchase/{ebook}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{ebook}', [PurchaseController::class, 'store'])->name('purchase.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ebooks CRUD
    Route::resource('ebooks', AdminEbookController::class)->except(['show']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{purchase}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::patch('/payments/{purchase}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
