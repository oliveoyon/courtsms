<?php

namespace Database\Factories;

use App\Models\CaseHearing;
use App\Models\CourtCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseHearingFactory extends Factory
{
    protected $model = CaseHearing::class;

    public function definition()
    {
        return [
            'case_id'      => CourtCase::factory(),
            'hearing_date' => now()->addDays(rand(1, 10)),
            'hearing_time' => now()->format('H:i:s'),
            'is_reschedule'=> false,
            'created_by'   => 1, // static admin id
        ];
    }
}
