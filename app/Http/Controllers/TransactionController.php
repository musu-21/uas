<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);

        // Hitung Total
        $total_price = 0;
        foreach ($cart as $id => $details) {
            $total_price += $details['price'] * $details['quantity'];
        }

        return view('kasir.dashboard', compact('products', 'cart', 'total_price'));
    }

    // FUNGSI UTAMA TOMBOL "TAMBAH"
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $id = $request->product_id;
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // 2. Cek Stok (Jangan kurangi DB dulu, cek aja)
        if($product->stock < $request->quantity) {
             return redirect()->back()->with('error', 'Stok barang tidak cukup!');
        }

        // 3. Masukkan ke Session Cart
        if(isset($cart[$id])) {
            // Jika sudah ada, tambahkan jumlahnya
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            // Jika belum ada, buat baru
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "product_id" => $product->id
            ];
        }

        session()->put('cart', $cart);

        // 4. Balik ke Dashboard
        return redirect()->route('kasir.dashboard')
            ->with('success', 'Menu ' . $product->name . ' masuk keranjang!');
    }
    
    public function checkout()
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $total_price = 0;
        foreach ($cart as $id => $details) {
            $total_price += $details['price'] * $details['quantity'];
        }

        // Mulai Transaksi Database
        $transaction = DB::transaction(function () use ($cart, $total_price) {
            
            // A. Header Transaksi
            $transaction = Transaction::create([
                'invoice_code' => 'TRX-' . time(),
                'user_id' => Auth::id(),
                'total_price' => $total_price,
                'transaction_date' => now(),
            ]);

            // B. Detail & Kurangi Stok
            foreach ($cart as $id => $details) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $details['product_id'],
                    'quantity' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity'],
                ]);

                // Kurangi Stok Real di Database DISINI
                $product = Product::find($details['product_id']);
                $product->decrement('stock', $details['quantity']);
            }

            return $transaction;
        });

        session()->forget('cart'); // Kosongkan keranjang

        return redirect()->route('kasir.dashboard')
            ->with('success', 'Transaksi Berhasil!')
            ->with('last_transaction_id', $transaction->id);
    }

    public function print(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');
        return view('kasir.print', compact('transaction'));
    }

    // FUNGSI MENGHAPUS ITEM DARI KERANJANG
    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]); // Hapus item dari array session
            session()->put('cart', $cart); // Simpan kembali session yang sudah bersih
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }
    
}