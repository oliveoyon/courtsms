<?php

use App\Http\Controllers\Admin\CaseRescheduleController;
use App\Http\Controllers\Admin\CourtCaseController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\MessageTemplateCategoryController;
use App\Http\Controllers\Admin\MessageTemplateController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RescheduleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('language/{locale}', [LanguageController::class, 'setLocale'])->name('locale.set');






// routes/web.php

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

    Route::resource('users', UserController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('courts', CourtController::class);
    Route::get('divisions/{division}/districts', [DivisionController::class, 'districts']);
    Route::get('districts/{district}/courts', [DistrictController::class, 'courts']);


    Route::get('cases/create-and-send', [CourtCaseController::class, 'createAndSend'])->name('cases.create_send');
    Route::post('cases/create-and-send', [CourtCaseController::class, 'storeAndSend'])->name('cases.store_send');
    Route::resource('message-templates', MessageTemplateController::class);
    Route::resource('message-template-categories', MessageTemplateCategoryController::class);

    Route::get('{case}/reschedules', [CaseRescheduleController::class, 'index'])->name('reschedules.index');
    Route::get('{case}/reschedules/create', [CaseRescheduleController::class, 'create'])->name('reschedules.create');
    Route::post('{case}/reschedules', [CaseRescheduleController::class, 'store'])->name('reschedules.store');
    Route::post('reschedules/{reschedule}/attendance', [CaseRescheduleController::class, 'updateAttendance'])->name('reschedules.updateAttendance');


    Route::get('/test-sms', [SmsController::class, 'testSend']);
    Route::get('/test-otp', [SmsController::class, 'testOtp']);
});

require __DIR__ . '/auth.php';
