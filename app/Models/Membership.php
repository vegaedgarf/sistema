<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Activity;
use App\Models\MembershipPrice;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_memberships';

    protected $fillable = [
        'member_id',
        'membership_price_id',
        'start_date',
        'end_date',
        'status',
        'total_amount',
        'payment_method',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /** Una membresía pertenece a un miembro */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /** Una membresía tiene un tipo de precio */
    public function price()
    {
        return $this->belongsTo(MembershipPrice::class, 'membership_price_id');
    }

    /** Una membresía tiene muchos pagos */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'membership_id');
    }

    /** Actividad asociada (a través del precio) */
    public function activity()
    {
        return $this->hasOneThrough(
            Activity::class,
            MembershipPrice::class,
            'id',            // foreign key on MembershipPrice table
            'id',            // foreign key on Activity table
            'membership_price_id', // local key on Membership table
            'activity_id'          // local key on MembershipPrice table
        );
    }

    /** Auditoría */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
