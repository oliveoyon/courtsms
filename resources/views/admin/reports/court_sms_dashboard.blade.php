@extends('dashboard.layouts.admin')
@section('title', __('dashboard.court_sms_dashboard'))

@section('content')
<div class="container-fluid">

    {{-- Filters --}}
    <div class="row mb-4 g-2">
        <div class="col-6 col-md-2">
            <label>{{ __('dashboard.division') }}</label>
            <select id="filterDivision" class="form-select" {{ isset($user) && $user->division_id ? 'disabled' : '' }}>
                <option value="">{{ __('dashboard.all_divisions') }}</option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ isset($user) && $user->division_id == $division->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'bn' ? (is_array($division->name_bn) ? implode(', ', $division->name_bn) : $division->name_bn) : (is_array($division->name_en) ? implode(', ', $division->name_en) : $division->name_en) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label>{{ __('dashboard.district') }}</label>
            <select id="filterDistrict" class="form-select" disabled>
                <option value="">{{ __('dashboard.select_division_first') }}</option>
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label>{{ __('dashboard.court') }}</label>
            <select id="filterCourt" class="form-select" disabled>
                <option value="">{{ __('dashboard.select_district_first') }}</option>
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label>{{ __('dashboard.from_date') }}</label>
            <input type="date" id="fromDate" class="form-control">
        </div>

        <div class="col-6 col-md-2">
            <label>{{ __('dashboard.to_date') }}</label>
            <input type="date" id="toDate" class="form-control">
        </div>

        <div class="col-6 col-md-2 d-flex align-items-end">
            <button id="btnFilter" class="btn btn-primary w-100">{{ __('dashboard.apply_filter') }}</button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row mb-4 g-3" id="kpiCards" style="margin-top:15px;">
        @foreach ([
            'totalCases' => ['label' => __('dashboard.total_cases'), 'color' => ['#845ef7','#5f3dc4'], 'icon' => 'fa-solid fa-gavel'],
            'totalSms' => ['label' => __('dashboard.total_sms'), 'color' => ['#4dabf7','#1c7ed6'], 'icon' => 'fa-solid fa-sms'],
            'sentSms' => ['label' => __('dashboard.sent'), 'color' => ['#51cf66','#2b8a3e'], 'icon' => 'fa-solid fa-paper-plane'],
            'pendingSms' => ['label' => __('dashboard.pending'), 'color' => ['#ffd43b','#ffb703'], 'icon' => 'fa-solid fa-clock'],
            'failedSms' => ['label' => __('dashboard.failed'), 'color' => ['#ff6b6b','#c92a2a'], 'icon' => 'fa-solid fa-triangle-exclamation'],
            'appeared' => ['label' => __('dashboard.witness_appeared'), 'color' => ['#339af0','#1c7ed6'], 'icon' => 'fa-solid fa-user-check'],
            'rescheduled' => ['label' => __('dashboard.cases_rescheduled'), 'color' => ['#868e96','#495057'], 'icon' => 'fa-solid fa-calendar-days'],
        ] as $id => $card)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card-modern shadow-sm rounded p-3 d-flex align-items-center"
                     style="background: linear-gradient(135deg, {{ $card['color'][0] }}, {{ $card['color'][1] }}); 
                            color:white;
                            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                            transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="kpi-icon d-flex justify-content-center align-items-center me-3"
                         style="width:50px; height:50px; border-radius:50%; font-size:1.4rem; background: rgba(255,255,255,0.2);">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                    <div class="kpi-content flex-fill">
                        <h3 id="{{ $id }}" class="counter m-0" style="font-size:1.5rem; font-weight:600;">0</h3>
                        <p class="m-0" style="font-size:0.9rem; opacity:0.9;">{{ $card['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="row mb-4 g-3">
        <div class="col-12 col-md-6 mb-3 d-flex">
            <div class="card flex-fill shadow-sm rounded">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--bs-info), rgba(0,0,0,0.1));">
                    <h5 class="card-title mb-0">{{ __('dashboard.sms_status_distribution') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="height:180px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-3 d-flex">
            <div class="card flex-fill shadow-sm rounded">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--bs-success), rgba(0,0,0,0.1));">
                    <h5 class="card-title mb-0">{{ __('dashboard.sms_status_by_court') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-3 d-flex">
            <div class="card flex-fill shadow-sm rounded">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--bs-primary), rgba(0,0,0,0.1));">
                    <h5 class="card-title mb-0">{{ __('dashboard.witness_appearance') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="doughnutChart" style="height:180px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-3 d-flex">
            <div class="card flex-fill shadow-sm rounded">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--bs-secondary), rgba(0,0,0,0.1));">
                    <h5 class="card-title mb-0">{{ __('dashboard.rescheduled_cases_by_court') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="horizontalBarChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3 d-flex" id="lineChartCard">
            <div class="card flex-fill shadow-sm rounded">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--bs-warning), rgba(0,0,0,0.1));">
                    <h5 class="card-title mb-0">{{ __('dashboard.sms_trend_over_time') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title">{{ __('dashboard.court_sms_summary') }}</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="smsTable" class="table table-bordered table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('dashboard.division') }}</th>
                                <th>{{ __('dashboard.district') }}</th>
                                <th>{{ __('dashboard.court') }}</th>
                                <th>{{ __('dashboard.total_sms') }}</th>
                                <th>{{ __('dashboard.sent') }}</th>
                                <th>{{ __('dashboard.pending') }}</th>
                                <th>{{ __('dashboard.failed') }}</th>
                                <th>{{ __('dashboard.witness_appeared') }}</th>
                                <th>{{ __('dashboard.cases_rescheduled') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
.kpi-card-modern { cursor:pointer; }
.kpi-card-modern:hover { transform: translateY(-6px); box-shadow: 0 12px 25px rgba(0,0,0,0.25); }
.kpi-icon i { color: #fff; }
.table-status-badge { padding: 0.25rem 0.5rem; border-radius: 0.35rem; color: #fff; font-size: 0.85rem; display:inline-block; text-align:center;}
.table-status-success { background: var(--bs-success); }
.table-status-warning { background: var(--bs-warning); }
.table-status-danger { background: var(--bs-danger); }
.table-status-primary { background: var(--bs-primary); }
.table-status-secondary { background: var(--bs-secondary); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locale = '{{ app()->getLocale() }}';
    const divisionSelect = document.getElementById('filterDivision');
    const districtSelect = document.getElementById('filterDistrict');
    const courtSelect = document.getElementById('filterCourt');
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const btnFilter = document.getElementById('btnFilter');
    const userDivision = '{{ $user->division_id ?? '' }}';
    const userDistrict = '{{ $user->district_id ?? '' }}';
    const userCourt = '{{ $user->court_id ?? '' }}';

    function fetchDistricts(divisionId, selected = 0) {
        courtSelect.innerHTML = `<option>{{ __('dashboard.select_district_first') }}</option>`;
        if (!divisionId) return Promise.resolve();
        return fetch(`/admin/divisions/${divisionId}/districts`)
            .then(res => res.json())
            .then(data => {
                districtSelect.innerHTML = `<option value="">{{ __('dashboard.all_districts') }}</option>`;
                data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    let name = locale === 'bn' ? (Array.isArray(d.name_bn) ? d.name_bn.join(', ') : d.name_bn) : (Array.isArray(d.name_en) ? d.name_en.join(', ') : d.name_en);
                    opt.textContent = name;
                    if (selected == d.id) opt.selected = true;
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
                courtSelect.innerHTML = `<option value="">{{ __('dashboard.all_courts') }}</option>`;
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    let name = locale === 'bn' ? (Array.isArray(c.name_bn) ? c.name_bn.join(', ') : c.name_bn) : (Array.isArray(c.name_en) ? c.name_en.join(', ') : c.name_en);
                    opt.textContent = name;
                    if (selected == c.id) opt.selected = true;
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
                        loadMetrics();
                    });
                } else loadMetrics();
            });
        } else loadMetrics();
    }

    divisionSelect?.addEventListener('change', function() { fetchDistricts(this.value); });
    districtSelect?.addEventListener('change', function() { fetchCourts(this.value); });
    btnFilter.addEventListener('click', loadMetrics);

    let pieChart, barChart, doughnutChart, horizontalBarChart, lineChart;

    function animateCounter(element, value) {
        let start = 0;
        const duration = 1000;
        const increment = value / (duration / 16);
        function step() {
            start += increment;
            if (start < value) {
                element.textContent = Math.floor(start);
                requestAnimationFrame(step);
            } else element.textContent = value;
        }
        requestAnimationFrame(step);
    }

    function loadMetrics() {
        const params = new URLSearchParams({
            division_id: divisionSelect.value,
            district_id: districtSelect.value,
            court_id: courtSelect.value,
            from_date: fromDate.value,
            to_date: toDate.value
        });

        fetch(`{{ route('admin.reports.court_sms_dashboard.data') }}?${params.toString()}`)
            .then(res => res.json())
            .then(res => {
                const data = res.summary;
                const totalCases = res.total_cases || 0;
                const tbody = document.querySelector('#smsTable tbody');
                tbody.innerHTML = '';
                let totalSms = 0, sent = 0, pending = 0, failed = 0, appeared = 0, rescheduled = 0;

                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="9" class="text-center">{{ __('dashboard.no_data_found') }}</td></tr>`;
                }

                data.forEach(row => {
                    tbody.innerHTML += `<tr>
                        <td>${row.division}</td>
                        <td>${row.district}</td>
                        <td>${row.court}</td>
                        <td><span class="table-status-badge table-status-primary">${row.total_sms_sent}</span></td>
                        <td><span class="table-status-badge table-status-success">${row.sent}</span></td>
                        <td><span class="table-status-badge table-status-warning">${row.pending}</span></td>
                        <td><span class="table-status-badge table-status-danger">${row.failed}</span></td>
                        <td><span class="table-status-badge table-status-success">${row.witness_appeared}</span></td>
                        <td><span class="table-status-badge table-status-secondary">${row.rescheduled_cases}</span></td>
                    </tr>`;
                    totalSms += row.total_sms_sent;
                    sent += row.sent;
                    pending += row.pending;
                    failed += row.failed;
                    appeared += row.witness_appeared;
                    rescheduled += row.rescheduled_cases;
                });

                // Animate counters
                animateCounter(document.getElementById('totalCases'), totalCases);
                animateCounter(document.getElementById('totalSms'), totalSms);
                animateCounter(document.getElementById('sentSms'), sent);
                animateCounter(document.getElementById('pendingSms'), pending);
                animateCounter(document.getElementById('failedSms'), failed);
                animateCounter(document.getElementById('appeared'), appeared);
                animateCounter(document.getElementById('rescheduled'), rescheduled);

                renderCharts(data);
            })
            .catch(err => console.error(err));
    }

    function renderCharts(data) {
        const labels = ['{{ __("dashboard.sent") }}','{{ __("dashboard.pending") }}','{{ __("dashboard.failed") }}'];
        const colors = ['#28a745','#ffc107','#dc3545'];
        const totalSent = data.reduce((a,b)=>a+b.sent,0);
        const totalPending = data.reduce((a,b)=>a+b.pending,0);
        const totalFailed = data.reduce((a,b)=>a+b.failed,0);

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        if(pieChart) pieChart.destroy();
        pieChart = new Chart(pieCtx,{
            type:'pie',
            data:{labels:labels,datasets:[{data:[totalSent,totalPending,totalFailed],backgroundColor:colors}]},
            options:{responsive:true,plugins:{legend:{position:'bottom',labels:{boxWidth:20}}}}
        });

        const courts = data.map(d=>d.court);
        const sentData = data.map(d=>d.sent);
        const pendingData = data.map(d=>d.pending);
        const failedData = data.map(d=>d.failed);

        const barCtx = document.getElementById('barChart').getContext('2d');
        if(barChart) barChart.destroy();
        barChart = new Chart(barCtx,{
            type:'bar',
            data:{
                labels:courts,
                datasets:[
                    {label:'{{ __("dashboard.sent") }}',data:sentData,backgroundColor:'#28a745'},
                    {label:'{{ __("dashboard.pending") }}',data:pendingData,backgroundColor:'#ffc107'},
                    {label:'{{ __("dashboard.failed") }}',data:failedData,backgroundColor:'#dc3545'}
                ]
            },
            options:{responsive:true,plugins:{legend:{position:'top'}},scales:{y:{beginAtZero:true}}}
        });

        const appearedData = data.map(d=>d.witness_appeared);
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        if(doughnutChart) doughnutChart.destroy();
        doughnutChart = new Chart(doughnutCtx,{
            type:'doughnut',
            data:{labels:courts,datasets:[{data:appearedData,backgroundColor:colors}]},
            options:{responsive:true,plugins:{legend:{position:'bottom'}}}
        });

        const rescheduledData = data.map(d=>d.rescheduled_cases);
        const hBarCtx = document.getElementById('horizontalBarChart').getContext('2d');
        if(horizontalBarChart) horizontalBarChart.destroy();
        horizontalBarChart = new Chart(hBarCtx,{
            type:'bar',
            data:{labels:courts,datasets:[{label:'{{ __("dashboard.cases_rescheduled") }}',data:rescheduledData,backgroundColor:'#6c757d'}]},
            options:{indexAxis:'y',responsive:true,plugins:{legend:{display:false}},scales:{x:{beginAtZero:true}}}
        });

        // Hide line chart if court selected
        const lineCard = document.getElementById('lineChartCard');
        if(courtSelect.value) { lineCard.style.display='none'; } else { lineCard.style.display='flex'; }
    }

    // Initialize filters + auto-load
    initFilters();
});
</script>
@endpush
