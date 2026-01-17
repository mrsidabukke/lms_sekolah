<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Module;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Task;
use App\Models\TaskSubmission;

class DemoLmsSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =========================
         * USER (SISWA)
         * =========================
         */
        $user = User::create([
            'name' => 'Demo Siswa',
            'email' => 'demo@siswa.test',
            'password' => Hash::make('password'),
            'nisn' => '1234567890',
            'department_id' => 1,
        ]);

        /**
         * =========================
         * MODULE
         * =========================
         */
        $module = Module::create([
            'title' => 'Belajar DevOps Dasar',
            'description' => 'Module demo LMS Sekolah',
            'department_id' => 1,
            'is_active' => true,
        ]);

        /**
         * =========================
         * SECTIONS
         * =========================
         */
        $section1 = Section::create([
            'module_id' => $module->id,
            'title' => 'Pendahuluan',
            'order' => 1,
        ]);

        $section2 = Section::create([
            'module_id' => $module->id,
            'title' => 'Praktik & Evaluasi',
            'order' => 2,
        ]);

        /**
         * =========================
         * LESSONS
         * =========================
         */

        // TEXT
        $lessonText = Lesson::create([
            'module_id' => $module->id,
            'section_id' => $section1->id,
            'title' => 'Apa itu DevOps?',
            'content_type' => 'text',
            'content' => 'DevOps adalah budaya kolaborasi antara Development dan Operations.',
            'duration' => 120, // 2 menit baca
            'order' => 1,
            'position' => 1,
        ]);

        // PDF
        $lessonPdf = Lesson::create([
            'module_id' => $module->id,
            'section_id' => $section1->id,
            'title' => 'Slide DevOps',
            'content_type' => 'pdf',
            'content' => 'Silakan pelajari slide DevOps berikut.',
            'content_url' => 'https://drive.google.com/file/d/1NWDKf4tEoi-_Y7ADq7s73XKiPS_y4a3Y/view?usp=drive_link',
            'duration' => 180, // 3 menit baca
            'order' => 2,
            'position' => 2,
        ]);

        // VIDEO
        $lessonVideo = Lesson::create([
            'module_id' => $module->id,
            'section_id' => $section2->id,
            'title' => 'Video Pengenalan DevOps',
            'content_type' => 'video',
            'content' => 'Silakan pelajari video DevOps berikut.',
            'content_url' => 'https://youtu.be/tUUDL8QE1Wg',
            'duration' => null, // video tidak pakai duration baca
            'order' => 3,
            'position' => 3,
        ]);

        /**
         * =========================
         * QUIZ
         * =========================
         */
        $quiz = Quiz::create([
            'module_id' => $module->id,
            'section_id' => $section2->id,
            'lesson_id' => $lessonVideo->id,
            'title' => 'Quiz DevOps Dasar',
            'position' => 4,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa tujuan utama DevOps?',
            'option_a' => 'Mempercepat delivery software',
            'option_b' => 'Menghapus testing',
            'option_c' => 'Menambah server',
            'option_d' => 'Mengurangi developer',
            'correct_option' => 'a',
        ]);

        /**
         * =========================
         * TASK (TUGAS)
         * =========================
         */
        $task = Task::create([
    'module_id' => $module->id,
    'lesson_id' => $lessonVideo->id,
    'title' => 'Tugas Video DevOps',
    'description' => 'Kirim link Google Drive atau YouTube berisi penjelasan DevOps versi kamu.',
    'deadline' => Carbon::now()->addDays(7),
    'allow_revision' => true,
    'is_active' => true,
]);

        /**
         * =========================
         * TASK SUBMISSION (CONTOH)
         * =========================
         */
        TaskSubmission::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'submission_link' => 'https://drive.google.com/file/d/XXXXX/view',
           
            'status' => 'submitted',
        ]);
    }
}
