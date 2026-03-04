@extends('layouts.app')

@section('title', 'Edit User')
@section('breadcrumb', 'Management / Users / Edit')

@section('content')
<div class="card" style="max-width:700px;margin:auto;">
    <div class="card-header">
        <i class="bi bi-pencil-fill me-2 text-primary"></i>Edit User: {{ $user->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-muted"></i></span>
                        <input type="text" class="form-control bg-light text-muted" value="{{ $user->username }}" readonly>
                    </div>
                    <div class="form-text">Username tidak dapat diubah.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">New Password <span class="text-muted">(opsional)</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="pw1" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Kosongkan jika tidak ingin ubah">
                        <span class="input-group-text toggle-pw" data-target="pw1" style="cursor:pointer;"><i class="bi bi-eye-fill"></i></span>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="pw2" class="form-control"
                               placeholder="Ulangi password baru">
                        <span class="input-group-text toggle-pw" data-target="pw2" style="cursor:pointer;"><i class="bi bi-eye-fill"></i></span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Assign Roles</label>
                    <div class="row g-2">
                        @foreach($roles as $role)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                       id="role_{{ $role->id }}" value="{{ $role->id }}"
                                       {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->label }}
                                    <small class="text-muted d-block">{{ $role->description }}</small>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.toggle-pw').on('click', function() {
    const target = $('#' + $(this).data('target'));
    target.attr('type', target.attr('type') === 'password' ? 'text' : 'password');
    $(this).find('i').toggleClass('bi-eye-fill bi-eye-slash-fill');
});
</script>
@endpush