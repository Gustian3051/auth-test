<?php

namespace Database\Seeders;

use App\Models\AlatBahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlatBahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlatBahan::create([
            'nama' => 'Alat Bahan 1',
            'kategori_id' => 1,
            'satuans_id' => 1,
            'foto' => null,
        ]);
    }
}
