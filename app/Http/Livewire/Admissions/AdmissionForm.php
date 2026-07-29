<?php

namespace App\Http\Livewire\Admissions;

use App\Engines\WorkflowEngine;
use App\Models\AcademicSession;
use App\Models\AdmissionApplication;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Module 05 "Admission Form" (Part-2/6) — the entry point that was missing from the
 * initial vertical slice. Creates a Draft application, then immediately submits it
 * (Part-3 Workflow Engine: Draft -> Submitted) so it shows up in the Admission
 * Officer / Principal Approval Queue right away.
 */
class AdmissionForm extends Component
{
    public $applicant_name_en = '';
    public $applicant_name_bn = '';
    public $dob = '';
    public $gender = '';
    public $guardian_name = '';
    public $guardian_mobile = '';
    public $previous_school = '';
    public $academic_session_id = '';
    public $school_class_id = '';

    protected function rules(): array
    {
        return [
            'applicant_name_en' => 'required|string|max:255',
            'applicant_name_bn' => 'nullable|string|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'guardian_name' => 'required|string|max:255',
            'guardian_mobile' => 'required|string|max:20',
            'previous_school' => 'nullable|string|max:255',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'school_class_id' => 'required|exists:school_classes,id',
        ];
    }

    public function save(WorkflowEngine $workflow)
    {
        $this->authorize('admission.create');

        $data = $this->validate();
        $data['institution_id'] = Auth::user()->institution_id;
        $data['workflow_state'] = 'draft';

        $application = AdmissionApplication::create($data);

        // Submitted immediately so it enters the Approval Queue — matches the
        // Admission Form -> Admission Workflow flow from Part-2/8.
        $workflow->transition($application, 'submitted', 'Application submitted.');

        session()->flash('success', "Application {$application->application_number} submitted.");

        return redirect()->route('admissions.index');
    }

    public function render()
    {
        return view('livewire.admissions.admission-form', [
            'academicSessions' => AcademicSession::where('status', 'active')->get(),
            'schoolClasses' => SchoolClass::where('status', 'active')->orderBy('display_order')->get(),
        ])->layout('layouts.app');
    }
}
