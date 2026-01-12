<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // HARDCODE DATA (Simulasi agar sesuai gambar visual Anda)
        // Di real project, Anda akan mengambil ini menggunakan Eloquent:
        // $totalSiswa = User::where('role', 'student')->count();
        
        $stats = [
            'total_siswa' => 90,
            'kelas_aktif' => 3,
            'tugas_perlu_dinilai' => 12,
            'tugas_aktif' => 2,
            'rata_rata_kelas' => 82.5,
            'kenaikan_rata_rata' => 2.4
        ];

        $jadwal_hari_ini = [
            [
                'mapel' => 'Matematika Wajib',
                'kelas' => 'Kelas X-A',
                'ruang' => 'Ruang 301',
                'jam' => '08:00 - 09:30',
                'color' => 'blue' // Untuk styling border kiri
            ],
            [
                'mapel' => 'Matematika Peminatan',
                'kelas' => 'Kelas XI-B',
                'ruang' => 'Lab Komputer',
                'jam' => '10:00 - 11:30',
                'color' => 'pink'
            ]
        ];

        $aktivitas_terbaru = [
            [
                'user' => 'Anda',
                'action' => 'mengunggah materi baru',
                'time' => '2 jam yang lalu',
                'icon' => 'upload'
            ],
            [
                'user' => 'Ahmad Dahlan',
                'action' => 'mengumpulkan tugas',
                'time' => '3 jam yang lalu',
                'icon' => 'check'
            ]
        ];

        return view('teacher.dashboard', compact('stats', 'jadwal_hari_ini', 'aktivitas_terbaru'));
    }
}