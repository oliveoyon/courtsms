<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Witness;
use Carbon\Carbon;

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
            ->where('hearing_date', $request->date)
            ->get();

        $response = $cases->map(function ($case) {
            return [
                'case_id'    => $case->id,
                'case_no'    => $case->case_no,
                'court_name' => $case->court ? $case->court->name_en : '',
                'witnesses'  => $case->witnesses->map(function ($w) {
                    return [
                        'id'             => $w->id,
                        'name'           => $w->name,
                        'phone'          => $w->phone,
                        'appeared_status' => $w->appeared_status ?? 'pending',
                        'reschedule_date' => $w->reschedule_date ?? null,
                    ];
                }),
            ];
        });

        return response()->json($response);
    }


    // Update witness status (AJAX)
    public function updateStatus(Request $request, Witness $witness)
    {
        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:pending,appeared,absent,excused',
            ]);
            $witness->update(['appeared_status' => $request->status]);
            return response()->json(['message' => 'Status updated successfully.']);
        }

        if ($request->has('reschedule_date')) {
            $request->validate([
                'reschedule_date' => 'required|date',
            ]);
            // $witness->update(['hearing_date' => $request->reschedule_date]);
            $witness->courtCase->update(['hearing_date' => $request->reschedule_date]);
            return response()->json(['message' => 'Appearance rescheduled successfully.']);
        }

        return response()->json(['message' => 'No valid action provided.'], 422);
    }
}
