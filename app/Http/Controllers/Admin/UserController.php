<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Court;
use Spatie\Permission\Models\Role;
use App\Models\PermissionGroup;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Users')->only(['index']);
        $this->middleware('permission:Create Users')->only(['create', 'store']);
        $this->middleware('permission:Edit Users')->only(['edit', 'update']);
        $this->middleware('permission:Delete Users')->only(['destroy']);
        $this->middleware('permission:View User Permissions')->only(['destroy']);
    }

    public function index()
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->hasRole('Super Admin')) {
            // Super Admin sees all users
            $users = User::with('roles', 'permissions')->get();
        } elseif (is_null($loggedInUser->district_id)) {
            // Ministry-level user sees all except Super Admins
            $users = User::with('roles', 'permissions')
                ->whereDoesntHave('roles', fn($q) => $q->where('name', 'Super Admin'))
                ->get();
        } else {
            // District-level admin sees only users in their district, excluding Super Admins
            $users = User::with('roles', 'permissions')
                ->where('district_id', $loggedInUser->district_id)
                ->whereDoesntHave('roles', fn($q) => $q->where('name', 'Super Admin'))
                ->get();
        }

        return view('admin.rbac.users.index', compact('users'));
    }

    public function create()
    {
        $loggedInUser = Auth::user();

        $roles = $loggedInUser->hasRole('Super Admin')
            ? Role::all()
            : Role::where('name', '!=', 'Super Admin')->get();

        $permissionGroups = PermissionGroup::with('permissions')->get();

        // District assignment logic
        if ($loggedInUser->district_id) {
            // District admin → only their district
            $divisions = Division::with(['districts' => fn($q) => $q->where('id', $loggedInUser->district_id), 'districts.courts'])->get();
        } else {
            // Ministry / Super Admin → all divisions/districts
            $divisions = Division::with('districts.courts')->get();
        }

        $userRoles = [];
        $directPermissions = [];

        return view('admin.rbac.users.create_edit', compact(
            'roles',
            'permissionGroups',
            'userRoles',
            'directPermissions',
            'divisions'
        ));
    }

    public function store(Request $request)
    {
        $loggedInUser = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'court_id' => 'nullable|exists:courts,id',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        // District restriction for district admins
        if ($loggedInUser->district_id && $request->district_id != $loggedInUser->district_id) {
            abort(403, 'Unauthorized to assign user to another district.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'court_id' => $request->court_id,
            'password' => Hash::make($request->password),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        if ($request->permissions) {
            $user->givePermissionTo($request->permissions);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'User created successfully']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $loggedInUser = Auth::user();

        $user->load('roles');

        // Super Admin restriction
        if ($user->hasRole('Super Admin') && !$loggedInUser->hasRole('Super Admin')) {
            abort(403, 'Unauthorized to edit Super Admin.');
        }

        // District restriction
        if (!$loggedInUser->hasRole('Super Admin') && $loggedInUser->district_id 
            && $user->district_id !== $loggedInUser->district_id) {
            abort(403, 'Unauthorized to edit users from other districts.');
        }

        $roles = $loggedInUser->hasRole('Super Admin')
            ? Role::all()
            : Role::where('name', '!=', 'Super Admin')->get();

        $permissionGroups = PermissionGroup::with('permissions')->get();

        // District assignment logic
        if ($loggedInUser->district_id) {
            $divisions = Division::with(['districts' => fn($q) => $q->where('id', $loggedInUser->district_id), 'districts.courts'])->get();
        } else {
            $divisions = Division::with('districts.courts')->get();
        }

        $userRoles = $user->roles->pluck('name')->toArray();
        $directPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.rbac.users.create_edit', compact(
            'user',
            'roles',
            'permissionGroups',
            'userRoles',
            'directPermissions',
            'divisions'
        ));
    }

    public function update(Request $request, User $user)
    {
        $loggedInUser = Auth::user();

        $user->load('roles');
        $loggedInUser->load('roles');

        // Super Admin restriction
        if ($user->hasRole('Super Admin') && !$loggedInUser->hasRole('Super Admin')) {
            abort(403, 'Unauthorized to update Super Admin.');
        }

        // District restriction
        if (!$loggedInUser->hasRole('Super Admin') && $loggedInUser->district_id 
            && $user->district_id !== $loggedInUser->district_id) {
            abort(403, 'Unauthorized to update users from other districts.');
        }

        // District restriction for update assignment
        if ($loggedInUser->district_id && $request->district_id != $loggedInUser->district_id) {
            abort(403, 'Unauthorized to assign user to another district.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'court_id' => 'nullable|exists:courts,id',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'court_id' => $request->court_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'User updated successfully']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user, Request $request)
    {
        $loggedInUser = Auth::user();

        // Super Admin restriction
        if ($user->hasRole('Super Admin') && !$loggedInUser->hasRole('Super Admin')) {
            abort(403, 'Unauthorized to delete Super Admin.');
        }

        // District restriction
        if (!$loggedInUser->hasRole('Super Admin') && $loggedInUser->district_id 
            && $user->district_id !== $loggedInUser->district_id) {
            abort(403, 'Unauthorized to delete users from other districts.');
        }

        $user->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'User deleted successfully']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
