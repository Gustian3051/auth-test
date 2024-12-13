<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLaboratorium extends Model
{
    use HasFactory;

    protected $table = 'ruang_laboratorium';

    protected $fillable = [
        'nama',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'ruang_laboratorium_id');
    }
}
