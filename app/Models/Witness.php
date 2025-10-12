<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'name',
        'phone',
        'appeared_status',
        'remarks',
    ];

    // Relationships
    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'witness_id');
    }

    // New: Track multiple attendances
    public function attendances()
    {
        return $this->hasMany(WitnessAttendance::class, 'witness_id');
    }
}
