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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Guru yang upload
            $table->foreignId('subject_id'); // Mata Pelajaran
            $table->foreignId('class_id'); // Kelas Tujuan
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['pdf', 'video']); // Tipe materi
            $table->string('file_path')->nullable(); // Jika PDF/PPT
            $table->string('video_url')->nullable(); // Jika Link Video
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
