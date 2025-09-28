<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    /**
     * A Division has many Districts
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
