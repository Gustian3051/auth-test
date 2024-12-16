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
        'persetujuan',
        'dokumen_spo_id',
        'anggota_kelompok',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function ruangLaboratorium()
    {
        return $this->belongsTo(RuangLaboratorium::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }

    public function dokumenSpo()
    {
        return $this->belongsTo(DokumenSPO::class);
    }



    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

}
