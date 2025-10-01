<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationDefault;
use App\Models\NotificationSchedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourtCase extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'case_no',
        'court_id',
        'hearing_date',
        'hearing_time',
        'notes',
        'created_by',
    ];

    // Relationships
    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function witnesses()
    {
        return $this->hasMany(Witness::class, 'case_id');
    }

    public function schedules()
    {
        return $this->hasMany(NotificationSchedule::class, 'case_id');
    }

    // Auto-populate schedules after case creation
    protected static function booted()
    {
        static::created(function ($courtCase) {
            $defaults = NotificationDefault::where('active', true)->get();

            foreach ($defaults as $default) {
                $scheduledAt = Carbon::parse($courtCase->hearing_date)
                    ->subDays($default->days_before)
                    ->setTime(9, 0); // Default 9 AM, adjust if needed

                NotificationSchedule::create([
                    'case_id' => $courtCase->id,
                    'template_id' => $default->template_id,
                    'scheduled_at' => $scheduledAt,
                    'status' => 'active',
                    'created_by' => Auth::id() ?? 1, // fallback for seeding
                ]);
            }
        });
    }
}
