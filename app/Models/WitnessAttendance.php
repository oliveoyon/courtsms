<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WitnessAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'witness_id',
        'status',
        'attendance_date'
    ];

    // public function witness()
    // {
    //     return $this->belongsTo(Witness::class);
    // }

    public function case()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }

    public function witness()
    {
        return $this->belongsTo(Witness::class, 'witness_id');
    }
}
