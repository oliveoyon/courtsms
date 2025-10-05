<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Witness;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\Division;
use App\Models\MessageTemplate;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
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

    public function createAndSend()
    {
        $user = Auth::user();
        $loggedInUser = Auth::user();

        $roles = $loggedInUser->hasRole('Super Admin')
            ? Role::all()
            : Role::where('name', '!=', 'Super Admin')->get();

        $permissionGroups = PermissionGroup::with('permissions')->get();

        $divisions = $loggedInUser->district_id
            ? Division::with(['districts' => fn($q) => $q->where('id', $loggedInUser->district_id), 'districts.courts'])->get()
            : Division::with('districts.courts')->get();

        $templates = MessageTemplate::where('is_active', true)->get();

        return view('admin.cases.create_send', compact('divisions', 'templates', 'user'));
    }

    public function storeAndSend(Request $request)
    {
        $request->validate([
            'division_id'      => 'required|exists:divisions,id',
            'district_id'      => 'required|exists:districts,id',
            'court_id'         => 'required|exists:courts,id',
            'case_no'          => 'required|string|max:255',
            'hearing_date'     => 'required|date',
            'hearing_time'     => 'required',
            'witnesses.*.name' => 'required|string|max:255',
            'witnesses.*.phone' => ['required', 'regex:/^01\d{9}$/'],
            'schedules'        => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Static language and template
            $lang = 'en'; // or 'bn'
            $template = MessageTemplate::find(1); // default template ID

            if (!$template) {
                throw new \Exception("Default template not found!");
            }

            // 1. Create court case
            $courtCase = CourtCase::create([
                'case_no'      => $request->case_no,
                'court_id'     => $request->court_id,
                'hearing_date' => $request->hearing_date,
                'hearing_time' => $request->hearing_time,
                'notes'        => $request->notes ?? null,
                'created_by'   => Auth::id(),
            ]);

            // 2. Create witnesses
            $witnessIds = [];
            foreach ($request->witnesses as $w) {
                $witness = Witness::create([
                    'case_id' => $courtCase->id,
                    'name'    => $w['name'],
                    'phone'   => $w['phone'],
                ]);
                $witnessIds[] = $witness->id;
            }

            // 3. Create notification schedules and notifications
            foreach ($request->schedules as $sched) {
                $scheduleDate = match ($sched) {
                    '10_days_before' => Carbon::parse($request->hearing_date)->subDays(10),
                    '3_days_before'  => Carbon::parse($request->hearing_date)->subDays(3),
                    'send_now'       => now(),
                    default          => now(),
                };

                $schedule = NotificationSchedule::create([
                    'case_id'      => $courtCase->id,
                    'template_id'  => $template->id,
                    'channel'      => $template->channel, // use template channel
                    'status'       => 'active',
                    'schedule_date' => $scheduleDate,
                    'created_by'   => Auth::id(),
                ]);

                foreach ($witnessIds as $id) {
                    Notification::create([
                        'schedule_id' => $schedule->id,
                        'witness_id'  => $id,
                        'channel'     => $template->channel,
                        'status'      => 'pending',
                    ]);
                }

                // 4. Send immediately if 'send_now'
                if ($sched === 'send_now') {
                    foreach ($witnessIds as $id) {
                        $witness = Witness::find($id);

                        // Determine message body based on language & channel
                        $smsBody = $lang === 'en' ? $template->body_en_sms : $template->body_bn_sms;
                        $whatsappBody = $lang === 'en' ? $template->body_en_whatsapp : $template->body_bn_whatsapp;

                        $smsMessage = str_replace(
                            ['{witness_name}', '{case_no}', '{hearing_date}', '{hearing_time}'],
                            [$witness->name, $courtCase->case_no, $courtCase->hearing_date, $courtCase->hearing_time],
                            $smsBody
                        );

                        $whatsappMessage = str_replace(
                            ['{witness_name}', '{case_no}', '{hearing_date}', '{hearing_time}'],
                            [$witness->name, $courtCase->case_no, $courtCase->hearing_date, $courtCase->hearing_time],
                            $whatsappBody
                        );

                        if ($template->channel === 'sms' || $template->channel === 'both') {
                            $smsResponse = $this->smsService->send([[
                                'to' => '88' . $witness->phone,
                                'message' => $smsMessage
                            ]]);

                            // dd($smsResponse);

                            Notification::where('schedule_id', $schedule->id)
                                ->where('witness_id', $id)
                                ->update([
                                    'status'   => $smsResponse['response_code'] == 202 ? 'sent' : 'failed',
                                    'sent_at'  => $smsResponse['response_code'] == 202 ? now() : null,
                                    'response' => $smsResponse['response']
                                ]);
                        }

                        if ($template->channel === 'whatsapp' || $template->channel === 'both') {
                            // WhatsApp sending logic placeholder
                            // $whatsappResponse = $this->whatsappService->send([...]);
                            // Notification::update([...]);
                        }
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
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
}
