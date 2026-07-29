<?php

namespace App\Traits;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Part-4 "Multi-Institution Support" + Part-9 "InstitutionScopeInterceptor" implemented
 * as a single reusable trait. Every model that uses this trait:
 *   1. Is automatically scoped to the logged-in user's institution on every query.
 *   2. Automatically has institution_id (and created_by/updated_by) filled in on create.
 *
 * No controller or service should ever need to write ->where('institution_id', ...) by
 * hand — that manual pattern is exactly what leads to cross-institution data leaks.
 */
trait BelongsToInstitution
{
    protected static function bootBelongsToInstitution(): void
    {
        static::addGlobalScope('institution', function (Builder $builder) {
            if (Auth::check() && Auth::user()->institution_id && ! Auth::user()->hasRole('Super Admin')) {
                $builder->where($builder->getModel()->getTable().'.institution_id', Auth::user()->institution_id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                if (empty($model->institution_id) && Auth::user()->institution_id) {
                    $model->institution_id = Auth::user()->institution_id;
                }
                if (isset($model->created_by) || in_array('created_by', $model->getFillable())) {
                    $model->created_by = Auth::id();
                }
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && ($model->isFillable('updated_by') || array_key_exists('updated_by', $model->getAttributes()))) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Super Admin only — explicitly bypass institution scoping, e.g. for cross-institution
     * reports. Must never be used in a controller reachable by non-Super-Admin roles.
     */
    public function scopeAllInstitutions(Builder $query): Builder
    {
        return $query->withoutGlobalScope('institution');
    }
}
