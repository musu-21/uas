<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Jangan lupa import Model Product
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        // 1. Ambil data produk agar kasir bisa milih
        $products = Product::all();

        // 2. Ambil data keranjang dari Session (jika ada)
        // Logika: Kalau session kosong, anggap array kosong []
        $cart = session()->get('cart', []);

        // 3. Hitung Total Harga sementara
        $total_price = 0;
        foreach ($cart as $id => $details) {
            $total_price += $details['price'] * $details['quantity'];
        }

        return view('kasir.dashboard', compact('products', 'cart', 'total_price'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // Cek stok dulu
        if($product->stock < $quantity) {
             return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        // Jika produk sudah ada di cart, tambahkan jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Jika belum ada, masukkan baru
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "product_id" => $product->id // Simpan ID asli untuk nanti disimpan ke DB
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }
    
    public function checkout()
    {
        // 1. Cek apakah keranjang kosong?
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // 2. Hitung Total Harga
        $total_price = 0;
        foreach ($cart as $id => $details) {
            $total_price += $details['price'] * $details['quantity'];
        }

        // 3. Mulai Proses Database Transaction (Agar aman)
        $transaction = DB::transaction(function () use ($cart, $total_price) {
            
            // A. Buat Header Transaksi (Tabel transactions)
            $transaction = Transaction::create([
                'invoice_code' => 'TRX-' . time(), // Contoh: TRX-17654321
                'user_id' => Auth::id(), // Siapa kasir yang login
                'total_price' => $total_price,
                'transaction_date' => now(),
            ]);

            // B. Loop setiap barang di keranjang
            foreach ($cart as $id => $details) {
                // Masukkan ke tabel detail (Tabel transaction_details)
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $details['product_id'],
                    'quantity' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity'],
                ]);

                // C. KURANGI STOK PRODUK (PENTING!)
                $product = Product::find($details['product_id']);
                // Kita kurangi stok yang ada sekarang dengan jumlah beli
                $product->decrement('stock', $details['quantity']);
            }

            return $transaction;

        });

        // 4. Hapus Keranjang dari Session (Kosongkan lagi)
        session()->forget('cart');

        return redirect()->route('kasir.dashboard')->with('success', 'Transaksi Berhasil Disimpan!')->with('last_transaction_id', $transaction->id);
    }

    public function print(Transaction $transaction)
    {
        // Load data detail transaksi & user kasir
        $transaction->load('details.product', 'user');
        
        return view('kasir.print', compact('transaction'));
    }


}