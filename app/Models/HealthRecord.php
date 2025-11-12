<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_health_records';

    protected $fillable = [
        'member_id',
        'blood_type',
        'height',
        'weight',
        'allergies',
        'injuries',
        'medical_conditions',
        'medications',
        'observations',
        'created_by',
        'updated_by',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
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
