<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_relations_to_quizzes_table.php
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Menambahkan relasi agar sinkron dengan dashboard guru
            $table->foreignId('class_id')->after('id')->nullable(); 
            $table->foreignId('subject_id')->after('class_id')->nullable();
            
            // Opsional: Deadline khusus kuis
            $table->dateTime('deadline')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            //
        });
    }
};
