<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\District;
use App\Models\Division as ModelsDivision;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View District')->only(['index']);
        $this->middleware('permission:Create District')->only(['store']);
        $this->middleware('permission:Edit District')->only(['edit', 'update']);
        $this->middleware('permission:Delete District')->only(['destroy']);
    }

    public function index()
    {
        $districts = District::with('division')->get();
        $divisions = ModelsDivision::all();
        return view('admin.districts.index', compact('districts', 'divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:districts,name',
            'division_id' => 'required|exists:divisions,id',
        ]);

        $district = District::create($validated);

        return response()->json([
            'success' => true,
            'district' => $district->load('division'),
            'message' => 'District created successfully!'
        ]);
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        return response()->json($district);
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', Rule::unique('districts')->ignore($district->id)],
            'division_id' => 'required|exists:divisions,id',
        ]);

        $district->update($validated);

        return response()->json([
            'success' => true,
            'district' => $district->load('division'),
            'message' => 'District updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();

        return response()->json([
            'success' => true,
            'message' => 'District deleted successfully!'
        ]);
    }
}
