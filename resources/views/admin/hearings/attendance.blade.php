@extends('dashboard.layouts.admin')

@section('title', __('case.take_attendance'))

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <strong>
                    {{ __('case.case_no') }}: {{ $hearing->case->case_no }} |
                    {{ __('case.hearing_date') }}: {{ $hearing->hearing_date }}
                </strong>
            </div>

            <form method="POST" action="{{ route('admin.hearings.attendance.store', $hearing->id) }}">
                @csrf

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('case.witness_name') }}</th>
                                <th>{{ __('case.phone') }}</th>
                                <th>{{ __('case.attendance') }}</th>
                                <th>{{ __('case.gender') }}</th>
                                <th>{{ __('case.others_info') }}</th>
                                <th>{{ __('case.type_of_witness') }}</th>
                                <th class="text-center">{{ __('case.sms_seen') }}</th>
                                <th class="text-center">{{ __('case.witness_heard') }}</th>
                                <th>{{ __('case.remarks') }}</th>
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
                                            <option value="appeared" {{ $witness->appeared_status === 'appeared' ? 'selected' : '' }}>
                                                {{ __('case.appeared') }}
                                            </option>
                                            <option value="absent" {{ $witness->appeared_status === 'absent' ? 'selected' : '' }}>
                                                {{ __('case.not_appeared') }}
                                            </option>
                                            <option value="excused" {{ $witness->appeared_status === 'excused' ? 'selected' : '' }}>
                                                {{ __('case.excused') }}
                                            </option>
                                            <option value="pending" {{ $witness->appeared_status === 'pending' ? 'selected' : '' }}>
                                                {{ __('case.pending') }}
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Gender --}}
                                    <td>
                                        <select name="gender[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="">-- {{ __('case.select') }} --</option>
                                            <option value="Female" {{ $witness->gender === 'Female' ? 'selected' : '' }}>
                                                {{ __('case.female') }}
                                            </option>
                                            <option value="Male" {{ $witness->gender === 'Male' ? 'selected' : '' }}>
                                                {{ __('case.male') }}
                                            </option>
                                            <option value="Third Gender" {{ $witness->gender === 'Third Gender' ? 'selected' : '' }}>
                                                {{ __('case.third_gender') }}
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Others Info --}}
                                    <td>
                                        <select name="others_info[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="">-- {{ __('case.none') }} --</option>
                                            <option value="Under 18" {{ $witness->others_info === 'Under 18' ? 'selected' : '' }}>
                                                {{ __('case.under_18') }}
                                            </option>
                                            <option value="Person with Disability" {{ $witness->others_info === 'Person with Disability' ? 'selected' : '' }}>
                                                {{ __('case.person_with_disability') }}
                                            </option>
                                            <option value="Both" {{ $witness->others_info === 'Both' ? 'selected' : '' }}>
                                                {{ __('case.both') }}
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Type of Witness --}}
                                    <td>
                                        <select name="type_of_witness[{{ $witness->id }}]" class="form-select form-select-sm">
                                            <option value="">-- {{ __('case.select') }} --</option>
                                            <option value="IO" {{ $witness->type_of_witness === 'IO' ? 'selected' : '' }}>IO</option>
                                            <option value="MO" {{ $witness->type_of_witness === 'MO' ? 'selected' : '' }}>MO</option>
                                            <option value="DNC" {{ $witness->type_of_witness === 'DNC' ? 'selected' : '' }}>DNC</option>
                                            <option value="General" {{ $witness->type_of_witness === 'General' ? 'selected' : '' }}>General</option>
                                            <option value="Others" {{ $witness->type_of_witness === 'Others' ? 'selected' : '' }}>Others</option>
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
                        {{ __('case.save_attendance') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
