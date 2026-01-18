@extends('dashboard.layouts.admin')
@section('title', __('case.reschedule'))

@section('content')
<div class="app-content mt-3">
    <div class="container-fluid">

        <form id="rescheduleForm"
              action="{{ route('admin.hearings.reschedule.store', $hearing->id) }}"
              method="POST">
            @csrf

            {{-- Case Details --}}
            <div class="card card-body mb-3">
                <h5>{{ __('case.case_details') }}</h5>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label>{{ __('case.case_no') }}</label>
                        <input type="text" class="form-control form-control-sm"
                               value="{{ $hearing->case->case_no }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label>{{ __('case.hearing_date') }}</label>
                        <input type="date" name="new_date"
                               class="form-control form-control-sm"
                               value="{{ old('new_date', $hearing->hearing_date) }}"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label>{{ __('case.hearing_time') }}</label>
                        <input type="time" name="new_time"
                               class="form-control form-control-sm"
                               value="{{ old('new_time', $hearing->hearing_time) }}">
                    </div>
                </div>
            </div>

            {{-- Witnesses --}}
            <div class="card card-body mb-3">
                <h5>{{ __('case.witnesses') }}</h5>

                <table class="table table-bordered table-sm" id="witnessTable">
                    <thead>
                        <tr>
                            <th>{{ __('case.name') }}</th>
                            <th>{{ __('case.phone') }}</th>
                            <th>
                                <button type="button" id="addRow"
                                        class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hearing->case->witnesses as $i => $w)
                        <tr>
                            <td>
                                <input type="text"
                                       name="witnesses[{{ $i }}][name]"
                                       class="form-control form-control-sm witnessName"
                                       value="{{ $w->name }}" required>
                            </td>
                            <td>
                                <input type="text"
                                       name="witnesses[{{ $i }}][phone]"
                                       class="form-control form-control-sm witnessPhone"
                                       value="{{ $w->phone }}" required>
                            </td>
                            <td>
                                <button type="button"
                                        class="btn btn-danger btn-sm removeRow">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Schedule --}}
            <div class="card card-body mb-3">
                <h5>{{ __('case.schedule') }}</h5>
                <div class="btn-group" role="group">
                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched10" value="10_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched10">{{ __('case.10_days_before') }}</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="sched3" value="3_days_before">
                    <label class="btn btn-outline-success btn-sm" for="sched3">{{ __('case.3_days_before') }}</label>

                    <input type="checkbox" class="btn-check" name="schedules[]" id="schedNow" value="send_now">
                    <label class="btn btn-outline-success btn-sm" for="schedNow">{{ __('case.send_now') }}</label>
                </div>
            </div>

            {{-- Preview --}}
            <div class="card card-body mb-3">
                <h5>{{ __('case.preview_message') }}</h5>
                <div id="previewMessage" class="border p-2 bg-light">
                    {{ __('case.enter_preview') }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">
                {{ __('case.reschedule') }}
            </button>
        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let rowIndex = {{ $hearing->case->witnesses->count() }};
    let isSubmitting = false;

    // Add witness row
    document.getElementById('addRow').addEventListener('click', function () {
        document.querySelector('#witnessTable tbody')
            .insertAdjacentHTML('beforeend', `
            <tr>
                <td><input type="text" name="witnesses[${rowIndex}][name]"
                    class="form-control form-control-sm witnessName" required></td>
                <td><input type="text" name="witnesses[${rowIndex}][phone]"
                    class="form-control form-control-sm witnessPhone" required></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeRow">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `);
        rowIndex++;
        attachListeners();
        updatePreview();
    });

    // Remove row
    document.getElementById('witnessTable').addEventListener('click', e => {
        if (e.target.closest('.removeRow')) {
            e.target.closest('tr').remove();
            updatePreview();
        }
    });

    function attachListeners() {
        document.querySelectorAll('.witnessName').forEach(i =>
            i.addEventListener('input', updatePreview)
        );
        document.querySelectorAll('.witnessPhone').forEach(i =>
            i.addEventListener('input', () => {
                i.value = i.value.replace(/\D/g, '');
            })
        );
    }

    function toBanglaDate(date) {
        const d = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return date.replace(/\d/g, x => d[x]);
    }

    function updatePreview() {
        const date = document.querySelector('[name="new_date"]').value;
        let html = '';

        document.querySelectorAll('.witnessName').forEach((i, idx) => {
            if (i.value.trim()) {
                html += `<strong>{{ __('case.witnesses') }} ${idx+1}:</strong>
                         ${i.value} | {{ __('case.hearing_date') }}: ${toBanglaDate(date)}<br>`;
            }
        });

        document.getElementById('previewMessage').innerHTML =
            html || '{{ __('case.enter_preview') }}';
    }

    attachListeners();
    document.querySelector('[name="new_date"]').addEventListener('input', updatePreview);

    // FINAL SUBMIT HANDLER (ONLY ONE)
    document.getElementById('rescheduleForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return;

        // Frontend validation
        if (!document.querySelector('input[name="schedules[]"]:checked')) {
            Swal.fire('{{ __('case.schedule') }} প্রয়োজন', '{{ __('case.select') }}', 'warning');
            return;
        }

        isSubmitting = true;

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: new FormData(this)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok || data.status === 'error') throw data;
            return data;
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: '{{ __('case.success_save') }}',
                text: data.message,
                confirmButtonText: '{{ __('case.submit_send') }}',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('admin.hearings.index') }}";
            });
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: '{{ __('case.reschedule') }} ব্যর্থ',
                text: err.message ?? '{{ __('case.notes') }}'
            });
            isSubmitting = false;
        });
    });

});
</script>
@endpush
@endsection
