<?php

namespace App\Models;

use App\Engines\NumberGeneratorEngine;
use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Teacher extends Model
{
    use SoftDeletes, LogsActivity, BelongsToInstitution;

    protected $fillable = [
        'institution_id', 'teacher_id', 'user_id', 'name_en', 'name_bn', 'dob',
        'gender', 'nid', 'photo_path', 'joining_date', 'qualification', 'designation',
        'status', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logFillable();
    }

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher) {
            if (empty($teacher->teacher_id)) {
                $teacher->teacher_id = app(NumberGeneratorEngine::class)
                    ->next($teacher->institution_id, 'teacher_id', 'TCH');
            }
        });
    }

    public function classAssignments()
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }
}
