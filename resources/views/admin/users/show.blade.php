@extends('layouts.app')

@section('title', $user->name)
@section('breadcrumb', 'Management / Users / Detail')

@section('content')
<div class="row g-3" style="max-width:900px;margin:auto;">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $user->avatar_url }}" class="rounded-circle mb-3" width="80" height="80">
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                    {{ ucfirst($user->status) }}
                </span>
                <div class="mt-3">
                    @foreach($user->roles as $role)
                        <span class="badge badge-role rounded-pill me-1">{{ $role->label }}</span>
                    @endforeach
                </div>
                <div class="mt-3 text-muted small">
                    Joined {{ $user->created_at->format('d M Y') }}
                </div>
            </div>
            <div class="card-footer d-flex gap-2 justify-content-center">
                @if(auth()->user()->canDo('users.edit'))
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-fill me-1"></i>Edit
                </a>
                @endif
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-key-fill me-2 text-warning"></i>Permissions (via Roles)</div>
            <div class="card-body">
                @forelse($user->roles as $role)
                    <h6 class="fw-semibold mb-2">{{ $role->label }}</h6>
                    <div class="mb-3">
                        @forelse($role->permissions as $permission)
                            <span class="badge bg-light text-dark border me-1 mb-1">{{ $permission->label }}</span>
                        @empty
                            <span class="text-muted small">No permissions assigned.</span>
                        @endforelse
                    </div>
                @empty
                    <p class="text-muted">No roles assigned.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
