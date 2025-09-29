@extends('dashboard.layouts.admin')

@section('title', 'Courts')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Courts</h2>
            @can('Create Court')
                <button class="btn btn-primary" id="addCourtBtn">
                    <i class="bi bi-plus-circle"></i> {{ __('court.add_court') }}
                </button>
            @endcan
        </div>

        <table class="table table-striped" id="courtsTable">
            <thead>
                <tr>
                    <th>{{ __('court.id') }}</th>
                    <th>{{ __('court.name_en') }}</th>
                    <th>{{ __('court.name_bn') }}</th>
                    <th>{{ __('court.district') }}</th>
                    <th>{{ __('court.created_at') }}</th>
                    @canany(['Edit Court', 'Delete Court'])
                        <th>{{ __('courts.actions') }}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($courts as $court)
                    <tr id="court-{{ $court->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="court-name-en">{{ $court->name_en }}</td>
                        <td class="court-name-bn">{{ $court->name_bn }}</td>
                        <td class="court-district">
                            {{ session('locale') === 'bn' ? $court->district->name_bn : $court->district->name_en }}
                        </td>
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
                        <h5 class="modal-title" id="courtModalLabel">{{ __('court.add_court') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ __('court.cancel') }}"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="courtId">

                        <div class="mb-3">
                            <label for="courtNameEn" class="form-label">{{ __('court.name_en') }}</label>
                            <input type="text" class="form-control" id="courtNameEn" name="name_en" required>
                            <div class="invalid-feedback" id="nameEnError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="courtNameBn" class="form-label">{{ __('court.name_bn') }}</label>
                            <input type="text" class="form-control" id="courtNameBn" name="name_bn" required>
                            <div class="invalid-feedback" id="nameBnError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="districtSelect" class="form-label">{{ __('court.select_district') }}</label>
                            <select class="form-select" id="districtSelect" name="district_id" required>
                                <option value="">{{ __('court.select_district') }}</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="districtError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveCourtBtn">
                            <i class="bi bi-check-circle"></i> {{ __('court.save') }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('court.cancel') }}</button>
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
            const modal = new bootstrap.Modal(document.getElementById('courtModal'));
            const addBtn = document.getElementById('addCourtBtn');
            const form = document.getElementById('courtForm');
            const nameEnInput = document.getElementById('courtNameEn');
            const nameBnInput = document.getElementById('courtNameBn');
            const districtSelect = document.getElementById('districtSelect');
            const courtIdInput = document.getElementById('courtId');
            const nameEnError = document.getElementById('nameEnError');
            const nameBnError = document.getElementById('nameBnError');
            const districtError = document.getElementById('districtError');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const currentLocale = "{{ session('locale', app()->getLocale()) }}";

            // Open modal for Add
            addBtn.addEventListener('click', () => {
                form.reset();
                courtIdInput.value = '';
                document.getElementById('courtModalLabel').textContent = '{{ __('court.add_court') }}';
                clearErrors();
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
                            nameEnInput.value = data.name_en;
                            nameBnInput.value = data.name_bn;
                            districtSelect.value = data.district_id;
                            document.getElementById('courtModalLabel').textContent =
                                '{{ __('court.edit_court') }}';
                            clearErrors();
                            modal.show();
                        });
                });
            });

            // Save (Add or Update)
            // Inside your form submit handler, after adding is-invalid classes
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                districtError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');
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
                            name_en: nameEnInput.value,
                            name_bn: nameBnInput.value,
                            district_id: districtSelect.value
                        })
                    })
                    .then(async res => {
                        if (res.status === 422) {
                            const data = await res.json();
                            let firstInvalid = null;

                            if (data.errors.name_en) {
                                nameEnError.textContent = data.errors.name_en[0];
                                nameEnInput.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = nameEnInput;
                            }
                            if (data.errors.name_bn) {
                                nameBnError.textContent = data.errors.name_bn[0];
                                nameBnInput.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = nameBnInput;
                            }
                            if (data.errors.district_id) {
                                districtError.textContent = data.errors.district_id[0];
                                districtSelect.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = districtSelect;
                            }

                            // Focus the first invalid field
                            if (firstInvalid) firstInvalid.focus();

                        } else {
                            return res.json();
                        }
                    })
                    .then(data => {
                        if (data) {
                            const rowId = `court-${data.court.id}`;
                            const rowHtml = `
            <tr id="${rowId}">
                <td>${data.court.id}</td>
                <td class="court-name-en">${data.court.name_en}</td>
                <td class="court-name-bn">${data.court.name_bn}</td>
                <td class="court-district">
                    ${currentLocale === 'bn' ? (data.court.district?.name_bn ?? '-') : (data.court.district?.name_en ?? '-')}
                </td>
                <td>${data.court.created_at.split('T')[0]}</td>
                <td>
                    <button class="btn btn-sm btn-info editBtn" data-id="${data.court.id}"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.court.id}"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>`;

                            if (id) {
                                document.getElementById(rowId).outerHTML = rowHtml;
                            } else {
                                document.querySelector('#courtsTable tbody').insertAdjacentHTML(
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
                        text: "{{ __('court.delete_court') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/courts/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    }
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

            // -----------------------------
            // Helper functions
            // -----------------------------
            function clearErrors() {
                nameEnError.textContent = '';
                nameBnError.textContent = '';
                districtError.textContent = '';
                nameEnInput.classList.remove('is-invalid');
                nameBnInput.classList.remove('is-invalid');
                districtSelect.classList.remove('is-invalid');
            }

            function handleValidationErrors(errors) {
                if (errors.name_en) {
                    nameEnError.textContent = errors.name_en[0];
                    nameEnInput.classList.add('is-invalid');
                }
                if (errors.name_bn) {
                    nameBnError.textContent = errors.name_bn[0];
                    nameBnInput.classList.add('is-invalid');
                }
                if (errors.district_id) {
                    districtError.textContent = errors.district_id[0];
                    districtSelect.classList.add('is-invalid');
                }
            }
        });
    </script>
@endpush
