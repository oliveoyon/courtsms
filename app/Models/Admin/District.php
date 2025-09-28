<?php

namespace App\Models\Admin;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division_id', 'is_active'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
