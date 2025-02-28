<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualan_ids = DB::table('t_penjualan')->pluck('penjualan_id'); // Ambil semua ID penjualan
        $barang_ids = DB::table('m_barang')->pluck('barang_id'); // Ambil semua ID barang
        
        $data = [];
        $detail_id = 1; // Mulai dari 1 untuk detail_id
        
        foreach ($penjualan_ids as $penjualan_id) {
            // Ambil 3 barang secara acak untuk setiap transaksi
            $barang_acak = $barang_ids->shuffle()->take(3);
            
            foreach ($barang_acak as $barang_id) {
                $harga = rand(10000, 50000); // Harga random antara 10.000 - 50.000
                $jumlah = rand(1, 5); // Jumlah barang antara 1 - 5
                
                $data[] = [
                    'detail_id' => $detail_id++, // Auto-increment manual
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barang_id,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                ];
            }
        }

        // Insert data ke tabel `t_penjualan_detail`
        DB::table('t_penjualan_detail')->insert($data);
    }
}
