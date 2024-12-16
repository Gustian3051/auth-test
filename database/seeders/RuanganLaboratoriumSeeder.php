<?php

namespace Database\Seeders;

use App\Models\RuangLaboratorium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganLaboratoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RuangLaboratorium::create([
            'nama' => 'Laboratorium Komputer',
        ]);
        RuangLaboratorium::create([
            'nama' => 'HPC',
        ]);
    }
}
