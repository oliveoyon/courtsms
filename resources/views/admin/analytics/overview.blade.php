@extends('dashboard.layouts.admin')

@section('title', __('dashboard.court_sms_reports'))

@section('content')
<div class="container-fluid">

    {{-- Main Filters --}}
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <label>{{ __('dashboard.division') }}</label>
            <select id="divisionSelect" class="form-select shadow-sm rounded" {{ isset($user) && $user->division_id ? 'disabled' : '' }}>
                <option value="">{{ __('dashboard.all_divisions') }}</option>
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ isset($user) && $user->division_id == $division->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'bn' 
                            ? (is_array($division->name_bn) ? implode(', ', $division->name_bn) : $division->name_bn) 
                            : (is_array($division->name_en) ? implode(', ', $division->name_en) : $division->name_en) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.district') }}</label>
            <select id="districtSelect" class="form-select shadow-sm rounded" disabled>
                <option value="">{{ __('dashboard.select_division_first') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.court') }}</label>
            <select id="courtSelect" class="form-select shadow-sm rounded" disabled>
                <option value="">{{ __('dashboard.select_district_first') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.date_range') }}</label>
            <div class="d-flex gap-2">
                <input type="date" id="fromDate" class="form-control shadow-sm rounded">
                <input type="date" id="toDate" class="form-control shadow-sm rounded">
            </div>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <label>{{ __('dashboard.sms_status') }}</label>
            <select id="statusFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="sent">{{ __('dashboard.sent') }}</option>
                <option value="pending">{{ __('dashboard.pending') }}</option>
                <option value="failed">{{ __('dashboard.failed') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.witness') }}</label>
            <select id="witnessFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="appeared">{{ __('dashboard.appeared') }}</option>
                <option value="not_appeared">{{ __('dashboard.not_appeared') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.rescheduled') }}</label>
            <select id="rescheduledFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="yes">{{ __('dashboard.yes') }}</option>
                <option value="no">{{ __('dashboard.no') }}</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button id="btnFilter" class="btn btn-success w-100 shadow-sm fw-bold">{{ __('dashboard.apply_filter') }}</button>
        </div>
    </div>

    {{-- Advanced Witness Toggle --}}
    <div class="row mb-3 g-2 d-none" id="advancedToggleRow">
        <div class="col-md-12 d-flex justify-content-start">
            <button id="toggleAdvancedFilters" class="btn btn-outline-info shadow-sm">
                {{ __('dashboard.show_witness_filters') }}
            </button>
        </div>
    </div>

    {{-- Advanced Witness Filters --}}
    <div class="row mb-4 g-3 d-none" id="advancedFiltersRow">
        <div class="col-md-3">
            <label>{{ __('dashboard.gender') }}</label>
            <select id="genderFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="Female">{{ __('dashboard.female') }}</option>
                <option value="Male">{{ __('dashboard.male') }}</option>
                <option value="Third Gender">{{ __('dashboard.third_gender') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.others_info') }}</label>
            <select id="othersInfoFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="Under 18">{{ __('dashboard.under_18') }}</option>
                <option value="Person with Disability">{{ __('dashboard.person_with_disability') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.sms_seen') }}</label>
            <select id="smsSeenFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="yes">{{ __('dashboard.yes') }}</option>
                <option value="no">{{ __('dashboard.no') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>{{ __('dashboard.witness_heard') }}</label>
            <select id="witnessHeardFilter" class="form-select shadow-sm rounded">
                <option value="">{{ __('dashboard.all') }}</option>
                <option value="yes">{{ __('dashboard.yes') }}</option>
                <option value="no">{{ __('dashboard.no') }}</option>
            </select>
        </div>
    </div>

    {{-- Scrollable Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white sticky-top">
                    <h4 class="card-title mb-0">{{ __('dashboard.sms_summary') }}</h4>
                </div>
                <div class="card-body p-0" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0 text-center align-middle" id="smsSummaryTable">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th>{{ __('dashboard.division') }}</th>
                                <th>{{ __('dashboard.district') }}</th>
                                <th>{{ __('dashboard.court') }}</th>
                                <th>{{ __('dashboard.total_sms') }}</th>
                                <th class="text-success">{{ __('dashboard.sent') }}</th>
                                <th class="text-warning">{{ __('dashboard.pending') }}</th>
                                <th class="text-danger">{{ __('dashboard.failed') }}</th>
                                <th>{{ __('dashboard.witness_appeared') }}</th>
                                <th>{{ __('dashboard.rescheduled_cases') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td colspan="9" class="text-muted py-3">{{ __('dashboard.select_filters_to_load_data') }}</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light text-center fw-bold d-none sticky-bottom">
                            <tr>
                                <td colspan="3">{{ __('dashboard.total') }}</td>
                                <td id="totalSms">0</td>
                                <td id="totalSent">0</td>
                                <td id="totalPending">0</td>
                                <td id="totalFailed">0</td>
                                <td id="totalWitness">0</td>
                                <td id="totalRescheduled">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Custom Styles --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #1f3c88, #1f6ca5);
    }
    table.table-hover tbody tr:hover {
        background-color: #e3f2fd !important;
    }
    table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    .form-select, .form-control {
        min-height: 42px;
    }
    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: #fff;
    }
    .sticky-top {
        z-index: 2;
    }
    .sticky-bottom {
        position: sticky;
        bottom: 0;
        background-color: #f1f3f5;
    }
</style>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const divisionSelect       = document.getElementById('divisionSelect');
    const districtSelect       = document.getElementById('districtSelect');
    const courtSelect          = document.getElementById('courtSelect');
    const fromDate             = document.getElementById('fromDate');
    const toDate               = document.getElementById('toDate');
    const statusFilter         = document.getElementById('statusFilter');
    const witnessFilter        = document.getElementById('witnessFilter');
    const rescheduledFilter    = document.getElementById('rescheduledFilter');
    const genderFilter         = document.getElementById('genderFilter');
    const othersInfoFilter     = document.getElementById('othersInfoFilter');
    const smsSeenFilter        = document.getElementById('smsSeenFilter');
    const witnessHeardFilter   = document.getElementById('witnessHeardFilter');
    const tableBody            = document.querySelector('#smsSummaryTable tbody');
    const tfoot                = document.querySelector('#smsSummaryTable tfoot');
    const totalSms             = document.getElementById('totalSms');
    const totalSent            = document.getElementById('totalSent');
    const totalPending         = document.getElementById('totalPending');
    const totalFailed          = document.getElementById('totalFailed');
    const totalWitness         = document.getElementById('totalWitness');
    const totalRescheduled     = document.getElementById('totalRescheduled');

    const btnFilter            = document.getElementById('btnFilter');
    const advancedToggleRow    = document.getElementById('advancedToggleRow');
    const advancedFiltersRow   = document.getElementById('advancedFiltersRow');
    const toggleAdvancedBtn    = document.getElementById('toggleAdvancedFilters');

    // --- User info from backend for blocking ---
    const userDivision = '{{ $user->division_id ?? '' }}';
    const userDistrict = '{{ $user->district_id ?? '' }}';
    const userCourt    = '{{ $user->court_id ?? '' }}';

    // --- Dependent dropdown helpers ---
    const clearSelect = (select, placeholder) => select.innerHTML = `<option value="">${placeholder}</option>`;

    function fetchDistricts(divisionId, selected = 0) {
        courtSelect.innerHTML = `<option value="">All Courts</option>`;
        if (!divisionId) return Promise.resolve();
        return fetch(`/admin/divisions/${divisionId}/districts`)
            .then(res => res.json())
            .then(data => {
                districtSelect.innerHTML = `<option value="">All Districts</option>`;
                data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name_en;
                    if (selected && selected == d.id) opt.selected = true;
                    districtSelect.appendChild(opt);
                });
                if (!userDistrict) districtSelect.disabled = false;
            });
    }

    function fetchCourts(districtId, selected = 0) {
        if (!districtId) return Promise.resolve();
        return fetch(`/admin/districts/${districtId}/courts`)
            .then(res => res.json())
            .then(data => {
                courtSelect.innerHTML = `<option value="">All Courts</option>`;
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name_en;
                    if (selected && selected == c.id) opt.selected = true;
                    courtSelect.appendChild(opt);
                });
                if (!userCourt) courtSelect.disabled = false;
            });
    }

    function initFilters() {
        if (userDivision) {
            divisionSelect.value = userDivision;
            divisionSelect.disabled = true;

            fetchDistricts(userDivision, userDistrict).then(() => {
                if (userDistrict) {
                    districtSelect.disabled = true;
                    fetchCourts(userDistrict, userCourt).then(() => {
                        if (userCourt) courtSelect.disabled = true;
                        loadSummary();
                    });
                } else loadSummary();
            });
        } else loadSummary();
    }

    divisionSelect.addEventListener('change', function () {
        fetchDistricts(this.value);
    });

    districtSelect.addEventListener('change', function () {
        fetchCourts(this.value);
    });

    // --- Advanced Witness Filters Toggle ---
    witnessFilter.addEventListener('change', function () {
        if (this.value === 'appeared') {
            advancedToggleRow.classList.remove('d-none');
        } else {
            advancedToggleRow.classList.add('d-none');
            advancedFiltersRow.classList.add('d-none');
        }
    });

    toggleAdvancedBtn.addEventListener('click', function () {
        advancedFiltersRow.classList.toggle('d-none');
        toggleAdvancedBtn.textContent = advancedFiltersRow.classList.contains('d-none')
            ? 'Show Witness Filters' : 'Hide Witness Filters';
    });

    // --- Load Table Data ---
    const loadSummary = () => {
        tableBody.innerHTML = '<tr><td colspan="9" class="text-center py-3">Loading...</td></tr>';

        const params = new URLSearchParams({
            division_id: divisionSelect.value,
            district_id: districtSelect.value,
            court_id: courtSelect.value,
            from_date: fromDate.value,
            to_date: toDate.value,
            status: statusFilter.value,
            witness: witnessFilter.value,
            rescheduled: rescheduledFilter.value,
            gender: genderFilter.value,
            others_info: othersInfoFilter.value,
            sms_seen: smsSeenFilter.value,
            witness_heard: witnessHeardFilter.value
        });

        fetch(`/admin/analytics/sms-summary?${params.toString()}`)
            .then(res => res.json())
            .then(rows => {
                tableBody.innerHTML = '';
                if (!rows.length) {
                    tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-3">No data found</td></tr>';
                    tfoot.classList.add('d-none');
                    return;
                }

                let sms=0, sent=0, pending=0, failed=0, witness=0, rescheduled=0;

                rows.forEach(r => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${r.division}</td>
                            <td>${r.district}</td>
                            <td>${r.court}</td>
                            <td>${r.total_sms_sent}</td>
                            <td>${r.sent}</td>
                            <td>${r.pending}</td>
                            <td>${r.failed}</td>
                            <td>${r.witness_appeared}</td>
                            <td>${r.rescheduled_cases}</td>
                        </tr>`;

                    sms += r.total_sms_sent;
                    sent += r.sent;
                    pending += r.pending;
                    failed += r.failed;
                    witness += r.witness_appeared;
                    rescheduled += r.rescheduled_cases;
                });

                totalSms.textContent = sms;
                totalSent.textContent = sent;
                totalPending.textContent = pending;
                totalFailed.textContent = failed;
                totalWitness.textContent = witness;
                totalRescheduled.textContent = rescheduled;
                tfoot.classList.remove('d-none');
            })
            .catch(err => {
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger py-3">Error loading data</td></tr>';
                console.error(err);
                tfoot.classList.add('d-none');
            });
    };

    btnFilter.addEventListener('click', loadSummary);

    initFilters();
});
</script>
@endpush
