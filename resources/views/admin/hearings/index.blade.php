@extends('dashboard.layouts.admin')

@section('title', __('case.hearing_list'))

@section('content')
<div class="container-fluid">

    {{-- Filter + Print Form --}}
    <div class="card mb-3">
        <div class="card-body">
            {{-- 🔹 Use POST method --}}
            <form id="hearingFilterForm" class="row g-2 align-items-end" method="POST"
                action="{{ route('admin.hearings.index') }}">
                @csrf

                {{-- Date --}}
                <div class="col-md-2">
                    <label class="form-label">{{ __('case.date') }}</label>
                    <input type="date" name="date" value="{{ $date }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">{{ __('case.division') }}</label>
                    <select name="division_id" id="division_id" class="form-select"
                        {{ isset($user) && $user->division_id ? 'disabled' : '' }}>
                        <option value="">{{ __('case.select_division') }}</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ old('division_id', $user->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'bn' ? $division->name_bn : $division->name_en }}
                            </option>
                        @endforeach
                    </select>
                    @if (isset($user) && $user->division_id)
                        <input type="hidden" name="division_id" value="{{ $user->division_id }}">
                    @endif
                </div>

                <!-- District -->
                <div class="col-md-2">
                    <label class="form-label">{{ __('case.district') }}</label>
                    <select name="district_id" id="district_id" class="form-select"
                        {{ isset($user) && $user->district_id ? 'disabled' : '' }}>
                        <option value="">{{ __('case.select_district') }}</option>
                        @if (isset($user) && $user->division)
                            @foreach ($user->division->districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if (isset($user) && $user->district_id)
                        <input type="hidden" name="district_id" value="{{ $user->district_id }}">
                    @endif
                </div>

                <!-- Court -->
                <div class="col-md-2">
                    <label class="form-label">{{ __('case.court') }}</label>
                    <select name="court_id" id="court_id" class="form-select"
                        {{ isset($user) && $user->court_id ? 'disabled' : '' }}>
                        <option value="">{{ __('case.select_court') }}</option>
                        @if (isset($user) && $user->district)
                            @foreach ($user->district->courts as $court)
                                <option value="{{ $court->id }}"
                                    {{ old('court_id', $user->court_id) == $court->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'bn' ? $court->name_bn : $court->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if (isset($user) && $user->court_id)
                        <input type="hidden" name="court_id" value="{{ $user->court_id }}">
                    @endif
                </div>

                {{-- Filter Button --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">{{ __('case.apply_filter') }}</button>
                </div>

                {{-- Print Button --}}
                <div class="col-md-2">
                    @if ($hearings->count())
                        <button type="button" class="btn btn-danger w-100" id="printBtn">
                            🖨 {{ __('case.print_attendance_sheet') }}
                        </button>
                    @else
                        <button class="btn btn-secondary w-100" disabled>
                            🖨 {{ __('case.print_attendance_sheet') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Hearing Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('case.case_no') }}</th>
                        <th>{{ __('case.court') }}</th>
                        <th>{{ __('case.hearing_time') }}</th>
                        <th>{{ __('case.witness_count') }}</th>
                        <th>{{ __('case.status') }}</th>
                        <th>{{ __('case.action') }}</th>
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
                                    <span class="badge bg-warning text-dark">{{ __('case.rescheduled') }}</span>
                                @else
                                    <span class="badge bg-success">{{ __('case.original') }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Attendance Button --}}
                                <form method="POST"
                                    action="{{ route('admin.hearings.attendance.start', $hearing->id) }}"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success mb-1">{{ __('case.take_attendance') }}</button>
                                </form>

                                {{-- Reschedule Button --}}
                                <form method="POST"
                                    action="{{ route('admin.hearings.reschedule.start', $hearing->id) }}"
                                    class="rescheduleForm" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning mb-1">{{ __('case.reschedule') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('case.no_hearings_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const courtSelect = document.getElementById('court_id');
    const locale = '{{ app()->getLocale() }}';

    // Dynamic Districts
    divisionSelect?.addEventListener('change', function() {
        const divisionId = this.value;
        districtSelect.innerHTML =
            `<option value="">${locale === 'bn' ? 'সব জেলা' : 'All Districts'}</option>`;
        courtSelect.innerHTML =
            `<option value="">${locale === 'bn' ? 'সব আদালত' : 'All Courts'}</option>`;
        if (!divisionId) return;
        fetch(`/admin/divisions/${divisionId}/districts`)
            .then(res => res.json())
            .then(data => data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = locale === 'bn' ? d.name_bn : d.name_en;
                districtSelect.appendChild(opt);
            }));
    });

    // Dynamic Courts
    districtSelect?.addEventListener('change', function() {
        const districtId = this.value;
        courtSelect.innerHTML =
            `<option value="">${locale === 'bn' ? 'সব আদালত' : 'All Courts'}</option>`;
        if (!districtId) return;
        fetch(`/admin/districts/${districtId}/courts`)
            .then(res => res.json())
            .then(data => data.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = locale === 'bn' ? c.name_bn : c.name_en;
                courtSelect.appendChild(opt);
            }));
    });

    // Print Button submits form to Print route
    document.getElementById('printBtn')?.addEventListener('click', function() {
        const form = document.getElementById('hearingFilterForm');
        const originalAction = form.action;

        // Temporarily change action to print
        form.action = "{{ route('admin.hearings.print') }}";
        form.target = "_blank"; // open in new tab
        form.submit();

        // Restore original action
        form.action = originalAction;
        form.target = "_self";
    });
});
</script>
@endpush
