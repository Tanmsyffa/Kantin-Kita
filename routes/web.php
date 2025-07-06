<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;

// Landing Page (bisa diakses siapa saja)
Route::get('/', [LandingController::class, 'index']);

// Halaman Menu untuk User Biasa (bukan admin)
Route::middleware(['user'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders');
});

// Login/Register/Logout (bisa diakses siapa saja)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group khusus Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/menu', AdminMenuController::class);
    Route::post('/menu/{id}/restock', [AdminMenuController::class, 'restock'])->name('menu.restock');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});