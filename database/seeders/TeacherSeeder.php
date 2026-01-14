<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'identifier' => '1987654321',
            'name' => 'Budi Santoso',
            'email' => 'budi@guru.com',
            'password' => Hash::make('guru123'),
            'role' => 'teacher'
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'name' => 'Budi Santoso',
            'nip' => '1987654321',
            'mapel' => 'Matematika'
        ]);
    }
}
