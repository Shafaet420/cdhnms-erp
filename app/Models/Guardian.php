<?php

namespace App\Models;

use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Guardian extends Model
{
    use SoftDeletes, LogsActivity, BelongsToInstitution;

    protected $fillable = [
        'institution_id', 'name', 'relationship', 'mobile', 'nid', 'occupation',
        'address', 'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logFillable();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'guardian_student')->withPivot('is_primary');
    }
}
