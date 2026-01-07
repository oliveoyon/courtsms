@extends('dashboard.layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
@php
    // Logged-in user's scope
    $myDivision = auth()->user()->division_id;
    $myDistrict = auth()->user()->district_id;
    $myCourt = auth()->user()->court_id;

    // Editable user's existing data
    $editableDivision = $user->division_id ?? null;
    $editableDistrict = $user->district_id ?? null;
    $editableCourt = $user->court_id ?? null;
@endphp

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">{{ isset($user) ? 'Edit User' : 'Create User' }}</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ isset($user) ? 'Edit User' : 'Create User' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12">
                <form id="user-form"
                    action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif

                    <!-- Basic Info -->
                    <div class="card mb-4 shadow-sm border-start border-success border-4">
                        <div class="card-header bg-light fw-semibold">Basic Information</div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email ?? '') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $user->phone_number ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            {{ isset($user) && $user->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>

                            <!-- Division / District / Court -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('case.division') }}</label>
                                    <select name="division_id" id="division_id" class="form-select"
                                        {{ $myDivision ? 'disabled' : '' }}>
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ old('division_id', $editableDivision) == $division->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() === 'bn' ? $division->name_bn : $division->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('case.district') }}</label>
                                    <select name="district_id" id="district_id" class="form-select"
                                        {{ $myDistrict ? 'disabled' : '' }}>
                                        <option value="">Select District</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('case.court') }}</label>
                                    <select name="court_id" id="court_id" class="form-select"
                                        {{ $myCourt ? 'disabled' : '' }}>
                                        <option value="">Select Court</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="card mb-4 shadow-sm border-start border-success border-4">
                        <div class="card-header bg-light fw-semibold">Assign Roles</div>
                        <div class="card-body d-flex flex-wrap gap-2">
                            @foreach ($roles as $role)
                                <input type="checkbox" class="btn-check" id="role-{{ $role->id }}" name="roles[]"
                                    value="{{ $role->name }}" autocomplete="off"
                                    {{ isset($userRoles) && in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                <label class="btn btn-outline-success" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="card mb-4 shadow-sm border-start border-success border-4">
                        <div class="card-header bg-light fw-semibold">Assign Permissions</div>
                        <div class="card-body">
                            @foreach ($permissionGroups as $group)
                                <div class="card mb-2" style="background-color: #f0f9f0;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <strong>{{ $group->name }}</strong>
                                        <div>
                                            <input type="checkbox" class="select-all" data-group="{{ $group->id }}"> Select All
                                            <span class="badge bg-secondary" id="count-{{ $group->id }}">0</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($group->permissions as $permission)
                                            @php
                                                $isDirect = in_array($permission->name, $directPermissions ?? []);
                                                $isViaRole = isset($user) && $user->hasPermissionTo($permission->name) && !$isDirect;
                                                $isChecked = $isDirect || $isViaRole;
                                                $isDisabled = $isViaRole ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="form-check-input permission-checkbox group-{{ $group->id }}"
                                                    type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" {{ $isChecked ? 'checked' : '' }}
                                                    {{ $isDisabled }}>
                                                <label class="form-check-label">
                                                    {{ $permission->name }} @if ($isViaRole && !$isDirect)
                                                        <small class="text-muted">(via role)</small>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="btn btn-success">{{ isset($user) ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Permission counts & select all ---
    function updateCount(groupId) {
        const count = Array.from(document.querySelectorAll('.group-' + groupId + ':checked'))
            .filter(cb => !cb.disabled).length;
        document.getElementById('count-' + groupId).textContent = count;
    }

    document.querySelectorAll('.select-all').forEach(toggle => updateCount(toggle.dataset.group));

    document.querySelectorAll('.select-all').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const groupId = this.dataset.group;
            const checked = this.checked;
            document.querySelectorAll('.group-' + groupId).forEach(cb => {
                if (!cb.disabled) cb.checked = checked;
            });
            updateCount(groupId);
        });
    });

    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const groupClass = Array.from(this.classList).find(c => c.startsWith('group-'));
            if (groupClass) updateCount(groupClass.split('-')[1]);
        });
    });

    // --- Dynamic role permissions ---
    const form = document.getElementById('user-form');
    const roleUrlTemplate = "{{ url('admin/roles/ROLE_ID/permissions') }}";
    document.querySelectorAll('input[name="roles[]"]').forEach(roleCb => {
        roleCb.addEventListener('change', function() {
            const selectedRoles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked')).map(cb => cb.value);
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
            if (!selectedRoles.length) return;
            selectedRoles.forEach(roleName => {
                fetch(roleUrlTemplate.replace('ROLE_ID', roleName))
                    .then(res => res.json())
                    .then(data => {
                        data.rolePermissions.forEach(pid => {
                            const cb = document.querySelector('.permission-checkbox[value="' + data.permissions.find(p => p.id == pid).name + '"]');
                            if(cb) cb.checked = true;
                        });
                        document.querySelectorAll('.select-all').forEach(t => updateCount(t.dataset.group));
                    })
                    .catch(err => console.error(err));
            });
        });
    });

    // --- Division → District → Court dependency ---
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const courtSelect = document.getElementById('court_id');

    const editableDivision = "{{ $editableDivision }}";
    const editableDistrict = "{{ $editableDistrict }}";
    const editableCourt = "{{ $editableCourt }}";

    function loadDistricts(divisionId, selectedDistrictId = null) {
        districtSelect.innerHTML = '<option value="">Select District</option>';
        courtSelect.innerHTML = '<option value="">Select Court</option>';
        if (!divisionId) return;

        fetch('{{ url('admin/divisions') }}/' + divisionId + '/districts')
            .then(res => res.json())
            .then(data => {
                data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name_en;
                    if (d.id == selectedDistrictId) opt.selected = true;
                    districtSelect.appendChild(opt);
                });
                if (selectedDistrictId) loadCourts(selectedDistrictId, editableCourt);
            });
    }

    function loadCourts(districtId, selectedCourtId = null) {
        courtSelect.innerHTML = '<option value="">Select Court</option>';
        if (!districtId) return;

        fetch('{{ url('admin/districts') }}/' + districtId + '/courts')
            .then(res => res.json())
            .then(data => {
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name_en;
                    if (c.id == selectedCourtId) opt.selected = true;
                    courtSelect.appendChild(opt);
                });
            });
    }

    if(editableDivision) loadDistricts(editableDivision, editableDistrict);

    divisionSelect.addEventListener('change', function() {
        loadDistricts(this.value);
    });

    districtSelect.addEventListener('change', function() {
        loadCourts(this.value);
    });

    // --- AJAX form submission ---
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;

        const formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            submitBtn.disabled = false;
            if(res.success) {
                Swal.fire('Success', res.success, 'success')
                    .then(() => window.location.href = "{{ route('admin.users.index') }}");
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            Swal.fire('Error', 'Something went wrong!', 'error');
            console.error(err);
        });
    });

});
</script>
@endpush
@endsection
