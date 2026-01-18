<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\CourtCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtSmsReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $divisions = $user->district_id
            ? Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->get()
            : Division::with('districts.courts')->get();

        return view('admin.reports.court_sms_dashboard', compact('divisions', 'user'));
    }

    public function getMetrics(Request $request)
    {
        $divisionId = $request->query('division_id');
        $districtId = $request->query('district_id');
        $courtId    = $request->query('court_id');
        $fromDate   = $request->query('from_date');
        $toDate     = $request->query('to_date');

        $cases = CourtCase::with([
            'hearings.notifications',
            'hearings.witnesses',
            'court.district.division'
        ]);

        // Flexible filtering
        if ($divisionId) {
            $cases->whereHas('court.district.division', fn($q) => $q->where('id', $divisionId));
        }
        if ($districtId) {
            $cases->whereHas('court.district', fn($q) => $q->where('id', $districtId));
        }
        if ($courtId) {
            $cases->where('court_id', $courtId);
        }
        if ($fromDate) {
            $cases->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '>=', $fromDate));
        }
        if ($toDate) {
            $cases->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '<=', $toDate));
        }

        $cases = $cases->get();

        $summary = [];

        foreach ($cases as $case) {
            foreach ($case->hearings as $hearing) {
                $allNotifications = $hearing->notifications->flatMap(fn($schedule) => $schedule->notifications ?? collect());
                $witnesses = $hearing->witnesses;

                $sent      = $allNotifications->whereIn('status', ['sent', 'delivered'])->count();
                $pending   = $allNotifications->where('status', 'pending')->count();
                $failed    = $allNotifications->where('status', 'failed')->count();
                $totalSms  = $allNotifications->count();
                $appeared  = $witnesses->where('appeared_status', 'appeared')->count();
                $rescheduled = $hearing->is_reschedule ? 1 : 0;

                $summary[] = [
                    'division'          => optional($case->court->district->division)->name_en ?? '-',
                    'district'          => optional($case->court->district)->name_en ?? '-',
                    'court'             => $case->court->name_en,
                    'total_sms_sent'    => $totalSms,
                    'sent'              => $sent,
                    'pending'           => $pending,
                    'failed'            => $failed,
                    'witness_appeared'  => $appeared,
                    'rescheduled_cases' => $rescheduled,
                ];
            }
        }

        // Combine by division/district/court
        $combined = [];
        foreach ($summary as $row) {
            $key = $row['division'] . '|' . $row['district'] . '|' . $row['court'];
            if (!isset($combined[$key])) {
                $combined[$key] = $row;
            } else {
                $combined[$key]['total_sms_sent']    += $row['total_sms_sent'];
                $combined[$key]['sent']              += $row['sent'];
                $combined[$key]['pending']           += $row['pending'];
                $combined[$key]['failed']            += $row['failed'];
                $combined[$key]['witness_appeared']  += $row['witness_appeared'];
                $combined[$key]['rescheduled_cases'] += $row['rescheduled_cases'];
            }
        }

        return response()->json(array_values($combined));
    }
}
