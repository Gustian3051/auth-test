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
            'nama' => 'Boneka',
            'kategori_id' => 1,
            'satuans_id' => 1,
            'foto' => null,
        ]);

        AlatBahan::create([
            'nama' => 'Bensin',
            'kategori_id' => 2,
            'satuans_id' => 2,
            'foto' => null,
        ]);
    }
}
