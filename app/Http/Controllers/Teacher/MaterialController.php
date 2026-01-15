<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material; // Pastikan buat Model Material nanti
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // Halaman List Materi
    public function index()
    {
        // Mengambil daftar Mata Pelajaran yang diajar oleh Guru
        // (Data ini sama strukturnya dengan yang ada di Dashboard)
        $courses = [
            (object)[
                'id' => 1,
                'name' => 'Matematika Wajib',
                'class' => 'Kelas X-A',
                'total_materi' => 12, // Jumlah materi yang sudah diupload
                'last_update' => '2 jam yang lalu',
                'color' => 'bg-blue-600',
                'icon' => 'ph-function'
            ],
            (object)[
                'id' => 2,
                'name' => 'Matematika Peminatan',
                'class' => 'Kelas XI-B',
                'total_materi' => 8,
                'last_update' => '1 hari yang lalu',
                'color' => 'bg-indigo-600',
                'icon' => 'ph-chart-line-up'
            ],
            (object)[
                'id' => 3,
                'name' => 'Matematika Wajib',
                'class' => 'Kelas XII-IPA',
                'total_materi' => 20,
                'last_update' => '3 hari yang lalu',
                'color' => 'bg-purple-600',
                'icon' => 'ph-pi'
            ],
        ];

        return view('teacher.materials.index', compact('courses'));
    }

    // Halaman Form Upload
    public function create()
    {
        return view('teacher.materials.create');
    }

    // Proses Simpan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'grade_level' => 'required', // X, XI, XII
            'major'       => 'required', // RPL, IPA, dll
            'subject_id'  => 'required',
            'chapter'     => 'required|string',
            'type'        => 'required',
            'link_url'    => 'required|url', // Wajib URL valid
        ]);

        // Simpan ke Database
        // Pastikan Anda sudah menambahkan field ini di $fillable pada Model Material
        /* Model Material.php:
        protected $fillable = ['user_id', 'subject_id', 'class_id', 'grade_level', 'major', 'chapter', 'title', 'type', 'link_url', 'description'];
        */

        // Mockup logic simpan (Sesuaikan dengan Model Anda)
        // Material::create([
        //     'user_id'     => auth()->id(),
        //     'grade_level' => $request->grade_level,
        //     'major'       => $request->major,
        //     'subject_id'  => $request->subject_id,
        //     'chapter'     => $request->chapter,
        //     'title'       => $request->title,
        //     'type'        => $request->type,
        //     'link_url'    => $request->link_url,
        //     'description' => $request->description,
        //     'class_id'    => 1 // Default atau sesuaikan logika kelas
        // ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }
}