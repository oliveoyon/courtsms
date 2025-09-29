<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    // Allow mass assignment for English, Bangla names, district, and active status
    protected $fillable = ['district_id', 'name_en', 'name_bn', 'is_active'];

    /**
     * A Court belongs to a District
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the court name based on the current locale
     */
    public function getNameAttribute()
    {
        $locale = session('locale', 'en'); // default to English
        return $locale === 'bn' ? $this->name_bn : $this->name_en;
    }
}
