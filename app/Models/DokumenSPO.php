<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSPO extends Model
{
    use HasFactory;

    protected $table = 'dokumen_s_p_o_s';

    protected $fillable = [
        'id',
        'nama_dokumen',
        'file_dokumen',
        'created_at',
        'updated_at',
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_dokumen);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
