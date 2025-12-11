<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Import Model Transaksi

class ReportController extends Controller
{
    public function index()
    {
        // Ambil semua data transaksi, urutkan dari yang terbaru
        // with('user') gunanya agar kita bisa mengambil Nama Kasir dari relasi tabel User
        $transactions = Transaction::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.reports.index', compact('transactions'));
    }
}