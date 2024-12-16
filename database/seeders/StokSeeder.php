<?php

namespace Database\Seeders;

use App\Models\Stok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stok::create([
            'alat_bahan_id' => 1,
            'stok' => 10
        ]);
        Stok::create([
            'alat_bahan_id' => 2,
            'stok' => 10
        ]);
    }
}
