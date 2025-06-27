<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;

// Landing Page
Route::get('/', [LandingController::class, 'index']);

// Halaman Menu untuk User
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Simpan Pesanan
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Login/Register/Logout
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


    // Route logout admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Group untuk user setelah login
Route::middleware(['auth'])->get('/orders', [OrderController::class, 'history'])->name('orders');

