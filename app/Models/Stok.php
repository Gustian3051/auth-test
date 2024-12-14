<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    protected $fillable = [
        'alat_bahan_id',
        'stok',
    ];

    public function alatBahan()
    {
        return $this->belongsTo(AlatBahan::class, 'alat_bahan_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'stok_id');
    }

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class, 'stok_id');
    }
}
