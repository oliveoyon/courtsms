<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSchedule extends Model
{
    use HasFactory;

    protected $table = 'notification_schedules';

    protected $fillable = [
        'hearing_id',
        'template_id',
        'channel',
        'status',
        'schedule_date',
        'schedule_time',
        'created_by',
    ];

    public function case()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'schedule_id');
    }

    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }

    public function hearing()
    {
        return $this->belongsTo(CaseHearing::class, 'hearing_id');
    }

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }
}
