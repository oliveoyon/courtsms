<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseHearing;
use App\Models\Witness;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class HearingManagementController extends Controller
{
    /**
     * Show hearings by date (today / filtered)
     */
    public function index(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        $hearings = CaseHearing::with([
            'case.court',
            'case.witnesses'
        ])
            ->whereDate('hearing_date', $date)
            ->orderBy('hearing_time')
            ->get();

        return view('admin.hearings.index', compact('hearings', 'date'));
    }

    /**
     * Attendance form
     */
    public function attendanceForm($hearingId)
    {
        $hearing = CaseHearing::with(['case', 'case.witnesses'])->findOrFail($hearingId);

        return view('admin.hearings.attendance', compact('hearing'));
    }

    /**
     * Store attendance
     */
    public function storeAttendance(Request $request, $hearingId)
    {
        $request->validate([
            'attendance' => 'required|array',
            'gender' => 'array',
            'others_info' => 'array',
            'sms_seen' => 'array',
            'witness_heard' => 'array',
        ]);

        $hearing = CaseHearing::with('witnesses')->findOrFail($hearingId);

        DB::transaction(function () use ($request, $hearing) {
            foreach ($request->attendance as $witnessId => $status) {

                if (!in_array($status, ['pending', 'appeared', 'absent', 'excused'])) {
                    continue;
                }

                Witness::where('id', $witnessId)->update([
                    'appeared_status' => $status,
                    'gender'          => $request->gender[$witnessId] ?? null,
                    'others_info'     => $request->others_info[$witnessId] ?? null,
                    'sms_seen'        => isset($request->sms_seen[$witnessId]) ? 'yes' : 'no',
                    'witness_heard'   => isset($request->witness_heard[$witnessId]) ? 'yes' : 'no',
                    'remarks'         => $request->remarks[$witnessId] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.hearings.index')
            ->with('success', 'Attendance saved successfully.');
    }



    /**
     * Show reschedule form
     */
    public function rescheduleForm($hearingId)
    {
        $hearing = CaseHearing::with(['case', 'case.witnesses'])->findOrFail($hearingId);

        return view('admin.hearings.reschedule', compact('hearing'));
    }

    /**
     * Store rescheduled hearing
     */
    public function storeReschedule(Request $request, $hearingId)
    {
        $request->validate([
            'new_date' => 'required|date',
            'new_time' => 'nullable|string',
            'witnesses' => 'required|array|min:1',
            'witnesses.*.name' => 'required|string|max:255',
            'witnesses.*.phone' => ['required', 'regex:/^01\d{9}$/'],
            'schedules' => 'nullable|array', // optional schedules for SMS
        ]);

        $oldHearing = CaseHearing::with('case.witnesses')->findOrFail($hearingId);

        DB::transaction(function () use ($request, $oldHearing) {
            $lang = 'bn';
            $template = \App\Models\MessageTemplate::findOrFail(1); // default template

            // Create new hearing
            $newHearing = CaseHearing::create([
                'case_id' => $oldHearing->case_id,
                'hearing_date' => $request->new_date,
                'hearing_time' => $request->new_time ?? $oldHearing->hearing_time,
                'is_reschedule' => true,
                'created_by' => auth()->id(),
            ]);

            $existingWitnesses = $oldHearing->case->witnesses->keyBy('phone');
            $newWitnesses = [];

            foreach ($request->witnesses as $w) {
                $old = $existingWitnesses[$w['phone']] ?? null;

                $newWitnesses[] = Witness::create([
                    'hearing_id' => $newHearing->id,
                    'name' => $w['name'],
                    'phone' => $w['phone'],
                    'appeared_status' => 'pending',
                    'remarks' => $old->remarks ?? null,
                ]);
            }

            // ===============================
            // SCHEDULES + NOTIFICATIONS (Optional)
            // ===============================
            if ($request->schedules) {
                foreach ($request->schedules as $sched) {
                    $scheduleDate = match ($sched) {
                        '10_days_before' => Carbon::parse($request->new_date)->subDays(10),
                        '3_days_before' => Carbon::parse($request->new_date)->subDays(3),
                        'send_now' => now(),
                    };

                    $schedule = \App\Models\NotificationSchedule::create([
                        'hearing_id' => $newHearing->id,
                        'template_id' => $template->id,
                        'channel' => $template->channel,
                        'status' => 'active',
                        'schedule_date' => $scheduleDate,
                        'created_by' => auth()->id(),
                    ]);

                    foreach ($newWitnesses as $witness) {
                        \App\Models\Notification::create([
                            'schedule_id' => $schedule->id,
                            'witness_id' => $witness->id,
                            'channel' => $template->channel,
                            'status' => 'pending',
                        ]);
                    }

                    // Send Now
                    if ($sched === 'send_now') {
                        foreach ($newWitnesses as $witness) {
                            $smsBody = $lang === 'bn'
                                ? $template->body_bn_sms
                                : $template->body_en_sms;

                            $message = str_replace(
                                ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
                                [
                                    $witness->name,
                                    $request->new_date,
                                    $oldHearing->case->court->name_bn ?? $oldHearing->case->court->name,
                                    $oldHearing->case->case_no
                                ],
                                $smsBody
                            );

                            /* =====================================================
                         * 🔴 REAL SMS (COMMENTED — UNBLOCK LATER)
                         =====================================================
                          ===================================================== */
                            $smsResponse = app(\App\Services\SmsService::class)->send([
                                [
                                    'to' => '88' . $witness->phone,
                                    'message' => $message,
                                ]
                            ]);

                            $isSent = isset($smsResponse['response_code'])
                                && $smsResponse['response_code'] == 202;


                            /* =====================================================
                         * 🟡 FAKE SMS SUCCESS (TEMPORARY)
                         ===================================================== */
                            // $isSent = true;
                            // $smsResponse = [
                            //     'response_code' => 202,
                            //     'response' => 'FAKE SMS SUCCESS (DEV MODE)'
                            // ];
                            /* ===================================================== */

                            \App\Models\Notification::where('schedule_id', $schedule->id)
                                ->where('witness_id', $witness->id)
                                ->update([
                                    'status' => $isSent ? 'sent' : 'failed',
                                    'sent_at' => $isSent ? now() : null,
                                    'response' => $smsResponse,
                                ]);
                        }
                    }
                }
            }
        });

        return redirect()
            ->route('admin.hearings.index')
            ->with('success', 'Hearing rescheduled and SMS processed successfully.');
    }



    public function print(Request $request)
{
    $date = $request->date ?? now()->toDateString();

    $hearings = CaseHearing::with([
        'case.court',
        'witnesses'
    ])
        ->whereDate('hearing_date', $date)
        ->orderBy('hearing_time')
        ->get();

    // Render Blade as HTML
    $html = view('admin.hearings.print', compact('hearings', 'date'))->render();

    // mPDF font configuration
    $defaultConfig = (new ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    // Create mPDF instance
    $mpdf = new Mpdf([
        'mode' => 'utf-8',             // Important for Bangla
        'format' => 'A4-L',            // Landscape
        'margin_top' => 10,
        'margin_bottom' => 10,
        'margin_left' => 10,
        'margin_right' => 10,
        'fontDir' => array_merge($fontDirs, [public_path('assets/fonts')]), // add your fonts folder
        'fontdata' => $fontData + [
            'solaimanlipi' => [
                'R' => 'SolaimanLipi.ttf',  // regular
                // 'B' => 'SolaimanLipi-Bold.ttf', // optional
            ]
        ],
        'default_font' => 'solaimanlipi',  // set as default
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('hearing-attendance-' . $date . '.pdf', 'I'),
        200,
        ['Content-Type' => 'application/pdf']
    );
}
}
