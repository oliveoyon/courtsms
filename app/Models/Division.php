<?php

namespace App\Models;

use App\Models\Admin\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Optional: relationship with districts
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
