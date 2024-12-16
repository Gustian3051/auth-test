<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'waktu_tanggal_pengembalian',
        'persetujuan',
        'catatan',
    ];


    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function pengembalianDetail()
    {
        return $this->hasMany(PengembalianDetail::class);
    }

    // public function user()
    // {
    //     return $this->morphTo();
    // }



}
