@extends('dashboard.layouts.admin')
@section('title', 'Court Appearance Panel')

@section('content')
<div class="app-content-header py-3">
    <div class="container-fluid">
        <h3 class="mb-0 page-title">Court Appearance Panel</h3>
    </div>
</div>

<div class="app-content py-3">
    <div class="container-fluid">

        {{-- Filter --}}
        <div class="card mb-4">
            <div class="card-body">
                <form id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('case.division') }}</label>
                        <select name="division_id" id="division_id" class="form-select">
                            <option value="">{{ __('case.select_division') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">
                                    {{ app()->getLocale() === 'bn' ? $division->name_bn : $division->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">{{ __('case.district') }}</label>
                        <select name="district_id" id="district_id" class="form-select">
                            <option value="">{{ __('case.select_district') }}</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">{{ __('case.court') }}</label>
                        <select name="court_id" id="court_id" class="form-select">
                            <option value="">{{ __('case.select_court') }}</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" id="filter_date" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Fetch Cases</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Cases Container --}}
        <div id="casesContainer" class="row g-3">
            {{-- AJAX will populate cards here --}}
        </div>

    </div>
</div>

{{-- Reschedule Modal --}}
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form id="rescheduleForm" class="modal-content">
            @csrf
            <input type="hidden" id="rescheduleWitnessId">
            <div class="modal-header">
                <h5 class="modal-title">Reschedule Appearance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="reschedule_date" class="form-label">Select New Date</label>
                <input type="date" id="reschedule_date" name="reschedule_date" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const courtSelect = document.getElementById('court_id');
    const casesContainer = document.getElementById('casesContainer');
    const filterForm = document.getElementById('filterForm');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Dependent Dropdowns
    divisionSelect?.addEventListener('change', function() {
        const divisionId = this.value;
        districtSelect.innerHTML = '<option value="">Select District</option>';
        courtSelect.innerHTML = '<option value="">Select Court</option>';
        if (!divisionId) return;
        fetch(`{{ url('admin/divisions') }}/${divisionId}/districts`)
            .then(res => res.json())
            .then(data => data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = d.name_en;
                districtSelect.appendChild(opt);
            }));
    });

    districtSelect?.addEventListener('change', function() {
        const districtId = this.value;
        courtSelect.innerHTML = '<option value="">Select Court</option>';
        if (!districtId) return;
        fetch(`{{ url('admin/districts') }}/${districtId}/courts`)
            .then(res => res.json())
            .then(data => data.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.name_en;
                courtSelect.appendChild(opt);
            }));
    });

    // Fetch Cases
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('{{ route("admin.court-appearance.fetch") }}', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (!data.length) {
                html = '<div class="alert alert-info">No cases found for selected filters.</div>';
            } else {
                data.forEach(item => {
                    html += `
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    Case: ${item.case_no} | Court: ${item.court_name}
                                </div>
                                <ul class="list-group list-group-flush">
                                    ${item.witnesses.map(w => `
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>${w.name}</strong> <br>
                                                <small>${w.phone}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="btn-group btn-group-sm me-2" role="group">
                                                    ${['pending','appeared','absent','excused'].map(status => `
                                                        <input type="radio" class="btn-check" 
                                                            name="status_${w.id}" 
                                                            id="status_${w.id}_${status}" 
                                                            value="${status}" 
                                                            ${w.appeared_status === status ? 'checked' : ''}>
                                                        <label class="btn btn-outline-primary btn-sm" 
                                                            for="status_${w.id}_${status}"
                                                            onclick="updateStatus(${w.id}, '${status}')">
                                                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                                                        </label>
                                                    `).join('')}
                                                </div>
                                                <button class="btn btn-warning btn-sm" onclick="openReschedule(${w.id})">Reschedule</button>
                                            </div>
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                        </div>
                    `;
                });
            }
            casesContainer.innerHTML = html;
        });
    });

    // Update status AJAX
    window.updateStatus = function(witnessId, status) {
        fetch(`{{ url('admin/court-appearance') }}/${witnessId}/update-status`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({status})
        }).then(res => res.json())
          .then(data => Swal.fire('Success', data.message, 'success'));
    }

    // Reschedule Modal
    const rescheduleModalEl = document.getElementById('rescheduleModal');
    const rescheduleModal = new bootstrap.Modal(rescheduleModalEl);
    const rescheduleForm = document.getElementById('rescheduleForm');
    const rescheduleDate = document.getElementById('reschedule_date');
    const rescheduleWitnessId = document.getElementById('rescheduleWitnessId');

    window.openReschedule = function(witnessId) {
        rescheduleWitnessId.value = witnessId;
        rescheduleDate.value = '';
        rescheduleModal.show();
    }

    rescheduleForm.addEventListener('submit', function(e){
        e.preventDefault();
        fetch(`{{ url('admin/court-appearance') }}/${rescheduleWitnessId.value}/update-status`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({reschedule_date: rescheduleDate.value})
        }).then(res => res.json())
          .then(data => {
              rescheduleModal.hide();
              Swal.fire('Success', data.message, 'success');
          });
    });
});
</script>
@endpush
