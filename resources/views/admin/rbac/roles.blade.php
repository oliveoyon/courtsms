@extends('dashboard.layouts.admin')
@section('title', 'Roles')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Roles</h3>
            @can('Create Role')
            <button class="btn btn-primary" id="addRoleBtn">
                <i class="fas fa-plus"></i> Add Role
            </button>
            @endcan
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4" id="roleCards">
            @foreach($roles as $role)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm role-smart-card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-info">
                        <div>
                            <h5 class="mb-1">{{ $role->name }}</h5>
                            @if($role->name == 'Super Admin')
                            <span class="badge bg-danger">Super</span>
                            @endif
                        </div>
                        <div class="permissions-count">
                            <i class="fas fa-key"></i> {{ $role->permissions->count() }}
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Manage role actions and permissions.</p>
                        <div class="d-flex gap-2 flex-wrap">
                            @can('Edit Role')
                            <button class="btn btn-outline-primary btn-sm editBtn" data-id="{{ $role->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            @endcan
                            @can('Delete Role')
                            <button class="btn btn-outline-danger btn-sm deleteBtn" data-id="{{ $role->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            @endcan
                            @can('Assign Permissions')
                            <button class="btn btn-outline-success btn-sm assignBtn" data-id="{{ $role->id }}">
                                <i class="fas fa-user-shield"></i> Permissions
                            </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-footer text-end text-muted small">
                        {{ $role->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add/Edit Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="roleForm">
                @csrf
                <input type="hidden" id="roleId">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="roleName" class="form-control" placeholder="Role Name" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Permissions Modal -->
<div class="modal fade" id="assignPermissionsModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form id="assignPermissionsForm">
                @csrf
                <input type="hidden" id="assignRoleId">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Assign Permissions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="overflow-y:auto; max-height: calc(100vh - 150px);">
                    <div class="row g-3">
                        @foreach($permissions->groupBy('group.name') as $groupName => $groupPermissions)
                        @php $groupId = \Illuminate\Support\Str::slug($groupName ?? 'ungrouped'); @endphp
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card shadow-sm border-start border-success">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>{{ $groupName ?? 'Ungrouped' }}</strong>
                                    <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#group-{{ $groupId }}">
                                        View
                                    </button>
                                </div>
                                <div class="collapse" id="group-{{ $groupId }}">
                                    <div class="card-body bg-white">
                                        @foreach($groupPermissions as $perm)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input permissionCheckbox group-{{ $groupId }}" type="checkbox" value="{{ $perm->id }}" id="perm-{{ $perm->id }}">
                                            <label class="form-check-label" for="perm-{{ $perm->id }}">{{ $perm->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Permissions</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Smart Role Card Design */
.role-smart-card {
    border-radius: 12px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: none;
}
.role-smart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
}
.role-smart-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.role-smart-card .permissions-count {
    font-weight: bold;
    font-size: 0.9rem;
    background: #e2e3e5;
    padding: 4px 8px;
    border-radius: 12px;
}
.role-smart-card .card-body p {
    font-size: 0.85rem;
}
.role-smart-card .action-buttons button {
    min-width: 90px;
}
</style>
@endpush

@push('scripts')
<script>
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
const assignModal = new bootstrap.Modal(document.getElementById('assignPermissionsModal'));

// Add/Edit Role
document.getElementById('addRoleBtn').addEventListener('click', () => {
    document.getElementById('roleForm').reset();
    document.getElementById('roleId').value = '';
    roleModal.show();
});
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        fetch(`/admin/roles/${id}/edit`).then(r => r.json()).then(d => {
            document.getElementById('roleId').value = d.id;
            document.getElementById('roleName').value = d.name;
            roleModal.show();
        });
    });
});
document.getElementById('roleForm').addEventListener('submit', e => {
    e.preventDefault();
    const id = document.getElementById('roleId').value;
    const url = id ? `/admin/roles/${id}` : '/admin/roles';
    const method = id ? 'PUT' : 'POST';
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name: document.getElementById('roleName').value })
    }).then(r => r.json()).then(() => location.reload());
});

// Delete Role with SweetAlert2
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        Swal.fire({
            title: 'Are you sure?',
            text: "This role may be assigned to users.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                fetch(`/admin/roles/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token } })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            }
        });
    });
});

// Assign Permissions
document.querySelectorAll('.assignBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const roleId = btn.dataset.id;
        fetch(`/admin/roles/${roleId}/permissions`).then(r => r.json()).then(d => {
            document.getElementById('assignRoleId').value = d.role.id;
            document.querySelectorAll('.permissionCheckbox').forEach(c => c.checked = false);
            d.rolePermissions.forEach(pid => {
                const checkbox = document.querySelector(`.permissionCheckbox[value="${pid}"]`);
                if (checkbox) { checkbox.checked = true; checkbox.dispatchEvent(new Event('change')); }
            });
            assignModal.show();
        });
    });
});

// Save Permissions with SweetAlert2
document.getElementById('assignPermissionsForm').addEventListener('submit', e => {
    e.preventDefault();
    const roleId = document.getElementById('assignRoleId').value;
    const permissions = Array.from(document.querySelectorAll('.permissionCheckbox:checked')).map(c => parseInt(c.value));
    fetch(`/admin/roles/${roleId}/assign-permissions`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json','X-CSRF-TOKEN': token },
        body: JSON.stringify({ permissions })
    }).then(r => r.json()).then(d => {
        if(d.success){
            Swal.fire('Success', d.message, 'success');
            assignModal.hide();
        }
    });
});
</script>
@endpush
