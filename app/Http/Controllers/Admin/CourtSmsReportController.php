<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\CourtCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtSmsReportController extends Controller
{
    /**
     * Load the dashboard page
     */
    public function index()
    {
        $user = Auth::user();

        // Division filter data
        $divisions = $user->district_id
            ? Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->get()
            : Division::with('districts.courts')->get();

        return view('admin.reports.court_sms_dashboard', compact('divisions', 'user'));
    }

    /**
     * Return JSON metrics for charts and table
     */
    public function getMetrics(Request $request)
    {
        $user = Auth::user();

        $divisionId = $request->query('division_id') ?? $user->division_id;
        $districtId = $request->query('district_id') ?? $user->district_id;
        $courtId = $request->query('court_id') ?? $user->court_id;
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        $casesQuery = CourtCase::with([
            'hearings.notifications',
            'hearings.witnesses',
            'court.district.division'
        ]);

        // User-level + filter restrictions
        if ($divisionId) {
            $casesQuery->whereHas('court.district.division', fn($q) => $q->where('id', $divisionId));
        }
        if ($districtId) {
            $casesQuery->whereHas('court.district', fn($q) => $q->where('id', $districtId));
        }
        if ($courtId) {
            $casesQuery->where('court_id', $courtId);
        }
        if ($fromDate) {
            $casesQuery->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '>=', $fromDate));
        }
        if ($toDate) {
            $casesQuery->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '<=', $toDate));
        }

        $cases = $casesQuery->get();

        // Calculate metrics per court
        $summary = [];
        $totalCases = 0;

        foreach ($cases as $case) {
            $totalCases++; // count distinct cases

            foreach ($case->hearings as $hearing) {
                $notifications = $hearing->notifications->flatMap(fn($n) => $n->notifications ?? collect());
                $witnesses = $hearing->witnesses;

                $sent = $notifications->whereIn('status', ['sent', 'delivered'])->count();
                $pending = $notifications->where('status', 'pending')->count();
                $failed = $notifications->where('status', 'failed')->count();
                $totalSms = $notifications->count();
                $appeared = $witnesses->where('appeared_status', 'appeared')->count();
                $rescheduled = $hearing->is_reschedule ? 1 : 0;

                $summary[] = [
                    'division' => optional($case->court->district->division)->name_en ?? '-',
                    'district' => optional($case->court->district)->name_en ?? '-',
                    'court' => $case->court->name_en,
                    'total_cases' => 1, // each case counted once
                    'total_sms_sent' => $totalSms,
                    'sent' => $sent,
                    'pending' => $pending,
                    'failed' => $failed,
                    'witness_appeared' => $appeared,
                    'rescheduled_cases' => $rescheduled,
                ];
            }
        }

        // Combine metrics by court
        $combined = [];
        foreach ($summary as $row) {
            $key = $row['division'] . '|' . $row['district'] . '|' . $row['court'];

            if (!isset($combined[$key])) {
                $combined[$key] = $row;
            } else {
                foreach (['total_cases','total_sms_sent','sent','pending','failed','witness_appeared','rescheduled_cases'] as $field) {
                    $combined[$key][$field] += $row[$field];
                }
            }
        }

        return response()->json(array_values($combined));
    }
}
