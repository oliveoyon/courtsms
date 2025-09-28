@extends('dashboard.layouts.admin')

@section('title', 'Courts')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Courts</h2>
        @can('Create Court')
            <button class="btn btn-primary" id="addCourtBtn">
                <i class="bi bi-plus-circle"></i> Add Court
            </button>
        @endcan
    </div>

    <table class="table table-striped" id="courtsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Court Name</th>
                <th>District</th>
                <th>Created At</th>
                @canany(['Edit Court', 'Delete Court'])
                    <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach($courts as $court)
            <tr id="court-{{ $court->id }}">
                <td>{{ $loop->iteration }}</td>
                <td class="court-name">{{ $court->name }}</td>
                <td>{{ $court->district->name ?? '-' }}</td>
                <td>{{ $court->created_at->format('Y-m-d') }}</td>
                @canany(['Edit Court', 'Delete Court'])
                <td>
                    @can('Edit Court')
                        <button class="btn btn-sm btn-info editBtn" data-id="{{ $court->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    @endcan
                    @can('Delete Court')
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $court->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    @endcan
                </td>
                @endcanany
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="courtModal" tabindex="-1" aria-labelledby="courtModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="courtForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="courtModalLabel">Add Court</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="courtId">
                    <div class="mb-3">
                        <label for="courtName" class="form-label">Court Name</label>
                        <input type="text" class="form-control" id="courtName" name="name" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="districtSelect" class="form-label">District</label>
                        <select class="form-select" id="districtSelect" name="district_id" required>
                            <option value="">Select District</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="districtError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveCourtBtn">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        
        /* ====== Table Styling ====== */
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* ====== Smart Green Table Header ====== */
        .table thead {
            background: linear-gradient(135deg, #28a745, #1c7430);
            /* green gradient */
            color: #fff;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 12px;
        }


        .table tbody tr {
            transition: background 0.2s ease-in-out;
        }

        .table tbody tr:hover {
            background: #f6f9fc;
        }

        .table td {
            vertical-align: middle;
            padding: 12px;
        }

        /* ====== Buttons Styling ====== */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn i {
            margin-right: 4px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #00408f);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 91, 187, 0.25);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #0c7d8d);
            border: none;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #0c7d8d, #095e68);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(12, 125, 141, 0.25);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #a71d2a, #7a121c);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(167, 29, 42, 0.25);
        }

        /* ====== Modal Styling (optional, looks cleaner) ====== */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }
    </style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('courtModal'));
    const addBtn = document.getElementById('addCourtBtn');
    const form = document.getElementById('courtForm');
    const nameInput = document.getElementById('courtName');
    const districtSelect = document.getElementById('districtSelect');
    const courtIdInput = document.getElementById('courtId');
    const nameError = document.getElementById('nameError');
    const districtError = document.getElementById('districtError');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Open modal for Add
    addBtn.addEventListener('click', () => {
        form.reset();
        courtIdInput.value = '';
        document.getElementById('courtModalLabel').textContent = 'Add Court';
        nameError.textContent = '';
        districtError.textContent = '';
        nameInput.classList.remove('is-invalid');
        districtSelect.classList.remove('is-invalid');
        modal.show();
    });

    // Open modal for Edit
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            fetch(`/admin/courts/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    courtIdInput.value = data.id;
                    nameInput.value = data.name;
                    districtSelect.value = data.district_id;
                    document.getElementById('courtModalLabel').textContent = 'Edit Court';
                    nameError.textContent = '';
                    districtError.textContent = '';
                    nameInput.classList.remove('is-invalid');
                    districtSelect.classList.remove('is-invalid');
                    modal.show();
                });
        });
    });

    // Save (Add or Update)
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        nameError.textContent = '';
        districtError.textContent = '';
        nameInput.classList.remove('is-invalid');
        districtSelect.classList.remove('is-invalid');

        const id = courtIdInput.value;
        const url = id ? `/admin/courts/${id}` : '/admin/courts';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                name: nameInput.value,
                district_id: districtSelect.value
            })
        })
        .then(async res => {
            if(res.status === 422){
                const data = await res.json();
                if(data.errors.name){
                    nameError.textContent = data.errors.name[0];
                    nameInput.classList.add('is-invalid');
                }
                if(data.errors.district_id){
                    districtError.textContent = data.errors.district_id[0];
                    districtSelect.classList.add('is-invalid');
                }
            } else {
                return res.json();
            }
        })
        .then(data => {
            if(data){
                const rowId = `court-${data.court.id}`;
                const rowHtml = `
                <tr id="${rowId}">
                    <td>${data.court.id}</td>
                    <td class="court-name">${data.court.name}</td>
                    <td>${data.court.district.name}</td>
                    <td>${data.court.created_at.split('T')[0]}</td>
                    <td>
                        <button class="btn btn-sm btn-info editBtn" data-id="${data.court.id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.court.id}"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>`;
                
                if(id){
                    document.getElementById(rowId).outerHTML = rowHtml;
                } else {
                    document.querySelector('#courtsTable tbody').insertAdjacentHTML('beforeend', rowHtml);
                }
                modal.hide();
                Swal.fire('Success', data.message, 'success');
            }
        });
    });

    // Delete
    document.addEventListener('click', function(e){
        if(e.target.closest('.deleteBtn')){
            const id = e.target.closest('.deleteBtn').dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the court!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.isConfirmed){
                    fetch(`/admin/courts/${id}`, {
                        method: 'DELETE',
                        headers: {'X-CSRF-TOKEN': token}
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Deleted!', data.message, 'success');
                        document.getElementById(`court-${id}`).remove();
                    });
                }
            });
        }
    });
});
</script>
@endpush
