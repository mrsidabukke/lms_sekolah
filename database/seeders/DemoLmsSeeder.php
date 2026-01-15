<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Module;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class DemoLmsSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =========================
         * USER DEMO
         * =========================
         */
        $user = User::create([
            'name' => 'Demo Siswa',
            'email' => 'demo@siswa.test',
            'password' => Hash::make('password'),
        ]);

        /**
         * =========================
         * MODULE
         * =========================
         */
        $module = Module::create([
            'title' => 'Belajar DevOps Dasar',
            'description' => 'Module demo untuk LMS Sekolah',
            'department_id' => 1,
            'is_active' => true,
        ]);

        /**
         * =========================
         * SECTION (BAB)
         * =========================
         */
        $section1 = Section::create([
            'module_id' => $module->id,
            'title' => 'Pendahuluan',
            'order' => 1,
        ]);

        $section2 = Section::create([
            'module_id' => $module->id,
            'title' => 'Konsep Dasar',
            'order' => 2,
        ]);

        /**
         * =========================
         * LESSON
         * =========================
         */
        $lesson1 = Lesson::create([
            'module_id' => $module->id,
            'section_id' => $section1->id,
            'title' => 'Apa itu DevOps?',
            'content' => 'DevOps adalah budaya kolaborasi antara development dan operations.',
            'order' => 1,
            'position' => 1,
        ]);

        $lesson2 = Lesson::create([
            'module_id' => $module->id,
            'section_id' => $section1->id,
            'title' => 'Manfaat DevOps',
            'content' => 'DevOps mempercepat delivery dan meningkatkan kualitas.',
            'order' => 2,
            'position' => 2,
        ]);

        /**
         * =========================
         * QUIZ (INLINE DI MODULE)
         * =========================
         */
        $quiz = Quiz::create([
            'module_id' => $module->id,
            'section_id' => $section2->id,
            'lesson_id' => $lesson2->id, // quiz membuka lesson ini
            'title' => 'Quiz DevOps Dasar',
            'position' => 3,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        /**
         * =========================
         * QUIZ QUESTIONS
         * =========================
         */
        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa kepanjangan dari DevOps?',
            'option_a' => 'Development & Operations',
            'option_b' => 'Device Operations',
            'option_c' => 'Developer Options',
            'option_d' => 'Deployment System',
            'correct_option' => 'a',
        ]);

        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Tujuan utama DevOps adalah?',
            'option_a' => 'Menambah dokumentasi',
            'option_b' => 'Mempercepat delivery software',
            'option_c' => 'Mengurangi testing',
            'option_d' => 'Menghapus server',
            'correct_option' => 'b',
        ]);
    }
}
