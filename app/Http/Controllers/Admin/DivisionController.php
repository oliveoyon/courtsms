<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Division')->only(['index']);
        $this->middleware('permission:Create Division')->only(['store']);
        $this->middleware('permission:Edit Division')->only(['edit', 'update']);
        $this->middleware('permission:Delete Division')->only(['destroy']);
    }

    // Display all divisions
    public function index()
    {
        $divisions = Division::all();
        return view('admin.location.divisions', compact('divisions'));
    }

    // Store new division via AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en'   => 'required|unique:divisions,name_en',
            'name_bn'   => 'required|unique:divisions,name_bn',
            'is_active' => 'boolean',
        ]);

        $division = Division::create($validated);

        return response()->json([
            'success'  => true,
            'division' => $division,
            'message'  => __('messages.success_create')
        ]);
    }

    // Get a division for edit modal
    public function edit($id)
    {
        $division = Division::findOrFail($id);
        return response()->json($division);
    }

    // Update division via AJAX
    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);

        $validated = $request->validate([
            'name_en'   => ['required', Rule::unique('divisions', 'name_en')->ignore($division->id)],
            'name_bn'   => ['required', Rule::unique('divisions', 'name_bn')->ignore($division->id)],
            'is_active' => 'boolean',
        ]);

        $division->update($validated);

        return response()->json([
            'success'  => true,
            'division' => $division,
            'message'  => __('messages.success_update')
        ]);
    }

    // Delete division via AJAX (safe delete)
    public function destroy($id)
    {
        $division = Division::withCount('districts')->findOrFail($id);

        if ($division->districts_count > 0) {
            return response()->json([
                'success' => false,
                'message' => __('messages.division_has_districts') // e.g. "Cannot delete, districts exist under this division"
            ], 400);
        }

        $division->delete();

        return response()->json([
            'success' => true,
            'message' => __('messages.success_deleted')
        ]);
    }

    // Get all districts under a division
    public function districts(Division $division)
    {
        $districts = $division->districts()->where('is_active', 1)->with('courts')->get();
        return response()->json($districts);
    }
}
