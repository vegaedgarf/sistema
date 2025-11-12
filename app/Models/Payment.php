<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Member;
use App\Models\Membership;
use App\Models\FinancialReport;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_payments';

    protected $fillable = [
        'member_id',
        'membership_id',
        'amount',
        'payment_date',
        'expires_at',
        'status',
        'payment_method',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'expires_at'   => 'date',
    ];

    /* ==========================
       🔗 RELACIONES PRINCIPALES
       ========================== */

    /** Pago pertenece a un miembro */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /** Pago pertenece a una membresía */
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    /** Usuarios que crearon/editaron el pago */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /* ==========================
       💰 RELACIONES CON REPORTES
       ========================== */

    /**
     * Relación opcional con reportes financieros (si se usa una tabla de resumen)
     * No es directa en la BD, pero puede generarse dinámicamente si el módulo lo requiere.
     */
    public function scopeForMonth($query, $yearMonth)
    {
        return $query->whereRaw("DATE_FORMAT(payment_date, '%Y-%m') = ?", [$yearMonth]);
    }

    /* ==========================
       ⚙️ MÉTODOS AUXILIARES
       ========================== */

    /** Verifica si el pago está vencido */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /** Verifica si el pago está pendiente */
    public function isPending(): bool
    {
        return $this->status === 'pendiente';
    }

    /** Verifica si el pago fue cobrado */
    public function isPaid(): bool
    {
        return $this->status === 'cobrado';
    }
}
