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


    public function keranjangs()
    {
        return $this->morphMany(Keranjang::class, 'user');
    }
}
