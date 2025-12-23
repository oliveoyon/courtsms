<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    protected $fillable = [
        'hearing_id',
        'name',
        'phone',
        'appeared_status',
        'remarks',
    ];

    public function hearing()
    {
        return $this->belongsTo(CaseHearing::class, 'hearing_id');
    }

    public function attendances()
    {
        return $this->hasMany(WitnessAttendance::class, 'witness_id');
    }
}
