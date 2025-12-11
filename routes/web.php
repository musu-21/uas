<?php

use App\Http\Controllers\ProfileController; // <--- PENTING: Tambahkan ini
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleCheck;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', RoleCheck::class . ':admin'])->group(function () {
    Route::get('/admin/reports', 
    [ReportController::class, 'index'
    ])->name('admin.reports');
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('/admin/products', ProductController::class);
});

// --- ROUTE KHUSUS KASIR ---
Route::middleware(['auth', RoleCheck::class . ':kasir'])->group(function () {
    // Halaman Transaksi Utama (Dashboard Kasir)
    Route::get('/kasir/dashboard', [TransactionController::class, 'index'])->name('kasir.dashboard');

    // Route untuk proses transaksi nanti
    Route::post('/kasir/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('kasir.addToCart');
    Route::post('/kasir/checkout', [TransactionController::class, 'checkout'])->name('kasir.checkout');
    Route::get('/kasir/print/{transaction}', [TransactionController::class, 'print'])->name('kasir.print');
});

// --- ROUTE PROFILE (Bisa diakses Admin & Kasir) ---
// Bagian inilah yang tadi hilang dan menyebabkan error
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';