<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'nidn',
        'nama',
        'username',
        'password',
        'email',
        'telepon',
        'jenis_kelamin',
    ];



    public function keranjang()
    {
        return $this->morphMany(Keranjang::class, 'user');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'dosen_id');
    }
}
