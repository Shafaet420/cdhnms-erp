<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionWorkflowLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'admission_application_id', 'from_state', 'to_state', 'actor_user_id', 'remarks', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
