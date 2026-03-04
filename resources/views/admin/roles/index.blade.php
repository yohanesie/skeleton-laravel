@extends('layouts.app')

@section('title', 'Roles')
@section('breadcrumb', 'Management / Roles')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-shield-fill me-2 text-warning"></i>Roles</span>
        @if(auth()->user()->canDo('roles.create'))
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Role
        </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th class="text-center">Users</th>
                        <th class="text-center">Permissions</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>
                            <span class="badge badge-role rounded-pill fs-6 px-3 py-2">{{ $role->label }}</span>
                        </td>
                        <td><code class="text-muted">{{ $role->name }}</code></td>
                        <td class="text-muted small">{{ $role->description ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill">{{ $role->users_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success rounded-pill">{{ $role->permissions_count }}</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                @if(auth()->user()->canDo('roles.view'))
                                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-secondary" title="View">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @endif
                                @if(auth()->user()->canDo('roles.edit'))
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @endif
                                @if(auth()->user()->canDo('roles.delete'))
                                <button type="button" class="btn btn-outline-danger btn-delete" title="Delete"
                                        data-url="{{ route('admin.roles.destroy', $role) }}"
                                        data-name="{{ $role->label }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No roles found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($roles->hasPages())
    <div class="card-footer">{{ $roles->links() }}</div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Delete Role</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Delete role <strong id="deleteName"></strong>?</div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.btn-delete').on('click', function () {
    $('#deleteName').text($(this).data('name'));
    $('#deleteForm').attr('action', $(this).data('url'));
    new bootstrap.Modal('#deleteModal').show();
});
</script>
@endpush
