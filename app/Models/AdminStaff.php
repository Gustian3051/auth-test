<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class AdminStaff extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guard = 'admin_staff';

    protected $fillable = [
        'nama',
        'nidn',
        'username',
        'password',
    ];
}
