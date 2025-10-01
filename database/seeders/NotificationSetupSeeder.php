<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageTemplate;
use App\Models\NotificationDefault;

class NotificationSetupSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Seed minimal message templates
        $smsTemplate = MessageTemplate::create([
            'channel' => 'sms',
            'title' => 'Reminder 10 Days Before',
            'body' => 'Dear {witness_name}, this is a reminder for case {case_no} on {hearing_date}.',
            'active' => true,
        ]);

        $whatsappTemplate = MessageTemplate::create([
            'channel' => 'whatsapp',
            'title' => 'Reminder 3 Days Before',
            'body' => 'Hello {witness_name}, please remember your case {case_no} scheduled on {hearing_date}.',
            'active' => true,
        ]);

        // 2️⃣ Seed minimal global notification defaults
        NotificationDefault::create([
            'days_before' => 10,
            'template_id' => $smsTemplate->id,
            'active' => true,
        ]);

        NotificationDefault::create([
            'days_before' => 3,
            'template_id' => $whatsappTemplate->id,
            'active' => true,
        ]);

        $this->command->info('Message templates and global notification defaults seeded successfully.');
    }
}
