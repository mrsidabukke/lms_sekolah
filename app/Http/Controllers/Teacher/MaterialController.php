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
        // Simulasi data (nanti ganti dengan Material::where('user_id', auth()->id())->get())
        $materials = [
            (object)[
                'title' => 'Aljabar Linear Dasar',
                'type' => 'pdf',
                'class' => 'Kelas X-A',
                'date' => '07 Jan 2024'
            ],
             (object)[
                'title' => 'Video Pembahasan Trigonometri',
                'type' => 'video',
                'class' => 'Kelas XI-B',
                'date' => '06 Jan 2024'
            ]
        ];
        return view('teacher.materials.index', compact('materials'));
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
            'title' => 'required',
            'type' => 'required',
            'file_upload' => 'required_if:type,pdf|mimes:pdf,ppt,pptx|max:10240', // Max 10MB
            'video_url' => 'required_if:type,video|url'
        ]);

        // Logic simpan file
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $filePath = $request->file('file_upload')->store('materials', 'public');
        }

        // Simpan ke DB (Code Mockup)
        // Material::create([
        //     'title' => $request->title,
        //     'type' => $request->type,
        //     'file_path' => $filePath,
        //     'video_url' => $request->video_url,
        //     ... dst
        // ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diunggah!');
    }
}