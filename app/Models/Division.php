<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    // ✅ Allow mass assignment for these fields
    protected $fillable = ['name_en', 'name_bn', 'is_active'];

    /**
     * A Division has many Districts
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * Scope: Only active divisions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
