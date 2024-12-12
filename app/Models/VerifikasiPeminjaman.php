<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_peminjamen';

    protected $fillable = [
        'status',
        'tanggal_waktu_peminjaman',
        'waktu_pengembalian',
        'mahasiswa_id',
        'dosen_id',
        'ruang_laboratorium_id',
        'alat_bahan_id',
        'matkul_id',
        'dokumen_s_p_o_s_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function ruang_laboratorium()
    {
        return $this->belongsTo(RuangLaboratorium::class, 'ruang_laboratorium_id');
    }

    public function alat_bahan()
    {
        return $this->belongsTo(AlatBahan::class, 'alat_bahan_id');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }

    public function dokumen_s_p_o_s()
    {
        return $this->belongsTo(DokumenSPO::class, 'dokumen_s_p_o_s_id');
    }
}
