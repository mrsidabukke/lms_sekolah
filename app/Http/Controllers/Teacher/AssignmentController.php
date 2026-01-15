<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;          // Pastikan Model ini ada
use App\Models\QuizQuestion;  // Pastikan Model ini ada
// use App\Models\Assignment; // Uncomment jika sudah ada model Assignment
// use App\Models\Submission; // Uncomment jika sudah ada model Submission

class AssignmentController extends Controller
{
    /**
     * Menampilkan daftar tugas/kuis
     */
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
                'deadline' => '2023-12-20 23:59',
                'submitted_count' => 28,
                'total_students' => 28,
                'status' => 'completed'
            ]
        ];
        return view('teacher.assignments.index', compact('assignments'));
    }

    /**
     * Halaman form pembuatan tugas/kuis baru
     */
    public function create()
    {
        return view('teacher.assignments.create');
    }

    /**
     * Menyimpan data Tugas atau Kuis ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi Umum (Wajib untuk kedua tipe)
        $request->validate([
            'type'        => 'required|in:assignment,quiz', 
            'title'       => 'required|string|max:255',
            'class_id'    => 'required',
            'subject_id'  => 'required',
            'deadline'    => 'required|date',
        ]);

        if ($request->type === 'assignment') {
            // --- LOGIC A: SIMPAN TUGAS FILE (Assignment) ---
            
            // Validasi tambahan khusus file
            // $request->validate(['file_upload' => 'nullable|file|max:10240']);

            // Mockup Simpan DB:
            // Assignment::create([
            //     'class_id' => $request->class_id,
            //     'subject_id' => $request->subject_id,
            //     'title' => $request->title,
            //     'description' => $request->description,
            //     'deadline' => $request->deadline,
            //     'file_path' => $request->file('file_upload') ? $request->file('file_upload')->store('assignments') : null,
            //     'link_url' => $request->link_url
            // ]);
            
            return redirect()->route('guru.tugas.index')->with('success', 'Tugas upload berhasil diterbitkan!');

        } else {
            // --- LOGIC B: SIMPAN KUIS INTERAKTIF (Quiz) ---
            
            // 1. Simpan Header Kuis
            $quiz = Quiz::create([
                'class_id'    => $request->class_id,
                'subject_id'  => $request->subject_id,
                'title'       => $request->title,
                'deadline'    => $request->deadline,
                'passing_score' => 70, // Default KKM
                'is_active'   => 1
            ]);

            // 2. Loop dan Simpan Pertanyaan (Array dari form repeater)
            if ($request->has('questions')) {
                foreach ($request->questions as $q) {
                    // Pastikan data opsi lengkap sebelum simpan
                    if(isset($q['text']) && isset($q['correct'])) {
                        QuizQuestion::create([
                            'quiz_id'        => $quiz->id,
                            'question'       => $q['text'],
                            'option_a'       => $q['options']['a'],
                            'option_b'       => $q['options']['b'],
                            'option_c'       => $q['options']['c'],
                            'option_d'       => $q['options']['d'],
                            'correct_option' => $q['correct'], // a, b, c, atau d
                            'correct_answer' => $q['options'][$q['correct']] // Simpan teks jawaban
                        ]);
                    }
                }
            }

            return redirect()->route('guru.tugas.index')->with('success', 'Kuis interaktif berhasil diterbitkan!');
        }
    }

    /**
     * Halaman Detail Submission & Penilaian
     */
    public function show($id)
    {
        // Mock Data: List Siswa (Saya update agar punya student_id untuk bulk grading)
        $submissions = [
            (object)[
                'id' => 101, 
                'student_id' => 1, 
                'name' => 'Ahmad Dahlan', 
                'submitted_at' => '2024-01-08 10:00', 
                'score' => 90, 
                'feedback' => 'Bagus sekali',
                'status' => 'graded',
                'file_path' => 'dummy.pdf'
            ],
            (object)[
                'id' => 102, 
                'student_id' => 2, 
                'name' => 'Siti Aminah', 
                'submitted_at' => '2024-01-09 14:30', 
                'score' => null, 
                'feedback' => null,
                'status' => 'submitted',
                'file_path' => 'dummy.pdf'
            ],
            (object)[
                'id' => 103, 
                'student_id' => 3, 
                'name' => 'Budi Utomo', 
                'submitted_at' => null, 
                'score' => null, 
                'feedback' => null,
                'status' => 'pending',
                'file_path' => null
            ],
        ];

        return view('teacher.assignments.show', compact('submissions'));
    }

    /**
     * Menyimpan Nilai Satuan (Lewat Modal Popup)
     */
    public function grade(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required',
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        // Logic Update DB Satuan...
        
        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Menyimpan Nilai Massal (Lewat Tabel Bulk Grading)
     * FITUR BARU
     */
    public function bulkGrade(Request $request, $id)
    {
        // Validasi array input dari tabel
        $request->validate([
            'submissions' => 'required|array',
            'submissions.*.score' => 'nullable|numeric|min:0|max:100',
            'submissions.*.feedback' => 'nullable|string|max:255',
        ]);

        $data = $request->input('submissions');

        // Loop setiap siswa yang ada di tabel
        foreach ($data as $studentId => $fields) {
            
            // Hanya simpan jika nilai diisi (tidak null)
            if (isset($fields['score']) && $fields['score'] !== null) {
                
                // MOCKUP LOGIC: UpdateOrInsert ke Database Real
                // \App\Models\Submission::updateOrCreate(
                //     ['assignment_id' => $id, 'student_id' => $studentId],
                //     [
                //         'score'     => $fields['score'],
                //         'feedback'  => $fields['feedback'] ?? null,
                //         'status'    => 'graded',
                //         'graded_at' => now()
                //     ]
                // );
                
                // Untuk debugging sementara, kita bisa log data yang masuk
                // \Log::info("Menilai Siswa ID: $studentId dengan Nilai: " . $fields['score']);
            }
        }

        return back()->with('success', 'Semua nilai berhasil disimpan secara massal!');
    }
}