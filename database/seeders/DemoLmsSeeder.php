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
use App\Models\Department;

class DemoLmsSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =========================
         * DEPARTMENTS (MASTER)
         * =========================
         */
        $department = Department::firstOrCreate(
            ['id' => 1],
            ['name' => 'Teknik Mesin']
        );

        /**
         * =========================
         * USER (SISWA)
         * =========================
         */
        $user = User::firstOrCreate(
            ['email' => 'demo@siswa.test'],
            [
                'name' => 'Demo Siswa',
                'password' => Hash::make('password'),
                'nisn' => '1234567890',
                'department_id' => $department->id,
            ]
        );

        /**
         * =========================
         * MODULE
         * =========================
         */
        $module = Module::firstOrCreate(
            ['title' => 'Belajar DevOps Dasar'],
            [
                'description'   => 'Module demo LMS Sekolah',
                'department_id' => $department->id,
                'is_active'     => true,
            ]
        );

        /**
         * =========================
         * SECTIONS
         * =========================
         */
        $section1 = Section::firstOrCreate([
            'module_id' => $module->id,
            'title'     => 'Pendahuluan',
            'order'     => 1,
        ]);

        $section2 = Section::firstOrCreate([
            'module_id' => $module->id,
            'title'     => 'Praktik & Evaluasi',
            'order'     => 2,
        ]);

        /**
         * =========================
         * LESSONS
         * =========================
         */

        // TEXT
        $lessonText = Lesson::firstOrCreate(
            ['title' => 'Apa itu DevOps?'],
            [
                'module_id'   => $module->id,
                'section_id'  => $section1->id,
                'content_type'=> 'text',
                'content'     => 'DevOps adalah budaya kolaborasi antara Development dan Operations.',
                'duration'    => 120,
                'order'       => 1,
                'position'    => 1,
            ]
        );

        // PDF
        $lessonPdf = Lesson::firstOrCreate(
            ['title' => 'Slide DevOps'],
            [
                'module_id'   => $module->id,
                'section_id'  => $section1->id,
                'content_type'=> 'pdf',
                'content'     => 'Silakan pelajari slide DevOps berikut.',
                'content_url' => 'https://drive.google.com/file/d/1NWDKf4tEoi-_Y7ADq7s73XKiPS_y4a3Y/view',
                'duration'    => 180,
                'order'       => 2,
                'position'    => 2,
            ]
        );

        // VIDEO
        $lessonVideo = Lesson::firstOrCreate(
            ['title' => 'Video Pengenalan DevOps'],
            [
                'module_id'   => $module->id,
                'section_id'  => $section2->id,
                'content_type'=> 'video',
                'content'     => 'Silakan pelajari video DevOps berikut.',
                'content_url' => 'https://youtu.be/tUUDL8QE1Wg',
                'duration'    => null,
                'order'       => 3,
                'position'    => 3,
            ]
        );

        /**
         * =========================
         * QUIZ
         * =========================
         */
        $quiz = Quiz::firstOrCreate(
            ['title' => 'Quiz DevOps Dasar'],
            [
                'module_id'     => $module->id,
                'section_id'    => $section2->id,
                'lesson_id'     => $lessonVideo->id,
                'position'      => 4,
                'passing_score' => 70,
                'is_active'     => true,
            ]
        );

        QuizQuestion::firstOrCreate([
            'quiz_id' => $quiz->id,
            'question'=> 'Apa tujuan utama DevOps?',
        ], [
            'option_a' => 'Mempercepat delivery software',
            'option_b' => 'Menghapus testing',
            'option_c' => 'Menambah server',
            'option_d' => 'Mengurangi developer',
            'correct_option' => 'a',
        ]);

        /**
         * =========================
         * TASK
         * =========================
         */
        $task = Task::firstOrCreate(
            ['title' => 'Tugas Video DevOps'],
            [
                'module_id'      => $module->id,
                'lesson_id'      => $lessonVideo->id,
                'description'    => 'Kirim link Google Drive atau YouTube berisi penjelasan DevOps versi kamu.',
                'deadline'       => Carbon::now()->addDays(7),
                'allow_revision' => true,
                'is_active'      => true,
            ]
        );

        /**
         * =========================
         * TASK SUBMISSION (CONTOH)
         * =========================
         */
        TaskSubmission::firstOrCreate(
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
            ],
            [
                'submission_link' => 'https://drive.google.com/file/d/XXXXX/view',
                'status'          => 'submitted',
            ]
        );
    }
}
