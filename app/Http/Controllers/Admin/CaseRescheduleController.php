<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Witness;
use App\Models\CaseReschedule;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SmsService;

class CaseRescheduleController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
        $this->middleware('permission:Case Reschedule');
    }

    /**
     * List all reschedules for a case
     */
    public function index(CourtCase $case)
    {
        $reschedules = $case->reschedules()
            ->orderBy('reschedule_date')
            ->get()
            ->map(function($reschedule) use ($case) {

                // Attach witnesses and their attendance for this reschedule
                $reschedule->witnesses = $case->witnesses->map(function($w) use ($reschedule) {
                    $w->attendance = $w->attendances()
                        ->where('hearing_date', $reschedule->reschedule_date)
                        ->first();
                    return $w;
                });

                // Attach notifications for this reschedule
                $reschedule->notifications = Notification::whereIn('witness_id', $case->witnesses->pluck('id'))
                    ->whereHas('schedule', function($q) use ($reschedule, $case) {
                        $q->where('case_id', $case->id)
                          ->whereDate('schedule_date', $reschedule->reschedule_date);
                    })
                    ->get();

                return $reschedule;
            });

        return view('admin.cases.reschedules.index', compact('case', 'reschedules'));
    }

    /**
     * Show form to create a reschedule
     */
    public function create(CourtCase $case)
    {
        $witnesses = $case->witnesses()->get();
        $templates = MessageTemplate::where('is_active', true)->get();

        return view('admin.cases.reschedules.create', compact('case', 'witnesses', 'templates'));
    }

    /**
     * Store a new reschedule and generate notifications & attendance
     */
    public function store(Request $request, CourtCase $case)
    {
        $request->validate([
            'reschedule_date' => 'required|date|after_or_equal:today',
            'reschedule_time' => 'required',
            'witnesses'       => 'required|array|min:1',
            'schedules'       => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create reschedule
            $reschedule = CaseReschedule::create([
                'case_id'         => $case->id,
                'reschedule_date' => $request->reschedule_date,
                'reschedule_time' => $request->reschedule_time,
                'created_by'      => Auth::id(),
            ]);

            $template = MessageTemplate::find(1); // default template, can be dynamic
            if (!$template) {
                throw new \Exception("Default template not found!");
            }

            // 2. Generate notification schedules & notifications for selected witnesses
            foreach ($request->schedules as $sched) {

                $scheduleDate = match ($sched) {
                    '10_days_before' => Carbon::parse($request->reschedule_date)->subDays(10),
                    '3_days_before'  => Carbon::parse($request->reschedule_date)->subDays(3),
                    'send_now'       => now(),
                    default          => now(),
                };

                $notificationSchedule = NotificationSchedule::create([
                    'case_id'      => $case->id,
                    'template_id'  => $template->id,
                    'channel'      => $template->channel,
                    'status'       => 'active',
                    'schedule_date'=> $scheduleDate,
                    'schedule_time'=> $sched === 'send_now' ? now()->format('H:i:s') : null,
                    'created_by'   => Auth::id(),
                ]);

                foreach ($request->witnesses as $wId) {
                    $witness = Witness::find($wId);

                    Notification::create([
                        'schedule_id' => $notificationSchedule->id,
                        'witness_id'  => $witness->id,
                        'channel'     => $template->channel,
                        'status'      => $sched === 'send_now' ? 'sent' : 'pending',
                        'sent_at'     => $sched === 'send_now' ? now() : null,
                    ]);

                    // Create attendance for this reschedule date if not exists
                    $attendance = $witness->attendances()
                        ->where('hearing_date', $reschedule->reschedule_date)
                        ->first();

                    if (!$attendance) {
                        $witness->attendances()->create([
                            'case_id'      => $case->id,
                            'hearing_date' => $reschedule->reschedule_date,
                            'hearing_time' => $reschedule->reschedule_time,
                            'status'       => 'pending',
                        ]);
                    }

                    // Send SMS immediately if 'send_now'
                    if ($sched === 'send_now' && in_array($template->channel, ['sms','both'])) {
                        $smsBody = str_replace(
                            ['{witness_name}', '{case_no}', '{hearing_date}', '{hearing_time}'],
                            [$witness->name, $case->case_no, $request->reschedule_date, $request->reschedule_time],
                            $template->body_en_sms
                        );

                        $smsResponse = $this->smsService->send([[ 
                            'to' => '88'.$witness->phone,
                            'message' => $smsBody
                        ]]);

                        Notification::where('schedule_id', $notificationSchedule->id)
                            ->where('witness_id', $witness->id)
                            ->update([
                                'status'   => $smsResponse['response_code'] == 202 ? 'sent' : 'failed',
                                'sent_at'  => $smsResponse['response_code'] == 202 ? now() : null,
                                'response' => $smsResponse['response'],
                            ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Case rescheduled and notifications generated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage()
            ]);
        }
    }

    /**
     * Update witness attendance for a reschedule
     */
    public function updateAttendance(Request $request, CaseReschedule $reschedule)
    {
        $request->validate([
            'attendances' => 'required|array',
        ]);

        foreach ($request->attendances as $wId => $status) {
            $witness = Witness::find($wId);
            if (!$witness) continue;

            $attendance = $witness->attendances()
                ->where('hearing_date', $reschedule->reschedule_date)
                ->first();

            if ($attendance) {
                $attendance->update(['status' => $status]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully.'
        ]);
    }
}
