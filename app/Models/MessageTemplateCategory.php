<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplateCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_bn',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship to templates (optional for later)
    public function templates()
    {
        return $this->hasMany(MessageTemplate::class, 'category_id');
    }

    // Get localized name
    public function getNameAttribute()
    {
        return app()->getLocale() === 'bn' ? $this->name_bn ?? $this->name_en : $this->name_en;
    }
}
