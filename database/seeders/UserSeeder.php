<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@dimsum.com',
            'password' => Hash::make('password123'), // Password di-enkripsi
            'role' => 'admin',
        ]);

        // Buat akun Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@dimsum.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);
    }
}