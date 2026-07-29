<?php

namespace App\Models;

use App\Engines\NumberGeneratorEngine;
use App\Engines\QrEngine;
use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use SoftDeletes, LogsActivity, BelongsToInstitution;

    protected $fillable = [
        'institution_id', 'student_id', 'user_id', 'admission_application_id',
        'name_en', 'name_bn', 'dob', 'gender', 'blood_group', 'photo_path', 'qr_token',
        'academic_session_id', 'school_class_id', 'section_id', 'roll_number',
        'status', 'remarks', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logFillable();
    }

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            // Automation Policy (Part-1/6): Student ID and QR token are never entered
            // manually — always generated via the shared engines.
            if (empty($student->student_id)) {
                $student->student_id = app(NumberGeneratorEngine::class)
                    ->next($student->institution_id, 'student_id', 'STU');
            }
            if (empty($student->qr_token)) {
                $student->qr_token = app(QrEngine::class)->generateToken();
            }
        });
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student')->withPivot('is_primary');
    }

    public function admissionApplication()
    {
        return $this->belongsTo(AdmissionApplication::class);
    }

    public function promotionHistories()
    {
        return $this->hasMany(PromotionHistory::class);
    }
}
