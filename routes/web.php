<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\RoleCheck;

// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', RoleCheck::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [ReportController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');
    
    Route::resource('/admin/products', ProductController::class);
});

// --- ROUTE KHUSUS KASIR ---
Route::middleware(['auth', RoleCheck::class . ':kasir'])->group(function () {
    Route::get('/kasir/dashboard', [TransactionController::class, 'index'])->name('kasir.dashboard');
    
    // Proses Transaksi
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/kasir/remove-item/{id}', [TransactionController::class, 'removeItem'])->name('kasir.remove_item'); // Typo sudah diperbaiki
    
    Route::post('/kasir/checkout', [TransactionController::class, 'checkout'])->name('kasir.checkout');
    Route::get('/kasir/print/{transaction}', [TransactionController::class, 'print'])->name('kasir.print');
});

// --- ROUTE PROFILE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load Rute Bawaan Laravel (Login, Register, Logout resmi)
require __DIR__.'/auth.php';