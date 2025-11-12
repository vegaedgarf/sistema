<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_contacts';

    protected $fillable = [
        'member_id',
        'first_name',
        'last_name',
        'relationship',
        'phone',
        'email',
        'is_primary',
        'created_by',
        'updated_by',
    ];

    // Relación: un contacto pertenece a un miembro
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
