<?php

namespace App\Http\Livewire\Students;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->with(['schoolClass', 'section', 'academicSession'])
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('name_en', 'like', "%{$this->search}%")
                        ->orWhere('student_id', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.students.student-list', [
            'students' => $students,
        ])->layout('layouts.app');
    }
}
