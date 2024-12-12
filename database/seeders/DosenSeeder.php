<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nama' => 'Dosen 1',
            'nidn' => '123456789',
            'telepon' => '08123456789',
            'username' => 'dosen1',
            'password' => Hash::make('polindra'),
            'email' => 'dosen1@gmail.com',
            'jenis_kelamin' => 'Laki-laki',
            'foto' => null
        ]);
    }
}
