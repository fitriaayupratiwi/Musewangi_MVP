<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run()
    {
        // // Ambil semua pesanan yang sudah ada
        // $pesananList = Pesanan::all();

        // foreach ($pesananList as $pesanan) {
        //     // Cek apakah pesanan sudah punya item, kalau belum baru tambahkan item
        //     if ($pesanan->items()->count() == 0) {
        //         $items = [
        //             [
        //                 'nama' => 'Makanan untuk ' . $pesanan->nama_pelanggan,
        //                 'harga' => rand(10000, 30000),
        //                 'jumlah' => rand(1, 3)
        //             ],
        //             [
        //                 'nama' => 'Minuman untuk ' . $pesanan->nama_pelanggan,
        //                 'harga' => rand(5000, 15000),
        //                 'jumlah' => rand(1, 2)
        //             ]
        //         ];

        //         $pesanan->items()->createMany($items);

        //         // Hitung ulang total harga dari item
        //         $total = collect($items)->sum(function ($item) {
        //             return $item['harga'] * $item['jumlah'];
        //         });

        //         // Update total harga di pesanan
        //         $pesanan->update([
        //             'total_harga' => $total
        //         ]);
        //     }
        // }
    }
}
