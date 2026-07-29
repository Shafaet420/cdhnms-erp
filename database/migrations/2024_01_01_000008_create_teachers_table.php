<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('teacher_id')->unique(); // public identifier
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('nid')->nullable();
            $table->string('photo_path')->nullable();
            $table->date('joining_date');
            $table->string('qualification')->nullable();
            $table->string('designation')->nullable();

            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('teacher_class_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->foreignId('academic_session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_class_assignments');
        Schema::dropIfExists('teachers');
    }
};
