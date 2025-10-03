@extends('dashboard.layouts.admin')
@section('title', __('template.category.title'))

@section('content')
<div class="app-content-header py-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="mb-0 page-title">{{ __('template.category.title') }}</h3>
            </div>
            <div class="col-sm-6 text-end">
                <button class="btn btn-success btn-modern" id="addCategoryBtn">
                    <i class="bi bi-plus-circle"></i> {{ __('template.category.add') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="app-content py-3">
    <div class="container-fluid">
        <div class="row g-3" id="categoriesContainer">
            @foreach($categories as $category)
                <div class="col-md-4" id="category-{{ $category->id }}">
                    <div class="card shadow-sm p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{ $category->name }}</h5>
                            <div>
                                <button class="btn btn-sm btn-info editBtn" data-id="{{ $category->id }}">
                                    {{ __('template.edit') }}
                                </button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $category->id }}">
                                    {{ __('template.delete') }}
                                </button>
                            </div>
                        </div>
                        <small>{{ $category->is_active ? __('template.active') : __('template.inactive') }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="categoryForm" class="modal-content">
            @csrf
            <input type="hidden" id="categoryId">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">{{ __('template.category.add') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nameEn" class="form-label">{{ __('template.category.name_en') }}</label>
                    <input type="text" class="form-control" id="nameEn" name="name_en" required>
                    <div class="invalid-feedback" id="nameEnError"></div>
                </div>
                <div class="mb-3">
                    <label for="nameBn" class="form-label">{{ __('template.category.name_bn') }}</label>
                    <input type="text" class="form-control" id="nameBn" name="name_bn">
                    <div class="invalid-feedback" id="nameBnError"></div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="isActive" name="is_active" checked>
                    <label class="form-check-label" for="isActive">
                        {{ __('template.active') }}
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveCategoryBtn">{{ __('template.save') }}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('template.cancel') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('categoryModal');
    const modal = new bootstrap.Modal(modalEl);
    const addBtn = document.getElementById('addCategoryBtn');
    const form = document.getElementById('categoryForm');
    const idInput = document.getElementById('categoryId');
    const nameEnInput = document.getElementById('nameEn');
    const nameBnInput = document.getElementById('nameBn');
    const isActiveInput = document.getElementById('isActive');
    const container = document.getElementById('categoriesContainer');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    addBtn.addEventListener('click', () => {
        idInput.value = '';
        form.reset();
        modal.show();
        document.getElementById('categoryModalLabel').textContent = "{{ __('template.category.add') }}";
    });

    document.addEventListener('click', function(e){
        if(e.target.closest('.editBtn')){
            const btn = e.target.closest('.editBtn');
            const id = btn.dataset.id;
            fetch(`/admin/message-template-categories/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    idInput.value = data.id;
                    nameEnInput.value = data.name_en;
                    nameBnInput.value = data.name_bn;
                    isActiveInput.checked = data.is_active;
                    document.getElementById('categoryModalLabel').textContent = "{{ __('template.category.edit') }}";
                    modal.show();
                });
        }
        if(e.target.closest('.deleteBtn')){
            const btn = e.target.closest('.deleteBtn');
            const id = btn.dataset.id;
            Swal.fire({
                title: "{{ __('template.confirm_delete') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('template.yes_delete') }}",
                cancelButtonText: "{{ __('template.cancel') }}",
            }).then(result => {
                if(result.isConfirmed){
                    fetch(`/admin/message-template-categories/${id}`, {
                        method: 'DELETE',
                        headers: {'X-CSRF-TOKEN': token}
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById(`category-${id}`).remove();
                        Swal.fire('{{ __("template.deleted") }}', data.message, 'success');
                    });
                }
            });
        }
    });

    form.addEventListener('submit', function(e){
        e.preventDefault();
        const id = idInput.value;
        const url = id ? `/admin/message-template-categories/${id}` : '/admin/message-template-categories';
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
                is_active: isActiveInput.checked ? 1 : 0
            })
        })
        .then(async res => {
            if(res.status === 422){
                const data = await res.json();
                // simple validation handling
                alert(Object.values(data.errors).flat().join('\n'));
            } else return res.json();
        })
        .then(data => {
            if(data){
                const cardHtml = `
                    <div class="col-md-4" id="category-${data.category.id}">
                        <div class="card shadow-sm p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>${data.category.name_en}</h5>
                                <div>
                                    <button class="btn btn-sm btn-info editBtn" data-id="${data.category.id}">{{ __('template.edit') }}</button>
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.category.id}">{{ __('template.delete') }}</button>
                                </div>
                            </div>
                            <small>${data.category.is_active ? "{{ __('template.active') }}" : "{{ __('template.inactive') }}"}</small>
                        </div>
                    </div>
                `;
                if(id){
                    document.getElementById(`category-${id}`).outerHTML = cardHtml;
                } else {
                    container.insertAdjacentHTML('beforeend', cardHtml);
                }
                modal.hide();
                Swal.fire('{{ __("template.success") }}', data.message, 'success');
            }
        });
    });
});
</script>
@endpush
@endsection
