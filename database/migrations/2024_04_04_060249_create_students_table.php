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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('fn',false,true);
            $table->foreignId('major_id')->constrained()->onDelete('restrict');
            $table->tinyInteger('started_semester')->default(0);
            $table->tinyInteger('certified_semester')->default(0);
            $table->foreignId('student_status_id')->constrained()->onDelete('restrict');
            $table->foreignId('study_plan_id')->constrained()->onDelete('restrict');
            $table->foreignId('tuition_id')->constrained()->onDelete('restrict');
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('egn', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
