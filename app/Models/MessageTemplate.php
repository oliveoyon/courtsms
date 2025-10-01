<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'title',
        'body',
        'active',
    ];

    // Relationships
    public function schedules()
    {
        return $this->hasMany(NotificationSchedule::class, 'template_id');
    }

    
}
