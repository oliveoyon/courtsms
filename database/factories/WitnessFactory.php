<?php

namespace Database\Factories;

use App\Models\Witness;
use App\Models\CaseHearing;
use Illuminate\Database\Eloquent\Factories\Factory;

class WitnessFactory extends Factory
{
    protected $model = Witness::class;

    public function definition()
    {
        return [
            'hearing_id' => CaseHearing::factory(), // create a hearing automatically
            'name'       => $this->faker->name,
            'phone'      => '017' . $this->faker->numerify('########'),
            'appeared_status' => 'pending',
            'gender'     => $this->faker->randomElement(['Male', 'Female', 'Third Gender']),
            'sms_seen'   => 'no',
            'witness_heard' => 'no',
        ];
    }
}
