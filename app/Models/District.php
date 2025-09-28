<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['division_id', 'name'];

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
}
