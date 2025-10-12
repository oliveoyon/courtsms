<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReschedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'reschedule_date',
        'reschedule_time',
        'created_by'
    ];

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }

    public function case()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }
}
