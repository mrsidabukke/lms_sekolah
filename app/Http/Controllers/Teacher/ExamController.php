<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    // 1. Daftar Ujian
    public function index()
    {
        // Ambil data ujian (bisa difilter per guru nantinya)
        $exams = Quiz::orderBy('created_at', 'desc')->get();
        return view('teacher.exams.index', compact('exams'));
    }

    // 2. Form Buat Ujian Baru
    public function create()
    {
        return view('teacher.exams.create');
    }

    // 3. Simpan Header Ujian
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subject_id' => 'required',
            'class_id' => 'required',
            'duration_minutes' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $exam = Quiz::create([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'chapter' => $request->chapter,
            'duration_minutes' => $request->duration_minutes,
            'deadline' => $request->deadline,
            'is_active' => 1
        ]);

        // Redirect ke halaman penyusunan soal
        return redirect()->route('guru.ujian.show', $exam->id)->with('success', 'Ujian dibuat! Silakan tambah soal.');
    }

    // 4. Halaman Builder Soal (Detail Ujian)
    public function show($id)
    {
        $exam = Quiz::findOrFail($id);
        $questions = QuizQuestion::where('quiz_id', $id)->get();
        return view('teacher.exams.show', compact('exam', 'questions'));
    }

    // 5. Simpan Pertanyaan Baru
    public function storeQuestion(Request $request, $id)
    {
        // Validasi langsung untuk opsi jawaban
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        QuizQuestion::create([
            'quiz_id'        => $id,
            'type'           => 'multiple_choice', // Hardcode tipe
            'question'       => $request->question,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'correct_option' => $request->correct_option,
            // Simpan teks jawaban benar untuk kemudahan display nanti
            'correct_answer' => $request->input('option_' . $request->correct_option) 
        ]);

        return back()->with('success', 'Soal pilihan ganda berhasil ditambahkan!');
    }

    public function importQuestions(Request $request, $id)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Import file menggunakan Class yang tadi dibuat
        Excel::import(new QuestionsImport($id), $request->file('file_excel'));

        return back()->with('success', 'Soal berhasil diimport dari Excel!');
    }

    public function downloadTemplate()
    {
        // Cara cepat membuat template excel download
        // Di real project, simpan file asli di storage/app/public/template_soal.xlsx
        // Ini contoh simple membuat file on-the-fly tidak disarankan untuk production besar, 
        // tapi cukup untuk tugas kuliah.
        
        // Saran: Buat file Excel manual dengan header: 
        // pertanyaan | opsi_a | opsi_b | opsi_c | opsi_d | kunci_jawaban
        // Simpan di folder public/templates/template_soal.xlsx
        
        $path = public_path('templates/template_soal.xlsx');
        return response()->download($path);
    }

    // 6. Hapus Soal
    public function destroyQuestion($id)
    {
        QuizQuestion::destroy($id);
        return back()->with('success', 'Soal dihapus.');
    }
}