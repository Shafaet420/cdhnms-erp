<?php

namespace App\Models;

use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes, BelongsToInstitution;

    protected $fillable = ['institution_id', 'name_en', 'name_bn', 'status'];

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
