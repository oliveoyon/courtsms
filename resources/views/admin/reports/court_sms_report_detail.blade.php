@extends('dashboard.layouts.admin')
@section('title', $report['title'])

@php
    $isBn = app()->getLocale() === 'bn';
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

    $labels = $isBn
        ? [
            'back' => 'ড্যাশবোর্ডে ফিরুন',
            'back_to_reports' => 'বিস্তারিত রিপোর্টে ফিরুন',
            'empty' => 'এই রিপোর্টে এখন দেখানোর মতো তথ্য নেই।',
            'filters' => 'সক্রিয় ফিল্টার',
            'change_filters' => 'ফিল্টার পরিবর্তন',
            'apply' => 'রিপোর্ট দেখুন',
            'reset' => 'রিসেট',
            'all' => 'সব',
            'total' => 'মোট',
            'division_id' => 'বিভাগ',
            'district_id' => 'জেলা',
            'court_id' => 'কোর্ট',
            'from_date' => 'শুরুর তারিখ',
            'to_date' => 'শেষ তারিখ',
            'division' => 'বিভাগ',
            'district' => 'জেলা',
            'court' => 'কোর্ট',
            'date' => 'তারিখ',
            'created_month' => 'তৈরির মাস',
            'witness_type' => 'সাক্ষীর ধরন',
            'total_hearings' => 'মোট শুনানি',
            'original_hearings' => 'মূল শুনানি',
            'total_cases' => 'মোট মামলা',
            'total_sms_sent' => 'মোট এসএমএস',
            'sent' => 'পাঠানো',
            'pending' => 'নির্ধারিত',
            'failed' => 'ব্যর্থ',
            'total_witnesses' => 'মোট সাক্ষী',
            'witness_appeared' => 'উপস্থিত',
            'witness_not_appeared' => 'অনুপস্থিত',
            'absent' => 'অনুপস্থিত',
            'excused' => 'মাফ',
            'pending_attendance' => 'অপেক্ষমাণ',
            'sms_seen_yes' => 'এসএমএস দেখেছেন',
            'witness_heard_yes' => 'খবর জেনেছেন',
            'female_witnesses' => 'নারী',
            'male_witnesses' => 'পুরুষ',
            'third_gender_witnesses' => 'তৃতীয় লিঙ্গ',
            'under_18_witnesses' => '১৮ বছরের নিচে',
            'pwd_witnesses' => 'প্রতিবন্ধী',
            'both_support_needs' => 'একাধিক সহায়তা প্রয়োজন',
            'rescheduled_cases' => 'পুনঃনির্ধারিত',
        ]
        : [
            'back' => 'Back to Dashboard',
            'back_to_reports' => 'Back to Detailed Reports',
            'empty' => 'No data is available for this report.',
            'filters' => 'Active Filters',
            'change_filters' => 'Change Filters',
            'apply' => 'Apply Filters',
            'reset' => 'Reset',
            'all' => 'All',
            'total' => 'Total',
            'division_id' => 'Division',
            'district_id' => 'District',
            'court_id' => 'Court',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'division' => 'Division',
            'district' => 'District',
            'court' => 'Court',
            'date' => 'Date',
            'created_month' => 'Created Month',
            'witness_type' => 'Witness Type',
            'total_hearings' => 'Total Hearings',
            'original_hearings' => 'Original Hearings',
            'total_cases' => 'Total Cases',
            'total_sms_sent' => 'Total SMS',
            'sent' => 'Sent',
            'pending' => 'Scheduled',
            'failed' => 'Failed',
            'total_witnesses' => 'Total Witnesses',
            'witness_appeared' => 'Appeared',
            'witness_not_appeared' => 'Not Appeared',
            'absent' => 'Absent',
            'excused' => 'Excused',
            'pending_attendance' => 'Pending Attendance',
            'sms_seen_yes' => 'SMS Seen',
            'witness_heard_yes' => 'Heard',
            'female_witnesses' => 'Female',
            'male_witnesses' => 'Male',
            'third_gender_witnesses' => 'Third Gender',
            'under_18_witnesses' => 'Under 18',
            'pwd_witnesses' => 'Person with Disability',
            'both_support_needs' => 'Multiple Support Needs',
            'rescheduled_cases' => 'Rescheduled',
        ];

    $columnTotals = [];
    foreach ($report['columns'] as $column) {
        $sum = 0;
        $hasNumeric = false;
        foreach ($rows as $row) {
            if (isset($row[$column]) && is_numeric($row[$column])) {
                $sum += (float) $row[$column];
                $hasNumeric = true;
            }
        }
        if ($hasNumeric) {
            $columnTotals[$column] = $sum;
        }
    }
