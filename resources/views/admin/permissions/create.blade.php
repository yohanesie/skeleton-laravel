@extends('layouts.app')

@section('title', 'Add Permission')
@section('breadcrumb', 'Management / Permissions / Add')

@section('content')
<div class="card" style="max-width:550px;margin:auto;">
    <div class="card-header"><i class="bi bi-key-fill me-2 text-info"></i>Add New Permission</div>
    <div class="card-body">
        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">Permission Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. posts.publish">
                <div class="form-text">Lowercase letters, dots, underscores only.</div>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Label <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                       value="{{ old('label') }}" placeholder="e.g. Publish Posts">
                @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Group</label>
                <input type="text" name="group" class="form-control" value="{{ old('group') }}"
                       placeholder="e.g. Posts" list="groupList">
                <datalist id="groupList">
                    @foreach($groups as $g) <option value="{{ $g }}"> @endforeach
                </datalist>
            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
