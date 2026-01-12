<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        Guru::create([
            'username' => 'guru1',
            'password' => bcrypt('guru123'),
        ]);
    }
}
