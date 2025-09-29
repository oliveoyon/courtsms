<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    // Fillable fields
    protected $fillable = [
        'division_id',
        'name_en',
        'name_bn',
        'is_active'
    ];

    /**
     * A District belongs to a Division
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * A District has many Courts
     */
    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    /**
     * Get district name according to current locale
     */
    public function getNameAttribute()
    {
        $locale = session('locale', 'en');
        return $locale === 'bn' ? $this->name_bn : $this->name_en;
    }
}
