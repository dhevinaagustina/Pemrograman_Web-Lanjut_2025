<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'barang_id' => $i,
                'stok_tanggal' => now(),
                'stok_jumlah' => rand(10, 50),
                'user_id' => 1,
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
