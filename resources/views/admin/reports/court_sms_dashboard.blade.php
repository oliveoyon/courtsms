@extends('dashboard.layouts.admin')
@section('title', __('dashboard.court_sms_dashboard'))

@php
    $uiText = app()->getLocale() === 'bn'
        ? [
            'hero_copy' => 'নির্ধারিত এসএমএস, পাঠানো এসএমএস, সাক্ষীর উপস্থিতি এবং পুনঃনির্ধারিত শুনানির তথ্য দেখুন।',
            'filter_title' => 'ফ্লেক্সিবল ফিল্টার',
            'filter_copy' => 'আপনার লগইন-ভিত্তিক সীমাবদ্ধতা স্বয়ংক্রিয়ভাবে বজায় থাকবে।',
            'reset' => 'রিসেট',
            'quick_range' => 'দ্রুত সময়সীমা',
            'custom' => 'কাস্টম',
            'today' => 'আজ',
            'last_7_days' => 'শেষ ৭ দিন',
            'last_30_days' => 'শেষ ৩০ দিন',
            'this_month' => 'এই মাস',
            'scheduled' => 'নির্ধারিত',
            'waiting_to_send' => 'পাঠানোর অপেক্ষায়',
            'all_sms_notifications' => 'সব এসএমএস নোটিফিকেশন',
            'sent_and_delivered' => 'পাঠানো ও ডেলিভারড একসাথে',
            'failed_notifications' => 'ব্যর্থ নোটিফিকেশন',
            'witnesses_appeared' => 'উপস্থিত সাক্ষীর সংখ্যা',
            'not_appeared' => 'অনুপস্থিত',
            'not_appeared_note' => 'অনুপস্থিত, মুলতবি, মাফ',
            'rescheduled_note' => 'পুনঃনির্ধারিত শুনানি',
            'distinct_cases' => 'স্বতন্ত্র মামলা',
            'top_court' => 'এসএমএস অনুযায়ী শীর্ষ কোর্ট',
            'top_district' => 'এসএমএস অনুযায়ী শীর্ষ জেলা',
            'delivery_rate' => 'ডেলিভারি রেট',
            'appearance_rate' => 'উপস্থিতির হার',
            'sent_vs_total' => 'মোট এসএমএসের মধ্যে পাঠানো',
            'appeared_vs_witnesses' => 'মোট সাক্ষীর মধ্যে উপস্থিত',
            'sms_status_mix' => 'এসএমএস স্ট্যাটাস বিভাজন',
            'sms_status_mix_copy' => 'পাঠানো, নির্ধারিত, ব্যর্থ এসএমএসের অংশ।',
            'daily_sms_trend' => 'এসএমএস ট্রেন্ড',
            'daily_sms_trend_copy' => 'বেশি দিনের ডেটা হলে মাসভিত্তিক সারসংক্ষেপ দেখানো হবে।',
            'court_comparison' => 'কোর্টভিত্তিক তুলনা',
            'court_comparison_copy' => 'সবচেয়ে বেশি কার্যকর শীর্ষ কোর্টগুলোই শুধু দেখানো হবে।',
            'witness_attendance' => 'সাক্ষীর উপস্থিতি',
            'witness_attendance_copy' => 'এটি এসএমএস সংখ্যা নয়, সাক্ষীর অবস্থা ভিত্তিক।',
            'district_ranking' => 'জেলাভিত্তিক এসএমএস র‍্যাংকিং',
            'district_ranking_copy' => 'শীর্ষ জেলাগুলো দেখানো হবে যাতে গ্রাফ ভারী না হয়।',
            'rescheduled_by_court' => 'কোর্টভিত্তিক পুনঃনির্ধারণ',
            'rescheduled_by_court_copy' => 'সবচেয়ে বেশি পুনঃনির্ধারিত কোর্টগুলো।',
            'summary_title' => 'কোর্ট এসএমএস সারসংক্ষেপ',
            'summary_copy' => 'সক্রিয় ফিল্টারের ভেতরে র‍্যাংক করা সারাংশ।',
            'courts_count' => 'কোর্ট',
            'no_data' => 'কোনো ডেটা পাওয়া যায়নি',
            'load_failed' => 'ড্যাশবোর্ড ডেটা লোড করা যায়নি।',
            'top_items_note' => 'শুধু শীর্ষ %s টি দেখানো হচ্ছে',
            'trend_monthly' => 'মাসভিত্তিক',
            'trend_daily' => 'দৈনিক',
            'sms_short' => 'এসএমএস',
            'no_data_short' => 'কোনো ডেটা নেই',
            'apply_loading' => 'লোড হচ্ছে...',
            'dashboard_intro' => 'এক নজরে অবস্থা দেখুন, তারপর প্রয়োজনমতো বিস্তারিত রিপোর্ট খুলুন। সবকিছু একসাথে না দেখিয়ে ধাপে ধাপে কাজের তথ্য দেখানো হবে।',
            'decision_title' => 'আজকের নজরদারি',
            'decision_copy' => 'যে তথ্য দেখে দ্রুত সিদ্ধান্ত নেওয়া যায়, সেগুলো এখানে আগে রাখা হয়েছে।',
            'reports_title' => 'অ্যাকশনভিত্তিক রিপোর্ট',
            'reports_copy' => 'যে রিপোর্ট দরকার, শুধু সেটাই খুলুন। এতে পেজ হালকা থাকবে, কাজও দ্রুত হবে।',
            'open_report' => 'রিপোর্ট খুলুন',
            'quick_actions' => 'দ্রুত কাজ',
            'district_summary_report' => 'জেলা সারসংক্ষেপ',
            'district_summary_copy' => 'কোন জেলায় কত কাজ হচ্ছে, কোথায় চাপ বেশি, সেটি দেখুন।',
            'court_focus_report' => 'কোর্টভিত্তিক অবস্থা',
            'court_focus_copy' => 'কোন কোর্টে নির্ধারিত, পাঠানো, ব্যর্থ বা উপস্থিতির অবস্থা কেমন, তা দেখুন।',
            'trend_report' => 'তারিখভিত্তিক প্রবণতা',
            'trend_report_copy' => 'দিন বা মাস ধরে এসএমএসের গতি বোঝার জন্য এই রিপোর্ট খুলুন।',
            'attention_report' => 'ফলোআপ প্রয়োজন',
            'attention_report_copy' => 'যেখানে নির্ধারিত বা ব্যর্থ এসএমএস বেশি, সেই জায়গাগুলো আগে ধরুন।',
            'view_details' => 'বিস্তারিত দেখুন',
            'recommendation_1' => 'নির্ধারিত এসএমএস বেশি থাকলে সেই আদালত বা জেলায় দ্রুত অনুসরণ করুন।',
            'recommendation_2' => 'ব্যর্থ এসএমএস বেশি হলে নম্বর, টেমপ্লেট বা গেটওয়ে সমস্যা আছে কি না দেখুন।',
            'recommendation_3' => 'সাক্ষীর উপস্থিতির হার কম হলে স্থানীয় সমন্বয় জোরদার করা দরকার।',
            'high_priority' => 'অগ্রাধিকার',
            'report_ready' => 'রিপোর্ট প্রস্তুত',
            'action_report' => 'অ্যাকশন রিপোর্ট',
            'close' => 'বন্ধ করুন',
            'no_report_data' => 'এই রিপোর্টের জন্য এখন দেখানোর মতো তথ্য নেই।',
            'table_division' => 'বিভাগ',
            'table_district' => 'জেলা',
            'table_court' => 'কোর্ট',
            'table_total_cases' => 'মোট মামলা',
            'table_total_sms' => 'মোট এসএমএস',
            'table_sent' => 'পাঠানো',
            'table_scheduled' => 'নির্ধারিত',
            'table_failed' => 'ব্যর্থ',
            'table_total_witnesses' => 'মোট সাক্ষী',
            'table_appeared' => 'উপস্থিত',
            'table_not_appeared' => 'অনুপস্থিত',
            'table_rescheduled' => 'পুনঃনির্ধারিত',
        ]
        : [
            'hero_copy' => 'View scheduled SMS, sent SMS, witness appearance, and rescheduled hearing activity inside the user scope.',
            'filter_title' => 'Flexible Filters',
            'filter_copy' => 'Your login-based restriction remains enforced automatically.',
            'reset' => 'Reset',
            'quick_range' => 'Quick Range',
            'custom' => 'Custom',
            'today' => 'Today',
            'last_7_days' => 'Last 7 Days',
            'last_30_days' => 'Last 30 Days',
            'this_month' => 'This Month',
            'scheduled' => 'Scheduled',
            'waiting_to_send' => 'Waiting to send',
            'all_sms_notifications' => 'All SMS notifications',
            'sent_and_delivered' => 'Sent and delivered combined',
            'failed_notifications' => 'Failed notifications',
            'witnesses_appeared' => 'Witnesses marked as appeared',
            'not_appeared' => 'Not Appeared',
            'not_appeared_note' => 'Absent, pending, and excused',
            'rescheduled_note' => 'Rescheduled hearings',
            'distinct_cases' => 'Distinct cases',
            'top_court' => 'Top Court By SMS',
            'top_district' => 'Top District By SMS',
            'delivery_rate' => 'Delivery Rate',
            'appearance_rate' => 'Appearance Rate',
            'sent_vs_total' => 'Sent vs total SMS',
            'appeared_vs_witnesses' => 'Appeared vs witnesses',
            'sms_status_mix' => 'SMS Status Mix',
            'sms_status_mix_copy' => 'Share of sent, scheduled, and failed SMS.',
            'daily_sms_trend' => 'SMS Trend',
            'daily_sms_trend_copy' => 'Shows daily trend, then switches to monthly summary for long ranges.',
            'court_comparison' => 'Court Comparison',
            'court_comparison_copy' => 'Only the most relevant top courts are shown to avoid clutter.',
            'witness_attendance' => 'Witness Attendance',
            'witness_attendance_copy' => 'Based on witness status, not SMS counts.',
            'district_ranking' => 'District SMS Ranking',
            'district_ranking_copy' => 'Shows only the leading districts so the chart stays readable.',
            'rescheduled_by_court' => 'Rescheduled By Court',
            'rescheduled_by_court_copy' => 'Courts with the highest rescheduled hearing counts.',
            'summary_title' => 'Court SMS Summary',
            'summary_copy' => 'Ranked summary inside the active filter scope.',
            'courts_count' => 'courts',
            'no_data' => 'No data found',
            'load_failed' => 'Unable to load dashboard data.',
            'top_items_note' => 'Showing top %s only',
            'trend_monthly' => 'Monthly',
            'trend_daily' => 'Daily',
            'sms_short' => 'SMS',
            'no_data_short' => 'No data',
            'apply_loading' => 'Loading...',
            'dashboard_intro' => 'See the overall picture first, then open only the report you need.',
            'decision_title' => 'Decision Snapshot',
            'decision_copy' => 'The most actionable signals are shown here first.',
            'reports_title' => 'Action-Based Reports',
            'reports_copy' => 'Open only the report you need so the page stays light and responsive.',
            'open_report' => 'Open Report',
            'quick_actions' => 'Quick Actions',
            'district_summary_report' => 'District Summary',
            'district_summary_copy' => 'See which districts are carrying the highest load.',
            'court_focus_report' => 'Court Performance',
            'court_focus_copy' => 'Compare scheduled, sent, failed, and witness outcomes by court.',
            'trend_report' => 'Trend Report',
            'trend_report_copy' => 'Follow SMS activity across dates and watch direction over time.',
            'attention_report' => 'Needs Follow-up',
            'attention_report_copy' => 'Surface the areas with high scheduled or failed SMS counts.',
            'view_details' => 'View Details',
            'recommendation_1' => 'If scheduled SMS stays high, that area needs quick follow-up.',
            'recommendation_2' => 'If failed SMS rises, check numbers, templates, or gateway issues.',
            'recommendation_3' => 'If witness appearance stays low, field coordination may need attention.',
            'high_priority' => 'Priority',
            'report_ready' => 'Report Ready',
            'action_report' => 'Action Report',
            'close' => 'Close',
            'no_report_data' => 'No data is available for this report right now.',
            'table_division' => 'Division',
            'table_district' => 'District',
            'table_court' => 'Court',
            'table_total_cases' => 'Total Cases',
            'table_total_sms' => 'Total SMS',
            'table_sent' => 'Sent',
            'table_scheduled' => 'Scheduled',
            'table_failed' => 'Failed',
            'table_total_witnesses' => 'Total Witnesses',
            'table_appeared' => 'Appeared',
            'table_not_appeared' => 'Not Appeared',
            'table_rescheduled' => 'Rescheduled',
        ];
    $locationTree = $divisions->map(fn ($division) => [
        'id' => $division->id,
        'name_en' => $division->name_en,
        'name_bn' => $division->name_bn,
        'districts' => $division->districts->map(fn ($district) => [
            'id' => $district->id,
            'name_en' => $district->name_en,
            'name_bn' => $district->name_bn,
            'courts' => $district->courts->map(fn ($court) => [
                'id' => $court->id,
                'name_en' => $court->name_en,
                'name_bn' => $court->name_bn,
            ])->values(),
        ])->values(),
    ])->values();
