<?php

namespace App\Http\Livewire\Admissions;

use App\Engines\WorkflowEngine;
use App\Models\AdmissionApplication;
use App\Services\AdmissionService;
use Livewire\Component;

class AdmissionApprove extends Component
{
    public AdmissionApplication $application;
    public string $remarks = '';

    public function mount(AdmissionApplication $application): void
    {
        $this->application = $application;
    }

    public function verify(WorkflowEngine $workflow)
    {
        $this->authorize('admission.verify');
        $workflow->transition($this->application, 'verified', $this->remarks);
        session()->flash('success', 'Application marked as verified.');
    }

    public function approve(AdmissionService $service)
    {
        $this->authorize('admission.approve');
        $student = $service->approve($this->application, $this->remarks);
        session()->flash('success', "Approved. Student created: {$student->student_id}");

        return redirect()->route('admissions.index');
    }

    public function requestCorrection(WorkflowEngine $workflow)
    {
        $this->authorize('admission.reject');
        $workflow->transition($this->application, 'need_correction', $this->remarks);
        session()->flash('success', 'Correction requested from applicant.');

        return redirect()->route('admissions.index');
    }

    public function reject(AdmissionService $service)
    {
        $this->authorize('admission.reject');
        $service->reject($this->application, $this->remarks);
        session()->flash('success', 'Application rejected.');

        return redirect()->route('admissions.index');
    }

    public function render()
    {
        return view('livewire.admissions.admission-approve', [
            'logs' => $this->application->workflowLogs()->latest('created_at')->get(),
        ])->layout('layouts.app');
    }
}
