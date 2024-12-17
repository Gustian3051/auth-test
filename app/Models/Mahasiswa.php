<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'nama',
        'nim',
        'kelas',
        'password',
        'email',
        'telepon',
        'jenis_kelamin',
        'foto'
    ];


    public function keranjang()
    {
        return $this->morphMany(Keranjang::class, 'user');
    }

    public function peminjaman()
    {
        return $this->morphMany(Peminjaman::class, 'user');
    }

    public function pengembalian()
    {
        return $this->morphMany(Pengembalian::class, 'user');
    }
}
