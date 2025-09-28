<?php

use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home-test', [DashboardController::class, 'test'])->name('dashboard.test');
    Route::resource('permission-groups', PermissionGroupController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::post('roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assignPermissions');

    // Route::get('/home', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:delete users');;


    Route::get('permission-manager', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'index'])
        ->name('permission-manager.index');

    Route::get('permission-manager/{group}/permissions', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'groupPermissions'])
        ->name('permission-manager.permissions');

    Route::post('permission-manager/group', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'storeGroup'])
        ->name('permission-manager.group.store');
    Route::put('permission-manager/group/{id}', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'updateGroup'])
        ->name('permission-manager.group.update');
    Route::delete('permission-manager/group/{id}', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'destroyGroup'])
        ->name('permission-manager.group.destroy');

    Route::post('permission-manager/permission', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'storePermission'])
        ->name('permission-manager.permission.store');
    Route::put('permission-manager/permission/{id}', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'updatePermission'])
        ->name('permission-manager.permission.update');
    Route::delete('permission-manager/permission/{id}', [\App\Http\Controllers\Admin\PermissionManagerController::class, 'destroyPermission'])
        ->name('permission-manager.permission.destroy');



    Route::resource('users', UserController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('courts', CourtController::class);
    Route::get('divisions/{division}/districts', [DivisionController::class, 'districts']);
    Route::get('districts/{district}/courts', [DistrictController::class, 'courts']);
});

require __DIR__ . '/auth.php';
