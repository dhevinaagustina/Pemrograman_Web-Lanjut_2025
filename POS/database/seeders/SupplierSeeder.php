<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT Maju Jaya',
                'supplier_alamat' => 'Jl. Merdeka No. 45, Jakarta',
                'supplier_telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'CV Sukses Bersama',
                'supplier_alamat' => 'Jl. Diponegoro No. 99, Bandung',
                'supplier_telepon' => '081987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
