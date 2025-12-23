<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseHearing extends Model
{
    use HasFactory;

    protected $table = 'case_hearings';

    protected $fillable = [
        'case_id',
        'hearing_date',
        'hearing_time',
        'is_reschedule',
        'created_by',
    ];

    public function case()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }

    public function witnesses()
    {
        return $this->hasMany(Witness::class, 'hearing_id');
    }

    public function witnessAttendances()
    {
        return $this->hasMany(WitnessAttendance::class, 'hearing_id');
    }

    public function attendanceFor(Witness $witness)
    {
        return $this->witnessAttendances()->where('witness_id', $witness->id)->first();
    }
}
