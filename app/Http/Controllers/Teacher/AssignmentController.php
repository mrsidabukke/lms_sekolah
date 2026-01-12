<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        // Mock Data: Daftar Tugas
        $assignments = [
            (object)[
                'id' => 1,
                'title' => 'Latihan Soal Trigonometri',
                'class' => 'Kelas X-A',
                'subject' => 'Matematika Wajib',
                'deadline' => '2024-01-10 23:59',
                'submitted_count' => 25,
                'total_students' => 30,
                'status' => 'active'
            ],
            (object)[
                'id' => 2,
                'title' => 'Analisis Data Statistik',
                'class' => 'Kelas XI-B',
                'subject' => 'Matematika Peminatan',
                'deadline' => '2023-12-20 23:59', // Sudah lewat
                'submitted_count' => 28,
                'total_students' => 28,
                'status' => 'completed'
            ]
        ];
        return view('teacher.assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('teacher.assignments.create');
    }

    public function store(Request $request)
    {
        // Validasi & Simpan Logic (Sama seperti Materi)
        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diterbitkan!');
    }

    // Halaman Detail untuk Menilai Siswa
    public function show($id)
    {
        // Mock Data: List Siswa yang mengumpulkan tugas ini
        $submissions = [
            (object)['name' => 'Ahmad Dahlan', 'submitted_at' => '2024-01-08 10:00', 'score' => 90, 'status' => 'graded'],
            (object)['name' => 'Siti Aminah', 'submitted_at' => '2024-01-09 14:30', 'score' => null, 'status' => 'submitted'],
            (object)['name' => 'Budi Utomo', 'submitted_at' => null, 'score' => null, 'status' => 'pending'],
        ];

        return view('teacher.assignments.show', compact('submissions'));
    }
}