@endphp

@section('content')
<div class="container-fluid py-4 report-dashboard">
    <div class="dash-hero">
        <div>
            <span class="dash-kicker">{{ __('dashboard.court_sms_dashboard') }}</span>
            <h1>{{ __('dashboard.court_sms_dashboard') }}</h1>
            <p>{{ $uiText['hero_copy'] }}</p>
        </div>
        <div class="dash-badges" id="activeFilterBadges"></div>
    </div>

    <div class="filter-card">
        <div class="filter-head">
            <div>
                <h3>{{ $uiText['filter_title'] }}</h3>
            </div>
            <div class="filter-buttons">
                <button type="button" class="btn btn-outline-secondary" id="btnResetFilters">{{ $uiText['reset'] }}</button>
                <button type="button" class="btn btn-primary" id="btnFilter">{{ __('dashboard.apply_filter') }}</button>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ __('dashboard.division') }}</label>
                <select id="filterDivision" class="form-select" {{ $user->division_id ? 'disabled' : '' }}></select>
            </div>
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ __('dashboard.district') }}</label>
                <select id="filterDistrict" class="form-select" {{ $user->district_id ? 'disabled' : '' }}></select>
            </div>
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ __('dashboard.court') }}</label>
                <select id="filterCourt" class="form-select" {{ $user->court_id ? 'disabled' : '' }}></select>
            </div>
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ __('dashboard.from_date') }}</label>
                <input type="date" id="fromDate" class="form-control" value="{{ $filters['from_date'] ?? '' }}">
            </div>
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ __('dashboard.to_date') }}</label>
                <input type="date" id="toDate" class="form-control" value="{{ $filters['to_date'] ?? '' }}">
            </div>
            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label">{{ $uiText['quick_range'] }}</label>
                <select id="quickRange" class="form-select">
                    <option value="">{{ $uiText['custom'] }}</option>
                    <option value="today">{{ $uiText['today'] }}</option>
                    <option value="last7">{{ $uiText['last_7_days'] }}</option>
                    <option value="last30">{{ $uiText['last_30_days'] }}</option>
                    <option value="thisMonth">{{ $uiText['this_month'] }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="metric-grid">
        <div class="metric tone-plum"><span>{{ __('dashboard.total_cases') }}</span><strong id="totalCases">0</strong><small>{{ $uiText['distinct_cases'] }}</small></div>
        <div class="metric tone-cyan"><span>{{ $uiText['table_total_witnesses'] }}</span><strong id="totalWitnesses">0</strong><small>{{ $uiText['witnesses_appeared'] }}</small></div>
        <div class="metric tone-blue"><span>{{ __('dashboard.total_sms') }}</span><strong id="totalSms">0</strong><small>{{ $uiText['all_sms_notifications'] }}</small></div>
        <div class="metric tone-green"><span>{{ __('dashboard.sent') }}</span><strong id="sentSms">0</strong><small>{{ $uiText['sent_and_delivered'] }}</small></div>
        <div class="metric tone-amber"><span>{{ $uiText['scheduled'] }}</span><strong id="scheduledSms">0</strong><small>{{ $uiText['waiting_to_send'] }}</small></div>
        <div class="metric tone-red"><span>{{ __('dashboard.failed') }}</span><strong id="failedSms">0</strong><small>{{ $uiText['failed_notifications'] }}</small></div>
        <div class="metric tone-cyan"><span>{{ __('dashboard.witness_appeared') }}</span><strong id="appeared">0</strong><small>{{ $uiText['witnesses_appeared'] }}</small></div>
        <div class="metric tone-slate"><span>{{ $uiText['not_appeared'] }}</span><strong id="notAppeared">0</strong><small>{{ $uiText['not_appeared_note'] }}</small></div>
        <div class="metric tone-indigo"><span>{{ __('dashboard.cases_rescheduled') }}</span><strong id="rescheduled">0</strong><small>{{ $uiText['rescheduled_note'] }}</small></div>
    </div>

    <div class="insight-grid">
        <div class="insight-card"><span>{{ $uiText['top_court'] }}</span><strong id="topCourtName">-</strong><small id="topCourtMeta">{{ $uiText['no_data_short'] }}</small></div>
        <div class="insight-card"><span>{{ $uiText['top_district'] }}</span><strong id="topDistrictName">-</strong><small id="topDistrictMeta">{{ $uiText['no_data_short'] }}</small></div>
        <div class="insight-card"><span>{{ $uiText['delivery_rate'] }}</span><strong id="deliveryRate">0%</strong><small>{{ $uiText['sent_vs_total'] }}</small></div>
        <div class="insight-card"><span>{{ $uiText['appearance_rate'] }}</span><strong id="appearanceRate">0%</strong><small>{{ $uiText['appeared_vs_witnesses'] }}</small></div>
    </div>

    <div class="action-card">
        <div class="section-head">
            <div>
                <h3>{{ $uiText['reports_title'] }}</h3>
            </div>
            <span class="section-chip">{{ $uiText['action_report'] }}</span>
        </div>
        <div class="action-grid">
            <button type="button" class="report-tile tone-blue-soft" data-report-link="district-summary">
                <strong>{{ $uiText['district_summary_report'] }}</strong>
                <p>{{ $uiText['district_summary_copy'] }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-green-soft" data-report-link="court-focus">
                <strong>{{ $uiText['court_focus_report'] }}</strong>
                <p>{{ $uiText['court_focus_copy'] }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-amber-soft" data-report-link="trend-focus">
                <strong>{{ $uiText['trend_report'] }}</strong>
                <p>{{ $uiText['trend_report_copy'] }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-red-soft" data-report-link="attention-focus">
                <strong>{{ $uiText['attention_report'] }}</strong>
                <p>{{ $uiText['attention_report_copy'] }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-blue-soft" data-report-link="witness-report">
                <strong>{{ app()->getLocale() === 'bn' ? 'সাক্ষী উপস্থিতি রিপোর্ট' : 'Witness Report' }}</strong>
                <p>{{ app()->getLocale() === 'bn' ? 'কোথায় মোট সাক্ষী বেশি, কোথায় উপস্থিতি কম, তা দেখুন।' : 'See where witness volume is high and attendance is low.' }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-green-soft" data-report-link="reschedule-report">
                <strong>{{ app()->getLocale() === 'bn' ? 'পুনঃনির্ধারণ রিপোর্ট' : 'Reschedule Report' }}</strong>
                <p>{{ app()->getLocale() === 'bn' ? 'যে কোর্টে পুনঃনির্ধারণ বেশি, তা আলাদা করে দেখুন।' : 'Focus on courts with repeated rescheduling.' }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-amber-soft" data-report-link="hearing-schedule-report">
                <strong>{{ app()->getLocale() === 'bn' ? 'à¦¶à§à¦¨à¦¾à¦¨à¦¿ à¦¸à¦®à§Ÿà¦¸à§‚à¦šà¦¿ à¦°à¦¿à¦ªà§‹à¦°à§à¦Ÿ' : 'Hearing Schedule Report' }}</strong>
                <p>{{ app()->getLocale() === 'bn' ? 'à¦¤à¦¾à¦°à¦¿à¦– à¦“ à¦•à§‹à¦°à§à¦Ÿà¦­à¦¿à¦¤à§à¦¤à¦¿à¦• à¦¶à§à¦¨à¦¾à¦¨à¦¿à¦° à¦šà¦¾à¦ª à¦“ à¦ªà§à¦¨à¦ƒà¦¨à¦¿à¦°à§à¦§à¦¾à¦°à¦£ à¦à¦•à¦¸à¦¾à¦¥à§‡ à¦¦à§‡à¦–à§à¦¨à¥¤' : 'See hearing volume by date and court, including rescheduled load.' }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-red-soft" data-report-link="attendance-status-report">
                <strong>{{ app()->getLocale() === 'bn' ? 'à¦‰à¦ªà¦¸à§à¦¥à¦¿à¦¤à¦¿ à¦…à¦¬à¦¸à§à¦¥à¦¾ à¦°à¦¿à¦ªà§‹à¦°à§à¦Ÿ' : 'Attendance Status Report' }}</strong>
                <p>{{ app()->getLocale() === 'bn' ? 'à¦•à§‹à¦¥à¦¾à§Ÿ à¦‰à¦ªà¦¸à§à¦¥à¦¿à¦¤, à¦…à¦¨à§à¦ªà¦¸à§à¦¥à¦¿à¦¤, à¦®à¦¾à¦« à¦“ à¦…à¦ªà§‡à¦•à§à¦·à¦®à¦¾à¦¨ à¦¬à§‡à¦¶à¦¿, à¦¤à¦¾ à¦¦à§à¦°à§à¦¤ à¦¬à§‹à¦à¦¾à¦° à¦œà¦¨à§à¦¯à¥¤' : 'Compare appeared, absent, excused, and pending attendance by court.' }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-blue-soft" data-report-link="witness-response-report">
                <strong>{{ app()->getLocale() === 'bn' ? 'à¦¸à¦¾à¦•à§à¦·à§€ à¦¸à¦¾à§œà¦¾ à¦°à¦¿à¦ªà§‹à¦°à§à¦Ÿ' : 'Witness Response Report' }}</strong>
                <p>{{ app()->getLocale() === 'bn' ? 'à¦•à¦¾à¦°à¦¾ à¦à¦¸à¦à¦®à¦à¦¸ à¦¦à§‡à¦–à§‡à¦›à§‡à¦¨, à¦•à¦¾à¦°à¦¾ à¦¶à§à¦¨à¦¾à¦¨à¦¿à¦° à¦–à¦¬à¦° à¦ªà§‡à§Ÿà§‡à¦›à§‡à¦¨ à¦“ à¦•à¦¾à¦°à¦¾ à¦à¦¸à§‡à¦›à§‡à¦¨, à¦¤à¦¾ à¦¦à§‡à¦–à§à¦¨à¥¤' : 'Track SMS seen, witness contact, and actual appearance response.' }}</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-green-soft" data-report-link="vulnerable-witness-report">
                <strong>Vulnerable Witness Report</strong>
                <p>Identify courts with under-18, disability, and other support-sensitive witness groups.</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-red-soft" data-report-link="witness-type-attendance-report">
                <strong>Witness Type Attendance Report</strong>
                <p>Compare attendance outcomes by witness type like IO, MO, DNC, General, and Others.</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
            <button type="button" class="report-tile tone-amber-soft" data-report-link="creation-month-report">
                <strong>Creation Month District Report</strong>
                <p>See district-wise monthly creation volume, already sent SMS, and still scheduled SMS.</p>
                <span>{{ $uiText['open_report'] }}</span>
            </button>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card span-4">
            <div class="chart-head"><h3>{{ $uiText['sms_status_mix'] }}</h3><p class="d-none">{{ $uiText['sms_status_mix_copy'] }}</p></div>
            <canvas id="statusDonut"></canvas>
        </div>
        <div class="chart-card span-8">
            <div class="chart-head"><h3>{{ $uiText['daily_sms_trend'] }}</h3><p id="trendDescription" class="d-none">{{ $uiText['daily_sms_trend_copy'] }}</p></div>
            <canvas id="trendLine"></canvas>
        </div>
        <div class="chart-card span-7">
            <div class="chart-head"><h3>{{ $uiText['court_comparison'] }}</h3><p id="courtDescription" class="d-none">{{ $uiText['court_comparison_copy'] }}</p></div>
            <canvas id="courtBar"></canvas>
        </div>
        <div class="chart-card span-5">
            <div class="chart-head"><h3>{{ $uiText['witness_attendance'] }}</h3><p class="d-none">{{ $uiText['witness_attendance_copy'] }}</p></div>
            <canvas id="witnessDonut"></canvas>
        </div>
        <div class="chart-card span-6">
            <div class="chart-head"><h3>{{ $uiText['district_ranking'] }}</h3><p id="districtDescription" class="d-none">{{ $uiText['district_ranking_copy'] }}</p></div>
            <canvas id="districtBar"></canvas>
        </div>
        <div class="chart-card span-6">
            <div class="chart-head"><h3>{{ $uiText['rescheduled_by_court'] }}</h3><p id="rescheduleDescription" class="d-none">{{ $uiText['rescheduled_by_court_copy'] }}</p></div>
            <canvas id="rescheduleBar"></canvas>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.report-dashboard{--ink:#17324d;--muted:#61758a;--line:rgba(23,50,77,.12);--panel:#fff;--bg1:#f7fbff;--shadow:0 18px 45px rgba(18,43,71,.12)}
.report-dashboard h1,.report-dashboard h3{color:var(--ink);font-weight:800}
.dash-hero,.filter-card,.metric,.insight-card,.chart-card,.intro-card,.decision-card,.action-card{background:var(--panel);border:1px solid var(--line);box-shadow:var(--shadow);border-radius:24px}
.dash-hero,.filter-card,.intro-card,.decision-card,.action-card{padding:1.5rem}
.dash-hero{display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;background:radial-gradient(circle at top right,rgba(10,132,255,.15),transparent 28%),linear-gradient(180deg,#f7fbff 0%,#eef5fb 100%)}
.dash-kicker,.dash-badges span{display:inline-flex;border-radius:999px;font-weight:700}
.dash-kicker{padding:.4rem .8rem;background:rgba(14,92,180,.1);color:#0e5cb4;font-size:.8rem;letter-spacing:.06em;text-transform:uppercase}
.dash-hero p,.filter-head p,.chart-head p,.metric small,.insight-card small{color:var(--muted);margin:0}
.dash-badges,.filter-buttons{display:flex;flex-wrap:wrap;gap:.65rem}
.dash-badges span{padding:.55rem .8rem;background:rgba(23,50,77,.08);color:var(--ink);font-size:.85rem}
.filter-card,.metric-grid,.insight-grid,.chart-grid,.intro-card,.decision-card,.action-card{margin-top:1.5rem}
.filter-head,.section-head{display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;margin-bottom:1rem}
.metric-grid,.insight-grid,.chart-grid,.decision-grid,.action-grid{display:grid;gap:1rem}
.metric-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
.metric,.insight-card,.chart-card{padding:1.15rem}
.metric span,.insight-card span{display:block;color:var(--muted);font-size:.8rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
.metric strong,.insight-card strong{display:block;color:var(--ink);font-size:1.9rem;line-height:1.1;margin:.45rem 0}
.tone-plum{background:linear-gradient(135deg,#fff,#f4edff)}.tone-blue{background:linear-gradient(135deg,#fff,#eaf5ff)}.tone-green{background:linear-gradient(135deg,#fff,#ebfaef)}.tone-amber{background:linear-gradient(135deg,#fff,#fff6e8)}.tone-red{background:linear-gradient(135deg,#fff,#fff0ef)}.tone-cyan{background:linear-gradient(135deg,#fff,#edf9ff)}.tone-slate{background:linear-gradient(135deg,#fff,#eef2f6)}.tone-indigo{background:linear-gradient(135deg,#fff,#eef0ff)}
.insight-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
.intro-card{background:linear-gradient(135deg,#fffdf5,#f7fbff)}
.intro-card h3,.section-head h3{margin-bottom:.35rem}
.section-chip{display:inline-flex;padding:.45rem .8rem;border-radius:999px;background:rgba(23,50,77,.08);color:var(--ink);font-weight:700;font-size:.8rem}
.decision-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
.decision-item{padding:1rem 1.1rem;border-radius:18px;background:linear-gradient(135deg,#ffffff,#f5f8fb);border:1px dashed rgba(23,50,77,.14)}
.decision-item strong{display:block;color:var(--ink);margin-bottom:.45rem}
.decision-item p{margin:0;color:var(--muted);line-height:1.55}
.action-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
.report-tile{padding:1.2rem;border-radius:20px;border:1px solid var(--line);text-align:left;transition:transform .2s ease, box-shadow .2s ease;background:#fff}
.report-tile:hover{transform:translateY(-3px);box-shadow:0 14px 32px rgba(18,43,71,.14)}
.report-tile strong{display:block;color:var(--ink);font-size:1rem;margin-bottom:.45rem}
.report-tile p{color:var(--muted);margin:0 0 .9rem;line-height:1.5}
.report-tile span{display:inline-flex;padding:.4rem .7rem;border-radius:999px;background:rgba(23,50,77,.09);color:var(--ink);font-weight:700;font-size:.82rem}
.tone-blue-soft{background:linear-gradient(135deg,#ffffff,#eef7ff)}
.tone-green-soft{background:linear-gradient(135deg,#ffffff,#eefcf2)}
.tone-amber-soft{background:linear-gradient(135deg,#ffffff,#fff9ed)}
.tone-red-soft{background:linear-gradient(135deg,#ffffff,#fff1f0)}
.chart-grid{grid-template-columns:repeat(12,minmax(0,1fr))}
.chart-card{min-height:360px}.chart-card canvas{width:100%!important;height:280px!important}.span-4{grid-column:span 4}.span-5{grid-column:span 5}.span-6{grid-column:span 6}.span-7{grid-column:span 7}.span-8{grid-column:span 8}
@media (max-width:1200px){.metric-grid,.insight-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.span-4,.span-5,.span-6,.span-7,.span-8{grid-column:span 12}}
@media (max-width:1200px){.decision-grid,.action-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media (max-width:768px){.dash-hero,.filter-head,.section-head{flex-direction:column}.metric-grid,.insight-grid,.decision-grid,.action-grid{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
const tree=@json($locationTree),locale='{{ app()->getLocale() }}',fixedDivision='{{ $user->division_id ?? '' }}',fixedDistrict='{{ $user->district_id ?? '' }}',fixedCourt='{{ $user->court_id ?? '' }}',initial=@json($filters),uiText=@json($uiText),reportUrlTemplate='{{ route('admin.reports.court_sms_dashboard.report', ['type' => '__TYPE__']) }}';
const division=document.getElementById('filterDivision'),district=document.getElementById('filterDistrict'),court=document.getElementById('filterCourt'),fromDate=document.getElementById('fromDate'),toDate=document.getElementById('toDate'),quickRange=document.getElementById('quickRange'),btnFilter=document.getElementById('btnFilter'),btnReset=document.getElementById('btnResetFilters'),badges=document.getElementById('activeFilterBadges'),trendDescription=document.getElementById('trendDescription'),courtDescription=document.getElementById('courtDescription'),districtDescription=document.getElementById('districtDescription'),rescheduleDescription=document.getElementById('rescheduleDescription');
const charts={},targets={totalCases:'totalCases',totalWitnesses:'totalWitnesses',totalSms:'totalSms',sentSms:'sentSms',scheduledSms:'scheduledSms',failedSms:'failedSms',appeared:'appeared',notAppeared:'notAppeared',rescheduled:'rescheduled'};
let activeRequest=null;
let currentPayload=null;
function localizeActionTiles(){const copy={en:{'hearing-schedule-report':['Hearing Schedule Report','See hearing volume by date and court, including rescheduled load.'],'attendance-status-report':['Attendance Status Report','Compare appeared, absent, excused, and pending attendance by court.'],'witness-response-report':['Witness Response Report','Track SMS seen, witness contact, and actual appearance response.'],'vulnerable-witness-report':['Vulnerable Witness Report','Identify courts with under-18, disability, and other support-sensitive witness groups.'],'witness-type-attendance-report':['Witness Type Attendance Report','Compare attendance outcomes by witness type like IO, MO, DNC, General, and Others.'],'creation-month-report':['Creation Month District Report','See district-wise monthly creation volume, already sent SMS, and still scheduled SMS.']},bn:{'hearing-schedule-report':['শুনানি সময়সূচি রিপোর্ট','কোন তারিখে, কোন কোর্টে শুনানির চাপ বেশি এবং কোথায় পুনঃনির্ধারণ বেড়েছে, তা দেখুন।'],'attendance-status-report':['উপস্থিতি অবস্থা রিপোর্ট','কোথায় অনুপস্থিতি, মাফ কিংবা অপেক্ষমাণ উপস্থিতি বেশি, তা দেখে দ্রুত ব্যবস্থা নিন।'],'witness-response-report':['সাক্ষীর সাড়া রিপোর্ট','এসএমএস দেখেছেন কিনা, শুনানির খবর জেনেছেন কিনা এবং শেষ পর্যন্ত হাজির হয়েছেন কিনা, তা দেখুন।'],'vulnerable-witness-report':['সহায়তা-প্রয়োজন সাক্ষী রিপোর্ট','নারী, তৃতীয় লিঙ্গ, ১৮ বছরের নিচে এবং প্রতিবন্ধী সাক্ষীর ঘনত্ব কোথায় বেশি, তা দেখুন।'],'witness-type-attendance-report':['সাক্ষীর ধরনভিত্তিক উপস্থিতি রিপোর্ট','IO, MO, DNC, General বা Others অনুযায়ী কারা বেশি অনুপস্থিত বা অপেক্ষমাণ, তা দেখুন।'],'creation-month-report':['সৃষ্টিমাসভিত্তিক জেলা রিপোর্ট','কোন মাসে কোন জেলায় কত তৈরি হয়েছে, কত পাঠানো হয়েছে এবং কত এখনো নির্ধারিত আছে, তা দেখুন।']}};Object.entries(copy[locale]||copy.en).forEach(([key,[title,desc]])=>{const tile=document.querySelector(`[data-report-link="${key}"]`);if(!tile)return;const strong=tile.querySelector('strong');const para=tile.querySelector('p');if(strong)strong.textContent=title;if(para)para.textContent=desc;});}
function nameOf(item){return locale==='bn'?(item.name_bn||item.name_en):(item.name_en||item.name_bn)}
function byId(items,id){return items.find(item=>String(item.id)===String(id))||null}
function setOptions(select,items,placeholder,selected=''){select.innerHTML='';const first=document.createElement('option');first.value='';first.textContent=placeholder;select.appendChild(first);items.forEach(item=>{const option=document.createElement('option');option.value=item.id;option.textContent=nameOf(item);if(String(item.id)===String(selected))option.selected=true;select.appendChild(option);});}
function divisions(){return tree}
function selectedDivision(){return byId(divisions(),division.value)}
function districts(){return selectedDivision()?selectedDivision().districts:[]}
function selectedDistrict(){return byId(districts(),district.value)}
function courts(){return selectedDistrict()?selectedDistrict().courts:[]}
function syncFilters(filters={}){setOptions(division,divisions(),'{{ __('dashboard.all_divisions') }}',filters.division_id||fixedDivision||'');setOptions(district,districts(),'{{ __('dashboard.all_districts') }}',filters.district_id||fixedDistrict||'');setOptions(court,courts(),'{{ __('dashboard.all_courts') }}',filters.court_id||fixedCourt||'');if(fixedDivision)division.value=fixedDivision;if(fixedDistrict)district.value=fixedDistrict;if(fixedCourt)court.value=fixedCourt;district.disabled=districts().length===0||Boolean(fixedDistrict);court.disabled=courts().length===0||Boolean(fixedCourt);}
function animate(id,value){const el=document.getElementById(id),end=Number(value||0);if(end===0){el.textContent='0';return}let cur=0,step=end/30;function frame(){cur+=step;if(cur<end){el.textContent=Math.floor(cur).toLocaleString();requestAnimationFrame(frame)}else el.textContent=end.toLocaleString()}requestAnimationFrame(frame)}
function params(){const p=new URLSearchParams();if(division.value)p.set('division_id',division.value);if(district.value)p.set('district_id',district.value);if(court.value)p.set('court_id',court.value);if(fromDate.value)p.set('from_date',fromDate.value);if(toDate.value)p.set('to_date',toDate.value);return p}
function setBadges(filters,totals){const pills=[];const d1=byId(divisions(),filters.division_id||division.value),d2=d1?byId(d1.districts,filters.district_id||district.value):null,d3=d2?byId(d2.courts,filters.court_id||court.value):null;if(d1)pills.push(`{{ __('dashboard.division') }}: ${nameOf(d1)}`);if(d2)pills.push(`{{ __('dashboard.district') }}: ${nameOf(d2)}`);if(d3)pills.push(`{{ __('dashboard.court') }}: ${nameOf(d3)}`);if(filters.from_date||filters.to_date)pills.push(`{{ __('dashboard.date_range') }}: ${filters.from_date||'...'} to ${filters.to_date||'...'}`);pills.push(`SMS: ${(totals.total_sms_sent||0).toLocaleString()}`);badges.innerHTML=pills.map(item=>`<span>${item}</span>`).join('')}
function insights(data){document.getElementById('topCourtName').textContent=data.top_court?.court||'-';document.getElementById('topCourtMeta').textContent=data.top_court?`${data.top_court.total_sms_sent} ${uiText.sms_short} • ${data.top_court.total_cases} {{ __('dashboard.total_cases') }}`:uiText.no_data_short;document.getElementById('topDistrictName').textContent=data.top_district?.district||'-';document.getElementById('topDistrictMeta').textContent=data.top_district?`${data.top_district.total_sms_sent} ${uiText.sms_short} • ${data.top_district.total_cases} {{ __('dashboard.total_cases') }}`:uiText.no_data_short;document.getElementById('deliveryRate').textContent=`${data.delivery_rate||0}%`;document.getElementById('appearanceRate').textContent=`${data.appearance_rate||0}%`;}
function chart(id,config){if(charts[id])charts[id].destroy();charts[id]=new Chart(document.getElementById(id),config)}
function chartOptions(extra={}){return Object.assign({responsive:true,maintainAspectRatio:false,animation:false,plugins:{legend:{position:'bottom'}}},extra)}
function topRows(rows,limit=8){return rows.slice(0,limit)}
function note(template,count){return template.replace('%s',count)}
function openReport(type){const query=params().toString(),url=reportUrlTemplate.replace('__TYPE__',type);window.location.href=query?`${url}?${query}`:url;}
function toggleReport(type,visible){const button=document.querySelector(`[data-report-link="${type}"]`);if(button){button.style.display=visible?'block':'none';}}
function setBlockVisibility(payload){
const visibility=payload.chart_visibility||{},mode=payload.dashboard_mode||'national',statusCard=document.getElementById('statusDonut').closest('.chart-card'),trendCard=document.getElementById('trendLine').closest('.chart-card'),courtCard=document.getElementById('courtBar').closest('.chart-card'),witnessCard=document.getElementById('witnessDonut').closest('.chart-card'),districtCard=document.getElementById('districtBar').closest('.chart-card'),rescheduleCard=document.getElementById('rescheduleBar').closest('.chart-card');
statusCard.style.display=visibility.show_status?'block':'none';
trendCard.style.display=visibility.show_trend?'block':'none';
courtCard.style.display=visibility.show_courts?'block':'none';
witnessCard.style.display=visibility.show_witness?'block':'none';
districtCard.style.display=visibility.show_districts?'block':'none';
rescheduleCard.style.display=visibility.show_reschedules?'block':'none';
toggleReport('district-summary',mode==='national');
toggleReport('court-focus',mode!=='court');
toggleReport('trend-focus',true);
toggleReport('attention-focus',mode!=='court');
toggleReport('witness-report',true);
toggleReport('reschedule-report',mode!=='court');
}
function renderCharts(payload){const rows=payload.rows||[],districtRows=payload.district_rows||[],totals=payload.totals||{},trend=payload.trend||[],courtTop=topRows(rows,8),districtTop=topRows(districtRows,8),rescheduleTop=topRows(rows.filter(x=>x.rescheduled_cases>0),8);
trendDescription.textContent=`${uiText.daily_sms_trend_copy} ${payload.trend_mode==='monthly' ? uiText.trend_monthly : uiText.trend_daily}`;
courtDescription.textContent=`${uiText.court_comparison_copy} ${rows.length>courtTop.length ? note(uiText.top_items_note,courtTop.length) : ''}`.trim();
districtDescription.textContent=`${uiText.district_ranking_copy} ${districtRows.length>districtTop.length ? note(uiText.top_items_note,districtTop.length) : ''}`.trim();
rescheduleDescription.textContent=`${uiText.rescheduled_by_court_copy} ${rows.filter(x=>x.rescheduled_cases>0).length>rescheduleTop.length ? note(uiText.top_items_note,rescheduleTop.length) : ''}`.trim();
chart('statusDonut',{type:'doughnut',data:{labels:['{{ __('dashboard.sent') }}',uiText.scheduled,'{{ __('dashboard.failed') }}'],datasets:[{data:[totals.sent||0,totals.pending||0,totals.failed||0],backgroundColor:['#1f9d55','#c98500','#d64545'],borderWidth:0}]},options:chartOptions()});
chart('trendLine',{type:'line',data:{labels:trend.map(x=>x.date),datasets:[{label:'{{ __('dashboard.total_sms') }}',data:trend.map(x=>x.total_sms_sent),borderColor:'#0a84ff',backgroundColor:'rgba(10,132,255,.16)',fill:true,tension:.25},{label:'{{ __('dashboard.sent') }}',data:trend.map(x=>x.sent),borderColor:'#1f9d55',fill:false,tension:.25},{label:uiText.scheduled,data:trend.map(x=>x.pending),borderColor:'#c98500',fill:false,tension:.25},{label:'{{ __('dashboard.failed') }}',data:trend.map(x=>x.failed),borderColor:'#d64545',fill:false,tension:.25}]},options:chartOptions({scales:{y:{beginAtZero:true}}})});
chart('courtBar',{type:'bar',data:{labels:courtTop.map(x=>x.court),datasets:[{label:'{{ __('dashboard.sent') }}',data:courtTop.map(x=>x.sent),backgroundColor:'#1f9d55'},{label:uiText.scheduled,data:courtTop.map(x=>x.pending),backgroundColor:'#c98500'},{label:'{{ __('dashboard.failed') }}',data:courtTop.map(x=>x.failed),backgroundColor:'#d64545'},{label:'{{ __('dashboard.witness_appeared') }}',data:courtTop.map(x=>x.witness_appeared),backgroundColor:'#2167d8'}]},options:chartOptions({scales:{x:{stacked:true},y:{stacked:true,beginAtZero:true}}})});
chart('witnessDonut',{type:'doughnut',data:{labels:['{{ __('dashboard.appeared') }}','{{ __('dashboard.not_appeared') }}'],datasets:[{data:[totals.witness_appeared||0,totals.witness_not_appeared||0],backgroundColor:['#2167d8','#5a6878'],borderWidth:0}]},options:chartOptions()});
chart('districtBar',{type:'bar',data:{labels:districtTop.map(x=>x.district),datasets:[{label:'{{ __('dashboard.total_sms') }}',data:districtTop.map(x=>x.total_sms_sent),backgroundColor:'#0a84ff'}]},options:chartOptions({indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true}}})});
chart('rescheduleBar',{type:'bar',data:{labels:rescheduleTop.map(x=>x.court),datasets:[{label:'{{ __('dashboard.cases_rescheduled') }}',data:rescheduleTop.map(x=>x.rescheduled_cases),backgroundColor:'#5a6878'}]},options:chartOptions({plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}})});}
function quick(){const today=new Date(),fmt=d=>d.toISOString().slice(0,10),start=new Date(today),end=new Date(today);if(quickRange.value==='today'){fromDate.value=fmt(start);toDate.value=fmt(end)}else if(quickRange.value==='last7'){start.setDate(today.getDate()-6);fromDate.value=fmt(start);toDate.value=fmt(end)}else if(quickRange.value==='last30'){start.setDate(today.getDate()-29);fromDate.value=fmt(start);toDate.value=fmt(end)}else if(quickRange.value==='thisMonth'){start.setDate(1);fromDate.value=fmt(start);toDate.value=fmt(end)}}
function setLoadingState(isLoading){btnFilter.disabled=isLoading;btnFilter.textContent=isLoading?uiText.apply_loading:'{{ __('dashboard.apply_filter') }}';}
function load(){if(activeRequest){activeRequest.abort()}activeRequest=new AbortController();setLoadingState(true);fetch(`{{ route('admin.reports.court_sms_dashboard.data') }}?${params().toString()}`,{signal:activeRequest.signal}).then(r=>r.json()).then(payload=>{currentPayload=payload;animate(targets.totalCases,payload.totals?.total_cases||0);animate(targets.totalWitnesses,payload.totals?.total_witnesses||0);animate(targets.totalSms,payload.totals?.total_sms_sent||0);animate(targets.sentSms,payload.totals?.sent||0);animate(targets.scheduledSms,payload.totals?.pending||0);animate(targets.failedSms,payload.totals?.failed||0);animate(targets.appeared,payload.totals?.witness_appeared||0);animate(targets.notAppeared,payload.totals?.witness_not_appeared||0);animate(targets.rescheduled,payload.totals?.rescheduled_cases||0);insights(payload.insights||{});setBlockVisibility(payload);renderCharts(payload);setBadges(payload.filters||{},payload.totals||{});}).catch(err=>{if(err.name==='AbortError')return;console.error(err);}).finally(()=>{setLoadingState(false);activeRequest=null})}
division.addEventListener('change',()=>{setOptions(district,districts(),'{{ __('dashboard.all_districts') }}','');setOptions(court,[],'{{ __('dashboard.all_courts') }}','');district.disabled=districts().length===0||Boolean(fixedDistrict);court.disabled=true;quickRange.value='';});
district.addEventListener('change',()=>{setOptions(court,courts(),'{{ __('dashboard.all_courts') }}','');court.disabled=courts().length===0||Boolean(fixedCourt);quickRange.value='';});
[court,fromDate,toDate].forEach(el=>el.addEventListener('change',()=>{if(el===fromDate||el===toDate)quickRange.value='';}));
quickRange.addEventListener('change',()=>{quick();load()});btnFilter.addEventListener('click',load);btnReset.addEventListener('click',()=>{quickRange.value='';fromDate.value='';toDate.value='';syncFilters({division_id:fixedDivision||'',district_id:fixedDistrict||'',court_id:fixedCourt||''});load()});
document.querySelectorAll('[data-report-link]').forEach(button=>button.addEventListener('click',()=>openReport(button.dataset.reportLink)));
localizeActionTiles();syncFilters(initial);load();
});
</script>
@endpush
