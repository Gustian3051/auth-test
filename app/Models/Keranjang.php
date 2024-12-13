<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';
    protected $fillable = ['user_id', 'user_type', 'alat_bahan_id', 'jumlah', 'tindakan_SPO'];


    public function alatBahan()
    {
        return $this->belongsTo(AlatBahan::class, 'alat_bahan_id');
    }

    public function user()
    {
        return $this->morphTo();
    }
}
