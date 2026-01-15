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
        // Tambah kolom durasi & bab di tabel quizzes
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('duration_minutes')->default(60)->after('deadline'); // Durasi dalam menit
            $table->string('chapter')->nullable()->after('subject_id'); // Bab materi
        });

        // Tambah tipe soal di tabel quiz_questions
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->enum('type', ['multiple_choice', 'essay'])->default('multiple_choice')->after('quiz_id');
            
            // Buat kolom opsi jadi nullable karena Essay tidak butuh opsi
            $table->string('option_a')->nullable()->change();
            $table->string('option_b')->nullable()->change();
            $table->string('option_c')->nullable()->change();
            $table->string('option_d')->nullable()->change();
            $table->string('correct_option')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
