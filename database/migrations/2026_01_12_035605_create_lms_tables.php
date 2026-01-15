<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Tabel Kelas (Contoh: X-A, XI-B)
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Tabel Mata Pelajaran (Contoh: Matematika Wajib)
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Tabel Jadwal (Untuk fitur "Jadwal Hari Ini")
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Guru
            $table->foreignId('class_id');
            $table->foreignId('subject_id');
            $table->string('room'); // Ruang 301
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day'); // Senin, Selasa, dll
            $table->timestamps();
        });

        // Tabel Tugas (Untuk statistik "Tugas Perlu Dinilai")
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->string('title');
            $table->dateTime('deadline');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Tabel Submission (Tugas yang dikumpul siswa)
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id');
            $table->foreignId('student_id'); // User ID siswa
            $table->integer('score')->nullable(); // Nilai
            $table->string('status')->default('submitted'); // submitted, graded
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_tables');
    }
};
