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
            'name' => 'required|unique:divisions,name',
        ]);

        $division = Division::create($validated);

        return response()->json([
            'success' => true,
            'division' => $division,
            'message' => 'Division created successfully!'
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
            'name' => ['required', Rule::unique('divisions')->ignore($division->id)],
        ]);

        $division->update($validated);

        return response()->json([
            'success' => true,
            'division' => $division,
            'message' => 'Division updated successfully!'
        ]);
    }

    // Delete division via AJAX
    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return response()->json([
            'success' => true,
            'message' => 'Division deleted successfully!'
        ]);
    }

    public function districts(Division $division)
    {
        // eager load courts too if needed
        $districts = $division->districts()->with('courts')->get();

        return response()->json($districts);
    }
}
