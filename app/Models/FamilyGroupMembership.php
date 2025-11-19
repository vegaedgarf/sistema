<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FamilyGroupMembership extends Pivot
{
    protected $table = 'corpo_family_group_members';
    
    // Indicamos que SÍ es auto-incremental (porque le pusimos ->id() en la migración)
    public $incrementing = true;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relaciones desde el pivote
     */
    public function member()
    {
       // Especificamos explícitamente la foreign key 'member_id'
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function group()
    {
        // Especificamos explícitamente la foreign key 'family_group_id'
        return $this->belongsTo(FamilyGroup::class, 'family_group_id');
    }
}