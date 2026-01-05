<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\District;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $courts = $user->district_id
            ? Court::with('district')
            ->where('district_id', $user->district_id)
            ->where('is_active', 1)
            ->get()
            : Court::with('district')
            ->where('is_active', 1)
            ->get();

        $districts = $user->district_id
            ? District::where('id', $user->district_id)
            ->where('is_active', 1)
            ->get()
            : District::where('is_active', 1)->get();


        return view('admin.courts.index', compact('courts', 'districts'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_en' => 'required|unique:courts,name_en',
                'name_bn' => 'required|unique:courts,name_bn',
                'district_id' => 'required|exists:districts,id',
                'is_active' => 'sometimes|boolean',
            ]);

            $court = Court::create($validated);
            $court->load('district');

            return response()->json([
                'success' => true,
                'court' => $court,
                'message' => __('court.created_success')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON errors instead of redirect
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
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
            'name_en' => ['required', Rule::unique('courts')->ignore($court->id)],
            'name_bn' => ['required', Rule::unique('courts')->ignore($court->id)],
            'district_id' => 'required|exists:districts,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $court->update($validated);
        $court->load('district');

        return response()->json([
            'success' => true,
            'court' => $court,
            'message' => __('court.updated_success')
        ]);
    }

    public function destroy($id)
    {
        $court = Court::findOrFail($id);
        $court->delete();

        return response()->json([
            'success' => true,
            'message' => __('court.deleted_success')
        ]);
    }
}