@endphp

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h2 class="mb-2">{{ $report['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $report['description'] }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.reports.detailed', request()->query()) }}" class="btn btn-outline-dark">
                        {{ $labels['back_to_reports'] }}
                    </a>
                    <a href="{{ route('admin.reports.court_sms_dashboard', request()->query()) }}" class="btn btn-outline-secondary">
                        {{ $labels['back'] }}
                    </a>
                </div>
            </div>

            <div class="border rounded-4 p-3 mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">{{ $labels['change_filters'] }}</h6>
                        <p class="text-muted mb-0">{{ $labels['filters'] }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="detailReset">{{ $labels['reset'] }}</button>
                        <button type="button" class="btn btn-primary btn-sm" id="detailApply">{{ $labels['apply'] }}</button>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">{{ $labels['division_id'] }}</label>
                        <select id="detailDivision" class="form-select form-select-sm"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $labels['district_id'] }}</label>
                        <select id="detailDistrict" class="form-select form-select-sm"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $labels['court_id'] }}</label>
                        <select id="detailCourt" class="form-select form-select-sm"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $labels['from_date'] }}</label>
                        <input type="date" id="detailFromDate" class="form-control form-control-sm" value="{{ $filters['from_date'] }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $labels['to_date'] }}</label>
                        <input type="date" id="detailToDate" class="form-control form-control-sm" value="{{ $filters['to_date'] }}">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-muted text-uppercase mb-2">{{ $labels['filters'] }}</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($filters as $key => $value)
                        <span class="badge text-bg-light border px-3 py-2">
                            {{ $labels[$key] ?? $key }}: {{ $value ?: $labels['all'] }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if (empty($rows))
                <div class="alert alert-light border mb-0">{{ $labels['empty'] }}</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                @foreach ($report['columns'] as $column)
                                    <th>{{ $labels[$column] ?? ucfirst(str_replace('_', ' ', $column)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach ($report['columns'] as $column)
                                        <td>{{ $row[$column] ?? '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        @if (!empty($columnTotals))
                            <tfoot class="table-light">
                                <tr>
                                    @php $totalLabelShown = false; @endphp
                                    @foreach ($report['columns'] as $column)
                                        @if (array_key_exists($column, $columnTotals))
                                            <th>{{ number_format($columnTotals[$column], fmod($columnTotals[$column], 1.0) === 0.0 ? 0 : 2) }}</th>
                                        @elseif (!$totalLabelShown)
                                            <th>{{ $labels['total'] }}</th>
                                            @php $totalLabelShown = true; @endphp
                                        @else
                                            <th></th>
                                        @endif
                                    @endforeach
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tree = @json($locationTree);
    const locale = '{{ app()->getLocale() }}';
    const fixedDivision = '{{ $user->division_id ?? '' }}';
    const fixedDistrict = '{{ $user->district_id ?? '' }}';
    const fixedCourt = '{{ $user->court_id ?? '' }}';
    const initial = @json($filters);
    const division = document.getElementById('detailDivision');
    const district = document.getElementById('detailDistrict');
    const court = document.getElementById('detailCourt');
    const fromDate = document.getElementById('detailFromDate');
    const toDate = document.getElementById('detailToDate');

    function nameOf(item) { return locale === 'bn' ? (item.name_bn || item.name_en) : (item.name_en || item.name_bn); }
    function byId(items, id) { return items.find(item => String(item.id) === String(id)) || null; }
    function setOptions(select, items, placeholder, selected = '') {
        select.innerHTML = '';
        const first = document.createElement('option');
        first.value = '';
        first.textContent = placeholder;
        select.appendChild(first);
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = nameOf(item);
            if (String(item.id) === String(selected)) option.selected = true;
            select.appendChild(option);
        });
    }
    function divisions() { return tree; }
    function selectedDivision() { return byId(divisions(), division.value); }
    function districts() { return selectedDivision() ? selectedDivision().districts : []; }
    function selectedDistrict() { return byId(districts(), district.value); }
    function courts() { return selectedDistrict() ? selectedDistrict().courts : []; }
    function sync(filters = {}) {
        setOptions(division, divisions(), @json($labels['all']), filters.division_id || fixedDivision || '');
        setOptions(district, districts(), @json($labels['all']), filters.district_id || fixedDistrict || '');
        setOptions(court, courts(), @json($labels['all']), filters.court_id || fixedCourt || '');
        if (fixedDivision) division.value = fixedDivision;
        if (fixedDistrict) district.value = fixedDistrict;
        if (fixedCourt) court.value = fixedCourt;
        division.disabled = Boolean(fixedDivision);
        district.disabled = districts().length === 0 || Boolean(fixedDistrict);
        court.disabled = courts().length === 0 || Boolean(fixedCourt);
    }
    function params() {
        const p = new URLSearchParams();
        if (division.value) p.set('division_id', division.value);
        if (district.value) p.set('district_id', district.value);
        if (court.value) p.set('court_id', court.value);
        if (fromDate.value) p.set('from_date', fromDate.value);
        if (toDate.value) p.set('to_date', toDate.value);
        return p.toString();
    }
    function go() {
        const base = '{{ route('admin.reports.court_sms_dashboard.report', ['type' => $reportKey]) }}';
        const query = params();
        window.location.href = query ? `${base}?${query}` : base;
    }

    division.addEventListener('change', () => {
        setOptions(district, districts(), @json($labels['all']), '');
        setOptions(court, [], @json($labels['all']), '');
        district.disabled = districts().length === 0 || Boolean(fixedDistrict);
        court.disabled = true;
    });
    district.addEventListener('change', () => {
        setOptions(court, courts(), @json($labels['all']), '');
        court.disabled = courts().length === 0 || Boolean(fixedCourt);
    });
    document.getElementById('detailApply').addEventListener('click', go);
    document.getElementById('detailReset').addEventListener('click', () => {
        fromDate.value = '';
        toDate.value = '';
        sync({ division_id: fixedDivision || '', district_id: fixedDistrict || '', court_id: fixedCourt || '' });
        go();
    });

    sync(initial);
});
</script>
@endpush
