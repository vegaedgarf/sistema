<?php
// app/Models/CorpoPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'corpo_plans';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    // Un Plan tiene muchos Detalles (las actividades y frecuencias que lo componen)
    public function details(): HasMany
    {
        return $this->hasMany(PlanDetail::class, 'plan_id');
    }

    // Un Plan tiene muchos Precios (historial de precios)
    public function prices(): HasMany
    {
        return $this->hasMany(PlanPrice::class, 'plan_id');
    }

    // Un Plan tiene muchas Membresías (contratos)
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'plan_id');
    }
}