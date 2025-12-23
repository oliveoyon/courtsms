<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseHearing;
use App\Models\Witness;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsService;

class HearingManagementController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index()
    {
        return view('admin.hearings.manage');
    }

    public function getByDate(Request $request)
    {
        $request->validate(['date' => 'required|date']);

        $hearings = CaseHearing::with(['case.court', 'witnesses'])
            ->where('hearing_date', $request->date)
            ->get();


        return response()->json($hearings);
    }

    public function updateAttendance(Request $request)
    {
        $request->validate([
            'witness_id' => 'required|exists:witnesses,id',
            'status' => 'required|in:pending,appeared,absent,excused',
        ]);

        $witness = Witness::findOrFail($request->witness_id);
        $witness->appeared_status = $request->status;
        $witness->save();

        return response()->json(['success' => true, 'message' => 'Attendance updated.']);
    }

    public function reschedule(Request $request)
    {
        $request->validate([
            'hearing_id' => 'required|exists:case_hearings,id',
            'new_date'   => 'required|date',
            'new_time'   => 'nullable',
            'witnesses'  => 'nullable|array',
            'schedules'  => 'required|array', // e.g., ['10_days_before', '3_days_before', 'send_now']
        ]);

        DB::beginTransaction();
        try {
            $hearing = CaseHearing::with('witnesses')->findOrFail($request->hearing_id);

            // Update hearing date/time
            $hearing->hearing_date = $request->new_date;
            $hearing->hearing_time = $request->new_time;
            $hearing->is_reschedule = true;
            $hearing->save();

            // Sync witnesses
            $existingNames = $hearing->witnesses->pluck('name')->toArray();
            $submittedNames = array_column($request->witnesses ?? [], 'name');

            // Remove deleted witnesses
            foreach ($existingNames as $ename) {
                if (!in_array($ename, $submittedNames)) {
                    $w = $hearing->witnesses->where('name', $ename)->first();
                    if ($w) $w->delete();
                }
            }

            // Add/update submitted witnesses
            foreach ($request->witnesses ?? [] as $w) {
                if (!isset($w['name']) || !isset($w['phone'])) continue;
                Witness::updateOrCreate(
                    ['hearing_id' => $hearing->id, 'name' => $w['name']],
                    ['phone' => $w['phone']]
                );
            }

            // Prepare message template
            $template = MessageTemplate::find(1); // default template
            $lang = 'bn'; // or 'en'

            // Create notification schedules
            foreach ($request->schedules as $sched) {
                $scheduleDate = match ($sched) {
                    '10_days_before' => Carbon::parse($hearing->hearing_date)->subDays(10),
                    '3_days_before'  => Carbon::parse($hearing->hearing_date)->subDays(3),
                    'send_now'       => now(),
                    default          => now(),
                };

                $schedule = NotificationSchedule::create([
                    'hearing_id'    => $hearing->id,
                    'template_id'   => $template->id,
                    'channel'       => $template->channel,
                    'status'        => 'active',
                    'schedule_date' => $scheduleDate,
                    'created_by'    => Auth::id(),
                ]);

                // Create notifications for each witness
                foreach ($hearing->witnesses as $witness) {
                    Notification::create([
                        'schedule_id' => $schedule->id,
                        'witness_id'  => $witness->id,
                        'channel'     => $template->channel,
                        'status'      => 'pending',
                    ]);
                }

                // If send_now, send SMS immediately
                if ($sched === 'send_now') {
                    foreach ($hearing->witnesses as $witness) {
                        $smsMessage = str_replace(
                            ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
                            [$witness->name, $hearing->hearing_date, $hearing->case->court->name, $hearing->case->case_no],
                            $template->body_bn_sms
                        );

                        $smsResponse = $this->smsService->send([[
                            'to' => '88' . $witness->phone,
                            'message' => $smsMessage
                        ]]);

                        Notification::where('schedule_id', $schedule->id)
                            ->where('witness_id', $witness->id)
                            ->update([
                                'status'   => $smsResponse['response_code'] == 202 ? 'sent' : 'failed',
                                'sent_at'  => now(),
                                'response' => $smsResponse,
                            ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Hearing rescheduled and notifications created.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
