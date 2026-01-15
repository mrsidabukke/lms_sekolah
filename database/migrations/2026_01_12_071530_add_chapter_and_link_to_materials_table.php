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
        Schema::table('materials', function (Blueprint $table) {
            // Tambahan Hierarki
            $table->string('grade_level')->after('class_id'); // Contoh: X, XI, XII
            $table->string('major')->after('grade_level');    // Contoh: RPL, TKJ, IPA
            $table->string('chapter')->after('subject_id');   // Contoh: Bab 1: Eksponen
            
            // Ubah struktur penyimpanan (File fisik jadi Link)
            $table->string('link_url')->nullable()->after('type'); 
            
            // File path jadi nullable (opsional jika masih mau support upload langsung)
            $table->string('file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            //
        });
    }
};
