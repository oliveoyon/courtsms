@extends('dashboard.layouts.admin')

@section('title', 'Districts')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Districts</h2>
            @can('Create District')
                <button class="btn btn-primary" id="addDistrictBtn">
                    <i class="bi bi-plus-circle"></i> Add District
                </button>
            @endcan
        </div>

        <table class="table table-striped" id="districtsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>District Name</th>
                    <th>Division</th>
                    <th>Created At</th>
                    @canany(['Edit District', 'Delete District'])
                        <th>Actions</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($districts as $district)
                    <tr id="district-{{ $district->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="district-name">{{ $district->name }}</td>
                        <td>{{ $district->division->name ?? '-' }}</td>
                        <td>{{ $district->created_at->format('Y-m-d') }}</td>
                        @canany(['Edit District', 'Delete District'])
                            <td>
                                @can('Edit District')
                                    <button class="btn btn-sm btn-info editBtn" data-id="{{ $district->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                @endcan
                                @can('Delete District')
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $district->id }}">
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
    <div class="modal fade" id="districtModal" tabindex="-1" aria-labelledby="districtModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="districtForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="districtModalLabel">Add District</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="districtId">
                        <div class="mb-3">
                            <label for="districtName" class="form-label">District Name</label>
                            <input type="text" class="form-control" id="districtName" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="divisionSelect" class="form-label">Division</label>
                            <select class="form-select" id="divisionSelect" name="division_id" required>
                                <option value="">Select Division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="divisionError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveDistrictBtn">
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
            const modal = new bootstrap.Modal(document.getElementById('districtModal'));
            const addBtn = document.getElementById('addDistrictBtn');
            const form = document.getElementById('districtForm');
            const nameInput = document.getElementById('districtName');
            const divisionSelect = document.getElementById('divisionSelect');
            const districtIdInput = document.getElementById('districtId');
            const nameError = document.getElementById('nameError');
            const divisionError = document.getElementById('divisionError');

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Open modal for Add
            addBtn.addEventListener('click', () => {
                form.reset();
                districtIdInput.value = '';
                document.getElementById('districtModalLabel').textContent = 'Add District';
                nameError.textContent = '';
                divisionError.textContent = '';
                nameInput.classList.remove('is-invalid');
                divisionSelect.classList.remove('is-invalid');
                modal.show();
            });

            // Open modal for Edit
            // Delegate edit button click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.editBtn')) {
                    const btn = e.target.closest('.editBtn');
                    const id = btn.dataset.id;

                    fetch(`/admin/districts/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            districtIdInput.value = data.id;
                            nameInput.value = data.name;
                            divisionSelect.value = data.division_id;
                            document.getElementById('districtModalLabel').textContent = 'Edit District';
                            nameError.textContent = '';
                            divisionError.textContent = '';
                            nameInput.classList.remove('is-invalid');
                            divisionSelect.classList.remove('is-invalid');
                            modal.show();
                        });
                }
            });


            // Save (Add or Update)
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                nameError.textContent = '';
                divisionError.textContent = '';
                nameInput.classList.remove('is-invalid');
                divisionSelect.classList.remove('is-invalid');

                const id = districtIdInput.value;
                const url = id ? `/admin/districts/${id}` : '/admin/districts';
                const method = id ? 'PUT' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            name: nameInput.value,
                            division_id: divisionSelect.value
                        })
                    })
                    .then(async res => {
                        if (res.status === 422) {
                            const data = await res.json();
                            if (data.errors.name) {
                                nameError.textContent = data.errors.name[0];
                                nameInput.classList.add('is-invalid');
                            }
                            if (data.errors.division_id) {
                                divisionError.textContent = data.errors.division_id[0];
                                divisionSelect.classList.add('is-invalid');
                            }
                        } else {
                            return res.json();
                        }
                    })
                    .then(data => {
                        if (data) {
                            const rowId = `district-${data.district.id}`;
                            const rowHtml = `
                <tr id="${rowId}">
                    <td>${data.district.id}</td>
                    <td class="district-name">${data.district.name}</td>
                    <td>${data.district.division.name}</td>
                    <td>${data.district.created_at.split('T')[0]}</td>
                    <td>
                        <button class="btn btn-sm btn-info editBtn" data-id="${data.district.id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.district.id}"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>`;

                            if (id) {
                                document.getElementById(rowId).outerHTML = rowHtml;
                            } else {
                                document.querySelector('#districtsTable tbody').insertAdjacentHTML(
                                    'beforeend', rowHtml);
                            }
                            modal.hide();
                            Swal.fire('Success', data.message, 'success');
                        }
                    });
            });

            // Delete
            document.addEventListener('click', function(e) {
                if (e.target.closest('.deleteBtn')) {
                    const id = e.target.closest('.deleteBtn').dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the district!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/districts/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire('Deleted!', data.message, 'success');
                                    document.getElementById(`district-${id}`).remove();
                                });
                        }
                    });
                }
            });

        });
    </script>
@endpush
