<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourtCase;
use App\Models\Division;

class CaseReportController extends Controller
{
    public function index()
    {
        // Fetch divisions for filter dropdown
        $divisions = Division::with('districts')->get();

        return view('admin.reports.cases.index', compact('divisions'));
    }

    public function filter(Request $request)
    {
        $query = CourtCase::with(['court.district.division']);

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
