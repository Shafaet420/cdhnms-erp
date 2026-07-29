<?php

namespace App\Services;

use App\Engines\WorkflowEngine;
use App\Models\AdmissionApplication;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Part-3/6 "Admission Approved -> Auto Create Student Account" business rule, kept in
 * the Service layer (Part-9.1) rather than scattered across a controller.
 */
class AdmissionService
{
    public function __construct(protected WorkflowEngine $workflow) {}

    public function approve(AdmissionApplication $application, ?string $remarks = null): Student
    {
        return DB::transaction(function () use ($application, $remarks) {
            $this->workflow->transition($application, 'approved', $remarks);

            $application->update([
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            $student = Student::create([
                'institution_id' => $application->institution_id,
                'admission_application_id' => $application->id,
                'name_en' => $application->applicant_name_en,
                'name_bn' => $application->applicant_name_bn,
                'dob' => $application->dob,
                'gender' => $application->gender,
                'academic_session_id' => $application->academic_session_id,
                'school_class_id' => $application->school_class_id,
                'status' => 'active',
            ]);

            $application->update(['created_student_id' => $student->id]);
            $this->workflow->transition($application, 'completed', 'Auto-completed after student creation.');

            return $student;
        });
    }

    public function reject(AdmissionApplication $application, string $remarks): AdmissionApplication
    {
        $this->workflow->transition($application, 'rejected', $remarks);

        return $application;
    }
}
