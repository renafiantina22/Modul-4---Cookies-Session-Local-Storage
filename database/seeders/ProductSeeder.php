<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['BRG0000001', 'Buku Tulis', 'Buku tulis 38 lembar', 5000, 50, 'buku-tulis.jpg'],
            ['BRG0000002', 'Pulpen Hitam', 'Pulpen tinta hitam', 3000, 40, 'pulpen-hitam.jpg'],
            ['BRG0000003', 'Pensil 2B', 'Pensil untuk menulis', 2500, 35, 'pensil-2b.jpg'],
            ['BRG0000004', 'Penghapus', 'Penghapus pensil', 2000, 25, 'penghapus.jpg'],
            ['BRG0000005', 'Penggaris 30 cm', 'Penggaris plastik', 4000, 20, 'penggaris.jpg'],
            ['BRG0000006', 'Spidol Hitam', 'Spidol permanen hitam', 7000, 15, 'spidol.jpg'],
            ['BRG0000007', 'Stabilo Kuning', 'Penanda teks warna kuning', 6000, 18, 'stabilo.jpg'],
            ['BRG0000008', 'Map Plastik', 'Map untuk menyimpan dokumen', 3500, 30, 'map.jpg'],
            ['BRG0000009', 'Kertas HVS', 'Kertas HVS ukuran A4', 50000, 12, 'kertas-hvs.jpg'],
            ['BRG0000010', 'Tempat Pensil', 'Tempat alat tulis sederhana', 12000, 10, 'tempat-pensil.jpg'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['id_barang' => $product[0]],
                [
                    'nama_barang' => $product[1],
                    'deskripsi' => $product[2],
                    'harga' => $product[3],
                    'stok' => $product[4],
                    'gambar' => $product[5],
                ]
            );
        }
    }
}
