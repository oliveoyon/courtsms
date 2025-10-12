<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Witness;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SmsService;

class WitnessScheduleController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->middleware('permission:SMS Form')->only(['create']);
        $this->middleware('permission:Send SMS')->only(['store', 'reschedule']);
        $this->smsService = $smsService;
    }

    // Show create schedule panel
    public function create()
    {
        $cases = CourtCase::with('witnesses')->get();
        $templates = MessageTemplate::where('is_active', true)->get();

        return view('admin.witness_schedules.create', compact('cases', 'templates'));
    }

    // Store schedule per witness
    public function store(Request $request)
    {
        $request->validate([
            'case_id'       => 'required|exists:cases,id',
            'witness_ids'   => 'required|array|min:1',
            'witness_ids.*' => 'exists:witnesses,id',
            'template_id'   => 'required|exists:message_templates,id',
            'schedule_date' => 'required|date',
            'schedule_time' => 'nullable',
            'send_now'      => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $case = CourtCase::findOrFail($request->case_id);
            $template = MessageTemplate::findOrFail($request->template_id);
            $scheduleDateTime = Carbon::parse($request->schedule_date)
                ->setTimeFromTimeString($request->schedule_time ?? '09:00');

            // Create notification schedule
            $schedule = NotificationSchedule::create([
                'case_id'     => $case->id,
                'template_id' => $template->id,
                'channel'     => $template->channel,
                'status'      => 'active',
                'schedule_date'=> $scheduleDateTime,
                'created_by'  => Auth::id(),
            ]);

            foreach ($request->witness_ids as $witnessId) {
                $witness = Witness::findOrFail($witnessId);

                $notification = Notification::create([
                    'schedule_id' => $schedule->id,
                    'witness_id'  => $witness->id,
                    'channel'     => $template->channel,
                    'status'      => 'pending',
                ]);

                // Send immediately if requested
                if ($request->send_now) {
                    $message = str_replace(
                        ['{witness_name}', '{case_no}', '{hearing_date}', '{hearing_time}'],
                        [$witness->name, $case->case_no, $case->hearing_date, $case->hearing_time],
                        $template->body_en_sms
                    );

                    $smsResponse = $this->smsService->send([[
                        'to'      => '88' . $witness->phone,
                        'message' => $message
                    ]]);

                    $notification->update([
                        'status'   => $smsResponse['response_code'] == 202 ? 'sent' : 'failed',
                        'sent_at'  => $smsResponse['response_code'] == 202 ? now() : null,
                        'response' => $smsResponse['response']
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Witness schedule saved successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Show case reschedule form
    public function rescheduleForm(CourtCase $case)
    {
        return view('admin.cases.reschedule', compact('case'));
    }

    // Reschedule all witnesses for a case
    public function reschedule(Request $request, CourtCase $case)
    {
        $request->validate([
            'reschedule_date' => 'required|date',
            'reschedule_time' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $case->update([
                'hearing_date' => $request->reschedule_date,
                'hearing_time' => $request->reschedule_time,
            ]);

            foreach ($case->witnesses as $witness) {
                $schedule = NotificationSchedule::create([
                    'case_id'     => $case->id,
                    'template_id' => 1, // default template or allow selection
                    'channel'     => 'sms',
                    'status'      => 'active',
                    'schedule_date'=> Carbon::parse($request->reschedule_date)
                                        ->setTimeFromTimeString($request->reschedule_time ?? '09:00'),
                    'created_by'  => Auth::id(),
                ]);

                Notification::create([
                    'schedule_id' => $schedule->id,
                    'witness_id'  => $witness->id,
                    'channel'     => 'sms',
                    'status'      => 'pending',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.witness_schedules.create')->with('success', 'Case rescheduled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
