<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CourtCaseController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\CourtSmsReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\HearingManagementController;
use App\Http\Controllers\Admin\MessageTemplateCategoryController;
use App\Http\Controllers\Admin\MessageTemplateController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TestSmsDebugController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('language/{locale}', [LanguageController::class, 'setLocale'])->name('locale.set');



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

    
    Route::match(['get', 'post'], '/hearings', [HearingManagementController::class, 'index'])
        ->name('hearings.index');

    // Attendance / Reschedule start - POST only
    Route::post('/hearings/{hearing}/attendance/start', [HearingManagementController::class, 'attendanceForm'])
        ->name('hearings.attendance.start');

    Route::post('/hearings/{hearing}/reschedule/start', [HearingManagementController::class, 'rescheduleForm'])
        ->name('hearings.reschedule.start');

    // Storing attendance / reschedule - POST
    Route::post('/hearings/{hearing}/attendance', [HearingManagementController::class, 'storeAttendance'])
        ->name('hearings.attendance.store');

    Route::post('/hearings/{hearing}/reschedule', [HearingManagementController::class, 'storeReschedule'])
        ->name('hearings.reschedule.store');

    // Printing filtered list
    Route::post('/hearings/print', [HearingManagementController::class, 'print'])
        ->name('hearings.print');



    Route::get('/test-sms', [SmsController::class, 'testSend']);
    Route::get('/test-otp', [SmsController::class, 'testOtp']);

    Route::get('/debug-sms', [TestSmsDebugController::class, 'send']);


    // dd(class_exists(\App\Http\Controllers\Admin\AnalyticsController::class));

    Route::get('analytics/overview', [AnalyticsController::class, 'overview'])
            ->name('analytics.overview');
    
            Route::get('analytics/sms-summary', [AnalyticsController::class, 'smsSummary'])
    ->name('analytics.sms.summary');

    
    Route::get('reports/court-sms-dashboard', [CourtSmsReportController::class, 'index'])->name('reports.court_sms_dashboard');
    Route::get('reports/court-sms-dashboard/data', [CourtSmsReportController::class, 'getMetrics'])->name('reports.court_sms_dashboard.data');
    
});

require __DIR__ . '/auth.php';
