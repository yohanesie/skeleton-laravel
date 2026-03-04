@extends('layouts.app')

@section('title', 'Permissions')
@section('breadcrumb', 'Management / Permissions')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-key-fill me-2 text-info"></i>Permissions</span>
        @if(auth()->user()->canDo('permissions.create'))
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Permission
        </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Group</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                    <tr>
                        <td><code>{{ $permission->name }}</code></td>
                        <td>{{ $permission->label }}</td>
                        <td>
                            @if($permission->group)
                                <span class="badge bg-light text-dark border">{{ $permission->group }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                @if(auth()->user()->canDo('permissions.edit'))
                                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @endif
                                @if(auth()->user()->canDo('permissions.delete'))
                                <button class="btn btn-outline-danger btn-delete" title="Delete"
                                        data-url="{{ route('admin.permissions.destroy', $permission) }}"
                                        data-name="{{ $permission->label }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No permissions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($permissions->hasPages())
    <div class="card-footer">{{ $permissions->links() }}</div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body pt-4">Delete <strong id="deleteName"></strong>?</div>
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
