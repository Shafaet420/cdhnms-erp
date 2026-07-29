<?php

namespace App\Models;

use App\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use SoftDeletes, BelongsToInstitution;

    protected $table = 'school_classes';

    protected $fillable = [
        'institution_id', 'department_id', 'name_en', 'name_bn', 'display_order', 'status',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
