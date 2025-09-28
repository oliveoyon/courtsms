<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Court;
use App\Models\Admin\District;
use Illuminate\Validation\Rule;

class CourtController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Court')->only(['index']);
        $this->middleware('permission:Create Court')->only(['store']);
        $this->middleware('permission:Edit Court')->only(['edit', 'update']);
        $this->middleware('permission:Delete Court')->only(['destroy']);
    }

    public function index()
    {
        $courts = Court::with('district')->get();
        $districts = District::all();
        return view('admin.courts.index', compact('courts', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:courts,name',
            'district_id' => 'required|exists:districts,id',
        ]);

        $court = Court::create($validated);
        $court->load('district');

        return response()->json([
            'success' => true,
            'court' => $court,
            'message' => 'Court created successfully!'
        ]);
    }

    public function edit($id)
    {
        $court = Court::findOrFail($id);
        return response()->json($court);
    }

    public function update(Request $request, $id)
    {
        $court = Court::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', Rule::unique('courts')->ignore($court->id)],
            'district_id' => 'required|exists:districts,id',
        ]);

        $court->update($validated);
        $court->load('district');

        return response()->json([
            'success' => true,
            'court' => $court,
            'message' => 'Court updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $court = Court::findOrFail($id);
        $court->delete();

        return response()->json([
            'success' => true,
            'message' => 'Court deleted successfully!'
        ]);
    }
}
