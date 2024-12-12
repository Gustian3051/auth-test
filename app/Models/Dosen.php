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

    public function peminjam()
    {
        return $this->morphMany(peminjaman::class, 'peminjam_id');
    }

    public function keranjang()
    {
        return $this->morphMany(Keranjang::class, 'user');
    }


}
