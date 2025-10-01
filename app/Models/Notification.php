<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'witness_id',
        'channel',
        'status',
        'sent_at',
        'response'
    ];

    public function schedule()
    {
        return $this->belongsTo(NotificationSchedule::class, 'schedule_id');
    }

    public function witness()
    {
        return $this->belongsTo(Witness::class, 'witness_id');
    }
}
