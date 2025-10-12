<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Witness;
use App\Models\CaseReschedule;
use App\Models\WitnessAttendance;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourtAppearanceController extends Controller
{
    // Show the appearance panel
    public function index()
    {
        $divisions = \App\Models\Division::with('districts.courts')->get();
        $user = auth()->user();
        return view('admin.cases.appearance_panel', compact('divisions', 'user'));
    }

    // Fetch witnesses for selected filters (AJAX)
    public function fetchWitnesses(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'court_id'    => 'required|exists:courts,id',
            'date'        => 'required|date',
        ]);

        $cases = CourtCase::with(['witnesses'])
            ->where('court_id', $request->court_id)
            ->where(function ($q) use ($request) {
                $q->where('hearing_date', $request->date)
                    ->orWhereHas('reschedules', function ($q2) use ($request) {
                        $q2->where('reschedule_date', $request->date);
                    });
            })
            ->get();

        $response = $cases->map(function ($case) {
            // Get next reschedule (if any)
            $nextReschedule = $case->reschedules()
                ->where('reschedule_date', '>', $case->hearing_date)
                ->orderBy('reschedule_date', 'asc')
                ->first();

            return [
                'case_id' => $case->id,
                'case_no' => $case->case_no,
                'court_name' => $case->court ? $case->court->name_en : '',
                'hearing_date' => $case->hearing_date,
                'hearing_time' => $case->hearing_time,
                'next_schedule_date' => $nextReschedule->reschedule_date ?? null,
                'next_schedule_time' => $nextReschedule->reschedule_time ?? null,
                'witnesses' => $case->witnesses->map(function ($w) use ($case) {
                    $attendance = WitnessAttendance::where('case_id', $case->id)
                        ->where('witness_id', $w->id)
                        ->latest()
                        ->first();

                    return [
                        'id' => $w->id,
                        'name' => $w->name,
                        'phone' => $w->phone,
                        'appeared_status' => $attendance->status ?? 'pending',
                        'hearing_date' => $attendance->hearing_date ?? $case->hearing_date,
                        'hearing_time' => $attendance->hearing_time ?? $case->hearing_time,
                    ];
                }),
            ];
        });

        return response()->json($response);
    }

    // Update witness status (AJAX)
    public function updateStatus(Request $request, Witness $witness)
    {
        $request->validate([
            'status' => 'required|in:pending,appeared,absent,excused',
            'case_id' => 'required|exists:cases,id',
        ]);

        // Store/update witness attendance
        WitnessAttendance::updateOrCreate(
            [
                'case_id' => $request->case_id,
                'witness_id' => $witness->id,
                'hearing_date' => now()->toDateString(),
            ],
            [
                'status' => $request->status,
            ]
        );

        // Maintain old column update if it exists
        if ($witness->isFillable('appeared_status')) {
            $witness->update(['appeared_status' => $request->status]);
        }

        return response()->json(['message' => 'Witness attendance updated successfully.']);
    }

    // Reschedule case & notifications
    public function reschedule(Request $request, CourtCase $case)
    {
        $request->validate([
            'reschedule_date' => 'required|date|after_or_equal:today',
            'reschedule_time' => 'nullable',
            'notify_options'  => 'required|array|min:1',
        ]);

        $notifyOptions = $request->notify_options;

        DB::beginTransaction();

        try {
            // Create a new reschedule record using new table
            $reschedule = CaseReschedule::create([
                'case_id' => $case->id,
                'reschedule_date' => $request->reschedule_date,
                'reschedule_time' => $request->reschedule_time ?? $case->hearing_time,
                'created_by' => Auth::id(), // ✅ Added this line
            ]);


            // Get all witnesses of the case
            $witnesses = $case->witnesses;
            if ($witnesses->isEmpty()) {
                DB::commit();
                return response()->json(['message' => 'Case rescheduled successfully. No witnesses found.']);
            }

            $template = MessageTemplate::find(1); // Default template

            foreach ($notifyOptions as $option) {
                $scheduleDate = match ($option) {
                    '10_days_before' => Carbon::parse($reschedule->reschedule_date)->subDays(10),
                    '3_days_before'  => Carbon::parse($reschedule->reschedule_date)->subDays(3),
                    'send_now'       => now(),
                    default          => now(),
                };

                if (Carbon::parse($request->reschedule_date)->lt($scheduleDate)) {
                    DB::rollBack();
                    return response()->json(['message' => "Reschedule date cannot be before notification ($option)."], 422);
                }

                $schedule = NotificationSchedule::create([
                    'case_id' => $case->id,
                    'template_id' => $template->id,
                    'channel' => $template->channel,
                    'status' => 'active',
                    'schedule_date' => $scheduleDate,
                    'created_by' => auth()->id(),
                ]);

                foreach ($witnesses as $w) {
                    Notification::create([
                        'schedule_id' => $schedule->id,
                        'witness_id' => $w->id,
                        'channel' => $template->channel,
                        'status' => 'pending',
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Case rescheduled and notifications updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
