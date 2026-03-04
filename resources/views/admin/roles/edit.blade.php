@extends('layouts.app')

@section('title', 'Edit Role')
@section('breadcrumb', 'Management / Roles / Edit')

@section('content')
<div class="card" style="max-width:700px;margin:auto;">
    <div class="card-header"><i class="bi bi-pencil-fill me-2 text-warning"></i>Edit Role: {{ $role->label }}</div>
    <div class="card-body">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Role Slug <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $role->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Display Label <span class="text-danger">*</span></label>
                    <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                           value="{{ old('label', $role->label) }}">
                    @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold small">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $role->description) }}</textarea>
                </div>
            </div>

            <hr>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <label class="form-label fw-semibold small mb-0">Permissions</label>
                <a href="#" id="checkAll" class="small">Check All</a>
            </div>

            @php $assignedIds = $role->permissions->pluck('id')->toArray(); @endphp

            @foreach($permissions as $group => $groupPermissions)
            <div class="mb-3">
                <div class="fw-semibold small text-muted mb-2 text-uppercase" style="font-size:.7rem;letter-spacing:.8px;">{{ $group }}</div>
                <div class="row g-2">
                    @foreach($groupPermissions as $permission)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                   id="perm_{{ $permission->id }}" value="{{ $permission->id }}"
                                   {{ in_array($permission->id, old('permissions', $assignedIds)) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="perm_{{ $permission->id }}">
                                {{ $permission->label }}
                                <code class="text-muted" style="font-size:.65rem;">{{ $permission->name }}</code>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Role</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allChecked = false;
$('#checkAll').on('click', function(e) {
    e.preventDefault();
    allChecked = !allChecked;
    $('input[name="permissions[]"]').prop('checked', allChecked);
    $(this).text(allChecked ? 'Uncheck All' : 'Check All');
});
</script>
@endpush
