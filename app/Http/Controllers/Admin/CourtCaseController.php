<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\CaseHearing;
use App\Models\Witness;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\Division;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SmsService;

class CourtCaseController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->middleware('permission:SMS Form')->only(['createAndSend']);
        $this->middleware('permission:Send SMS')->only(['storeAndSend']);
        $this->smsService = $smsService;
    }

    /**
     * Show create + send form
     */
    public function createAndSend()
    {
        $user = Auth::user();

        $divisions = $user->district_id
            ? Division::with([
                'districts' => fn ($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->get()
            : Division::with('districts.courts')->get();

        $templates = MessageTemplate::where('is_active', true)->get();

        return view('admin.cases.create_send', compact('divisions', 'templates', 'user'));
    }

    /**
     * Store case, hearing, witnesses and send notifications
     */
    public function storeAndSend(Request $request)
    {
        $request->validate([
            'division_id'       => 'required|exists:divisions,id',
            'district_id'       => 'required|exists:districts,id',
            'court_id'          => 'required|exists:courts,id',
            'case_no'           => 'required|string|max:255',
            'hearing_date'      => 'required|date',
            'witnesses'         => 'required|array|min:1',
            'witnesses.*.name'  => 'required|string|max:255',
            'witnesses.*.phone' => ['required', 'regex:/^01\d{9}$/'],
            'schedules'         => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            $lang = 'bn';
            $template = MessageTemplate::findOrFail(1); // default template

            /* ===============================
             * 1️⃣ CREATE CASE
             * =============================== */
            $courtCase = CourtCase::create([
                'case_no'      => $request->case_no,
                'court_id'     => $request->court_id,
                'hearing_date' => $request->hearing_date,
                'hearing_time' => $request->hearing_time ?? null,
                'notes'        => $request->notes ?? null,
                'created_by'   => Auth::id(),
            ]);

            /* ===============================
             * 2️⃣ CREATE FIRST HEARING
             * =============================== */
            $hearing = CaseHearing::create([
                'case_id'       => $courtCase->id,
                'hearing_date'  => $request->hearing_date,
                'hearing_time'  => $request->hearing_time ?? null,
                'is_reschedule' => false,
                'created_by'    => Auth::id(),
            ]);

            /* ===============================
             * 3️⃣ CREATE WITNESSES
             * =============================== */
            $witnesses = [];
            foreach ($request->witnesses as $w) {
                // Always include hearing_id
                $witnesses[] = Witness::create([
                    'hearing_id' => $hearing->id,
                    'name'       => $w['name'],
                    'phone'      => $w['phone'],
                ]);
            }

            /* ===============================
             * Helper: English → Bangla digits
             * =============================== */
            $toBn = fn ($v) => str_replace(
                range(0, 9),
                ['০','১','২','৩','৪','৫','৬','৭','৮','৯'],
                $v
            );

            $hearingDateBn = $toBn($request->hearing_date);

            /* ===============================
             * 4️⃣ SCHEDULES + NOTIFICATIONS
             * =============================== */
            foreach ($request->schedules as $sched) {

                $scheduleDate = match ($sched) {
                    '10_days_before' => Carbon::parse($request->hearing_date)->subDays(10),
                    '3_days_before'  => Carbon::parse($request->hearing_date)->subDays(3),
                    'send_now'       => now(),
                };

                $schedule = NotificationSchedule::create([
                    'hearing_id'    => $hearing->id,
                    'template_id'   => $template->id,
                    'channel'       => $template->channel,
                    'status'        => 'active',
                    'schedule_date' => $scheduleDate,
                    'created_by'    => Auth::id(),
                ]);

                foreach ($witnesses as $witness) {
                    Notification::create([
                        'schedule_id' => $schedule->id,
                        'witness_id'  => $witness->id,
                        'channel'     => $template->channel,
                        'status'      => 'pending',
                    ]);
                }

                /* ===============================
                 * 5️⃣ SEND NOW
                 * =============================== */
                if ($sched === 'send_now') {
                    foreach ($witnesses as $witness) {

                        $smsBody = $lang === 'bn'
                            ? $template->body_bn_sms
                            : $template->body_en_sms;

                        $message = str_replace(
                            ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
                            [
                                $witness->name,
                                $hearingDateBn,
                                $courtCase->court->name_bn ?? $courtCase->court->name,
                                $courtCase->case_no
                            ],
                            $smsBody
                        );

                        /* =====================================================
                         * 🔴 REAL SMS (COMMENTED — UNBLOCK LATER)
                         * ===================================================== */
                        // $smsResponse = $this->smsService->send([
                        //     [
                        //         'to' => '88' . $witness->phone,
                        //         'message' => $message,
                        //     ]
                        // ]);

                        // $isSent = isset($smsResponse['response_code'])
                        //     && $smsResponse['response_code'] == 200;
                        /* ===================================================== */

                        /* =====================================================
                         * 🟡 FAKE SMS SUCCESS (TEMPORARY)
                         * ===================================================== */
                        $isSent = true;
                        $smsResponse = [
                            'response_code' => 200,
                            'response' => 'FAKE SMS SUCCESS (DEV MODE)'
                        ];
                        /* ===================================================== */

                        Notification::where('schedule_id', $schedule->id)
                            ->where('witness_id', $witness->id)
                            ->update([
                                'status'   => $isSent ? 'sent' : 'failed',
                                'sent_at'  => $isSent ? now() : null,
                                'response' => $smsResponse,
                            ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('case.success_save'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
