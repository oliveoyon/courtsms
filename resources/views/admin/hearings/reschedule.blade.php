@extends('dashboard.layouts.admin')
@section('title', 'Reschedule Hearing')

@section('content')
<div class="app-content mt-3">
    <div class="container-fluid">
        <form id="rescheduleForm" action="{{ route('admin.hearings.reschedule.store', $hearing->id) }}" method="POST">
            @csrf

            <!-- Case Details -->
            <div class="card card-body mb-3">
                <h5>Case Details</h5>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label>Case No</label>
                        <input type="text" name="case_no" class="form-control form-control-sm" value="{{ $hearing->case->case_no }}" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>New Hearing Date</label>
                        <input type="date" name="new_date" class="form-control form-control-sm" value="{{ old('new_date', $hearing->hearing_date) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>New Hearing Time</label>
                        <input type="time" name="new_time" class="form-control form-control-sm" value="{{ old('new_time', $hearing->hearing_time) }}">
                    </div>
                </div>
            </div>

            <!-- Witnesses -->
            <div class="card card-body mb-3">
                <h5>Witnesses</h5>
                <table class="table table-bordered table-sm" id="witnessTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>
                                <button type="button" id="addRow" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hearing->case->witnesses as $index => $w)
                        <tr>
                            <td><input type="text" name="witnesses[{{ $index }}][name]" class="form-control form-control-sm witnessName" value="{{ $w->name }}" required></td>
                            <td><input type="text" name="witnesses[{{ $index }}][phone]" class="form-control form-control-sm witnessPhone" value="{{ $w->phone }}" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Schedule -->
            <div class="card card-body mb-3">
                <h5>Schedule</h5>
                <div class="btn-group" role="group" aria-label="Schedule buttons">
                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched10" value="10_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched10">10 days before</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched3" value="3_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched3">3 days before</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="schedNow" value="send_now">
                    <label class="btn btn-outline-success btn-sm" for="schedNow">Send Now</label>
                </div>
            </div>

            <!-- Preview Message -->
            <div class="card card-body mb-3">
                <h5>Preview Message</h5>
                <div id="previewMessage" class="border p-2 bg-light">Enter details to see preview.</div>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm">Save Reschedule</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = {{ $hearing->case->witnesses->count() }};
    let isSubmitting = false;

    // Add Witness Row
    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.querySelector('#witnessTable tbody');
        tbody.insertAdjacentHTML('beforeend', `<tr>
            <td><input type="text" name="witnesses[${rowIndex}][name]" class="form-control form-control-sm witnessName" required></td>
            <td><input type="text" name="witnesses[${rowIndex}][phone]" class="form-control form-control-sm witnessPhone" required></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
        </tr>`);
        rowIndex++;
        attachWitnessListeners();
        updatePreview();
    });

    // Remove Row
    document.querySelector('#witnessTable').addEventListener('click', function(e) {
        if(e.target.closest('.removeRow')) {
            e.target.closest('tr').remove();
            updatePreview();
        }
    });

    // Convert Bangla phone digits to English
    function setupPhoneInputConversion(selector) {
        const banglaToEnglish = {'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};
        const inputs = document.querySelectorAll(selector);
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value;
                value = value.replace(/[০-৯]/g, d => banglaToEnglish[d]);
                value = value.replace(/\D/g,'');
                this.value = value;
            });
        });
    }

    // Attach listener for preview update
    function attachWitnessListeners() {
        document.querySelectorAll('.witnessName').forEach(input => {
            input.removeEventListener('input', updatePreview);
            input.addEventListener('input', updatePreview);
        });
        setupPhoneInputConversion('.witnessPhone');
    }

    function toBanglaDate(dateStr) {
        if(!dateStr) return '';
        const digits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return dateStr.replace(/\d/g,d => digits[d]);
    }

    function updatePreview() {
        const caseNo = '{{ $hearing->case->case_no }}';
        const date = document.querySelector('input[name="new_date"]').value;
        const banglaDate = toBanglaDate(date);
        let html = '';

        document.querySelectorAll('.witnessName').forEach((input, idx) => {
            const name = input.value.trim();
            if(!name) return;
            html += `<strong>Witness ${idx+1}:</strong> ${name}, Hearing Date: ${banglaDate}<br>`;
        });

        document.getElementById('previewMessage').innerHTML = html || 'Enter details to see preview.';
    }

    attachWitnessListeners();
    document.querySelector('input[name="new_date"]').addEventListener('input', updatePreview);

    // Submit form validation
    document.getElementById('rescheduleForm').addEventListener('submit', function(e){
        e.preventDefault();
        if(isSubmitting) return;

        const phoneInputs = document.querySelectorAll('.witnessPhone');
        for(const inp of phoneInputs) {
            if(!/^(01)\d{9}$/.test(inp.value.trim())) {
                alert('Phone number must be 11 digits and start with 01');
                inp.focus();
                return;
            }
        }

        if(document.querySelectorAll('input[name="schedules[]"]:checked').length === 0) {
            alert('Please select at least one schedule');
            return;
        }

        isSubmitting = true;
        this.submit();
    });
});
</script>
@endpush
@endsection
