<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Contact;
use App\Models\Routine;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\HealthRecord;
use App\Models\MedicalRecord;
use App\Models\Activity;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    /** Nombre de la tabla */
    protected $table = 'corpo_members';

    /** Campos asignables */
    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'birth_date',
        'address',
        'phone',
        'email',
        'observations',
        'status',
        'joined_at',
        'membership_expires_at',
        'user_id',
        'created_by',
        'updated_by',
    ];

    /** Casts de tipo */
    protected $casts = [
        'birth_date'            => 'date',
        'joined_at'             => 'date',
        'membership_expires_at' => 'date',
    ];

    // === RELACIONES ===

    /** 1 miembro → muchos contactos */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'member_id');
    }

    /** 1 miembro → una ficha médica */
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'member_id');
    }

    /** 1 miembro → muchos registros de salud */
    public function healthRecord()
    {
        return $this->hasOne(HealthRecord::class, 'member_id');
    }

    /** 1 miembro → muchas rutinas */
    public function routines()
    {
        return $this->hasMany(Routine::class, 'member_id');
    }

    /** 1 miembro → muchas membresías */
    public function memberships()
    {
        return $this->hasMany(Membership::class, 'member_id');
    }

    /** 1 miembro → muchos pagos */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }

    /** 1 miembro → muchas actividades (tabla pivote corpo_member_activity) */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'corpo_member_activity', 'member_id', 'activity_id')
                    ->withPivot(['membership_price_id', 'start_date', 'end_date', 'amount_paid', 'payment_method', 'notes'])
                    ->withTimestamps();
    }

    /** Usuarios que crean/actualizan registros */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
