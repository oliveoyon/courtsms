@extends('dashboard.layouts.admin')
@section('title', __('case.create_case_send'))

@section('content')
<div class="app-content">
    <div class="container-fluid">
        <form id="caseForm">
            @csrf

            <!-- Case Details -->
            <div class="card card-body mb-3">
                <h5>{{ __('case.case_details') }}</h5>
                <div class="row g-3 mt-3">
                    <!-- Division -->
                    <div class="col-md-4">
                        <label class="form-label">{{ __('case.division') }}</label>
                        <select name="division_id" id="division_id" class="form-select"
                            {{ isset($user) && $user->division_id ? 'disabled' : '' }}>
                            <option value="">{{ __('case.select_division') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id', $user->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'bn' ? $division->name_bn : $division->name_en }}
                                </option>
                            @endforeach
                        </select>
                        @if (isset($user) && $user->division_id)
                            <input type="hidden" name="division_id" value="{{ $user->division_id }}">
                        @endif
                    </div>

                    <!-- District -->
                    <div class="col-md-4">
                        <label class="form-label">{{ __('case.district') }}</label>
                        <select name="district_id" id="district_id" class="form-select"
                            {{ isset($user) && $user->district_id ? 'disabled' : '' }}>
                            <option value="">{{ __('case.select_district') }}</option>
                            @if (isset($user) && $user->division)
                                @foreach ($user->division->districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if (isset($user) && $user->district_id)
                            <input type="hidden" name="district_id" value="{{ $user->district_id }}">
                        @endif
                    </div>

                    <!-- Court -->
                    <div class="col-md-4">
                        <label class="form-label">{{ __('case.court') }}</label>
                        <select name="court_id" id="court_id" class="form-select"
                            {{ isset($user) && $user->court_id ? 'disabled' : '' }}>
                            <option value="">{{ __('case.select_court') }}</option>
                            @if (isset($user) && $user->district)
                                @foreach ($user->district->courts as $court)
                                    <option value="{{ $court->id }}"
                                        {{ old('court_id', $user->court_id) == $court->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() === 'bn' ? $court->name_bn : $court->name_en }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if (isset($user) && $user->court_id)
                            <input type="hidden" name="court_id" value="{{ $user->court_id }}">
                        @endif
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label>{{ __('case.case_no') }}</label>
                        <input type="text" name="case_no" class="form-control form-control-sm" id="caseNo"
                            required>
                    </div>

                    <div class="col-md-2">
                        <label>{{ __('case.hearing_date') }}</label>
                        <input type="date" name="hearing_date" class="form-control form-control-sm" id="hearingDate"
                            required>
                    </div>
                    <div class="col-md-2">
                        <label>{{ __('case.hearing_time') }}</label>
                        <input type="time" name="hearing_time" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="mt-2">
                    <label>{{ __('case.notes') }}</label>
                    <textarea name="notes" class="form-control form-control-sm"></textarea>
                </div>
            </div>

            <!-- Witnesses -->
            <div class="card card-body mb-3">
                <h5>{{ __('case.witnesses') }}</h5>
                <table class="table table-bordered table-sm" id="witnessTable">
                    <thead>
                        <tr>
                            <th>{{ __('case.name') }}</th>
                            <th>{{ __('case.phone') }}</th>
                            <th>
                                <button type="button" id="addRow" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="witnesses[0][name]"
                                    class="form-control form-control-sm witnessName" required></td>
                            <td><input type="text" name="witnesses[0][phone]"
                                    class="form-control form-control-sm witnessPhone" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow"><i
                                        class="bi bi-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Schedule -->
            <div class="card card-body mb-3">
                <h5>{{ __('case.schedule') }}</h5>
                <div class="btn-group" role="group" aria-label="Schedule buttons">
                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched10" value="10_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched10">{{ __('case.10_days_before') }}</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched3" value="3_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched3">{{ __('case.3_days_before') }}</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="schedNow" value="send_now">
                    <label class="btn btn-outline-success btn-sm" for="schedNow">{{ __('case.send_now') }}</label>
                </div>
            </div>

            <div class="card card-body mb-3">
                <h5>{{ __('case.preview_message') }}</h5>
                <div id="previewMessage" class="border p-2 bg-light">{{ __('case.enter_preview') }}</div>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm">{{ __('case.submit_send') }}</button>
        </form>
    </div>
</div>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const courtSelect = document.getElementById('court_id');

    divisionSelect?.addEventListener('change', function() {
        const divisionId = this.value;
        districtSelect.innerHTML = '<option value="">Select District</option>';
        courtSelect.innerHTML = '<option value="">Select Court</option>';
        if (!divisionId) return;
        fetch('{{ url('admin/divisions') }}/' + divisionId + '/districts')
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
        fetch('{{ url('admin/districts') }}/' + districtId + '/courts')
            .then(res => res.json())
            .then(data => data.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.name_en;
                courtSelect.appendChild(opt);
            }));
    });

    // Witness rows
    let rowIndex = 1;
    let isSubmitting = false;

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.querySelector('#witnessTable tbody');
        tbody.insertAdjacentHTML('beforeend', `<tr>
            <td><input type="text" name="witnesses[${rowIndex}][name]" class="form-control form-control-sm witnessName" required></td>
            <td><input type="text" name="witnesses[${rowIndex}][phone]" class="form-control form-control-sm witnessPhone" required></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
        </tr>`);
        rowIndex++;
        updatePreview();
    });

    document.querySelector('#witnessTable').addEventListener('click', function(e) {
        if (e.target.closest('.removeRow')) {
            e.target.closest('tr').remove();
            updatePreview();
        }
    });

    // Preview using static template ID 1
    const template = @json($templates->firstWhere('id', 1));
    const lang = 'en'; // or 'bn'

    // Convert 24-hour time to 12-hour AM/PM
    function formatAMPM(time24) {
        if (!time24) return '';
        let [h, m] = time24.split(':').map(Number);
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        return `${h}:${m.toString().padStart(2,'0')} ${ampm}`;
    }

    function updatePreview() {
        if (!template) {
            document.getElementById('previewMessage').innerHTML = 'Template not found.';
            return;
        }

        const caseNo = document.getElementById('caseNo').value || '';
        const date = document.getElementById('hearingDate').value || '';
        const time = document.querySelector('input[name="hearing_time"]')?.value || '';
        const timeFormatted = formatAMPM(time); // use AM/PM format
        let html = '';

        document.querySelectorAll('.witnessName').forEach((input, idx) => {
            const name = input.value || '{witness_name}';
            let msgSMS = '', msgWA = '';

            if (lang === 'en') {
                msgSMS = template.body_en_sms || '';
                msgWA  = template.body_en_whatsapp || '';
            } else {
                msgSMS = template.body_bn_sms || '';
                msgWA  = template.body_bn_whatsapp || '';
            }

            // Replace placeholders
            msgSMS = msgSMS.replace(/{witness_name}/g, name)
                           .replace(/{case_no}/g, caseNo)
                           .replace(/{hearing_date}/g, date)
                           .replace(/{hearing_time}/g, timeFormatted);

            msgWA  = msgWA.replace(/{witness_name}/g, name)
                          .replace(/{case_no}/g, caseNo)
                          .replace(/{hearing_date}/g, date)
                          .replace(/{hearing_time}/g, timeFormatted);

            if (template.channel === 'both') {
                html += `<strong>Witness ${idx+1} - SMS:</strong> ${msgSMS}<br>`;
                html += `<strong>Witness ${idx+1} - WhatsApp:</strong> ${msgWA}<br><br>`;
            } else if (template.channel === 'sms') {
                html += `<strong>Witness ${idx+1} - SMS:</strong> ${msgSMS}<br><br>`;
            } else if (template.channel === 'whatsapp') {
                html += `<strong>Witness ${idx+1} - WhatsApp:</strong> ${msgWA}<br><br>`;
            }
        });

        document.getElementById('previewMessage').innerHTML = html || 'Enter details to see preview.';
    }

    ['input','change'].forEach(evt => {
        document.getElementById('caseNo').addEventListener(evt, updatePreview);
        document.getElementById('hearingDate').addEventListener(evt, updatePreview);
        document.querySelector('input[name="hearing_time"]').addEventListener(evt, updatePreview);
        document.querySelector('#witnessTable').addEventListener(evt, updatePreview);
    });

    // Submit form
    document.getElementById('caseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (isSubmitting) return;

        const formData = new FormData(this);
        if (!formData.get('division_id') || !formData.get('district_id') || !formData.get('court_id')) {
            Swal.fire('Error', 'Please select Division, District, and Court.', 'error');
            return;
        }

        const phoneInputs = document.querySelectorAll('.witnessPhone');
        for (const inp of phoneInputs) {
            const val = inp.value.trim();
            if (!/^(01)\d{9}$/.test(val)) {
                Swal.fire('Error', 'Phone number must be 11 digits, start with 01, and numeric.', 'error');
                inp.focus();
                return;
            }
        }

        if (document.querySelectorAll('input[name="schedules[]"]:checked').length === 0) {
            Swal.fire('Error', 'Please select at least one schedule.', 'error');
            return;
        }

        isSubmitting = true;
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value || '';

        fetch("{{ route('admin.cases.store_send') }}", {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData,
            redirect: 'follow'
        })
        .then(async res => {
            if (res.redirected) {
                Swal.fire('Error', 'Session expired. Please login.', 'error').then(() =>
                    window.location.href = "{{ route('login') }}"
                );
                throw new Error('Redirected');
            }
            let data;
            try { data = await res.json(); } 
            catch (err) { const text = await res.text(); throw new Error(text || 'Invalid JSON'); }

            if (data.success) {
                Swal.fire('Success', data.message, 'success');
                this.reset();
                document.getElementById('previewMessage').innerHTML = 'Enter details to see preview.';
                rowIndex = 1;
                document.querySelector('#witnessTable tbody').innerHTML = `<tr>
                    <td><input type="text" name="witnesses[0][name]" class="form-control form-control-sm witnessName" required></td>
                    <td><input type="text" name="witnesses[0][phone]" class="form-control form-control-sm witnessPhone" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
                </tr>`;
            } else Swal.fire('Error', data.message || 'Something went wrong', 'error');
        })
        .catch(err => { Swal.fire('Error', err.message || 'Something went wrong', 'error'); })
        .finally(() => { btn.disabled = false; isSubmitting = false; });

    });

});
</script>
@endpush

@endsection
