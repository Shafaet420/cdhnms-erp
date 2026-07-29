<?php

namespace App\Http\Livewire;

use App\Models\AdmissionApplication;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'pending_admissions' => AdmissionApplication::whereIn('workflow_state', [
                'submitted', 'under_review', 'verified',
            ])->count(),
            'approved_today' => AdmissionApplication::where('workflow_state', 'completed')
                ->whereDate('approved_at', today())->count(),
        ];

        $recentAdmissions = AdmissionApplication::latest()->limit(5)->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentAdmissions' => $recentAdmissions,
            'user' => Auth::user(),
        ])->layout('layouts.app');
    }
}
