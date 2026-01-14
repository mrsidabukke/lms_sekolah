<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'password',
        'role',
    ];

    protected $hidden = ['password'];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'id_user');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user');
    }
}
