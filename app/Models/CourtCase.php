<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtCase extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'case_no',
        'court_id',
        'hearing_date',
        'hearing_time',
        'reschedule_date',
        'reschedule_time',
        'notes',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function witnesses()
    {
        return $this->hasMany(Witness::class, 'hearing_id');
    }


    public function notificationSchedules()
    {
        return $this->hasMany(NotificationSchedule::class, 'hearing_id');
    }

    public function allWitnesses()
    {
        return $this->hasManyThrough(Witness::class, CaseHearing::class, 'case_id', 'hearing_id');
    }

    public function hearings()
    {
        return $this->hasMany(\App\Models\CaseHearing::class, 'case_id');
    }
}
