<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Backs the reusable NumberGeneratorEngine (Part-9.3) — one table drives
        // Student ID, Admission No, Receipt No, Certificate No, etc. per institution,
        // per configurable format, instead of one-off numbering logic per module.
        Schema::create('number_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('sequence_key'); // e.g. "student_id", "admission_number"
            $table->string('prefix')->nullable(); // e.g. "STU"
            $table->unsignedInteger('year_component')->nullable(); // e.g. 2026, for STU-2026-0001 style
            $table->unsignedInteger('padding')->default(4); // zero-padding width
            $table->unsignedBigInteger('last_value')->default(0);
            $table->timestamps();

            $table->unique(['institution_id', 'sequence_key', 'year_component']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('number_sequences');
    }
};
