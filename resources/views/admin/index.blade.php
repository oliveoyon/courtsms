@extends('dashboard.layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">CourtSMS Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <!-- KPI Cards -->
        <div class="row g-3">
            <div class="col-md-3 col-sm-6">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Divisions</h5>
                            <h3>{{ $divisionsCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-grid-1x2-fill fs-1"></i>
                    </div>
                    <div class="card-footer text-white-50">Total Divisions</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Districts</h5>
                            <h3>{{ $districtsCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-geo-alt-fill fs-1"></i>
                    </div>
                    <div class="card-footer text-white-50">Total Districts</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Courts</h5>
                            <h3>{{ $courtsCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-bank fs-1"></i>
                    </div>
                    <div class="card-footer text-white-50">Total Courts</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card text-white bg-info shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Users (Staff)</h5>
                            <h3>{{ $usersCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                    <div class="card-footer text-white-50">Total Staff</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        {{-- <div class="row mt-4 g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Monthly SMS Trends</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="120"></canvas>
                    </div>
                </div>

                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Top Districts by Appeared</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barDistricts" height="80"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Outcome Distribution</h5>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center">
                        <canvas id="outcomePie" width="200" height="200"></canvas>
                        <small class="text-muted mt-2">Overview of recipient responses</small>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Recent SMS Logs Table -->
        {{-- <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Recent SMS Logs</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="smsTable" class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Court</th>
                                        <th>District</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th>Appeared</th>
                                        <th>Sent At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSms as $s)
                                        <tr>
                                            <td>{{ $s->id }}</td>
                                            <td>{{ $s->court }}</td>
                                            <td>{{ $s->district }}</td>
                                            <td>{{ $s->to }}</td>
                                            <td>{{ $s->status }}</td>
                                            <td>{{ $s->appeared }}</td>
                                            <td>{{ $s->sent_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    const monthly = @json($monthly);
    const outcomes = @json($outcomes);
    const topDistricts = @json($topDistricts);

    const labels = monthly.map(m => m.label);
    const sentData = monthly.map(m => m.sent);
    const deliveredData = monthly.map(m => m.delivered);
    const appearedData = monthly.map(m => m.appeared);

    new Chart(document.getElementById('monthlyChart').getContext('2d'), {
        type: 'line',
        data: { labels: labels, datasets: [
            { label: 'Sent', data: sentData, borderColor: 'rgba(0,123,255,0.7)', backgroundColor: 'transparent', tension:0.3 },
            { label: 'Delivered', data: deliveredData, borderColor: 'rgba(40,167,69,0.7)', backgroundColor: 'transparent', tension:0.3 },
            { label: 'Appeared', data: appearedData, borderColor: 'rgba(255,193,7,0.7)', backgroundColor: 'rgba(255,193,7,0.3)', tension:0.3, fill:true }
        ]},
        options: { responsive: true, interaction: { mode: 'index', intersect: false }, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('barDistricts').getContext('2d'), {
        type: 'bar',
        data: { labels: topDistricts.map(d => d.name), datasets: [{ label: 'Appeared', data: topDistricts.map(d => d.appeared), backgroundColor: 'rgba(0,123,255,0.7)' }]},
        options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
    });

    new Chart(document.getElementById('outcomePie').getContext('2d'), {
        type: 'doughnut',
        data: { labels: Object.keys(outcomes), datasets: [{ data: Object.values(outcomes), backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545'] }]},
        options: { responsive:true, plugins:{legend:{position:'bottom'}} }
    });

    $(document).ready(function(){ $('#smsTable').DataTable({ pageLength:10, lengthChange:false, order:[[0,'desc']] }); });
</script>
@endpush

@endsection