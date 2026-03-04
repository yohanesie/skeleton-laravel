<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - Admin Panel</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e2a3a;
            --sidebar-hover: #2d3f54;
            --sidebar-active: #4f46e5;
            --topbar-height: 60px;
        }

        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        #sidebar .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .sidebar-brand span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .5px;
        }
        #sidebar .nav-label {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,.35);
            padding: .75rem 1.5rem .25rem;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.72);
            padding: .6rem 1.5rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .9rem;
            transition: all .2s;
        }
        #sidebar .nav-link:hover { background: var(--sidebar-hover); color: #fff; }
        #sidebar .nav-link.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }
        #sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; }

        /* ── Main ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }
        #topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky; top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }
        .page-content { padding: 1.75rem; }

        /* ── Cards ── */
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: .75rem; }
        .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; font-weight: 600; padding: 1rem 1.25rem; }

        /* ── Table ── */
        .table th { font-size: .8rem; text-transform: uppercase; color: #6b7280; letter-spacing: .5px; font-weight: 600; }
        .table td { vertical-align: middle; }

        /* ── Badges ── */
        .badge-role { background: #ede9fe; color: #5b21b6; font-size: .72rem; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { left: calc(-1 * var(--sidebar-width)); }
            #sidebar.show { left: 0; }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-hexagon-fill me-2" style="color:#4f46e5;font-size:1.3rem;"></i>
        <span>{{ config('app.name') }}</span>
    </div>

    <div class="mt-2">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @if(auth()->user()->canDo('users.view'))
        <div class="nav-label">Management</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a>
        @endif

        @if(auth()->user()->canDo('roles.view'))
        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
            <i class="bi bi-shield-fill"></i> Roles
        </a>
        @endif

        @if(auth()->user()->canDo('permissions.view'))
        <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
            <i class="bi bi-key-fill"></i> Permissions
        </a>
        @endif
    </div>
</nav>

<!-- Main Content -->
<div id="main-content">
    <!-- Topbar -->
    <div id="topbar">
        <button class="btn btn-sm btn-light me-3 d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="fw-semibold text-secondary small">@yield('breadcrumb', 'Dashboard')</div>
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center gap-2 border-0 bg-transparent" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="34" height="34" alt="avatar">
                    <div class="text-start d-none d-sm-block">
                        <div class="fw-semibold" style="font-size:.85rem;line-height:1.1;">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:.72rem;">{{ auth()->user()->roles->pluck('label')->join(', ') }}</div>
                    </div>
                    <i class="bi bi-chevron-down small text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script>
    // CSRF setup for jQuery AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Sidebar toggle (mobile)
    $('#sidebarToggle').on('click', function() {
        $('#sidebar').toggleClass('show');
    });

    // Auto-dismiss alerts
    setTimeout(() => $('.alert').fadeOut('slow'), 5000);
</script>
@stack('scripts')
</body>
</html>
