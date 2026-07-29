<?php

namespace App\Http\Livewire\Admissions;

use App\Models\AdmissionApplication;
use Livewire\Component;
use Livewire\WithPagination;

class AdmissionList extends Component
{
    use WithPagination;

    public string $stateFilter = '';

    public function render()
    {
        $applications = AdmissionApplication::query()
            ->with(['schoolClass', 'academicSession'])
            ->when($this->stateFilter, fn ($q) => $q->where('workflow_state', $this->stateFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admissions.admission-list', [
            'applications' => $applications,
        ])->layout('layouts.app');
    }
}
