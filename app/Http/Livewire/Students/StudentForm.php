<?php

namespace App\Http\Livewire\Students;

use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentForm extends Component
{
    public ?Student $student = null;

    public $name_en = '';
    public $name_bn = '';
    public $dob = '';
    public $gender = '';
    public $blood_group = '';
    public $academic_session_id = '';
    public $school_class_id = '';
    public $section_id = '';

    protected function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'nullable|exists:sections,id',
        ];
    }

    public function mount(?Student $student = null): void
    {
        if ($student && $student->exists) {
            $this->student = $student;
            $this->fill($student->only([
                'name_en', 'name_bn', 'dob', 'gender', 'blood_group',
                'academic_session_id', 'school_class_id', 'section_id',
            ]));
        }
    }

    public function save()
    {
        $this->authorize($this->student ? 'student.edit' : 'student.create');

        $data = $this->validate();
        $data['institution_id'] = Auth::user()->institution_id;

        if ($this->student) {
            $this->student->update($data);
            session()->flash('success', 'Student updated.');
        } else {
            $data['status'] = 'active';
            Student::create($data);
            session()->flash('success', 'Student created.');
        }

        return redirect()->route('students.index');
    }

    public function render()
    {
        return view('livewire.students.student-form', [
            'academicSessions' => AcademicSession::where('status', 'active')->get(),
            'schoolClasses' => SchoolClass::where('status', 'active')->orderBy('display_order')->get(),
            'sections' => $this->school_class_id
                ? Section::where('school_class_id', $this->school_class_id)->get()
                : collect(),
        ])->layout('layouts.app');
    }
}
