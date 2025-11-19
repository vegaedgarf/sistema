<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Membership extends Model
{
    use SoftDeletes;

    protected $table = 'corpo_memberships';

    protected $fillable = [
        'member_id',
        'plan_id',
        'start_date',
        'end_date',
        'plan_price_at_purchase',
        'discount_applied',
        'final_price',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'plan_price_at_purchase' => 'decimal:2',
        'discount_applied' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    // --- Relaciones ---

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Relación con Pagos (La crearemos en el siguiente paso del módulo)
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'membership_id');
    }

    // --- Helpers / Accessors ---

    /**
     * Calcula el saldo pendiente (Precio Final - Total Pagado).
     */
    public function getBalanceAttribute(): float
    {
        // Asumiendo que Payment tiene un campo 'amount'
        $paid = $this->payments()->sum('amount');
        return $this->final_price - $paid;
    }

    /**
     * Verifica si la membresía está vencida.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->end_date < Carbon::today();
    }
}