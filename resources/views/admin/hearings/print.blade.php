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
    জেলা (District): {{ $districtName ?? '________________' }} &nbsp;&nbsp;
    আদালতের নাম (Court Name): {{ $courtName ?? '________________' }} &nbsp;&nbsp;
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
            @foreach($hearing->case->witnesses as $index => $witness)
                <tr>
                    @if($index === 0)
                        <td rowspan="{{ $hearing->case->witnesses->count() }}">
                            {{ $serial }}.<br>
                            {{ $hearing->case->case_no }}
                        </td>
                    @endif

                    <td>{{ $witness->name ?? '________________' }}</td>
                    <td>{{ $witness->phone ?? '________________' }}</td>

                    <!-- Gender checkboxes -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Female</label>
                            <label><input type="checkbox"> Male</label>
                            <label><input type="checkbox"> Third Gender</label>
                        </div>
                    </td>

                    <!-- Type of Witness -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> IO</label>
                            <label><input type="checkbox"> MO</label>
                            <label><input type="checkbox"> DNC</label>
                            <label><input type="checkbox"> General</label>
                            <label><input type="checkbox"> Other</label>
                        </div>
                    </td>

                    <!-- Other Info -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Under 18</label>
                            <label><input type="checkbox"> Person with Disability</label>
                        </div>
                    </td>

                    <!-- Witness Appeared -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Present</label>
                            <label><input type="checkbox"> Absent</label>
                            <label><input type="checkbox"> Excused</label>
                            <label><input type="checkbox"> Pending</label>
                        </div>
                    </td>

                    <!-- SMS Seen -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Yes</label>
                            <label><input type="checkbox"> No</label>
                        </div>
                    </td>

                    <!-- Witness Heard -->
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Yes</label>
                            <label><input type="checkbox"> No</label>
                        </div>
                    </td>
                </tr>
            @endforeach
            @php $serial++; @endphp
        @endforeach
    </tbody>
</table>

<p>Prepared for manual attendance entry.</p>

</body>
</html>
