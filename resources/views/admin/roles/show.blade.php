@extends('layouts.app')

@section('title', $role->label)
@section('breadcrumb', 'Management / Roles / Detail')

@section('content')
<div class="row g-3" style="max-width:900px;margin:auto;">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-3"
                     style="width:64px;height:64px;background:#fef3c7;">
                    <i class="bi bi-shield-fill text-warning fs-2"></i>
                </div>
                <h5 class="fw-bold">{{ $role->label }}</h5>
                <code class="text-muted">{{ $role->name }}</code>
                <p class="text-muted small mt-2">{{ $role->description ?? '—' }}</p>
                <div class="row text-center mt-3">
                    <div class="col-6 border-end">
                        <div class="fs-4 fw-bold text-primary">{{ $role->users->count() }}</div>
                        <div class="small text-muted">Users</div>
                    </div>
                    <div class="col-6">
                        <div class="fs-4 fw-bold text-success">{{ $role->permissions->count() }}</div>
                        <div class="small text-muted">Permissions</div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex gap-2 justify-content-center">
                @if(auth()->user()->canDo('roles.edit'))
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-fill me-1"></i>Edit
                </a>
                @endif
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-key-fill me-2 text-warning"></i>Permissions</div>
            <div class="card-body">
                @forelse($role->permissions->groupBy('group') as $group => $perms)
                    <div class="mb-3">
                        <div class="small fw-semibold text-muted text-uppercase mb-2" style="font-size:.7rem;">{{ $group }}</div>
                        @foreach($perms as $perm)
                            <span class="badge bg-light text-dark border me-1 mb-1">{{ $perm->label }}</span>
                        @endforeach
                    </div>
                @empty
                    <p class="text-muted mb-0">No permissions assigned.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-people-fill me-2 text-primary"></i>Users with this Role</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            @forelse($role->users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $user->avatar_url }}" class="rounded-circle" width="30" height="30">
                                        <div>
                                            <div class="fw-semibold small">{{ $user->name }}</div>
                                            <div class="text-muted" style="font-size:.7rem;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td class="text-muted small py-3 text-center">No users assigned.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
