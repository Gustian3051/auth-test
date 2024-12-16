<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDetail extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_details';

    protected $fillable = [
        'pengembalian_id',
        'alat_bahan_id',
        'jumlah',
        'kondisi',
        'catatan',
    ];

    public function alatBahan()
    {
        return $this->belongsTo(AlatBahan::class);
    }

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}
