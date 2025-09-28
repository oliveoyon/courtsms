@extends('dashboard.layouts.admin')

@section('title', 'Divisions')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Divisions</h2>
            @can('Create Division')
                <button class="btn btn-primary" id="addDivisionBtn">
                    <i class="bi bi-plus-circle"></i> Add Division
                </button>
            @endcan

        </div>

        <table class="table table-striped" id="divisionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    @canany(['Edit Division', 'Delete Division'])
                        <th>Actions</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($divisions as $division)
                    <tr id="division-{{ $division->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="division-name">{{ $division->name }}</td>
                        <td>{{ $division->created_at->format('Y-m-d') }}</td>
                        @canany(['Edit Division', 'Delete Division'])
                            <td>
                                @can('Edit Division')
                                    <button class="btn btn-sm btn-info editBtn" data-id="{{ $division->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                @endcan
                                @can('Delete Division')
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $division->id }}">
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

    <!-- Modal (used for both Add and Edit) -->
    <div class="modal fade" id="divisionModal" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="divisionForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="divisionModalLabel">Add Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="divisionId">
                        <div class="mb-3">
                            <label for="divisionName" class="form-label">Division Name</label>
                            <input type="text" class="form-control" id="divisionName" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveDivisionBtn">
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
            const modal = new bootstrap.Modal(document.getElementById('divisionModal'));
            const addBtn = document.getElementById('addDivisionBtn');
            const form = document.getElementById('divisionForm');
            const nameInput = document.getElementById('divisionName');
            const divisionIdInput = document.getElementById('divisionId');
            const nameError = document.getElementById('nameError');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Open modal for Add
            addBtn.addEventListener('click', () => {
                form.reset();
                divisionIdInput.value = '';
                document.getElementById('divisionModalLabel').textContent = 'Add Division';
                nameError.textContent = '';
                nameInput.classList.remove('is-invalid');
                modal.show();
            });

            // Open modal for Edit
            document.querySelectorAll('.editBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    fetch(`/admin/divisions/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            divisionIdInput.value = data.id;
                            nameInput.value = data.name;
                            document.getElementById('divisionModalLabel').textContent =
                                'Edit Division';
                            nameError.textContent = '';
                            nameInput.classList.remove('is-invalid');
                            modal.show();
                        });
                });
            });

            // Save division (create or update)
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                nameError.textContent = '';
                nameInput.classList.remove('is-invalid');

                const id = divisionIdInput.value;
                const url = id ? `/admin/divisions/${id}` : '/admin/divisions';
                const method = id ? 'PUT' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            name: nameInput.value
                        })
                    })
                    .then(async res => {
                        if (res.status === 422) {
                            const data = await res.json();
                            nameError.textContent = data.errors.name ? data.errors.name[0] : '';
                            nameInput.classList.add('is-invalid');
                        } else {
                            return res.json();
                        }
                    })
                    .then(data => {
                        if (data) {
                            const rowId = `division-${data.division.id}`;
                            const rowHtml = `
                <tr id="${rowId}">
                    <td>${data.division.id}</td>
                    <td class="division-name">${data.division.name}</td>
                    <td>${data.division.created_at.split('T')[0]}</td>
                    <td>
                        <button class="btn btn-sm btn-info editBtn" data-id="${data.division.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.division.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;

                            if (id) {
                                document.getElementById(rowId).outerHTML = rowHtml;
                            } else {
                                document.querySelector('#divisionsTable tbody').insertAdjacentHTML(
                                    'beforeend', rowHtml);
                            }
                            modal.hide();
                            Swal.fire('Success', data.message, 'success').then(() => location.reload());
                        }
                    });
            });

            // Delete division
            document.addEventListener('click', function(e) {
                if (e.target.closest('.deleteBtn')) {
                    const id = e.target.closest('.deleteBtn').dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the division!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/divisions/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                                        document.getElementById(`division-${id}`)
                                            .remove();
                                    });
                                });
                        }
                    });
                }
            });
        });
    </script>
@endpush
