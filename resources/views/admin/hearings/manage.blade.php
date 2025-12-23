@extends('dashboard.layouts.admin')
@section('title', 'Manage Hearings')

@section('content')
<div class="container mt-3">
    <label>Select Hearing Date:</label>
    <input type="date" id="hearingDatePicker" class="form-control mb-3" />

    <table class="table table-bordered" id="hearingsTable">
        <thead>
            <tr>
                <th>Case No</th>
                <th>Court</th>
                <th>Witnesses</th>
                <th>Attendance</th>
                <th>Reschedule</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Reschedule Modal -->
@include('admin.hearings.partials.reschedule-modal')

@endsection

@push('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';

document.getElementById('hearingDatePicker').addEventListener('change', function() {
    const date = this.value;
    if (!date) return;

    fetch(`/admin/hearings/by-date?date=${date}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#hearingsTable tbody');
            tbody.innerHTML = '';
            if (!data.length) {
                tbody.innerHTML = `<tr><td colspan="5">No hearings found.</td></tr>`;
                return;
            }

            data.forEach(hearing => {
                const witnessesList = hearing.witnesses.map(w => `${w.name} (${w.phone})`).join('<br>');
                const courtName = hearing.case.court.name_bn ?? hearing.case.court.name_en ?? 'N/A';

                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${hearing.case.case_no}</td>
                        <td>${courtName}</td>
                        <td>${witnessesList}</td>
                        <td>
                            ${hearing.witnesses.map(w => `
                                <select class="form-select attendance-select mb-1" data-witness-id="${w.id}">
                                    <option value="pending" ${w.appeared_status=='pending'?'selected':''}>Pending</option>
                                    <option value="appeared" ${w.appeared_status=='appeared'?'selected':''}>Appeared</option>
                                    <option value="absent" ${w.appeared_status=='absent'?'selected':''}>Absent</option>
                                    <option value="excused" ${w.appeared_status=='excused'?'selected':''}>Excused</option>
                                </select>
                            `).join('')}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary reschedule-btn" data-hearing-id="${hearing.id}" data-witnesses='${encodeURIComponent(JSON.stringify(hearing.witnesses))}'>Reschedule</button>
                        </td>
                    </tr>
                `);
            });

            // Attendance update
            document.querySelectorAll('.attendance-select').forEach(sel => {
                sel.addEventListener('change', function() {
                    const witnessId = this.dataset.witnessId;
                    const status = this.value;
                    fetch(`/admin/hearings/attendance`, {
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': csrfToken,'Content-Type':'application/json'},
                        body: JSON.stringify({witness_id: witnessId, status})
                    }).then(res=>res.json()).then(res=>{
                        if(!res.success) alert(res.message);
                    });
                });
            });

            // Reschedule modal population
            document.querySelectorAll('.reschedule-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hearingId = this.dataset.hearingId;
                    document.getElementById('modalHearingId').value = hearingId;

                    const witnesses = JSON.parse(decodeURIComponent(this.dataset.witnesses));
                    const container = document.getElementById('witnessContainer');
                    container.innerHTML = '';

                    witnesses.forEach(w => {
                        container.insertAdjacentHTML('beforeend', `
                            <div class="witness-row mb-2">
                                <input type="text" name="witnesses[][name]" value="${w.name}" placeholder="Name" class="form-control mb-1" required>
                                <input type="text" name="witnesses[][phone]" value="${w.phone}" placeholder="Phone" class="form-control mb-1" required>
                                <button type="button" class="btn btn-sm btn-danger remove-witness mt-1">Remove</button>
                            </div>
                        `);
                    });

                    new bootstrap.Modal(document.getElementById('rescheduleModal')).show();
                });
            });
        });
});

// Add/Remove witness rows
document.getElementById('addWitnessBtn').addEventListener('click', function(){
    const container = document.getElementById('witnessContainer');
    container.insertAdjacentHTML('beforeend', `
        <div class="witness-row mb-2">
            <input type="text" name="witnesses[][name]" placeholder="Name" class="form-control mb-1" required>
            <input type="text" name="witnesses[][phone]" placeholder="Phone" class="form-control mb-1" required>
            <button type="button" class="btn btn-sm btn-danger remove-witness mt-1">Remove</button>
        </div>
    `);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-witness')){
        e.target.closest('.witness-row').remove();
    }
});

// Reschedule form submit
document.getElementById('rescheduleForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);

    // Collect SMS schedule options
    const scheduleOptions = [];
    document.querySelectorAll('.sms-schedule-checkbox:checked').forEach(cb => scheduleOptions.push(cb.value));
    scheduleOptions.forEach((v,i)=>formData.append(`schedules[${i}]`, v));

    fetch(`/admin/hearings/reschedule`, {
        method:'POST', headers:{'X-CSRF-TOKEN': csrfToken}, body:formData
    })
    .then(res=>res.json())
    .then(res=>{
        alert(res.message);
        if(res.success) location.reload();
    });
});
</script>
@endpush
