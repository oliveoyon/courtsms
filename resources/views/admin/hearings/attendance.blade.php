@extends('dashboard.layouts.admin')

@section('title', 'Take Attendance')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <strong>
                    Case No: {{ $hearing->case->case_no }} |
                    Hearing Date: {{ $hearing->hearing_date }}
                </strong>
            </div>

            <form method="POST" action="{{ route('admin.hearings.attendance.store', $hearing->id) }}">
                @csrf

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Witness Name</th>
                                <th>Phone</th>
                                <th>Attendance</th>
                                <th>Gender</th>
                                <th>Others Info</th>
                                <th class="text-center">SMS Seen</th>
                                <th class="text-center">Witness Heard</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($hearing->witnesses as $witness)
                                <tr>
                                    {{-- Witness Name --}}
                                    <td>{{ $witness->name }}</td>

                                    {{-- Phone --}}
                                    <td>{{ $witness->phone }}</td>

                                    {{-- Attendance --}}
                                    <td>
                                        <select name="attendance[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="appeared"
                                                {{ $witness->appeared_status === 'appeared' ? 'selected' : '' }}>
                                                Present
                                            </option>
                                            <option value="absent"
                                                {{ $witness->appeared_status === 'absent' ? 'selected' : '' }}>
                                                Absent
                                            </option>
                                            <option value="excused"
                                                {{ $witness->appeared_status === 'excused' ? 'selected' : '' }}>
                                                Excused
                                            </option>
                                            <option value="pending"
                                                {{ $witness->appeared_status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Gender --}}
                                    <td>
                                        <select name="gender[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            <option value="Female" {{ $witness->gender === 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="Male" {{ $witness->gender === 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Third Gender"
                                                {{ $witness->gender === 'Third Gender' ? 'selected' : '' }}>
                                                Third Gender
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Others Info --}}
                                    <td>
                                        <select name="others_info[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="">-- None --</option>
                                            <option value="Under 18"
                                                {{ $witness->others_info === 'Under 18' ? 'selected' : '' }}>
                                                Under 18
                                            </option>
                                            <option value="Person with Disability"
                                                {{ $witness->others_info === 'Person with Disability' ? 'selected' : '' }}>
                                                Person with Disability
                                            </option>
                                        </select>
                                    </td>

                                    {{-- SMS Seen --}}
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="sms_seen[{{ $witness->id }}]" value="yes"
                                            {{ $witness->sms_seen === 'yes' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Witness Heard --}}
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="witness_heard[{{ $witness->id }}]" value="yes"
                                            {{ $witness->witness_heard === 'yes' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Remarks --}}
                                    <td>
                                        <input type="text" name="remarks[{{ $witness->id }}]"
                                            class="form-control form-control-sm" value="{{ $witness->remarks }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
