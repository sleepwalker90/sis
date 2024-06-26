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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('study_plan_id')->constrained()->onDelete('restrict');
            $table->foreignId('academic_year_id')->constrained()->onDelete('restrict');
            $table->timestamps();

            $table->unique(['number', 'academic_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};
