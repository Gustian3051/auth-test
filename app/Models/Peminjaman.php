<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'peminjam_id',
        'peminjam_type',
        'alat_bahan_id',
        'tanggal_waktu_peminjaman',
        'waktu_pengembalian',
        'status',
        'tindakan_SPO',
    ];

    public function peminjam()
    {
        return $this->morphTo();
    }

    public function alat_bahan()
    {
        return $this->belongsTo(AlatBahan::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }

}
