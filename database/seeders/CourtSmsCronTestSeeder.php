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

class CourtSmsCronTestSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {

            /* ===============================
             * CONFIG
             * =============================== */
            $casesCount     = 3;
            $witnessPerCase = 5;
            $userId         = 1;
            $courtId        = 1;
            $template       = MessageTemplate::findOrFail(1);

            // TODAY = 6 JAN, HEARING = 16 JAN
            $hearingDate = Carbon::create(2026, 1, 16);

            /* ===============================
             * FAKE DATA
             * =============================== */
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
                 * 1️⃣ CASE
                 * =============================== */
                $courtCase = CourtCase::create([
                    'case_no'      => 'SEED-CRON-' . Str::padLeft($i, 4, '0'),
                    'court_id'     => $courtId,
                    'hearing_date' => $hearingDate->toDateString(),
                    'created_by'   => $userId,
                ]);

                /* ===============================
                 * 2️⃣ HEARING
                 * =============================== */
                $hearing = CaseHearing::create([
                    'case_id'       => $courtCase->id,
                    'hearing_date'  => $hearingDate->toDateString(),
                    'is_reschedule' => false,
                    'created_by'    => $userId,
                ]);

                /* ===============================
                 * 3️⃣ WITNESSES
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
                 * 4️⃣ SCHEDULES (REALISTIC)
                 * =============================== */
                $scheduleMap = [
                    '10_days_before' => $hearingDate->copy()->subDays(10), // 6 Jan
                    '3_days_before'  => $hearingDate->copy()->subDays(3),  // 13 Jan
                ];

                foreach ($scheduleMap as $type => $date) {

                    $schedule = NotificationSchedule::create([
                        'hearing_id'    => $hearing->id,
                        'template_id'   => $template->id,
                        'channel'       => $template->channel,
                        'status'        => 'active',
                        'schedule_date' => $date->toDateString(),
                        'created_by'    => $userId,
                    ]);

                    /* ===============================
                     * 5️⃣ NOTIFICATIONS
                     * =============================== */
                    foreach ($witnesses as $witness) {
                        Notification::create([
                            'schedule_id' => $schedule->id,
                            'witness_id'  => $witness->id,
                            'channel'     => $template->channel,
                            'status'      => 'pending',
                        ]);
                    }
                }
            }

            DB::commit();
            $this->command->info('✅ Seeder created realistic reminder data.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Seeder failed: ' . $e->getMessage());
        }
    }
}
