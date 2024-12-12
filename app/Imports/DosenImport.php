<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dosen([
            'nama' => $row['nama'],
            'nidn' => $row['nidn'],
            'username' => $row['username'],
            'password' => Hash::make('polindra'),
        ]);
    }
}
