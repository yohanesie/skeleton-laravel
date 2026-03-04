@extends('layouts.app')

@section('title', 'Add User')
@section('breadcrumb', 'Management / Users / Add')

@section('content')
<div class="card" style="max-width:700px;margin:auto;">
    <div class="card-header">
        <i class="bi bi-person-plus-fill me-2 text-primary"></i>Add New User
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="John Doe">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username') }}" placeholder="john_doe">
                    <div class="form-text">Huruf kecil, angka, underscore. Tidak bisa diubah setelah dibuat.</div>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="john@example.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="pw1" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 karakter">
                        <span class="input-group-text toggle-pw" data-target="pw1" style="cursor:pointer;"><i class="bi bi-eye-fill"></i></span>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="pw2" class="form-control" placeholder="Ulangi password">
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
                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->label }}
                                    <small class="text-muted d-block">{{ $role->description }}</small>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('roles') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Create User
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
    const isPass = target.attr('type') === 'password';
    target.attr('type', isPass ? 'text' : 'password');
    $(this).find('i').toggleClass('bi-eye-fill bi-eye-slash-fill');
});
</script>
@endpush