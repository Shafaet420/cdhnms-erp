<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberSequence extends Model
{
    protected $fillable = [
        'institution_id', 'sequence_key', 'prefix', 'year_component', 'padding', 'last_value',
    ];
}
