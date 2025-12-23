<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WitnessAttendance extends Model
{
    protected $fillable = ['hearing_id', 'witness_id', 'status'];

    public function witness()
    {
        return $this->belongsTo(Witness::class);
    }

    public function hearing()
    {
        return $this->belongsTo(CaseHearing::class);
    }
}
