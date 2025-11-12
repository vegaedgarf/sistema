<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_activities';

    protected $fillable = [
        'name',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relaciones

    public function membershipPrices()
        {
            return $this->belongsToMany(MembershipPrice::class, 'corpo_membership_combinations')
                ->withPivot('times_per_week')
                ->withTimestamps();
        }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
