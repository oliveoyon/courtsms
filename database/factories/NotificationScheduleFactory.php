<?php

namespace Database\Factories;

use App\Models\NotificationSchedule;
use App\Models\CaseHearing;
use App\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationScheduleFactory extends Factory
{
    protected $model = NotificationSchedule::class;

    public function definition()
    {
        return [
            'hearing_id'   => CaseHearing::factory(),   // link to a hearing
            'template_id'  => 1,                        // static template id (make sure it exists)
            'channel'      => $this->faker->randomElement(['sms', 'whatsapp', 'both']),
            'status'       => 'active',
            'schedule_date'=> now()->addMinutes(rand(1, 120)),
            'created_by'   => 1,                        // admin id
        ];
    }
}
