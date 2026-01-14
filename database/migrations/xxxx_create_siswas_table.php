<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nisn')->unique();
            $table->timestamps();

            $table->foreignId('id_user')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswas');
    }
};
