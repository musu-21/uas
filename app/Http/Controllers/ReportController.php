<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Import Model Transaksi
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data transaksi, urutkan dari yang terbaru
        $transactions = Transaction::with('user')->latest()->get();

        // 2. Hitung Total Pendapatan (Omset) Keseluruhan
        $totalRevenue = $transactions->sum('total_price');

        // 3. Hitung Total Transaksi
        $totalTransactions = $transactions->count();

        // 4. Hitung Pendapatan Hari Ini (Opsional, biar keren)
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())->sum('total_price');

        return view('admin.reports.index', compact('transactions', 'totalRevenue', 'totalTransactions', 'todayRevenue'));
    }

    public function dashboard()
    {
        // Kita ambil data ringkas saja untuk dashboard
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())->sum('total_price');
        $totalTransactions = Transaction::whereDate('created_at', Carbon::today())->count();
        $totalProducts = \App\Models\Product::count();
        $lowStockProducts = \App\Models\Product::where('stock', '<', 10)->count(); // Produk yang mau habis

        return view('admin.dashboard', compact('todayRevenue', 'totalTransactions', 'totalProducts', 'lowStockProducts'));
    }
}