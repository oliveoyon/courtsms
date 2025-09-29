<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Division as ModelsDivision;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        try {
            $validated = $request->validate([
                'name_en' => 'required|unique:districts,name_en',
                'name_bn' => 'required|unique:districts,name_bn',
                'division_id' => 'required|exists:divisions,id',
                'is_active' => 'sometimes|boolean',
            ]);

            $district = District::create($validated);

            return response()->json([
                'success' => true,
                'district' => $district->load('division'),
                'message' => __('district.district_created_success')
            ]);
        } catch (ValidationException $e) {
            // Return JSON errors instead of redirect
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        return response()->json($district);
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);

        try {
            $validated = $request->validate([
                'name_en' => ['required', Rule::unique('districts')->ignore($district->id)],
                'name_bn' => ['required', Rule::unique('districts')->ignore($district->id)],
                'division_id' => 'required|exists:divisions,id',
                'is_active' => 'sometimes|boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $district->update($validated);

        return response()->json([
            'success' => true,
            'district' => $district->load('division'),
            'message' => __('district.district_updated_success')
        ]);
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();

        return response()->json([
            'success' => true,
            'message' => __('district.district_deleted_success')
        ]);
    }

    public function courts(District $district)
    {
        $courts = $district->courts()->get();
        return response()->json($courts);
    }
}
