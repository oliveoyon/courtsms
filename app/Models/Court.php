<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = ['district_id', 'name'];

    /**
     * A Court belongs to a District
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
