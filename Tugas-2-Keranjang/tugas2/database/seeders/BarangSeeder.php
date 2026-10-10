<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::insert([
            ['nama_barang' => 'Buku Tulis', 'harga' => 5000, 'stok' => 50],
            ['nama_barang' => 'Pulpen Hitam', 'harga' => 3000, 'stok' => 40],
            ['nama_barang' => 'Pensil 2B', 'harga' => 2500, 'stok' => 35],
            ['nama_barang' => 'Penghapus', 'harga' => 2000, 'stok' => 25],
            ['nama_barang' => 'Penggaris 30 cm', 'harga' => 4000, 'stok' => 20],
        ]);
    }
}
