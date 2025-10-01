<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDefault extends Model
{
    use HasFactory;

    protected $fillable = [
        'days_before',
        'template_id',
        'active',
    ];

    // Relationships
    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }
}
