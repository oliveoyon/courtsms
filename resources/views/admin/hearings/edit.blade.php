@extends('dashboard.layouts.admin')
@section('title', app()->getLocale() === 'bn' ? 'সাক্ষীর তথ্য সংশোধন' : 'Edit Witness Info')

@section('content')
<div class="app-content mt-3">
    <div class="container-fluid">

        <form id="editWitnessForm"
              action="{{ route('admin.hearings.edit.store', $hearing->id) }}"
              method="POST">
            @csrf

            <div class="card card-body mb-3">
                <h5>{{ __('case.case_details') }}</h5>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label>{{ __('case.case_no') }}</label>
                        <input type="text" class="form-control form-control-sm"
                               value="{{ $hearing->case->case_no }}" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('case.hearing_date') }}</label>
                        <input type="date" class="form-control form-control-sm"
                               value="{{ $hearing->hearing_date }}" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('case.hearing_time') }}</label>
                        <input type="time" class="form-control form-control-sm"
                               value="{{ $hearing->hearing_time }}" disabled>
                    </div>
                </div>
            </div>

            <div class="card card-body mb-3">
                <h5>{{ app()->getLocale() === 'bn' ? 'সাক্ষীর তথ্য' : 'Witness Information' }}</h5>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('case.name') }}</th>
                            <th>{{ __('case.phone') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hearing->witnesses as $index => $witness)
                            <tr>
                                <td>
                                    <input type="hidden" name="witnesses[{{ $index }}][id]" value="{{ $witness->id }}">
                                    <input type="text"
                                           name="witnesses[{{ $index }}][name]"
                                           class="form-control form-control-sm witnessName"
                                           value="{{ $witness->name }}"
                                           required>
                                </td>
                                <td>
                                    <input type="text"
                                           name="witnesses[{{ $index }}][phone]"
                                           class="form-control form-control-sm witnessPhone"
                                           value="{{ $witness->phone }}"
                                           required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <small class="d-block mt-2 text-muted">
                    {{ app()->getLocale() === 'bn' ? 'আগে থেকে নির্ধারিত ভবিষ্যৎ এসএমএস এই সংশোধিত নাম ও ফোন ব্যবহার করবে।' : 'Future scheduled SMS for this hearing will use the corrected witness name and phone.' }}
                </small>
            </div>

            <div class="card card-body mb-3">
                <h5>{{ __('case.preview_message') }}</h5>
                <div id="previewMessage" class="border p-2 bg-light">
                    {{ __('case.enter_preview') }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">
                {{ app()->getLocale() === 'bn' ? 'তথ্য হালনাগাদ করুন' : 'Update Information' }}
            </button>
        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let isSubmitting = false;
    const hearingDate = '{{ $hearing->hearing_date }}';
    const locale = '{{ app()->getLocale() }}';

    function toBanglaDate(date) {
        const digits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return date.replace(/\d/g, x => digits[x]);
    }

    function updatePreview() {
        let html = '';

        document.querySelectorAll('.witnessName').forEach((input, index) => {
            if (input.value.trim()) {
                const hearingDateText = locale === 'bn' ? toBanglaDate(hearingDate) : hearingDate;
                html += `<strong>{{ __('case.witnesses') }} ${index + 1}:</strong> ${input.value} | {{ __('case.hearing_date') }}: ${hearingDateText}<br>`;
            }
        });

        document.getElementById('previewMessage').innerHTML = html || '{{ __('case.enter_preview') }}';
    }

    document.querySelectorAll('.witnessName').forEach(input => {
        input.addEventListener('input', updatePreview);
    });

    document.querySelectorAll('.witnessPhone').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    });

    updatePreview();

    document.getElementById('editWitnessForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return;

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
                title: locale === 'bn' ? 'তথ্য হালনাগাদ ব্যর্থ' : 'Update failed',
                text: err.message ?? (locale === 'bn' ? 'তথ্য হালনাগাদ করা যায়নি।' : 'Unable to update witness information.')
            });
            isSubmitting = false;
        });
    });
});
</script>
@endpush
@endsection
