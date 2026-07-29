<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable, SoftDeletes, LogsActivity, HasRoles, MustVerifyEmail;

    protected $fillable = [
        'name', 'email', 'password', 'public_user_id', 'institution_id',
        'linked_entity_type', 'linked_entity_id', 'account_status',
        'must_change_password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_change_password' => 'boolean',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['password']);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // Part-3 Account Status Lifecycle helper
    public function isActive(): bool
    {
        return $this->account_status === 'active'
            && (! $this->institution || $this->institution->isActive());
    }
}
