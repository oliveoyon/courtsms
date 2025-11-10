@extends('dashboard.layouts.admin')

@section('title', __('Case Reschedules'))

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">{{ __('Case Reschedules for') }}: {{ $case->case_no }}</h1>

    <a href="{{ route('admin.reschedules.create', $case->id) }}" class="btn btn-primary mb-3">
        {{ __('Add Reschedule') }}
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Reschedule Date') }}</th>
                    <th>{{ __('Reschedule Time') }}</th>
                    <th>{{ __('Witnesses & Attendance') }}</th>
                    <th>{{ __('Notifications') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reschedules as $res)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $res->reschedule_date }}</td>
                    <td>{{ $res->reschedule_time }}</td>
                    <td>
                        <form class="attendance-form" data-reschedule-id="{{ $res->id }}">
                            @csrf
                            @foreach($res->witnesses as $witness)
                                <div class="d-flex align-items-center mb-1">
                                    <span class="me-2">{{ $witness->name }}</span>
                                    <select name="attendances[{{ $witness->id }}]" class="form-select form-select-sm w-auto attendance-select">
                                        <option value="pending" {{ ($witness->attendance->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="appeared" {{ ($witness->attendance->status ?? '') == 'appeared' ? 'selected' : '' }}>Appeared</option>
                                        <option value="absent" {{ ($witness->attendance->status ?? '') == 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="excused" {{ ($witness->attendance->status ?? '') == 'excused' ? 'selected' : '' }}>Excused</option>
                                    </select>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success btn-sm mt-2">{{ __('Update Attendance') }}</button>
                        </form>
                    </td>
                    <td>
                        @foreach($res->notifications as $notif)
                            <span class="badge bg-{{ $notif->status === 'sent' ? 'success' : 'secondary' }}">
                                {{ ucfirst($notif->status) }} ({{ $notif->channel }})
                            </span><br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('.attendance-form').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let rescheduleId = form.data('reschedule-id');

        $.ajax({
            url: '/admin/reschedules/' + rescheduleId + '/attendance',
            method: 'POST',
            data: form.serialize(),
            success: function(res){
                if(res.success){
                    Swal.fire('Success', res.message, 'success');
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
