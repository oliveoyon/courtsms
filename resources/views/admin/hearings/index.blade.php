@extends('dashboard.layouts.admin')

@section('title', 'Hearing List')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <form class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <input type="date" name="date" value="{{ $date }}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>

                    {{-- 🖨 Print Button --}}
                    <div class="col-md-3">
                        @if ($hearings->count())
                            <a href="{{ route('admin.hearings.print', ['date' => $date]) }}" target="_blank"
                                class="btn btn-danger w-100">
                                🖨 Print Attendance Sheet
                            </a>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                🖨 Print Attendance Sheet
                            </button>
                        @endif
                    </div>

                </form>
            </div>


            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Case No</th>
                            <th>Court</th>
                            <th>Hearing Time</th>
                            <th>Witness Count</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hearings as $hearing)
                            <tr>
                                <td>{{ $hearing->case->case_no }}</td>
                                <td>{{ $hearing->case->court->name }}</td>
                                <td>{{ $hearing->hearing_time ?? '-' }}</td>
                                <td>{{ $hearing->witnesses->count() }}</td>
                                <td>
                                    @if ($hearing->is_reschedule)
                                        <span class="badge bg-warning text-dark">Rescheduled</span>
                                    @else
                                        <span class="badge bg-success">Original</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.hearings.attendance', $hearing->id) }}"
                                        class="btn btn-sm btn-success mb-1">
                                        Take Attendance
                                    </a>
                                    <a href="{{ route('admin.hearings.reschedule', $hearing->id) }}"
                                        class="btn btn-sm btn-warning mb-1">
                                        Reschedule
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No hearings found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
