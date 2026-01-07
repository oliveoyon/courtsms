<?php

namespace Database\Factories;

use App\Models\CourtCase;
use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtCaseFactory extends Factory
{
    protected $model = CourtCase::class;

    public function definition()
    {
        return [
            'case_no'      => strtoupper($this->faker->bothify('CASE###??')),
            'court_id'     => 1, // make sure Court with id=1 exists
            'hearing_date' => now()->addDays(rand(1, 10)),
            'hearing_time' => now()->format('H:i:s'),
            'created_by'   => 1, // static admin id
        ];
    }
}
