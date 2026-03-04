@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    @php
        $cards = [
            ['label' => 'Total Users',       'value' => $stats['users'],       'icon' => 'bi-people-fill',      'color' => '#4f46e5', 'bg' => '#ede9fe'],
            ['label' => 'Active Users',       'value' => $stats['active'],      'icon' => 'bi-person-check-fill','color' => '#059669', 'bg' => '#d1fae5'],
            ['label' => 'Roles',              'value' => $stats['roles'],       'icon' => 'bi-shield-fill',      'color' => '#d97706', 'bg' => '#fef3c7'],
            ['label' => 'Permissions',        'value' => $stats['permissions'], 'icon' => 'bi-key-fill',         'color' => '#0891b2', 'bg' => '#cffafe'],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:{{ $card['bg'] }};flex-shrink:0;">
                    <i class="bi {{ $card['icon'] }} fs-4" style="color:{{ $card['color'] }};"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $card['value'] }}</div>
                    <div class="text-muted small">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-shield-fill text-warning"></i> Roles Overview
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Role</th>
                                <th class="text-center">Users</th>
                                <th class="text-center">Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Role::withCount(['users','permissions'])->get() as $role)
                            <tr>
                                <td>
                                    <span class="badge rounded-pill" style="background:#ede9fe;color:#5b21b6;">
                                        {{ $role->label }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $role->users_count }}</td>
                                <td class="text-center">{{ $role->permissions_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-primary"></i> Recent Users
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Roles</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::with('roles')->latest()->take(5)->get() as $user)
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
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-role rounded-pill">{{ $role->label }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
