<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $fillable = ['case_id', 'hearing_id', 'name', 'phone', 'appeared_status', 'remarks'];

    public function case()
    {
        return $this->belongsTo(CourtCase::class, 'case_id');
    }
}
