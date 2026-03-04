@extends('layouts.app')

@section('title', 'Users')
@section('breadcrumb', 'Management / Users')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-people-fill me-2 text-primary"></i>Users</span>
        @if(auth()->user()->canDo('users.create'))
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add User
        </a>
        @endif
    </div>
    <div class="card-body border-bottom py-2">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->avatar_url }}" class="rounded-circle" width="38" height="38">
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-role rounded-pill me-1">{{ $role->label }}</span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                @if(auth()->user()->canDo('users.view'))
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary" title="View">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @endif
                                @if(auth()->user()->canDo('users.edit'))
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @endif
                                @if(auth()->user()->canDo('users.delete') && $user->id !== auth()->id())
                                <button type="button" class="btn btn-outline-danger btn-delete" title="Delete"
                                        data-url="{{ route('admin.users.destroy', $user) }}"
                                        data-name="{{ $user->name }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</small>
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Confirm Delete</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Delete user <strong id="deleteName"></strong>?</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
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
    const url = $(this).data('url');
    const name = $(this).data('name');
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', url);
    new bootstrap.Modal('#deleteModal').show();
});
</script>
@endpush
