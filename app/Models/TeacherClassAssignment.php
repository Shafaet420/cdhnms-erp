<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassAssignment extends Model
{
    protected $fillable = [
        'teacher_id', 'school_class_id', 'section_id', 'academic_session_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
