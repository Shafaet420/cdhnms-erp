<?php

namespace App\Http\Livewire\Institutions;

use App\Models\Institution;
use Livewire\Component;
use Livewire\WithPagination;

class InstitutionList extends Component
{
    use WithPagination;

    public function suspend(Institution $institution)
    {
        $this->authorize('institution.suspend');
        $institution->update(['status' => 'suspended']);
        session()->flash('success', "{$institution->name_en} suspended.");
    }

    public function activate(Institution $institution)
    {
        $this->authorize('institution.activate');
        $institution->update(['status' => 'active']);
        session()->flash('success', "{$institution->name_en} activated.");
    }

    public function render()
    {
        return view('livewire.institutions.institution-list', [
            'institutions' => Institution::latest()->paginate(15),
        ])->layout('layouts.app');
    }
}
