<?php

namespace Database\Seeders;

use App\Models\DokumenSPO;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenSpoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DokumenSPO::create([
            'nama_dokumen' => 'Dokumen SPO',
            'file_dokumen' => 'path/to/file.pdf',
        ]);
    }
}
