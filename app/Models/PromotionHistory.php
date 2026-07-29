<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionHistory extends Model
{
    // History Never Deleted (Part-1/4): no SoftDeletes needed because there is no
    // update/delete path exposed anywhere in the app for this table — append only.
    public $timestamps = false;

    protected $fillable = [
        'student_id', 'from_academic_session_id', 'to_academic_session_id',
        'from_school_class_id', 'to_school_class_id', 'promoted_by', 'promoted_at',
    ];

    protected $casts = [
        'promoted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
