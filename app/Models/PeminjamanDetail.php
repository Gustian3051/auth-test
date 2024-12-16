<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_details';

    protected $fillable = [
        'peminjaman_id',
        'alat_bahan_id',
        'jumlah',
        'tindakan_SPO',
        'status',
        'alasan_penolakan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class) ;
    }

    

    public function alatBahan()
    {
        return $this->belongsTo(AlatBahan::class, 'alat_bahan_id');
    }
}
