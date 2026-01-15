<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Mock Data: Daftar Siswa
        // Di real project: User::where('role', 'student')->where('class_id', $selectedClass)->paginate(10);
        $students = [
            (object)[
                'id' => 1,
                'name' => 'Ahmad Dahlan',
                'nisn' => '0054321981',
                'class' => 'Kelas X-A',
                'email' => 'ahmad.d@sekolah.sch.id',
                'phone' => '081234567890',
                'gender' => 'L',
                'status' => 'active',
                'avg_score' => 88.5
            ],
            (object)[
                'id' => 2,
                'name' => 'Siti Aminah',
                'nisn' => '0054321982',
                'class' => 'Kelas X-A',
                'email' => 'siti.am@sekolah.sch.id',
                'phone' => '081298765432',
                'gender' => 'P',
                'status' => 'active',
                'avg_score' => 92.0
            ],
            (object)[
                'id' => 3,
                'name' => 'Budi Utomo',
                'nisn' => '0061234567',
                'class' => 'Kelas XI-B',
                'email' => 'budi.u@sekolah.sch.id',
                'phone' => '085712345678',
                'gender' => 'L',
                'status' => 'inactive', // Cuti / Non-aktif
                'avg_score' => 75.0
            ],
        ];

        return view('teacher.students.index', compact('students'));
    }
}