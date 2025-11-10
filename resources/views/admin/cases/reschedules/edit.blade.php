@extends('dashboard.layouts.admin')
@section('title', __('case.reschedules'))

@section('content')
<div class="app-content">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ __('case.reschedules_for_case') }}: {{ $case->case_no }}</h4>
            <a href="{{ route('admin.reschedules.create', $case->id) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> {{ __('case.add_reschedule') }}
            </a>
        </div>

        <table class="table table-bordered table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('case.reschedule_date') }}</th>
                    <th>{{ __('case.reschedule_time') }}</th>
                    <th>{{ __('case.witnesses') }}</th>
                    <th>{{ __('case.notifications') }}</th>
                    <th>{{ __('case.attendance') }}</th>
                    <th>{{ __('case.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reschedules as $res)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($res->reschedule_date)->format('d M, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($res->reschedule_time)->format('h:i A') }}</td>

                        {{-- Witnesses linked to notifications --}}
                        <td>
                            @foreach($res->case->witnesses as $witness)
                                @if($res->notifications->contains('witness_id', $witness->id))
                                    <span class="badge bg-info">{{ $witness->name }}</span><br>
                                @endif
                            @endforeach
                        </td>

                        {{-- Notification statuses --}}
                        <td>
                            @foreach($res->notifications as $notif)
                                <span class="badge 
                                    bg-{{ $notif->status === 'sent' ? 'success' : ($notif->status === 'failed' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($notif->status) }} ({{ strtoupper($notif->channel) }})
                                </span><br>
                            @endforeach
                        </td>

                        {{-- Attendance --}}
                        <td>
                            @foreach($res->case->witnesses as $witness)
                                @php
                                    $attendance = $witness->attendances()
                                        ->where('hearing_date', $res->reschedule_date)
                                        ->first();
                                @endphp
                                @if($attendance)
                                    <span class="badge 
                                        bg-{{ $attendance->status === 'appeared' ? 'success' : ($attendance->status === 'absent' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span> <br>
                                @else
                                    <span class="badge bg-warning">Pending</span><br>
                                @endif
                            @endforeach
                        </td>

                        {{-- Actions --}}
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger mb-1 deleteBtn"
                                data-id="{{ $res->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-success mb-1 sendNowBtn"
                                data-id="{{ $res->id }}">
                                <i class="bi bi-send"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">{{ __('case.no_reschedules_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Delete reschedule
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const resId = this.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the reschedule and related notifications!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/reschedules/${resId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if(data.success){
                            Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }).catch(err => Swal.fire('Error!', 'Something went wrong', 'error'));
                }
            })
        });
    });

    // Send Now for a reschedule
    document.querySelectorAll('.sendNowBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const resId = this.dataset.id;
            Swal.fire({
                title: 'Send notifications now?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Send Now',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if(result.isConfirmed){
                    fetch(`/admin/reschedules/${resId}/send-now`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if(data.success){
                            Swal.fire('Success!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }).catch(err => Swal.fire('Error!', 'Something went wrong', 'error'));
                }
            })
        });
    });

});
</script>
@endpush

@endsection
