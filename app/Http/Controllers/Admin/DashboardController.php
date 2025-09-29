<?php
// Full Controller: app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\District;
use App\Models\Court;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // REAL COUNTS
        $divisionsCount = Division::count();
        $districtsCount = District::count();
        $courtsCount = Court::count();
        $usersCount = User::count();

        // --- FAKE / DEMO DATA ---
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('M Y'));
        }

        $monthly = $months->map(function ($m) {
            return [
                'label' => $m,
                'sent' => rand(800, 3500),
                'delivered' => rand(600, 3200),
                'appeared' => rand(200, 1500),
            ];
        })->values();

        $outcomes = [
            'Appeared' => rand(12000, 25000),
            'No Response' => rand(4000, 12000),
            'Wrong Number' => rand(500, 3000),
            'Deferred' => rand(800, 4000),
        ];

        $topDistricts = collect();
        for ($i = 1; $i <= 12; $i++) {
            $topDistricts->push([
                'id' => $i,
                'name' => "District $i",
                'sent' => rand(1500, 8000),
                'appeared' => rand(400, 4200),
            ]);
        }

        $recentSms = collect();
        for ($i = 0; $i < 25; $i++) {
            $created = Carbon::now()->subDays(rand(0, 40))->subMinutes(rand(0, 1440));
            $recentSms->push((object)[
                'id' => 1000 + $i,
                'court' => 'Court ' . rand(1, 40),
                'district' => 'District ' . rand(1, 20),
                'to' => '+8801' . rand(111111111, 999999999),
                'status' => ['Sent', 'Delivered', 'Failed'][array_rand([0,1,2])],
                'appeared' => (rand(0, 10) > 6) ? 'Yes' : 'No',
                'sent_at' => $created->toDateTimeString(),
            ]);
        }

        $totalSent = collect($monthly->toArray())->sum('sent') + array_sum(array_values($outcomes));
        $totalAppeared = collect($monthly->toArray())->sum('appeared') + $outcomes['Appeared'];
        $avgResponseRate = $totalSent ? round(($totalAppeared / $totalSent) * 100, 2) : 0;

        return view('admin.index', [
            'divisionsCount' => $divisionsCount,
            'districtsCount' => $districtsCount,
            'courtsCount' => $courtsCount,
            'usersCount' => $usersCount,
            'monthly' => $monthly,
            'outcomes' => $outcomes,
            'topDistricts' => $topDistricts,
            'recentSms' => $recentSms,
            'totalSent' => $totalSent,
            'totalAppeared' => $totalAppeared,
            'avgResponseRate' => $avgResponseRate
        ]);
    }
}