<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\CaseReschedule;
use App\Models\Witness;
use App\Models\WitnessAttendance;
use App\Models\NotificationSchedule;
use App\Models\Notification;
use App\Models\MessageTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RescheduleController extends Controller
{
    public function index()
    {
        $reschedules = CaseReschedule::with('case.court')->latest()->paginate(20);
        return view('admin.cases.reschedule_index', compact('reschedules'));
    }

    public function create(CourtCase $case)
    {
        $witnesses = $case->witnesses;
        $templates = MessageTemplate::where('is_active', true)->get();
        return view('admin.cases.reschedule_create', compact('case', 'witnesses', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:cases,id',
            'reschedule_date' => 'required|date',
            'reschedule_time' => 'nullable',
            'attendances' => 'required|array',
            'attendances.*.witness_id' => 'required|exists:witnesses,id',
            'attendances.*.status' => 'required|in:pending,appeared,absent,excused',
        ]);

        DB::beginTransaction();
        try {
            $reschedule = CaseReschedule::create([
                'case_id' => $request->case_id,
                'reschedule_date' => $request->reschedule_date,
                'reschedule_time' => $request->reschedule_time,
            ]);

            foreach ($request->attendances as $att) {
                WitnessAttendance::updateOrCreate(
                    [
                        'case_id' => $reschedule->case_id,
                        'witness_id' => $att['witness_id'],
                        'hearing_date' => $reschedule->reschedule_date,
                    ],
                    [
                        'case_id' => $reschedule->case_id,
                        'witness_id' => $att['witness_id'],
                        'hearing_time' => $reschedule->reschedule_time,
                        'status' => $att['status'],
                        'remarks' => $att['remarks'] ?? null,
                    ]
                );
            }

            // Reschedule notifications
            $template = MessageTemplate::first(); // default
            foreach ($request->attendances as $att) {
                NotificationSchedule::create([
                    'case_id' => $reschedule->case_id,
                    'template_id' => $template->id,
                    'channel' => $template->channel,
                    'status' => 'active',
                    'schedule_date' => $reschedule->reschedule_date,
                    'schedule_time' => $reschedule->reschedule_time,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Case rescheduled successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit(CaseReschedule $reschedule)
    {
        $case = $reschedule->case;
        $witnesses = $case->witnesses;
        $attendances = WitnessAttendance::where('case_id', $case->id)
                            ->where('hearing_date', $reschedule->reschedule_date)
                            ->pluck('status', 'witness_id')->toArray();

        return view('admin.cases.reschedule_edit', compact('reschedule', 'case', 'witnesses', 'attendances'));
    }

    public function update(Request $request, CaseReschedule $reschedule)
    {
        $request->validate([
            'reschedule_date' => 'required|date',
            'reschedule_time' => 'nullable',
            'attendances' => 'required|array',
            'attendances.*.witness_id' => 'required|exists:witnesses,id',
            'attendances.*.status' => 'required|in:pending,appeared,absent,excused',
        ]);

        DB::beginTransaction();
        try {
            $reschedule->update([
                'reschedule_date' => $request->reschedule_date,
                'reschedule_time' => $request->reschedule_time,
            ]);

            foreach ($request->attendances as $att) {
                WitnessAttendance::updateOrCreate(
                    [
                        'case_id' => $reschedule->case_id,
                        'witness_id' => $att['witness_id'],
                        'hearing_date' => $reschedule->reschedule_date,
                    ],
                    [
                        'case_id' => $reschedule->case_id,
                        'witness_id' => $att['witness_id'],
                        'hearing_time' => $reschedule->reschedule_time,
                        'status' => $att['status'],
                        'remarks' => $att['remarks'] ?? null,
                    ]
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Reschedule updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
