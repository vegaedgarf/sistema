<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipCombination extends Model
{
    use HasFactory;

    protected $table = 'corpo_membership_combinations';

    protected $fillable = [
        'membership_price_id',
        'activity_id',
        'times_per_week',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function membershipPrice()
    {
        return $this->belongsTo(MembershipPrice::class);
    }
}
