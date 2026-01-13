<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. buat user admin
        $user = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@mail.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        // 2. buat data admin (relasi ke users)
        Admin::create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'id_user'  => $user->id,
        ]);
    }
}
