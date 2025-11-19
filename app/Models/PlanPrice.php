<?php
// app/Models/CorpoPlanPrice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanPrice extends Model
{
    // No usamos SoftDeletes aquí, el registro de precio es inmutable.

    protected $table = 'corpo_plan_prices';

    protected $fillable = [
        'plan_id',
        'price',
        'tax_rate',
        'valid_from',
        'valid_to',
    ];

    // Un Precio pertenece a un Plan
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    // Un Precio (snapshot) puede ser usado en varias facturas (CorpoPayment)
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'plan_price_id');
    }
}