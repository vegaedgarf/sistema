<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Activity;

class MembershipPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_membership_prices';

    protected $fillable = [
        'activity_id',
        'price',
        'valid_from',
        'valid_to',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'valid_from' => 'date',
        'valid_to'   => 'date',
    ];

public function activity()
{
    return $this->belongsToMany(Activity::class, 'corpo_membership_combinations')
                ->withPivot('times_per_week')
                ->withTimestamps();
}



//  public function activity()
  //  {
    //    return $this->belongsTo(Activity::class, 'activity_id');
    //}


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
