@extends('layouts.app')

@section('title', 'Edit Permission')
@section('breadcrumb', 'Management / Permissions / Edit')

@section('content')
<div class="card" style="max-width:550px;margin:auto;">
    <div class="card-header"><i class="bi bi-pencil-fill me-2 text-info"></i>Edit Permission</div>
    <div class="card-body">
        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold small">Permission Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $permission->name) }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Label <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                       value="{{ old('label', $permission->label) }}">
                @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Group</label>
                <input type="text" name="group" class="form-control" value="{{ old('group', $permission->group) }}"
                       list="groupList">
                <datalist id="groupList">
                    @foreach($groups as $g) <option value="{{ $g }}"> @endforeach
                </datalist>
            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
