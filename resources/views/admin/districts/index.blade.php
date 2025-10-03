@extends('dashboard.layouts.admin')

@section('title', __('district.title'))

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('district.title') }}</h2>
            @can('Create District')
                <button class="btn btn-primary" id="addDistrictBtn">
                    <i class="bi bi-plus-circle"></i> {{ __('district.add') }}
                </button>
            @endcan
        </div>

        <table class="table table-striped" id="districtsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('district.name_en') }}</th>
                    <th>{{ __('district.name_bn') }}</th>
                    <th>{{ __('district.division') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    @canany(['Edit District', 'Delete District'])
                        <th>{{ __('district.actions') }}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($districts as $district)
                    <tr id="district-{{ $district->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $district->name_en }}</td>
                        <td>{{ $district->name_bn }}</td>
                        <td>{{ session('locale') === 'bn' ? $district->division->name_bn : $district->division->name_en }}
                        </td>
                        <td>
                            @if ($district->is_active)
                                <span class="badge bg-success">{{ __('messages.active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('messages.inactive') }}</span>
                            @endif
                        </td>
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
                        <h5 class="modal-title" id="districtModalLabel">{{ __('district.add') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ __('district.close') }}"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="districtId">
                        <div class="mb-3">
                            <label for="districtNameEn" class="form-label">{{ __('district.name_en') }}</label>
                            <input type="text" class="form-control" id="districtNameEn" name="name_en" required>
                            <div class="invalid-feedback" id="nameEnError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="districtNameBn" class="form-label">{{ __('district.name_bn') }}</label>
                            <input type="text" class="form-control" id="districtNameBn" name="name_bn" required>
                            <div class="invalid-feedback" id="nameBnError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="divisionSelect" class="form-label">{{ __('district.division') }}</label>
                            <select class="form-select" id="divisionSelect" name="division_id" required>
                                <option value="">{{ __('district.select_division') }}</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">
                                        {{ session('locale') === 'bn' ? $division->name_bn : $division->name_en }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback" id="divisionError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">{{ __('district.status') }}</label>
                            <select class="form-select" id="statusSelect" name="is_active" required>
                                <option value="1">{{ __('district.active') }}</option>
                                <option value="0">{{ __('district.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveDistrictBtn">
                            <i class="bi bi-check-circle"></i> {{ __('district.save') }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('district.cancel') }}</button>
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
            const modal = new bootstrap.Modal(document.getElementById('districtModal'));
            const addBtn = document.getElementById('addDistrictBtn');
            const form = document.getElementById('districtForm');
            const nameEnInput = document.getElementById('districtNameEn');
            const nameBnInput = document.getElementById('districtNameBn');
            const divisionSelect = document.getElementById('divisionSelect');
            const statusSelect = document.getElementById('statusSelect');
            const districtIdInput = document.getElementById('districtId');
            const nameEnError = document.getElementById('nameEnError');
            const nameBnError = document.getElementById('nameBnError');
            const divisionError = document.getElementById('divisionError');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const currentLocale = "{{ session('locale', app()->getLocale()) }}";

            // === Open Add Modal ===
            addBtn.addEventListener('click', () => {
                form.reset();
                districtIdInput.value = '';
                document.getElementById('districtModalLabel').textContent = '{{ __('district.add') }}';
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                divisionError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');
                divisionSelect.classList.remove('is-invalid');
                modal.show();
            });

            // === Open Edit Modal ===
            document.addEventListener('click', function(e) {
                if (e.target.closest('.editBtn')) {
                    const id = e.target.closest('.editBtn').dataset.id;
                    fetch(`/admin/districts/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            districtIdInput.value = data.id;
                            nameEnInput.value = data.name_en;
                            nameBnInput.value = data.name_bn;
                            divisionSelect.value = data.division_id;
                            statusSelect.value = data.is_active ? 1 : 0;
                            document.getElementById('districtModalLabel').textContent =
                                '{{ __('district.edit') }}';
                            nameEnError.textContent = '';
                            nameBnError.textContent = '';
                            divisionError.textContent = '';
                            nameEnInput.classList.remove('is-invalid');
                            nameBnInput.classList.remove('is-invalid');
                            divisionSelect.classList.remove('is-invalid');
                            modal.show();
                        });
                }
            });

            // === Save District ===
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                divisionError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');
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
                        name_en: nameEnInput.value,
                        name_bn: nameBnInput.value,
                        division_id: divisionSelect.value,
                        is_active: statusSelect.value
                    })
                }).then(async res => {
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
                        if (data.errors.division_id) {
                            divisionError.textContent = data.errors.division_id[0];
                            divisionSelect.classList.add('is-invalid');
                        }
                    } else {
                        return res.json();
                    }
                }).then(data => {
                    if (data) {
                        const rowId = `district-${data.district.id}`;
                        const isActive = data.district.is_active == 1 || data.district.is_active ===
                            true;
                        const rowHtml = `
                            <tr id="${rowId}">
                                <td>${data.district.id}</td>
                                <td>${data.district.name_en}</td>
                                <td>${data.district.name_bn}</td>
                                <td>${currentLocale === 'bn' ? (data.district.division?.name_bn ?? '-') : (data.district.division?.name_en ?? '-')}</td>
                                <td>
                                    ${isActive 
                                        ? (currentLocale === 'bn' ? '<span class="badge bg-success">সক্রিয়</span>' : '<span class="badge bg-success">Active</span>') 
                                        : (currentLocale === 'bn' ? '<span class="badge bg-danger">নিষ্ক্রিয়</span>' : '<span class="badge bg-danger">Inactive</span>')}
                                </td>
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

            // === Delete District ===
            document.addEventListener('click', function(e) {
                if (e.target.closest('.deleteBtn')) {
                    const id = e.target.closest('.deleteBtn').dataset.id;
                    Swal.fire({
                        title: '{{ __('district.confirm_delete') }}',
                        text: '{{ __('district.confirm_delete_text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('district.yes_delete') }}'
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch(`/admin/districts/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    }
                                }).then(res => res.json())
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
