<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Member;
use App\Models\Activity;
use App\Models\MembershipPrice;

class MemberActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_member_activity';

    protected $fillable = [
        'member_id',
        'activity_id',
        'membership_price_id',
        'start_date',
        'end_date',
        'amount_paid',
        'payment_method',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function membershipPrice()
    {
        return $this->belongsTo(MembershipPrice::class, 'membership_price_id');
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
