<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('hasLectures')->default(false);
            $table->boolean('hasSeminars')->default(false);
            $table->boolean('hasLabs')->default(false);
            $table->boolean('hasExam')->default(false);
            $table->boolean('hasOa')->default(false);
            $table->boolean('hasCw')->default(false);
            $table->boolean('hasCp')->default(false);
            $table->string('code')->unique();
            $table->tinyInteger('credits');
            $table->foreignId('major_id')->nullable()->constrained()->onDelete('restrict'); //Set major id to indicate if the course belongs to a major or is applicable to all majors
            $table->boolean('is_elective_group')->default(false);
            $table->foreignId('elective_course_group_id')->nullable()->constrained('courses','id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
