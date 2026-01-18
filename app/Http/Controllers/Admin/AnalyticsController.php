<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourtCase;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function overview()
    {
        $user = Auth::user();

        // Dependent loading: restrict dropdowns if user has division/district
        $divisions = $user->district_id
            ? Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->get()
            : Division::with('districts.courts')->get();

        return view('admin.analytics.overview', compact('divisions', 'user'));
    }

    public function smsSummary(Request $request)
    {
        $divisionId   = $request->query('division_id');
        $districtId   = $request->query('district_id');
        $courtId      = $request->query('court_id');
        $fromDate     = $request->query('from_date');
        $toDate       = $request->query('to_date');
        $status       = $request->query('status');        // sent/pending/failed
        $witness      = $request->query('witness');       // appeared/not_appeared
        $rescheduled  = $request->query('rescheduled');   // yes/no
        $gender       = $request->query('gender');        // Male/Female/Third Gender
        $othersInfo   = $request->query('others_info');   // Under 18 / Person with Disability
        $smsSeen      = $request->query('sms_seen');      // yes/no
        $witnessHeard = $request->query('witness_heard'); // yes/no

        $cases = CourtCase::with([
            'hearings.notifications',
            'hearings.witnesses',
            'court.district.division'
        ]);

        // Hierarchical filters
        if ($courtId) {
            $cases->where('court_id', $courtId);
        } elseif ($districtId) {
            $cases->whereHas('court.district', fn($q) => $q->where('id', $districtId));
        } elseif ($divisionId) {
            $cases->whereHas('court.district.division', fn($q) => $q->where('id', $divisionId));
        }

        if ($fromDate) $cases->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '>=', $fromDate));
        if ($toDate) $cases->whereHas('hearings', fn($q) => $q->whereDate('hearing_date', '<=', $toDate));

        $cases = $cases->get();

        $summary = [];

        foreach ($cases as $case) {
            foreach ($case->hearings as $hearing) {
                $allNotifications = $hearing->notifications->flatMap(fn($s) => $s->notifications ?? collect());
                $witnesses = $hearing->witnesses;

                $sent      = $allNotifications->whereIn('status', ['sent', 'delivered'])->count();
                $pending   = $allNotifications->where('status', 'pending')->count();
                $failed    = $allNotifications->where('status', 'failed')->count();
                $totalSms  = $allNotifications->count();

                $appeared      = $witnesses->where('appeared_status','appeared')->count();
                $notAppeared   = $witnesses->where('appeared_status','!=','appeared')->count();
                $isRescheduled = $hearing->is_reschedule ? 1 : 0;

                // Advanced witness filters only on appeared/absent/excused
                $witnessFiltered = $witnesses->whereIn('appeared_status', ['appeared','absent','excused']);
                if ($gender) $witnessFiltered = $witnessFiltered->where('gender', $gender);
                if ($othersInfo) $witnessFiltered = $witnessFiltered->where('others_info', $othersInfo);
                if ($smsSeen) $witnessFiltered = $witnessFiltered->where('sms_seen', $smsSeen);
                if ($witnessHeard) $witnessFiltered = $witnessFiltered->where('witness_heard', $witnessHeard);

                // Skip if main filters don't match
                if ($witness && $witness === 'appeared' && $witnessFiltered->where('appeared_status','appeared')->count() === 0) continue;
                if ($witness && $witness === 'not_appeared' && $witnessFiltered->where('appeared_status','!=','appeared')->count() === 0) continue;

                if ($status === 'sent' && $sent === 0) continue;
                if ($status === 'pending' && $pending === 0) continue;
                if ($status === 'failed' && $failed === 0) continue;

                if ($rescheduled === 'yes' && !$isRescheduled) continue;
                if ($rescheduled === 'no' && $isRescheduled) continue;

                $summary[] = [
                    'division'          => optional($case->court->district->division)->name_en ?? '-',
                    'district'          => optional($case->court->district)->name_en ?? '-',
                    'court'             => $case->court->name_en,
                    'total_sms_sent'    => $totalSms,
                    'sent'              => $sent,
                    'pending'           => $pending,
                    'failed'            => $failed,
                    'witness_appeared'  => $appeared,
                    'rescheduled_cases' => $isRescheduled,
                ];
            }
        }

        // Combine counts
        $combined = [];
        foreach ($summary as $row) {
            $key = $row['division'].'|'.$row['district'].'|'.$row['court'];
            if (!isset($combined[$key])) $combined[$key] = $row;
            else {
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
