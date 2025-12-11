<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Logic: Kolom mana saja yang boleh diisi lewat form?
    protected $fillable = [
        'name', 'price', 'stock', 'description', 'image'
    ];

    // Relasi: Satu produk bisa ada di banyak detail transaksi
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}