<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourtSmsReportController extends Controller
{
    protected function resolveDashboardMode($user, array $filters): array
    {
        $roleNames = $user->getRoleNames()->map(fn ($role) => mb_strtolower($role))->values();

        $nationalRoles = collect(['super admin', 'admin', 'ministry focal']);
        $districtRoles = collect(['district focal', 'district support']);
        $courtRoles = collect(['court staff']);

        if ($roleNames->intersect($courtRoles)->isNotEmpty() || $user->court_id || $filters['court_id']) {
            return [
                'mode' => 'court',
                'label' => app()->getLocale() === 'bn' ? 'কোর্টভিত্তিক চিত্র' : 'Court View',
            ];
        }

        if ($roleNames->intersect($districtRoles)->isNotEmpty() || $user->district_id || $filters['district_id']) {
            return [
                'mode' => 'district',
                'label' => app()->getLocale() === 'bn' ? 'জেলাভিত্তিক চিত্র' : 'District View',
            ];
        }

        if ($roleNames->intersect($nationalRoles)->isNotEmpty() || $user->division_id || $filters['division_id']) {
            return [
                'mode' => 'national',
                'label' => app()->getLocale() === 'bn' ? 'সার্বিক চিত্র' : 'Overall View',
            ];
        }

        return [
            'mode' => 'national',
            'label' => app()->getLocale() === 'bn' ? 'সার্বিক চিত্র' : 'Overall View',
        ];
    }

    protected function localizedName($model): string
    {
        if (!$model) {
            return '-';
        }

        $locale = app()->getLocale();
        $localizedField = $locale === 'bn' ? 'name_bn' : 'name_en';

        return $model->{$localizedField}
            ?? $model->name_en
            ?? $model->name_bn
            ?? '-';
    }

    protected function localizedColumn(string $alias): string
    {
        $locale = app()->getLocale();

        return $locale === 'bn' ? "{$alias}.name_bn" : "{$alias}.name_en";
    }

    protected function hearingBaseQuery(array $filters)
    {
        return DB::table('case_hearings as h')
            ->join('cases as c', 'c.id', '=', 'h.case_id')
            ->join('courts as ct', 'ct.id', '=', 'c.court_id')
            ->join('districts as dt', 'dt.id', '=', 'ct.district_id')
            ->join('divisions as dv', 'dv.id', '=', 'dt.division_id')
            ->when($filters['division_id'], fn ($query, $value) => $query->where('dv.id', $value))
            ->when($filters['district_id'], fn ($query, $value) => $query->where('dt.id', $value))
            ->when($filters['court_id'], fn ($query, $value) => $query->where('ct.id', $value))
            ->when($filters['from_date'], fn ($query, $value) => $query->whereDate('h.hearing_date', '>=', $value))
            ->when($filters['to_date'], fn ($query, $value) => $query->whereDate('h.hearing_date', '<=', $value));
    }

    protected function numericRow($row): array
    {
        return collect((array) $row)->map(function ($value, $key) {
            return in_array($key, [
                'total_cases',
                'total_hearings',
                'original_hearings',
                'total_sms_sent',
                'sent',
                'pending',
                'failed',
                'witness_appeared',
                'witness_not_appeared',
                'total_witnesses',
                'absent',
                'excused',
                'pending_attendance',
                'sms_seen_yes',
                'witness_heard_yes',
                'female_witnesses',
                'male_witnesses',
                'third_gender_witnesses',
                'under_18_witnesses',
                'pwd_witnesses',
                'both_support_needs',
                'rescheduled_cases',
            ], true) ? (int) $value : $value;
        })->all();
    }

    protected function buildReportRows(string $type, array $filters): array
    {
        $localizedCourt = $this->localizedColumn('ct');
        $localizedDistrict = $this->localizedColumn('dt');
        $localizedDivision = $this->localizedColumn('dv');
        $notifications = $this->notificationAggregate();
        $witnesses = $this->witnessAggregate();

        $base = $this->hearingBaseQuery($filters)
            ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
            ->leftJoinSub($witnesses, 'wa', fn ($join) => $join->on('wa.hearing_id', '=', 'h.id'));

        if ($type === 'district-summary') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}")
                ->orderByDesc('total_sms_sent')
                ->limit(100)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'court-focus') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->orderByDesc('total_sms_sent')
                ->limit(150)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'trend-focus') {
            $trendMode = ($filters['from_date'] || $filters['to_date']) ? 'daily' : 'monthly';
            $trendDateSelect = $trendMode === 'monthly'
                ? "DATE_FORMAT(h.hearing_date, '%Y-%m')"
                : "DATE(h.hearing_date)";
            $trendDateLabel = $trendMode === 'monthly'
                ? "DATE_FORMAT(h.hearing_date, '%b %Y')"
                : "DATE(h.hearing_date)";

            return $base
                ->selectRaw("
                    {$trendDateLabel} as date,
                    {$trendDateSelect} as sort_date,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared
                ")
                ->groupByRaw("{$trendDateLabel}, {$trendDateSelect}")
                ->orderBy('sort_date')
                ->limit($trendMode === 'monthly' ? 24 : 90)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'attention-focus') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->havingRaw('COALESCE(SUM(na.pending), 0) > 0 OR COALESCE(SUM(na.failed), 0) > 0 OR COALESCE(SUM(wa.witness_not_appeared), 0) > 0')
                ->orderByDesc('pending')
                ->orderByDesc('failed')
                ->limit(150)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'witness-report') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->orderByDesc('total_witnesses')
                ->limit(150)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'reschedule-report') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->havingRaw('SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) > 0')
                ->orderByDesc('rescheduled_cases')
                ->limit(150)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'hearing-schedule-report') {
            return $base
                ->selectRaw("
                    DATE(h.hearing_date) as date,
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.id) as total_hearings,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases,
                    SUM(CASE WHEN h.is_reschedule = 0 THEN 1 ELSE 0 END) as original_hearings
                ")
                ->groupByRaw("DATE(h.hearing_date), {$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->orderByDesc('date')
                ->orderByDesc('total_hearings')
                ->limit(180)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'attendance-status-report') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.id) as total_hearings,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.absent), 0) as absent,
                    COALESCE(SUM(wa.excused), 0) as excused,
                    COALESCE(SUM(wa.pending_attendance), 0) as pending_attendance
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->havingRaw('COALESCE(SUM(wa.total_witnesses), 0) > 0')
                ->orderByDesc('pending_attendance')
                ->orderByDesc('absent')
                ->limit(180)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'witness-response-report') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.id) as total_hearings,
                    COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                    COALESCE(SUM(wa.sms_seen_yes), 0) as sms_seen_yes,
                    COALESCE(SUM(wa.witness_heard_yes), 0) as witness_heard_yes,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.absent), 0) as absent
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->havingRaw('COALESCE(SUM(wa.total_witnesses), 0) > 0')
                ->orderByDesc('sms_seen_yes')
                ->orderByDesc('witness_heard_yes')
                ->limit(180)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'vulnerable-witness-report') {
            return $base
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.id) as total_hearings,
                    COUNT(w.id) as total_witnesses,
                    SUM(CASE WHEN w.gender = 'Female' THEN 1 ELSE 0 END) as female_witnesses,
                    SUM(CASE WHEN w.gender = 'Male' THEN 1 ELSE 0 END) as male_witnesses,
                    SUM(CASE WHEN w.gender = 'Third Gender' THEN 1 ELSE 0 END) as third_gender_witnesses,
                    SUM(CASE WHEN w.others_info = 'Under 18' THEN 1 ELSE 0 END) as under_18_witnesses,
                    SUM(CASE WHEN w.others_info = 'Person with Disability' THEN 1 ELSE 0 END) as pwd_witnesses,
                    SUM(CASE WHEN w.others_info = 'Both' THEN 1 ELSE 0 END) as both_support_needs
                ")
                ->join('witnesses as w', 'w.hearing_id', '=', 'h.id')
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->havingRaw('COUNT(w.id) > 0')
                ->orderByDesc('under_18_witnesses')
                ->orderByDesc('pwd_witnesses')
                ->limit(180)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'witness-type-attendance-report') {
            return $base
                ->join('witnesses as w', 'w.hearing_id', '=', 'h.id')
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COALESCE(NULLIF(w.type_of_witness, ''), '') as witness_type,
                    COUNT(DISTINCT h.id) as total_hearings,
                    COUNT(w.id) as total_witnesses,
                    SUM(CASE WHEN w.appeared_status = 'appeared' THEN 1 ELSE 0 END) as witness_appeared,
                    SUM(CASE WHEN w.appeared_status = 'absent' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN w.appeared_status = 'excused' THEN 1 ELSE 0 END) as excused,
                    SUM(CASE WHEN w.appeared_status = 'pending' OR w.appeared_status IS NULL THEN 1 ELSE 0 END) as pending_attendance,
                    SUM(CASE WHEN w.sms_seen = 'yes' THEN 1 ELSE 0 END) as sms_seen_yes
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}, COALESCE(NULLIF(w.type_of_witness, ''), '')")
                ->havingRaw('COUNT(w.id) > 0')
                ->orderByDesc('pending_attendance')
                ->orderByDesc('absent')
                ->limit(220)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        if ($type === 'creation-month-report') {
            return DB::table('cases as c')
                ->join('courts as ct', 'ct.id', '=', 'c.court_id')
                ->join('districts as dt', 'dt.id', '=', 'ct.district_id')
                ->join('divisions as dv', 'dv.id', '=', 'dt.division_id')
                ->leftJoin('case_hearings as h', 'h.case_id', '=', 'c.id')
                ->leftJoin('notification_schedules as ns', 'ns.hearing_id', '=', 'h.id')
                ->leftJoin('notifications as n', 'n.schedule_id', '=', 'ns.id')
                ->when($filters['division_id'], fn ($query, $value) => $query->where('dv.id', $value))
                ->when($filters['district_id'], fn ($query, $value) => $query->where('dt.id', $value))
                ->when($filters['court_id'], fn ($query, $value) => $query->where('ct.id', $value))
                ->when($filters['from_date'], fn ($query, $value) => $query->whereDate('c.created_at', '>=', $value))
                ->when($filters['to_date'], fn ($query, $value) => $query->whereDate('c.created_at', '<=', $value))
                ->selectRaw("
                    DATE_FORMAT(c.created_at, '%Y-%m') as sort_month,
                    DATE_FORMAT(c.created_at, '%b %Y') as created_month,
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    COUNT(DISTINCT c.id) as total_cases,
                    COUNT(DISTINCT h.id) as total_hearings,
                    SUM(CASE WHEN n.status IN ('sent', 'delivered') THEN 1 ELSE 0 END) as sent,
                    SUM(CASE WHEN n.status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN n.status = 'failed' THEN 1 ELSE 0 END) as failed,
                    COUNT(n.id) as total_sms_sent
                ")
                ->groupByRaw("DATE_FORMAT(c.created_at, '%Y-%m'), DATE_FORMAT(c.created_at, '%b %Y'), {$localizedDivision}, {$localizedDistrict}")
                ->orderBy('sort_month')
                ->orderBy('district')
                ->limit(240)
                ->get()
                ->map(fn ($row) => $this->numericRow($row))
                ->all();
        }

        return [];
    }

    protected function reportMeta(): array
    {
        return [
                'district-summary' => [
                    'title' => 'জেলা সারসংক্ষেপ',
                    'description' => 'জেলাভিত্তিক মোট চাপ, পাঠানো এসএমএস ও সাক্ষী পরিস্থিতি দেখুন।',
                    'columns' => ['division', 'district', 'total_cases', 'total_sms_sent', 'sent', 'pending', 'failed', 'total_witnesses', 'witness_appeared'],
                ],
                'court-focus' => [
                    'title' => 'কোর্টভিত্তিক অবস্থা',
                    'description' => 'কোন কোর্টে কী অবস্থা, তুলনামূলকভাবে বোঝার জন্য।',
                    'columns' => ['division', 'district', 'court', 'total_cases', 'total_sms_sent', 'sent', 'pending', 'failed', 'total_witnesses', 'witness_appeared'],
                ],
                'trend-focus' => [
                    'title' => 'তারিখভিত্তিক প্রবণতা',
                    'description' => 'তারিখ ধরে এসএমএসের গতি ও কার্যকারিতা বোঝার জন্য।',
                    'columns' => ['date', 'total_sms_sent', 'sent', 'pending', 'failed', 'total_witnesses', 'witness_appeared'],
                ],
                'attention-focus' => [
                    'title' => 'ফলোআপ প্রয়োজন',
                    'description' => 'যেখানে নির্ধারিত, ব্যর্থ বা অনুপস্থিতির সংখ্যা বেশি, সেগুলো আগে ধরুন।',
                    'columns' => ['division', 'district', 'court', 'total_cases', 'pending', 'failed', 'witness_not_appeared', 'rescheduled_cases'],
                ],
                'witness-report' => [
                    'title' => 'সাক্ষী উপস্থিতি রিপোর্ট',
                    'description' => 'কোথায় সাক্ষীর উপস্থিতি কম, তা দ্রুত বোঝার জন্য।',
                    'columns' => ['division', 'district', 'court', 'total_witnesses', 'witness_appeared', 'witness_not_appeared'],
                ],
                'reschedule-report' => [
                    'title' => 'পুনঃনির্ধারিত শুনানি রিপোর্ট',
                    'description' => 'যে কোর্টে পুনঃনির্ধারণ বেশি হচ্ছে, তা দেখুন।',
                    'columns' => ['division', 'district', 'court', 'total_cases', 'rescheduled_cases', 'total_sms_sent'],
                ],
                'hearing-schedule-report' => [
                    'title' => 'Hearing Schedule Report',
                    'description' => 'Review hearing volume by date and court, including rescheduled load.',
                    'columns' => ['date', 'division', 'district', 'court', 'total_hearings', 'total_cases', 'total_witnesses', 'rescheduled_cases', 'original_hearings'],
                ],
                'attendance-status-report' => [
                    'title' => 'Attendance Status Report',
                    'description' => 'Compare appeared, absent, excused, and pending attendance across courts.',
                    'columns' => ['division', 'district', 'court', 'total_hearings', 'total_witnesses', 'witness_appeared', 'absent', 'excused', 'pending_attendance'],
                ],
                'witness-response-report' => [
                    'title' => 'Witness Response Report',
                    'description' => 'Track SMS seen, witness contact, and attendance response by court.',
                    'columns' => ['division', 'district', 'court', 'total_hearings', 'total_witnesses', 'sms_seen_yes', 'witness_heard_yes', 'witness_appeared', 'absent'],
                ],
                'vulnerable-witness-report' => [
                    'title' => 'Vulnerable Witness Report',
                    'description' => 'Identify courts with under-18, disability, and other support-sensitive witness groups.',
                    'columns' => ['division', 'district', 'court', 'total_hearings', 'total_witnesses', 'female_witnesses', 'male_witnesses', 'third_gender_witnesses', 'under_18_witnesses', 'pwd_witnesses', 'both_support_needs'],
                ],
                'witness-type-attendance-report' => [
                    'title' => 'Witness Type Attendance Report',
                    'description' => 'Compare attendance outcomes by witness type such as IO, MO, DNC, General, and Others.',
                    'columns' => ['division', 'district', 'court', 'witness_type', 'total_hearings', 'total_witnesses', 'witness_appeared', 'absent', 'excused', 'pending_attendance', 'sms_seen_yes'],
                ],
                'creation-month-report' => [
                    'title' => 'Creation Month District Report',
                    'description' => 'Track district-wise case creation by month, with already sent and still scheduled SMS counts.',
                    'columns' => ['created_month', 'division', 'district', 'total_cases', 'total_hearings', 'total_sms_sent', 'sent', 'pending', 'failed'],
                ],
            ];
    }

    protected function standaloneReportKeys(): array
    {
        return [
            'hearing-schedule-report',
            'attendance-status-report',
            'witness-response-report',
            'vulnerable-witness-report',
            'witness-type-attendance-report',
            'creation-month-report',
        ];
    }

    protected function reportHubGroups(array $reports, string $mode): array
    {
        $isBn = app()->getLocale() === 'bn';

        $groups = [
            [
                'title' => $isBn ? 'উপস্থিতি রিপোর্ট' : 'Attendance Reports',
                'description' => $isBn ? 'উপস্থিতি, অনুপস্থিতি ও অনুসরণ দরকার এমন কোর্ট দ্রুত ধরুন।' : 'Spot appearance gaps, pending attendance, and courts that need follow-up.',
                'reports' => [
                    ['key' => 'attendance-status-report', 'tone' => 'primary', 'icon' => 'bi-person-check', 'modes' => ['court', 'district', 'national']],
                    ['key' => 'witness-type-attendance-report', 'tone' => 'success', 'icon' => 'bi-diagram-3', 'modes' => ['court', 'district']],
                ],
            ],
            [
                'title' => $isBn ? 'সাক্ষী রিপোর্ট' : 'Witness Reports',
                'description' => $isBn ? 'সাক্ষীর সাড়া, সহায়তা-প্রয়োজন অবস্থা ও ঝুঁকির সংকেত দেখুন।' : 'Review response quality, support-needs signals, and witness risk patterns.',
                'reports' => [
                    ['key' => 'witness-response-report', 'tone' => 'info', 'icon' => 'bi-chat-left-text', 'modes' => ['court', 'district', 'national']],
                    ['key' => 'vulnerable-witness-report', 'tone' => 'warning', 'icon' => 'bi-universal-access', 'modes' => ['district', 'national']],
                ],
            ],
            [
                'title' => $isBn ? 'শুনানি ও সময়সূচি' : 'Scheduling Reports',
                'description' => $isBn ? 'শুনানির চাপ, তারিখভিত্তিক লোড ও পুনঃনির্ধারণ কোথায় বাড়ছে তা দেখুন।' : 'Track hearing load, scheduling pressure, and where reschedules are increasing.',
                'reports' => [
                    ['key' => 'hearing-schedule-report', 'tone' => 'secondary', 'icon' => 'bi-calendar-event', 'modes' => ['court', 'district', 'national']],
                ],
            ],
            [
                'title' => $isBn ? 'মাসভিত্তিক ব্যবস্থাপনা' : 'Monthly Reports',
                'description' => $isBn ? 'তৈরির মাস ধরে জেলা পর্যায়ে কাজের গতি ও এসএমএস অবস্থা দেখুন।' : 'Follow month-wise district activity based on record creation date.',
                'reports' => [
                    ['key' => 'creation-month-report', 'tone' => 'dark', 'icon' => 'bi-bar-chart-steps', 'modes' => ['district', 'national']],
                ],
            ],
        ];

        return collect($groups)
            ->map(function (array $group) use ($reports, $mode) {
                $group['reports'] = collect($group['reports'])
                    ->filter(function (array $report) use ($reports, $mode) {
                        return isset($reports[$report['key']]) && in_array($mode, $report['modes'], true);
                    })
                    ->values()
                    ->all();

                return $group;
            })
            ->filter(fn (array $group) => !empty($group['reports']))
            ->values()
            ->all();
    }

    protected function notificationAggregate()
    {
        return DB::table('notification_schedules as ns')
            ->leftJoin('notifications as n', 'n.schedule_id', '=', 'ns.id')
            ->selectRaw("
                ns.hearing_id,
                COUNT(n.id) as total_sms_sent,
                SUM(CASE WHEN n.status IN ('sent', 'delivered') THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN n.status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN n.status = 'failed' THEN 1 ELSE 0 END) as failed
            ")
            ->groupBy('ns.hearing_id');
    }

    protected function witnessAggregate()
    {
        return DB::table('witnesses as w')
            ->selectRaw("
                w.hearing_id,
                COUNT(w.id) as total_witnesses,
                SUM(CASE WHEN w.appeared_status = 'appeared' THEN 1 ELSE 0 END) as witness_appeared,
                SUM(CASE WHEN w.appeared_status <> 'appeared' THEN 1 ELSE 0 END) as witness_not_appeared,
                SUM(CASE WHEN w.appeared_status = 'absent' THEN 1 ELSE 0 END) as absent,
                SUM(CASE WHEN w.appeared_status = 'excused' THEN 1 ELSE 0 END) as excused,
                SUM(CASE WHEN w.appeared_status = 'pending' OR w.appeared_status IS NULL THEN 1 ELSE 0 END) as pending_attendance,
                SUM(CASE WHEN w.sms_seen = 'yes' THEN 1 ELSE 0 END) as sms_seen_yes,
                SUM(CASE WHEN w.witness_heard = 'yes' THEN 1 ELSE 0 END) as witness_heard_yes
            ")
            ->groupBy('w.hearing_id');
    }

    protected function getScopedDivisions($user)
    {
        if ($user->court_id) {
            return Division::with([
                'districts' => fn ($q) => $q->where('id', $user->district_id),
                'districts.courts' => fn ($q) => $q->where('id', $user->court_id),
            ])->where('id', $user->division_id)->get();
        }

        if ($user->district_id) {
            return Division::with([
                'districts' => fn ($q) => $q->where('id', $user->district_id),
                'districts.courts',
            ])->where('id', $user->division_id)->get();
        }

        if ($user->division_id) {
            return Division::with('districts.courts')->where('id', $user->division_id)->get();
        }

        return Division::with('districts.courts')->get();
    }

    protected function getScopedFilters(Request $request, $user): array
    {
        $divisionId = $user->division_id ?: $request->query('division_id');
        $districtId = $user->district_id ?: $request->query('district_id');
        $courtId = $user->court_id ?: $request->query('court_id');

        return [
            'division_id' => $divisionId ?: null,
            'district_id' => $districtId ?: null,
            'court_id' => $courtId ?: null,
            'from_date' => $request->query('from_date') ?: null,
            'to_date' => $request->query('to_date') ?: null,
        ];
    }

    /**
     * Load the dashboard page
     */
    public function index()
    {
        $user = Auth::user();
        $divisions = $this->getScopedDivisions($user);
        $filters = $this->getScopedFilters(request(), $user);

        return view('admin.reports.court_sms_dashboard', compact('divisions', 'user', 'filters'));
    }

    public function detailedReports(Request $request)
    {
        $user = Auth::user();
        $divisions = $this->getScopedDivisions($user);
        $filters = $this->getScopedFilters($request, $user);
        $dashboardMode = $this->resolveDashboardMode($user, $filters);
        $reports = collect($this->reportMeta())
            ->only($this->standaloneReportKeys())
            ->all();
        $groups = $this->reportHubGroups($reports, $dashboardMode['mode']);

        return view('admin.reports.court_sms_report_hub', compact('divisions', 'user', 'filters', 'reports', 'groups', 'dashboardMode'));
    }

    /**
     * Return JSON metrics for charts and table
     */
    public function getMetrics(Request $request)
    {
        $user = Auth::user();
        $filters = $this->getScopedFilters($request, $user);
        $dashboardMode = $this->resolveDashboardMode($user, $filters);
        $localizedCourt = $this->localizedColumn('ct');
        $localizedDistrict = $this->localizedColumn('dt');
        $localizedDivision = $this->localizedColumn('dv');
        $notifications = $this->notificationAggregate();
        $witnesses = $this->witnessAggregate();

        $totalRow = $this->hearingBaseQuery($filters)
            ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
            ->leftJoinSub($witnesses, 'wa', fn ($join) => $join->on('wa.hearing_id', '=', 'h.id'))
            ->selectRaw("
                COUNT(DISTINCT h.case_id) as total_cases,
                COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                COALESCE(SUM(na.sent), 0) as sent,
                COALESCE(SUM(na.pending), 0) as pending,
                COALESCE(SUM(na.failed), 0) as failed,
                COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                COALESCE(SUM(wa.total_witnesses), 0) as total_witnesses,
                SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
            ")
            ->first();

        $districtRows = [];
        if ($dashboardMode['mode'] === 'national') {
            $districtRows = $this->hearingBaseQuery($filters)
                ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
                ->leftJoinSub($witnesses, 'wa', fn ($join) => $join->on('wa.hearing_id', '=', 'h.id'))
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}")
                ->orderByDesc('total_sms_sent')
                ->limit(12)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();
        }

        $courtRows = [];
        if ($dashboardMode['mode'] === 'district') {
            $courtRows = $this->hearingBaseQuery($filters)
                ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
                ->leftJoinSub($witnesses, 'wa', fn ($join) => $join->on('wa.hearing_id', '=', 'h.id'))
                ->selectRaw("
                    {$localizedDivision} as division,
                    {$localizedDistrict} as district,
                    {$localizedCourt} as court,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedDivision}, {$localizedDistrict}, {$localizedCourt}")
                ->orderByDesc('total_sms_sent')
                ->limit(10)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();
        }

        $courtSnapshot = null;
        if ($dashboardMode['mode'] === 'court') {
            $courtSnapshot = $this->hearingBaseQuery($filters)
                ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
                ->leftJoinSub($witnesses, 'wa', fn ($join) => $join->on('wa.hearing_id', '=', 'h.id'))
                ->selectRaw("
                    {$localizedCourt} as court,
                    {$localizedDistrict} as district,
                    COUNT(DISTINCT h.case_id) as total_cases,
                    COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                    COALESCE(SUM(na.sent), 0) as sent,
                    COALESCE(SUM(na.pending), 0) as pending,
                    COALESCE(SUM(na.failed), 0) as failed,
                    COALESCE(SUM(wa.witness_appeared), 0) as witness_appeared,
                    COALESCE(SUM(wa.witness_not_appeared), 0) as witness_not_appeared,
                    SUM(CASE WHEN h.is_reschedule = 1 THEN 1 ELSE 0 END) as rescheduled_cases
                ")
                ->groupByRaw("{$localizedCourt}, {$localizedDistrict}")
                ->first();
        }

        $trendMode = ($filters['from_date'] || $filters['to_date']) ? 'daily' : 'monthly';
        $trendDateSelect = $trendMode === 'monthly'
            ? "DATE_FORMAT(h.hearing_date, '%Y-%m')"
            : "DATE(h.hearing_date)";
        $trendDateLabel = $trendMode === 'monthly'
            ? "DATE_FORMAT(h.hearing_date, '%b %Y')"
            : "DATE(h.hearing_date)";

        $trendRows = $this->hearingBaseQuery($filters)
            ->leftJoinSub($notifications, 'na', fn ($join) => $join->on('na.hearing_id', '=', 'h.id'))
            ->selectRaw("
                {$trendDateLabel} as date,
                {$trendDateSelect} as sort_date,
                COALESCE(SUM(na.total_sms_sent), 0) as total_sms_sent,
                COALESCE(SUM(na.sent), 0) as sent,
                COALESCE(SUM(na.pending), 0) as pending,
                COALESCE(SUM(na.failed), 0) as failed
            ")
            ->groupByRaw("{$trendDateLabel}, {$trendDateSelect}")
            ->orderBy('sort_date')
            ->limit($trendMode === 'monthly' ? 12 : 31)
            ->get()
            ->map(fn ($row) => [
                'date' => $row->date,
                'total_sms_sent' => (int) $row->total_sms_sent,
                'sent' => (int) $row->sent,
                'pending' => (int) $row->pending,
                'failed' => (int) $row->failed,
            ])
            ->all();

        $totals = [
            'total_cases' => (int) ($totalRow->total_cases ?? 0),
            'total_sms_sent' => (int) ($totalRow->total_sms_sent ?? 0),
            'sent' => (int) ($totalRow->sent ?? 0),
            'pending' => (int) ($totalRow->pending ?? 0),
            'failed' => (int) ($totalRow->failed ?? 0),
            'witness_appeared' => (int) ($totalRow->witness_appeared ?? 0),
            'witness_not_appeared' => (int) ($totalRow->witness_not_appeared ?? 0),
            'total_witnesses' => (int) ($totalRow->total_witnesses ?? 0),
            'rescheduled_cases' => (int) ($totalRow->rescheduled_cases ?? 0),
            'scheduled' => (int) ($totalRow->pending ?? 0),
        ];

        $topCourt = $courtRows[0] ?? $courtSnapshot;
        $topDistrict = $districtRows[0] ?? null;
        $appearanceRate = $totals['total_witnesses'] > 0
            ? round(($totals['witness_appeared'] / $totals['total_witnesses']) * 100, 1)
            : 0;
        $deliveryRate = $totals['total_sms_sent'] > 0
            ? round(($totals['sent'] / $totals['total_sms_sent']) * 100, 1)
            : 0;

        $chartVisibility = [
            'show_status' => true,
            'show_trend' => true,
            'show_witness' => true,
            'show_courts' => $dashboardMode['mode'] === 'district',
            'show_districts' => $dashboardMode['mode'] === 'national',
            'show_reschedules' => $dashboardMode['mode'] === 'district',
        ];

        return response()->json([
            'rows' => $courtRows,
            'district_rows' => $districtRows,
            'totals' => $totals,
            'trend' => $trendRows,
            'trend_mode' => $trendMode,
            'filters' => $filters,
            'dashboard_mode' => $dashboardMode['mode'],
            'dashboard_label' => $dashboardMode['label'],
            'chart_visibility' => $chartVisibility,
            'insights' => [
                'top_court' => $topCourt,
                'top_district' => $topDistrict,
                'appearance_rate' => $appearanceRate,
                'delivery_rate' => $deliveryRate,
                'court_snapshot' => $courtSnapshot,
            ],
        ]);
    }

    public function showReport(Request $request, string $type)
    {
        $reports = $this->reportMeta();

        abort_unless(isset($reports[$type]), 404);

        $user = Auth::user();
        $filters = $this->getScopedFilters($request, $user);
        $report = $reports[$type];
        $rows = $this->buildReportRows($type, $filters);
        $divisions = $this->getScopedDivisions($user);

        return view('admin.reports.court_sms_report_detail', [
            'reportKey' => $type,
            'report' => $report,
            'rows' => $rows,
            'filters' => $filters,
            'user' => $user,
            'divisions' => $divisions,
        ]);
    }
}
