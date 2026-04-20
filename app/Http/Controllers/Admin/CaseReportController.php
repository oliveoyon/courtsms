<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;

class CaseReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->court_id) {
            $divisions = Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts' => fn($q) => $q->where('id', $user->court_id),
            ])->where('id', $user->division_id)->get();
        } elseif ($user->district_id) {
            $divisions = Division::with([
                'districts' => fn($q) => $q->where('id', $user->district_id),
                'districts.courts'
            ])->where('id', $user->division_id)->get();
        } elseif ($user->division_id) {
            $divisions = Division::with('districts.courts')->where('id', $user->division_id)->get();
        } else {
            $divisions = Division::with('districts.courts')->get();
        }

        return view('admin.reports.cases.index', compact('divisions'));
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = CourtCase::with(['court.district.division']);

        if ($user->court_id) {
            $query->where('court_id', $user->court_id);
        } elseif ($user->district_id) {
            $query->whereHas('court.district', fn($q) => $q->where('id', $user->district_id));
        } elseif ($user->division_id) {
            $query->whereHas('court.district.division', fn($q) => $q->where('id', $user->division_id));
        }

        // Filters
        if ($request->division_id) {
            $query->whereHas('court.district.division', fn($q) => $q->where('id', $request->division_id));
        }
        if ($request->district_id) {
            $query->whereHas('court.district', fn($q) => $q->where('id', $request->district_id));
        }
        if ($request->court_id) {
            $query->where('court_id', $request->court_id);
        }
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('hearing_date', [$request->from_date, $request->to_date]);
        }

        $cases = $query->get();

        return view('admin.reports.cases.index', compact('cases', 'request'));
    }
}
