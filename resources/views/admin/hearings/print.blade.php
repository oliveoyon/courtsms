<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - {{ $date }}</title>
    <style>
        body { font-family: solaimanlipi, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; }
        .checkbox-group { display: flex; gap: 5px; flex-wrap: wrap; justify-content: center; }
        .checkbox-group label { display: flex; align-items: center; gap: 2px; }
    </style>
</head>
<body>

<h3 style="text-align: center;">CourtSMS Attendance Report</h3>
<p>
    জেলা (District): {{ auth()->user()?->district?->name_bn ?? '________________' }} &nbsp;&nbsp;
    আদালতের নাম (Court Name): {{ auth()->user()?->court?->name_bn ?? '________________' }} &nbsp;&nbsp;
    তারিখ (Date): {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>Serial + Case No</th>
            <th>Witness Name</th>
            <th>Mobile Number</th>
            <th>Gender</th>
            <th>Type of Witness</th>
            <th>Other Info</th>
            <th>Witness Appeared</th>
            <th>Seen SMS</th>
            <th>Witness Heard</th>
        </tr>
    </thead>
    <tbody>
@php $serial = 1; @endphp

@foreach($hearings as $hearing)
    @php
        $witnessCount = $hearing->witnesses->count();
    @endphp

    @foreach($hearing->witnesses as $index => $witness)
        <tr>
            {{-- ROWSPAN COLUMN (ONLY ON FIRST ROW) --}}
            @if($index === 0)
                <td rowspan="{{ $witnessCount }}">
                    {{ $serial }}<br>
                    {{ $hearing->case->case_no }}
                </td>
            @endif

            <td>{{ $witness->name ?? '________________' }}</td>
            <td>{{ $witness->phone ?? '________________' }}</td>

            <td>
                <div class="checkbox-group">
                    ☐ Female ☐ Male ☐ Third Gender
                </div>
            </td>

            <td>
                <div class="checkbox-group">
                    ☐ IO ☐ MO ☐ DNC ☐ General ☐ Other
                </div>
            </td>

            <td>
                <div class="checkbox-group">
                    ☐ Under 18<br>
                    ☐ Person with Disability
                </div>
            </td>

            <td>
                <div class="checkbox-group">
                    ☐ Present ☐ Absent<br>
                    ☐ Excused ☐ Pending
                </div>
            </td>

            <td>☐ Yes ☐ No</td>
            <td>☐ Yes ☐ No</td>
        </tr>
    @endforeach

    @php $serial++; @endphp
@endforeach
</tbody>

</table>

<p>Prepared for manual attendance entry.</p>

</body>
</html>
