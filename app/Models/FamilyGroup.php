<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyGroup extends Model
{
        protected $table = 'corpo_family_groups';

        protected $fillable = [
            'name',
            'discount_percentage',
            'is_active',
        ];



    /**
     * Obtiene todos los miembros que ALGUNA VEZ estuvieron en este grupo.
     */
    public function memberHistory(): HasMany
    {
        return $this->hasMany(FamilyGroupMembership::class, 'family_group_id');
    }

    /**
     * Obtiene los miembros ACTUALMENTE en este grupo.
     */
    public function currentMembers(): HasMany
    {
        return $this->hasMany(FamilyGroupMembership::class, 'family_group_id')
                    ->whereNull('end_date');
    }


}