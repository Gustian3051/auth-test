<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'user_type',
        'matkul_id',
        'dosen_id',
        'ruang_laboratorium_id',
        'tanggal_waktu_peminjaman',
        'waktu_pengembalian',
        'status',
        'dokumen_spo_id',
        'anggota_kelompok',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function ruangLaboratorium()
    {
        return $this->belongsTo(RuangLaboratorium::class, 'ruang_laboratorium_id');
    }

    public function dokumenSpo()
    {
        return $this->belongsTo(DokumenSpo::class, 'dokumen_spo_id');
    }
}
