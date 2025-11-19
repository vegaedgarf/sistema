<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanDetail extends Model
{
    // No requiere SoftDeletes ni Timestamps

   public $timestamps = false;
   
    protected $table = 'corpo_plan_details';

    protected $fillable = [
        'plan_id',
        'activity_id',
        'times_per_week',
    ];

    // Un Detalle pertenece a un Plan
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    // Un Detalle pertenece a una Actividad
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}