<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseHearing;
use App\Models\Division;
use App\Models\Witness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class HearingManagementController extends Controller
{
    public function __construct()
    {
        // Hearing list & filtering
        $this->middleware('permission:View Hearing')->only(['index']);
        // Attendance
        $this->middleware('permission:Take Hearing Attendance')->only(['attendanceForm', 'storeAttendance']);
        // Reschedule
        $this->middleware('permission:Reschedule Hearing')->only(['rescheduleForm', 'storeReschedule']);
        // Print
        $this->middleware('permission:Print Hearing Attendance')->only(['print']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $date = $request->date ?? now()->toDateString();

        $query = CaseHearing::with(['case.court', 'case.witnesses'])
            ->whereDate('hearing_date', $date);

        // Multi-user restriction
        if ($user->district_id) {
            $query->whereHas('case.court.district', fn($q) => $q->where('id', $user->district_id));
        } elseif ($user->division_id) {
            $query->whereHas('case.court.district.division', fn($q) => $q->where('id', $user->division_id));
        }

        // Filters
        if ($request->division_id) {
            $query->whereHas('case.court.district.division', fn($q) => $q->where('id', $request->division_id));
        }

        if ($request->district_id) {
            $query->whereHas('case.court.district', fn($q) => $q->where('id', $request->district_id));
        }

        if ($request->court_id) {
            $query->whereHas('case.court', fn($q) => $q->where('id', $request->court_id));
        }

        $hearings = $query->orderBy('hearing_time')->get();

        $divisions = $user->district_id
            ? Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->get()
            : Division::with('districts.courts')->get();

        return view('admin.hearings.index', compact('hearings', 'date', 'divisions', 'user', 'request'));
    }

    /**
     * Attendance form (POST secured start)
     */
    public function attendanceForm(Request $request, $hearingId)
    {
        $hearing = CaseHearing::with(['case', 'case.witnesses'])->findOrFail($hearingId);

        $user = Auth::user();
        if ($user->division_id && $hearing->case->court->district->division_id != $user->division_id) {
            abort(403, 'Unauthorized.');
        }
        if ($user->district_id && $hearing->case->court->district_id != $user->district_id) {
            abort(403, 'Unauthorized.');
        }

        return view('admin.hearings.attendance', compact('hearing'));
    }

    /**
     * Reschedule form (POST secured start)
     */


    /**
     * Store attendance
     */
    public function storeAttendance(Request $request, $hearingId)
    {
        $request->validate([
            'attendance' => 'required|array',
            'gender' => 'array',
            'others_info' => 'array',
            'type_of_witness' => 'array', // new field
            'sms_seen' => 'array',
            'witness_heard' => 'array',
            'remarks' => 'array',
        ]);

        $hearing = CaseHearing::with('witnesses')->findOrFail($hearingId);

        DB::transaction(function () use ($request, $hearing) {
            foreach ($request->attendance as $witnessId => $status) {
                if (!in_array($status, ['pending', 'appeared', 'absent', 'excused'])) continue;

                Witness::where('id', $witnessId)->update([
                    'appeared_status' => $status,
                    'gender' => $request->gender[$witnessId] ?? null,
                    'others_info' => $request->others_info[$witnessId] ?? null, // now can be 'Both'
                    'type_of_witness' => $request->type_of_witness[$witnessId] ?? null, // new field
                    'sms_seen' => isset($request->sms_seen[$witnessId]) ? 'yes' : 'no',
                    'witness_heard' => isset($request->witness_heard[$witnessId]) ? 'yes' : 'no',
                    'remarks' => $request->remarks[$witnessId] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.hearings.index')
            ->with('success', 'Attendance saved successfully.');
    }


    public function rescheduleForm(Request $request, $hearingId)
    {
        $hearing = CaseHearing::with(['case', 'case.witnesses'])->findOrFail($hearingId);

        dd($hearing);

        $user = Auth::user();
        if ($user->division_id && $hearing->case->court->district->division_id != $user->division_id) {
            abort(403, 'Unauthorized.');
        }
        if ($user->district_id && $hearing->case->court->district_id != $user->district_id) {
            abort(403, 'Unauthorized.');
        }

        return view('admin.hearings.reschedule', compact('hearing'));
    }

    /**
     * Store reschedule
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
        $oldDate = Carbon::parse($oldHearing->hearing_date);
        $newDate = Carbon::parse($request->new_date);

        // Prevent saving if date is same as old
        if ($newDate->toDateString() === $oldDate->toDateString()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The new date is the same as the old hearing date. No reschedule made.'
            ]);
        }

        // Validate 10_days_before and 3_days_before schedules
        if ($request->schedules) {
            $invalidSchedules = [];

            foreach ($request->schedules as $sched) {
                if ($sched === '10_days_before' && $newDate->copy()->subDays(10)->isPast()) {
                    $invalidSchedules[] = '10 days before';
                }
                if ($sched === '3_days_before' && $newDate->copy()->subDays(3)->isPast()) {
                    $invalidSchedules[] = '3 days before';
                }
            }

            if (!empty($invalidSchedules)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot schedule: ' . implode(', ', $invalidSchedules) . ' is not valid from the new date.'
                ]);
            }
        }

        DB::transaction(function () use ($request, $oldHearing, $newDate) {
            $lang = 'bn';
            $template = \App\Models\MessageTemplate::findOrFail(1);

            $newHearing = CaseHearing::create([
                'case_id' => $oldHearing->case_id,
                'hearing_date' => $newDate,
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

            if ($request->schedules) {
                foreach ($request->schedules as $sched) {
                    $scheduleDate = match ($sched) {
                        '10_days_before' => $newDate->copy()->subDays(10),
                        '3_days_before' => $newDate->copy()->subDays(3),
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

                    if ($sched === 'send_now') {
                        foreach ($newWitnesses as $witness) {
                            $smsBody = $lang === 'bn' ? $template->body_bn_sms : $template->body_en_sms;
                            $message = str_replace(
                                ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
                                [$witness->name, $newDate->toDateString(), $oldHearing->case->court->name_bn ?? $oldHearing->case->court->name, $oldHearing->case->case_no],
                                $smsBody
                            );

                            $smsResponse = app(\App\Services\SmsService::class)->send([
                                ['to' => '88' . $witness->phone, 'message' => $message]
                            ]);

                            $isSent = isset($smsResponse['response_code']) && $smsResponse['response_code'] == 202;

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

        return response()->json([
            'status' => 'success',
            'message' => 'Hearing rescheduled and SMS processed successfully.'
        ]);
    }




    /**
     * Print
     */
    public function print(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        $hearings = CaseHearing::with(['case.court', 'witnesses'])
            ->whereDate('hearing_date', $date)
            ->orderBy('hearing_time')
            ->get();

        $html = view('admin.hearings.print', compact('hearings', 'date'))->render();

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'fontDir' => array_merge($fontDirs, [public_path('assets/fonts')]),
            'fontdata' => $fontData + [
                'solaimanlipi' => [
                    'R' => 'SolaimanLipi.ttf',
                    // 'B' => 'SolaimanLipi-Bold.ttf', // optional bold
                ]
            ],
            'default_font' => 'solaimanlipi',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output('hearing-attendance-' . $date . '.pdf', 'I'),
            200,
            ['Content-Type' => 'application/pdf']
        );
    }
}
