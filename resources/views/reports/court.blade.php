@extends('dashboard.layouts.admin')

@section('title', 'Courts Report')

@push('styles')
<style>
    /* Table styling */
    #reportContent table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    #reportContent th, #reportContent td {
        border: 1px solid #333;
        padding: 6px;
    }

    #reportContent th {
        background: #f2f2f2;
    }

    /* Report header */
    #reportContent h2, #reportContent h3 {
        text-align: center;
        margin: 0;
        font-family: SolaimanLipi;
    }

    #reportContent p {
        text-align: center;
        margin: 5px 0;
    }

    #reportContent hr {
        border:1px solid #333;
        margin-bottom: 20px;
    }

    /* Footer */
    #reportContent .report-footer {
        margin-top: 30px;
        text-align: right;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Courts Report</h5>
            <button class="btn btn-primary" id="printPdfBtn">Print PDF</button>
        </div>

        <!-- Report Content -->
        <div class="" id="reportContent">
            
            <!-- Header -->
            <h2>বাংলাদেশ বিচার বিভাগ</h2>
            <h3>Courts Report</h3>
            <p>Published on: {{ now()->format('d M, Y') }}</p>
            <hr>

            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="font-family:SolaimanLipi;">আদালতের নাম</th>
                        <th style="font-family:SolaimanLipi;">জেলা</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courts as $court)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-family:SolaimanLipi;">{{ $court->name_bn }}</td>
                        <td style="font-family:SolaimanLipi;">{{ $court->district->name_bn ?? '-' }}</td>
                        <td>{{ $court->is_active ? 'Active' : 'Inactive' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            
        </div>
    </div>

</div>

<!-- Fullscreen Modal for PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" style="width:100%; height:90vh;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('printPdfBtn').addEventListener('click', function() {
    const reportHtml = document.getElementById('reportContent').innerHTML;

    const params = new URLSearchParams({
        pdf_data: reportHtml,
        fname: 'courts-report.pdf',
        orientation: 'L',           // P or L
        font: 'Nikosh',       // Bangla font
        english_font: 'DejaVuSans', // optional English font
        output: 'I'                 // I = preview, D = download, F = save file
    });

    const pdfUrl = `{{ route('admin.generate-pdf') }}?${params.toString()}`;
    document.getElementById('pdfIframe').src = pdfUrl;

    new bootstrap.Modal(document.getElementById('pdfModal')).show();
});
</script>
@endpush
