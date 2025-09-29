@extends('dashboard.layouts.admin')

@section('title', __('messages.divisions'))

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.divisions') }}</h2>
            @can('Create Division')
                <button class="btn btn-primary" id="addDivisionBtn">
                    <i class="bi bi-plus-circle"></i> {{ __('messages.add_division') }}
                </button>
            @endcan
        </div>

        <table class="table table-striped" id="divisionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.name_en') }}</th>
                    <th>{{ __('messages.name_bn') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    @canany(['Edit Division', 'Delete Division'])
                        <th>{{ __('messages.actions') }}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($divisions as $division)
                    <tr id="division-{{ $division->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="division-name-en">{{ $division->name_en }}</td>
                        <td class="division-name-bn">{{ $division->name_bn }}</td>
                        <td>
                            @if ($division->is_active)
                                <span class="badge bg-success">{{ __('messages.active') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('messages.inactive') }}</span>
                            @endif
                        </td>
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

    <!-- Modal (Add/Edit) -->
    <div class="modal fade" id="divisionModal" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="divisionForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="divisionModalLabel">{{ __('messages.add_division') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="divisionId">

                        <div class="mb-3">
                            <label for="divisionNameEn" class="form-label">{{ __('messages.division_name_en') }}</label>
                            <input type="text" class="form-control" id="divisionNameEn" name="name_en" required>
                            <div class="invalid-feedback" id="nameEnError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="divisionNameBn" class="form-label">{{ __('messages.division_name_bn') }}</label>
                            <input type="text" class="form-control" id="divisionNameBn" name="name_bn" required>
                            <div class="invalid-feedback" id="nameBnError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="isActive" class="form-label">{{ __('messages.status') }}</label>
                            <select class="form-select" id="isActive" name="is_active">
                                <option value="1">{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveDivisionBtn">
                            <i class="bi bi-check-circle"></i> {{ __('messages.save') }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
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

        .table thead {
            background: linear-gradient(135deg, #28a745, #1c7430);
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
            const divisionIdInput = document.getElementById('divisionId');
            const nameEnInput = document.getElementById('divisionNameEn');
            const nameBnInput = document.getElementById('divisionNameBn');
            const isActiveInput = document.getElementById('isActive');
            const nameEnError = document.getElementById('nameEnError');
            const nameBnError = document.getElementById('nameBnError');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Add Division
            addBtn.addEventListener('click', () => {
                form.reset();
                divisionIdInput.value = '';
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');
                document.getElementById('divisionModalLabel').textContent =
                    '{{ __('messages.add_division') }}';
                modal.show();
            });

            // Edit Division
            document.querySelectorAll('.editBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    fetch(`/admin/divisions/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            divisionIdInput.value = data.id;
                            nameEnInput.value = data.name_en;
                            nameBnInput.value = data.name_bn;
                            isActiveInput.value = data.is_active ? 1 : 0;
                            nameEnError.textContent = '';
                            nameBnError.textContent = '';
                            nameEnInput.classList.remove('is-invalid');
                            nameBnInput.classList.remove('is-invalid');
                            document.getElementById('divisionModalLabel').textContent =
                                '{{ __('messages.edit_division') }}';
                            modal.show();
                        });
                });
            });

            // Save Division
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');

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
                            name_en: nameEnInput.value,
                            name_bn: nameBnInput.value,
                            is_active: isActiveInput.value
                        })
                    })
                    .then(async res => {
                        if (res.status === 422) {
                            const data = await res.json();
                            if (data.errors.name_en) {
                                nameEnError.textContent = data.errors.name_en[0];
                                nameEnInput.classList.add('is-invalid');
                            }
                            if (data.errors.name_bn) {
                                nameBnError.textContent = data.errors.name_bn[0];
                                nameBnInput.classList.add('is-invalid');
                            }
                        } else {
                            return res.json();
                        }
                    })
                    .then(data => {
                        if (data) {
                            if (!data.success) {
                                Swal.fire('Error', data.message, 'error');
                                return;
                            }
                            Swal.fire('{{ __('messages.success') }}', data.message, 'success').then(
                            () => location.reload());
                        }
                    });
            });

            // Delete Division
            document.addEventListener('click', function(e) {
                if (e.target.closest('.deleteBtn')) {
                    const id = e.target.closest('.deleteBtn').dataset.id;
                    Swal.fire({
                        title: '{{ __('messages.confirm_delete') }}',
                        text: '{{ __('messages.confirm_delete_text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('messages.yes_delete') }}'
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch(`/admin/divisions/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (!data.success) {
                                        Swal.fire('Error', data.message, 'error');
                                        return;
                                    }
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
