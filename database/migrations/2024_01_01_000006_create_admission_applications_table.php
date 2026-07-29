<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->string('application_number')->unique()->nullable(); // public identifier, set on submit

            $table->string('applicant_name_en');
            $table->string('applicant_name_bn')->nullable();
            $table->date('dob');
            $table->string('gender')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_mobile');
            $table->string('previous_school')->nullable();

            // Workflow Engine states — Part-3
            $table->enum('workflow_state', [
                'draft', 'submitted', 'under_review', 'verified',
                'approved', 'rejected', 'need_correction', 'completed', 'archived',
            ])->default('draft');

            $table->unsignedInteger('waiting_list_position')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            // Set once approved + auto student creation runs
            $table->foreignId('created_student_id')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('admission_workflow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_application_id')->constrained('admission_applications')->cascadeOnDelete();
            $table->string('from_state')->nullable();
            $table->string('to_state');
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // append-only log — no updated_at, no soft delete: history never deleted (Part-4)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_workflow_logs');
        Schema::dropIfExists('admission_applications');
    }
};
