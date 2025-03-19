<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'barang_kode' => 'B001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 6000000, 'kategori_id' => 1],
            ['barang_id' => 2, 'barang_kode' => 'B002', 'barang_nama' => 'Handphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000, 'kategori_id' => 1],
            ['barang_id' => 3, 'barang_kode' => 'B003', 'barang_nama' => 'Polo', 'harga_beli' => 50000, 'harga_jual' => 75000, 'kategori_id' => 2],
            ['barang_id' => 4, 'barang_kode' => 'B004', 'barang_nama' => 'Pants', 'harga_beli' => 150000, 'harga_jual' => 200000, 'kategori_id' => 2],
            ['barang_id' => 5, 'barang_kode' => 'B005', 'barang_nama' => 'Nasi Bungkus', 'harga_beli' => 25000, 'harga_jual' => 35000, 'kategori_id' => 3],
            ['barang_id' => 6, 'barang_kode' => 'B006', 'barang_nama' => 'Air AQUA', 'harga_beli' => 5000, 'harga_jual' => 10000, 'kategori_id' => 4],
            ['barang_id' => 7, 'barang_kode' => 'B007', 'barang_nama' => 'Kipas Angin', 'harga_beli' => 200000, 'harga_jual' => 300000, 'kategori_id' => 5],
            ['barang_id' => 8, 'barang_kode' => 'B008', 'barang_nama' => 'Rice Cooker', 'harga_beli' => 400000, 'harga_jual' => 500000, 'kategori_id' => 5],
            ['barang_id' => 9, 'barang_kode' => 'B009', 'barang_nama' => 'Speaker Bluetooth', 'harga_beli' => 100000, 'harga_jual' => 150000, 'kategori_id' => 1],
            ['barang_id' => 10, 'barang_kode' => 'B010', 'barang_nama' => 'Teh Botol', 'harga_beli' => 7000, 'harga_jual' => 12000, 'kategori_id' => 4],
        ];
        DB::table('m_barang')->insert($data);
    }
}
