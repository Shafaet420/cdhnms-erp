<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('student_id')->unique(); // public identifier, auto-generated
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admission_application_id')->nullable()
                ->constrained('admission_applications')->nullOnDelete();

            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->date('dob');
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('qr_token')->unique()->nullable();

            $table->foreignId('academic_session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->string('roll_number')->nullable();

            $table->string('status')->default('active'); // active|promoted|transferred|archived
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('guardian_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('promotion_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_academic_session_id')->nullable()->constrained('academic_sessions')->nullOnDelete();
            $table->foreignId('to_academic_session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->foreignId('from_school_class_id')->nullable()->constrained('school_classes')->nullOnDelete();
            $table->foreignId('to_school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('promoted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('promoted_at')->useCurrent();
            // append-only, never updated (Part-4 History Policy)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_histories');
        Schema::dropIfExists('guardian_student');
        Schema::dropIfExists('students');
    }
};
