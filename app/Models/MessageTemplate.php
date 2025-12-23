<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body_en_sms',
        'body_en_whatsapp',
        'body_bn_sms',
        'body_bn_whatsapp',
        'body_email',
        'channel',
        'is_active',
        'category_id',
    ];

    

    public function category()
    {
        return $this->belongsTo(MessageTemplateCategory::class, 'category_id');
    }
}
