@extends('dashboard.layouts.admin')
@section('title', __('template.message_templates'))

@section('content')
<div class="app-content-header py-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3 class="mb-0 page-title">{{ __('template.message_templates') }}</h3>
        @can('Create Message Template')
        <button class="btn btn-success" id="addTemplateBtn">
            <i class="bi bi-plus-circle"></i> {{ __('template.add_template') }}
        </button>
        @endcan
    </div>
</div>

<div class="app-content py-3">
    <div class="container-fluid">
        <div class="row g-3" id="templatesContainer">
            @foreach($templates as $template)
            <div class="col-md-4" id="template-{{ $template->id }}">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>{{ $template->title }}</h5>
                                <small class="text-muted">
                                    {{ $template->category ? (app()->getLocale() === 'bn' ? $template->category->name_bn : $template->category->name_en) : '' }}
                                </small>
                            </div>
                            <div>
                                @can('Edit Message Template')
                                <button class="btn btn-sm btn-info editBtn" data-id="{{ $template->id }}">
                                    <i class="bi bi-pencil-square"></i> {{ __('template.edit') }}
                                </button>
                                @endcan
                                @can('Delete Message Template')
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $template->id }}">
                                    <i class="bi bi-trash"></i> {{ __('template.delete') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        <p class="mb-1"><strong>{{ __('template.channel') }}:</strong> {{ ucfirst($template->channel) }}</p>
                        <p class="mb-0"><strong>{{ __('template.status') }}:</strong> {{ $template->is_active ? __('template.active') : __('template.inactive') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div class="modal fade" id="templateModal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <form id="templateForm" class="modal-content">
        @csrf
        <input type="hidden" id="templateId">
        <div class="modal-header">
            <h5 class="modal-title" id="templateModalLabel">{{ __('template.add_template') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">{{ __('template.title') }}</label>
                <input type="text" name="title" id="title" class="form-control" required>
                <div class="invalid-feedback" id="titleError"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('template.category') }}</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">{{ __('template.select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ app()->getLocale() === 'bn' ? $category->name_bn : $category->name_en }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="categoryError"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('template.channel') }}</label>
                <select name="channel" id="channel" class="form-select">
                    <option value="sms">{{ __('template.sms') }}</option>
                    <option value="whatsapp">{{ __('template.whatsapp') }}</option>
                    <option value="both">{{ __('template.both') }}</option>
                    <option value="email">{{ __('template.email') }}</option>
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label>{{ __('template.body_en_sms') }}</label>
                    <textarea name="body_en_sms" id="body_en_sms" class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label>{{ __('template.body_en_whatsapp') }}</label>
                    <textarea name="body_en_whatsapp" id="body_en_whatsapp" class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label>{{ __('template.body_bn_sms') }}</label>
                    <textarea name="body_bn_sms" id="body_bn_sms" class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label>{{ __('template.body_bn_whatsapp') }}</label>
                    <textarea name="body_bn_whatsapp" id="body_bn_whatsapp" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                    <label>{{ __('template.body_email') }}</label>
                    <textarea name="body_email" id="body_email" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                <label for="is_active" class="form-check-label">{{ __('template.active') }}</label>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">{{ __('template.save') }}</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('template.cancel') }}</button>
        </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const modalEl = document.getElementById('templateModal');
    const modal = new bootstrap.Modal(modalEl);
    const addBtn = document.getElementById('addTemplateBtn');
    const form = document.getElementById('templateForm');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const idInput = document.getElementById('templateId');

    addBtn?.addEventListener('click', ()=>{
        idInput.value = '';
        form.reset();
        document.getElementById('templateModalLabel').textContent = '{{ __("template.add_template") }}';
        modal.show();
    });

    document.addEventListener('click', function(e){
        if(e.target.closest('.editBtn')){
            const id = e.target.closest('.editBtn').dataset.id;
            fetch(`/admin/message-templates/${id}/edit`)
            .then(res=>res.json())
            .then(data=>{
                idInput.value = data.id;
                form.title.value = data.title;
                form.category_id.value = data.category_id ?? '';
                form.channel.value = data.channel;
                form.body_en_sms.value = data.body_en_sms ?? '';
                form.body_en_whatsapp.value = data.body_en_whatsapp ?? '';
                form.body_bn_sms.value = data.body_bn_sms ?? '';
                form.body_bn_whatsapp.value = data.body_bn_whatsapp ?? '';
                form.body_email.value = data.body_email ?? '';
                form.is_active.checked = data.is_active;
                document.getElementById('templateModalLabel').textContent = '{{ __("template.edit_template") }}';
                modal.show();
            });
        }
        if(e.target.closest('.deleteBtn')){
            const id = e.target.closest('.deleteBtn').dataset.id;
            Swal.fire({
                title: '{{ __("template.are_you_sure") }}',
                text: "{{ __('template.delete_confirmation') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '{{ __("template.yes_delete") }}'
            }).then((result)=>{
                if(result.isConfirmed){
                    fetch(`/admin/message-templates/${id}`,{
                        method: 'DELETE',
                        headers: {'X-CSRF-TOKEN': token}
                    }).then(res=>res.json())
                    .then(data=>{
                        document.getElementById(`template-${id}`)?.remove();
                        Swal.fire('{{ __("template.deleted") }}', data.message, 'success');
                    });
                }
            });
        }
    });

    form.addEventListener('submit', function(e){
        e.preventDefault();
        const id = idInput.value;
        const url = id ? `/admin/message-templates/${id}` : '/admin/message-templates';
        const method = id ? 'PUT':'POST';

        const payload = {
            title: form.title.value,
            category_id: form.category_id.value,
            channel: form.channel.value,
            body_en_sms: form.body_en_sms.value,
            body_en_whatsapp: form.body_en_whatsapp.value,
            body_bn_sms: form.body_bn_sms.value,
            body_bn_whatsapp: form.body_bn_whatsapp.value,
            body_email: form.body_email.value,
            is_active: form.is_active.checked ? 1:0
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':token
            },
            body: JSON.stringify(payload)
        }).then(async res=>{
            if(res.status===422){
                const data = await res.json();
                Swal.fire('{{ __("template.error") }}', data.message || '{{ __("template.validation_failed") }}', 'error');
            } else {
                return res.json();
            }
        }).then(data=>{
            if(data){
                modal.hide();
                Swal.fire('{{ __("template.success") }}', data.message, 'success').then(()=>location.reload());
            }
        });
    });
});
</script>
@endpush
@endsection
