<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        Siswa::create([
            'username' => 'siswa1',
            'password' => bcrypt('siswa123'),
        ]);
    }
}
