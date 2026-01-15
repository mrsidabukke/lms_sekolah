<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectDetailController extends Controller
{
    public function show($id)
    {
        // 1. Ambil Detail Mapel & Kelas (Mock Data)
        $subjectInfo = (object)[
            'id' => $id,
            'name' => 'Matematika Wajib',
            'class' => 'Kelas X-A',
            'class_id' => 1, // Penting untuk link upload
            'subject_id' => 1 // Penting untuk link upload
        ];

        // 2. Ambil Materi dan Grouping berdasarkan BAB (Mock Data)
        // Di Real App: Material::where('subject_id', $id)->get()->groupBy('chapter');
        $chapters = [
            'Bab 1: Eksponen & Logaritma' => [
                (object)['id'=>101, 'title'=>'Konsep Dasar Eksponen', 'type'=>'pdf', 'link'=>'#'],
                (object)['id'=>102, 'title'=>'Video Pembahasan', 'type'=>'video', 'link'=>'#'],
            ],
            'Bab 2: Persamaan Linear' => [
                (object)['id'=>201, 'title'=>'Latihan Soal SPLDV', 'type'=>'pdf', 'link'=>'#'],
            ],
            'Bab 3: Matriks' => [] // Bab kosong belum ada materi
        ];

        return view('teacher.subjects.show', compact('subjectInfo', 'chapters'));
    }
}