<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\CourtCase;
use App\Models\CaseHearing;
use App\Models\Witness;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;

class TestCaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {

            /* ===============================
             * CONFIG
             * =============================== */
            $casesCount     = 15;
            $witnessPerCase = 8;
            $userId         = 1;
            $template       = MessageTemplate::findOrFail(1);

            $names = [
                'Rahim', 'Karim', 'Salam', 'Jamal', 'Kamal',
                'Hasan', 'Hossain', 'Rafiq', 'Anwar', 'Bashir'
            ];

            $phones = [
                '01712105580','01311078690','01765958444',
                '01741879685','01720614038','01819168092',
                '01723729350','01789948226','01790110586',
                '01711388804'
            ];

            foreach (range(1, $casesCount) as $i) {

                /* ===============================
                 * HEARING DATE (FUTURE)
                 * =============================== */
                $hearingDate = Carbon::today()->addDays(rand(5, 20));

                /* ===============================
                 * CASE
                 * =============================== */
                $courtCase = CourtCase::create([
                    'case_no'      => 'SEED-CRON-' . Str::padLeft($i, 4, '0'),
                    'court_id'     => rand(1, 10),
                    'hearing_date' => $hearingDate->toDateString(),
                    'created_by'   => $userId,
                ]);

                /* ===============================
                 * HEARING
                 * =============================== */
                $hearing = CaseHearing::create([
                    'case_id'       => $courtCase->id,
                    'hearing_date'  => $hearingDate->toDateString(),
                    'is_reschedule' => false,
                    'created_by'    => $userId,
                ]);

                /* ===============================
                 * WITNESSES
                 * =============================== */
                $witnesses = [];

                foreach (range(1, $witnessPerCase) as $w) {
                    $witnesses[] = Witness::create([
                        'hearing_id' => $hearing->id,
                        'name'       => $names[array_rand($names)] . ' ' . $w,
                        'phone'      => $phones[array_rand($phones)],
                    ]);
                }

                /* ===============================
                 * SCHEDULES (10 & 3 DAYS BEFORE)
                 * =============================== */
                $scheduleMap = [
                    '10_days_before' => $hearingDate->copy()->subDays(10),
                    '3_days_before'  => $hearingDate->copy()->subDays(3),
                ];

                foreach ($scheduleMap as $date) {

                    $schedule = NotificationSchedule::create([
                        'hearing_id'    => $hearing->id,
                        'template_id'   => $template->id,
                        'channel'       => $template->channel,
                        'status'        => 'active',
                        'schedule_date' => $date->toDateString(),
                        'created_by'    => $userId,
                    ]);

                    /* ===============================
                     * NOTIFICATIONS (SENT / FAILED)
                     * =============================== */
                    foreach ($witnesses as $witness) {

                        $isSent = rand(1, 10) <= 8; // 80% success

                        Notification::create([
                            'schedule_id' => $schedule->id,
                            'witness_id'  => $witness->id,
                            'channel'     => $template->channel,
                            'status'      => $isSent ? 'sent' : 'failed',
                            'sent_at'     => $isSent
                                ? $date->copy()->addHours(rand(1, 6))
                                : null,
                            'response'    => $isSent
                                ? json_encode([
                                    'response_code' => 200,
                                    'provider' => 'mnet',
                                    'message' => 'Mock SMS sent successfully',
                                ])
                                : json_encode([
                                    'response_code' => 500,
                                    'error' => 'Mock gateway failure',
                                ]),
                        ]);
                    }
                }
            }

            DB::commit();
            $this->command->info('✅ Court SMS cron test data seeded successfully (realistic).');

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('❌ Seeder failed: ' . $e->getMessage());
        }
    }
}
