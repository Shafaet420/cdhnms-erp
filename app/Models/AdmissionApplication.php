<?php

namespace App\Models;

use App\Engines\NumberGeneratorEngine;
use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AdmissionApplication extends Model
{
    use SoftDeletes, LogsActivity, BelongsToInstitution;

    protected $fillable = [
        'institution_id', 'academic_session_id', 'school_class_id', 'application_number',
        'applicant_name_en', 'applicant_name_bn', 'dob', 'gender', 'guardian_name',
        'guardian_mobile', 'previous_school', 'workflow_state', 'waiting_list_position',
        'remarks', 'verified_by', 'approved_by', 'approved_at', 'created_student_id',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'approved_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logFillable();
    }

    protected static function booted(): void
    {
        static::creating(function (AdmissionApplication $application) {
            if (empty($application->application_number)) {
                $application->application_number = app(NumberGeneratorEngine::class)
                    ->next($application->institution_id, 'admission_number', 'ADM');
            }
        });
    }

    public function workflowLogs()
    {
        return $this->hasMany(AdmissionWorkflowLog::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function createdStudent()
    {
        return $this->belongsTo(Student::class, 'created_student_id');
    }
}
