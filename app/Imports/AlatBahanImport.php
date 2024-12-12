<?php

namespace App\Imports;

use App\Models\AlatBahan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlatBahanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AlatBahan([
            'nama' => $row['nama'],
            'kategori' => $row['kategori'],
            'stok' => $row['stok'],
            'satuan' => $row['satuan'],
        ]);
    }
}
