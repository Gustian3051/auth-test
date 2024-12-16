<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatBahan extends Model
{
    use HasFactory;

    protected $table = 'alat_bahans';

    protected $fillable = [
        'nama',
        'kategori_id',
        'satuans_id',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuans_id');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class);
    }

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalianDetail()
    {
        return $this->hasMany(PengembalianDetail::class);
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'alat_bahan_id');
    }

}
