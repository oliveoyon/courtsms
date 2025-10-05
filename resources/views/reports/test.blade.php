@extends('dashboard.layouts.admin')

@section('title', 'PDF Test Report')

@push('styles')
<style>
/* Loader overlay */
#loader-overlay {
    display: none; /* hidden initially */
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}
#loader-overlay .spinner-border {
    width: 3rem;
    height: 3rem;
}

/* Optional: Table readable for PDF */
#reportDiv table {
    width: 100%;
    border-collapse: collapse;
}
#reportDiv th, #reportDiv td {
    border: 1px solid #000;
    padding: 5px;
    text-align: left;
}
#reportDiv th {
    background-color: #f0f0f0;
}

/* Fullscreen modal */
.modal-fullscreen {
    max-width: 100vw;
    margin: 0;
}
.modal-fullscreen .modal-content {
    height: 100vh;
}
.modal-fullscreen .modal-body {
    height: calc(100vh - 56px);
    overflow-y: auto;
}
</style>
@endpush

@section('content')
<div class="container-fluid mt-3">

    <button class="btn btn-success mb-3" id="printButton">
        <i class="fas fa-print"></i> Print Report
    </button>

    <!-- Loader overlay -->
    <div id="loader-overlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Report div -->
    <div id="reportDiv">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="font-family: SolaimanLipi">District Name / জেলা নাম</th>
                    <th>Profile No</th>
                </tr>
            </thead>
            <tbody>
                @foreach($districts as $district)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-family: SolaimanLipi">{{ $district->name }}</td>
                    <td>{{ $district->profile_no }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- PDF Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Generated PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="pdfFrame" style="width:100%; height:100%; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfModalEl = document.getElementById('pdfModal');
    const pdfModal = new bootstrap.Modal(pdfModalEl);
    const printBtn = document.getElementById('printButton');
    const pdfFrame = document.getElementById('pdfFrame');
    const loader = document.getElementById('loader-overlay');

    printBtn.addEventListener('click', function() {
        const data = document.getElementById('reportDiv').innerHTML;

        // Show loader
        loader.style.display = 'flex';

        fetch('{{ route("admin.pdf.generate") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                pdf_data: data,
                title: 'District List Report',
                orientation: 'P',
                fname: 'DistrictListReport.pdf'
            })
        })
        .then(res => res.json())
        .then(res => {
            loader.style.display = 'none';
            if(res.pdf_url) {
                pdfFrame.src = res.pdf_url;
                pdfModal.show();
            } else {
                alert('Failed to generate PDF.');
            }
        })
        .catch(() => {
            loader.style.display = 'none';
            alert('Error generating PDF.');
        });
    });
});
</script>
@endpush
