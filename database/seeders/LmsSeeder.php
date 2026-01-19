<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Course;
use App\Models\Module;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Hash;

class LmsSeeder extends Seeder
{
    public function run(): void
    {
        // Create departments
        $departments = [
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Jurusan yang mempelajari pengembangan software',
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'description' => 'Jurusan yang mempelajari jaringan komputer',
            ],
            [
                'code' => 'MM',
                'name' => 'Multimedia',
                'description' => 'Jurusan yang mempelajari desain dan multimedia',
            ],
            [
                'code' => 'AK',
                'name' => 'Akuntansi',
                'description' => 'Jurusan yang mempelajari akuntansi dan keuangan',
            ],
            [
                'code' => 'PM',
                'name' => 'Pemasaran',
                'description' => 'Jurusan yang mempelajari pemasaran dan bisnis',
            ],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Get RPL department
        $rplDepartment = Department::where('code', 'RPL')->first();

        // Create sample course
        $course = Course::create([
            'code' => 'RPL-101',
            'title' => 'Pemrograman Web Dasar',
            'description' => 'Mata pelajaran dasar pemrograman web menggunakan HTML, CSS, dan JavaScript',
            'department_id' => $rplDepartment->id,
            'teacher_id' => 1, // ID guru dari seeder sebelumnya
            'credit_hours' => 4,
            'duration_weeks' => 16,
            'start_date' => now(),
            'end_date' => now()->addWeeks(16),
            'is_active' => true,
            'is_public' => true,
            'max_students' => 30,
            'passing_score' => 70,
        ]);

        // Create modules
        $modules = [
            [
                'title' => 'Pengenalan HTML',
                'description' => 'Memahami dasar-dasar HTML',
                'order' => 1,
                'duration_minutes' => 180,
            ],
            [
                'title' => 'CSS Dasar',
                'description' => 'Memahami styling dengan CSS',
                'order' => 2,
                'duration_minutes' => 240,
            ],
            [
                'title' => 'JavaScript Dasar',
                'description' => 'Memahami pemrograman dengan JavaScript',
                'order' => 3,
                'duration_minutes' => 300,
            ],
        ];

        foreach ($modules as $moduleData) {
            $module = Module::create(array_merge($moduleData, [
                'course_id' => $course->id,
                'is_active' => true,
            ]));

            // Create materials for each module
            $this->createMaterialsForModule($module);

            // Create quiz for module
            $this->createQuizForModule($module);

            // Create task for module
            $this->createTaskForModule($module);
        }

        // Enroll sample student to course
        $student = User::where('identifier', '310506')->first();
        if ($student) {
            $course->students()->attach($student->id, [
                'enrolled_at' => now(),
                'progress' => 0,
                'status' => 'enrolled',
            ]);

            // Update enrollment count
            $course->enrollment_count = 1;
            $course->save();
        }
    }

    private function createMaterialsForModule(Module $module)
    {
        $materials = [
            [
                'title' => 'Pengenalan ' . $module->title,
                'content' => 'Ini adalah materi pengenalan untuk ' . $module->title,
                'content_type' => 'text',
                'order' => 1,
                'duration_minutes' => 30,
            ],
            [
                'title' => 'Video Tutorial ' . $module->title,
                'content' => 'Tonton video tutorial berikut',
                'content_type' => 'video',
                'content_url' => 'https://www.youtube.com/watch?v=example',
                'order' => 2,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'PDF Materi ' . $module->title,
                'content' => 'Baca materi berikut dalam format PDF',
                'content_type' => 'pdf',
                'content_url' => 'https://example.com/materi.pdf',
                'order' => 3,
                'duration_minutes' => 60,
            ],
        ];

        foreach ($materials as $materialData) {
            Material::create(array_merge($materialData, [
                'module_id' => $module->id,
                'is_active' => true,
                'requires_completion' => true,
            ]));
        }
    }

    private function createQuizForModule(Module $module)
    {
        $quiz = Quiz::create([
            'module_id' => $module->id,
            'title' => 'Quiz ' . $module->title,
            'description' => 'Quiz untuk menguji pemahaman tentang ' . $module->title,
            'duration_minutes' => 30,
            'passing_score' => 70,
            'max_attempts' => 3,
            'is_active' => true,
            'available_from' => now(),
            'available_until' => now()->addMonths(1),
            'show_correct_answers' => true,
            'shuffle_questions' => true,
        ]);

        // Create questions
        $questions = [
            [
                'question' => 'Apa kepanjangan dari HTML?',
                'option_a' => 'Hyper Text Markup Language',
                'option_b' => 'High Tech Modern Language',
                'option_c' => 'Hyper Transfer Markup Language',
                'option_d' => 'High Text Multi Language',
                'correct_option' => 'a',
                'order' => 1,
                'points' => 10,
            ],
            [
                'question' => 'Tag HTML untuk membuat paragraf adalah?',
                'option_a' => '<p>',
                'option_b' => '<para>',
                'option_c' => '<paragraph>',
                'option_d' => '<pg>',
                'correct_option' => 'a',
                'order' => 2,
                'points' => 10,
            ],
            [
                'question' => 'Apa fungsi dari tag <br>?',
                'option_a' => 'Membuat garis baru',
                'option_b' => 'Membuat teks tebal',
                'option_c' => 'Membuat tabel',
                'option_d' => 'Membuat link',
                'correct_option' => 'a',
                'order' => 3,
                'points' => 10,
            ],
        ];

        foreach ($questions as $questionData) {
            QuizQuestion::create(array_merge($questionData, [
                'quiz_id' => $quiz->id,
            ]));
        }
    }

    private function createTaskForModule(Module $module)
    {
        Task::create([
            'module_id' => $module->id,
            'title' => 'Tugas ' . $module->title,
            'description' => 'Kerjakan tugas berikut untuk melatih pemahaman tentang ' . $module->title,
            'instructions' => 'Buatlah contoh implementasi dari materi yang telah dipelajari',
            'max_score' => 100,
            'deadline' => now()->addWeeks(2),
            'allow_revision' => true,
            'is_active' => true,
        ]);
    }
}
