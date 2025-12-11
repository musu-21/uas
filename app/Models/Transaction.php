<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code', 'user_id', 'total_price', 'transaction_date'
    ];

    // Relasi: Transaksi ini milik siapa? (User/Kasir)
    // belongTo = "Milik dari"
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi ini punya barang apa aja?
    // hasMany = "Punya banyak"
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}