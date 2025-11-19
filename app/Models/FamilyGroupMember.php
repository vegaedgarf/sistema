<?php
// app/Models/FamilyGroupMember.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyGroupMember extends Model
{
    protected $table = 'corpo_family_group_members';

    protected $fillable = [
        'family_group_id',
        'member_id',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(FamilyGroup::class, 'family_group_id');
    }

    public function member(): BelongsTo
    {
        // Asumiendo que CorpoMember se renombra a Member
        return $this->belongsTo(Member::class, 'member_id');
    }
}