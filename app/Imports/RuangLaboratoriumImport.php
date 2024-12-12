<?php

namespace App\Imports;

use App\Models\RuangLaboratorium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuangLaboratoriumImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new RuangLaboratorium([
            'nama' => $row['nama'],
        ]);
    }
}
