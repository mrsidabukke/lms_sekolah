<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'identifier' => '310506',
            'name' => 'Baihaqie Ar Rafi',
            'email' => 'rafi@siswa.com',
            'password' => Hash::make('siswa123'),
            'role' => 'student'
        ]);

        Student::create([
            'user_id' => $user->id,
            'name' => 'Baihaqie Ar Rafi',
            'nisn' => '310506',
            'foto' => null,
            'jurusan' => 'RPL',
            'class_level' => 'XI'
        ]);
    }
}
