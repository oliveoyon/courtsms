@extends('dashboard.layouts.admin')

@section('title', __('Add Reschedule'))

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">{{ __('Reschedule Case') }}: {{ $case->case_no }}</h1>

    <form id="reschedule-form">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('Reschedule Date') }}</label>
            <input type="date" name="reschedule_date" class="form-control" required min="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Reschedule Time') }}</label>
            <input type="time" name="reschedule_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Select Witnesses') }}</label>
            <select name="witnesses[]" class="form-select" multiple required>
                @foreach($witnesses as $w)
                    <option value="{{ $w->id }}">{{ $w->name }} ({{ $w->phone }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Notification Schedules') }}</label>
            <div class="form-check">
                <input type="checkbox" name="schedules[]" value="10_days_before" class="form-check-input" id="sched10">
                <label class="form-check-label" for="sched10">{{ __('10 Days Before') }}</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="schedules[]" value="3_days_before" class="form-check-input" id="sched3">
                <label class="form-check-label" for="sched3">{{ __('3 Days Before') }}</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="schedules[]" value="send_now" class="form-check-input" id="schedNow">
                <label class="form-check-label" for="schedNow">{{ __('Send Now') }}</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Create Reschedule') }}</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('#reschedule-form').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.reschedules.store', $case->id) }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    Swal.fire('Success', res.message, 'success').then(() => {
                        window.location.href = "{{ route('admin.reschedules.index', $case->id) }}";
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function(xhr){
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        });
    });
});
</script>
@endsection
