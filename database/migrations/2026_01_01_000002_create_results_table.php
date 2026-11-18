<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            // one student -> many results
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('course_code');
            $table->unsignedTinyInteger('marks');
            $table->string('grade', 3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
