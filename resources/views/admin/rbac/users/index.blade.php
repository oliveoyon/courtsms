@extends('dashboard.layouts.admin')
@section('title', 'Users List')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center justify-content-start gap-2">
                    <h3 class="mb-0">Users</h3>
                    @can('Create Users')
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-lg"></i> Create User
                        </a>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">

                <form method="GET" class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Search -->
                            <div class="col-md-3">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                    placeholder="Search name, email, phone">
                            </div>

                            <!-- Role -->
                            <div class="col-md-2">
                                <select name="role" class="form-select">
                                    <option value="">All Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @selected(request('role') == $role->name)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" @selected(request('status') == 'active')>Active</option>
                                    <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <!-- Division -->
                            <div class="col-md-2">
                                <select name="division_id" id="division" class="form-select"
                                    {{ auth()->user()->division_id ? 'disabled' : '' }}>
                                    <option value="">All Divisions</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ (request('division_id') ?? auth()->user()->division_id) == $division->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() === 'bn' ? $division->name_bn : $division->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(auth()->user()->division_id)
                                    <input type="hidden" name="division_id" value="{{ auth()->user()->division_id }}">
                                @endif
                            </div>

                            <!-- District -->
                            <div class="col-md-2">
                                <select name="district_id" id="district" class="form-select"
                                    {{ auth()->user()->district_id ? 'disabled' : '' }}>
                                    <option value="">All Districts</option>
                                    @if(auth()->user()->division_id)
                                        @php
                                            $division = $divisions->firstWhere('id', auth()->user()->division_id);
                                        @endphp
                                        @foreach($division->districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ (request('district_id') ?? auth()->user()->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if(auth()->user()->district_id)
                                    <input type="hidden" name="district_id" value="{{ auth()->user()->district_id }}">
                                @endif
                            </div>

                            <!-- Court -->
                            <div class="col-md-1">
                                <select name="court_id" id="court" class="form-select"
                                    {{ auth()->user()->court_id ? 'disabled' : '' }}>
                                    <option value="">All Courts</option>
                                    @if(auth()->user()->district_id)
                                        @php
                                            $district = $divisions->flatMap(fn($d) => $d->districts)
                                                ->firstWhere('id', auth()->user()->district_id);
                                        @endphp
                                        @foreach($district->courts as $court)
                                            <option value="{{ $court->id }}"
                                                {{ (request('court_id') ?? auth()->user()->court_id) == $court->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() === 'bn' ? $court->name_bn : $court->name_en }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if(auth()->user()->court_id)
                                    <input type="hidden" name="court_id" value="{{ auth()->user()->court_id }}">
                                @endif
                            </div>

                            <div class="col-md-12 d-flex gap-2">
                                <button class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </div>
                </form>

                @foreach ($users as $user)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border-0 user-card h-100 position-relative">
                            <!-- Status Accent Bar -->
                            <div class="status-bar position-absolute w-100"
                                style="height:6px; background: {{ $user->is_active ? '#28a745' : '#dc3545' }}; top:0; left:0; border-top-left-radius:0.8rem; border-top-right-radius:0.8rem;">
                            </div>

                            <div class="card-body d-flex flex-column justify-content-between">
                                <!-- User Info -->
                                <div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-1">{{ $user->name }}</h5>
                                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1">{{ $user->email }}</p>
                                    <p class="text-muted mb-2">{{ $user->phone_number ?? 'N/A' }}</p>

                                    <!-- Roles -->
                                    <div class="mb-2">
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-primary me-1 mb-1">{{ $role->name }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    @can('View User Permissions')
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#permissionsModal-{{ $user->id }}">
                                                View Permissions
                                                <span class="badge bg-light text-dark">{{ $user->permissions->count() }}</span>
                                            </button>
                                        </div>
                                    @endcan

                                    <div class="d-flex gap-2">
                                        @can('Edit Users')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endcan
                                        @can('Delete Users')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-user"
                                                data-id="{{ $user->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        @endcan
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Permissions Modal -->
                        <div class="modal fade" id="permissionsModal-{{ $user->id }}" tabindex="-1"
                            aria-labelledby="permissionsModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="permissionsModalLabel-{{ $user->id }}">
                                            Permissions for {{ $user->name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $grouped = $user->permissions->groupBy(function ($perm) {
                                                return optional($perm->group)->name ?? 'Ungrouped';
                                            });
                                        @endphp
                                        @foreach ($grouped as $groupName => $permissions)
                                            <div class="mb-3">
                                                <h6 class="text-primary">{{ $groupName }}</h6>
                                                @foreach ($permissions as $permission)
                                                    <span
                                                        class="badge bg-secondary me-1 mb-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

                {{ $users->links() }}
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .user-card {
                border-radius: 0.8rem;
                transition: transform 0.3s, box-shadow 0.3s;
                cursor: pointer;
            }

            .user-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
            }

            .card-title {
                font-weight: 600;
                font-size: 1.1rem;
            }

            .badge {
                font-size: 0.8rem;
                padding: 0.35em 0.65em;
            }

            .status-bar {
                z-index: 1;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Delete user
                document.querySelectorAll('.delete-user').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const userId = this.dataset.id;
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This user will be deleted permanently!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch("{{ url('admin/users') }}/" + userId, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    }).then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            Swal.fire('Deleted!', res.success, 'success')
                                                .then(() => location.reload());
                                        } else {
                                            Swal.fire('Error', 'Something went wrong!',
                                                'error');
                                        }
                                    }).catch(err => {
                                        Swal.fire('Error', 'Something went wrong!',
                                        'error');
                                        console.error(err);
                                    });
                            }
                        });
                    });
                });

            });
        </script>

        <script>
            const divisions = @json($divisions);
            const locale = '{{ app()->getLocale() }}';

            const divisionEl = document.getElementById('division');
            const districtEl = document.getElementById('district');
            const courtEl = document.getElementById('court');

            function populateDistricts() {
                districtEl.innerHTML = `<option value="">${locale === 'bn' ? 'সব জেলা' : 'All Districts'}</option>`;
                courtEl.innerHTML = `<option value="">${locale === 'bn' ? 'সব আদালত' : 'All Courts'}</option>`;

                const division = divisions.find(d => d.id == divisionEl.value);
                if (!division) return;

                division.districts.forEach(d => {
                    const name = locale === 'bn' ? d.name_bn : d.name_en;
                    districtEl.innerHTML += `<option value="${d.id}">${name}</option>`;
                });

                districtEl.value = "{{ request('district_id') }}";
                populateCourts();
            }

            function populateCourts() {
                courtEl.innerHTML = `<option value="">${locale === 'bn' ? 'সব আদালত' : 'All Courts'}</option>`;

                const division = divisions.find(d => d.id == divisionEl.value);
                const district = division?.districts.find(d => d.id == districtEl.value);
                if (!district) return;

                district.courts.forEach(c => {
                    const name = locale === 'bn' ? c.name_bn : c.name_en;
                    courtEl.innerHTML += `<option value="${c.id}">${name}</option>`;
                });

                courtEl.value = "{{ request('court_id') }}";
            }

            if (!divisionEl.disabled) divisionEl?.addEventListener('change', populateDistricts);
            if (!districtEl.disabled) districtEl?.addEventListener('change', populateCourts);

            document.addEventListener('DOMContentLoaded', populateDistricts);
        </script>
    @endpush
@endsection
