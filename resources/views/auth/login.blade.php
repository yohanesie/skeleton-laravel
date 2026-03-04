<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1e2a3a 0%, #2d3f54 50%, #1e2a3a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: #fff;
        }
        .login-header .brand-icon {
            width: 60px; height: 60px;
            background: rgba(255,255,255,.15);
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            backdrop-filter: blur(10px);
        }
        .login-body { padding: 2rem; background: #fff; }
        .form-control {
            padding: .65rem 1rem;
            border-radius: .6rem;
            border: 1.5px solid #e5e7eb;
            transition: all .2s;
        }
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #e5e7eb;
            border-right: none;
            border-radius: .6rem 0 0 .6rem;
            color: #9ca3af;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 .6rem .6rem 0;
        }
        .btn-login {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: .6rem;
            padding: .7rem;
            font-weight: 600;
            letter-spacing: .3px;
            transition: all .2s;
        }
        .btn-login:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,.35); }
        .toggle-password { cursor: pointer; }
        .invalid-feedback { display: block; }
    </style>
</head>
<body>

<div class="login-card card">
    <div class="login-header">
        <div class="brand-icon">
            <i class="bi bi-hexagon-fill"></i>
        </div>
        <h4 class="fw-bold mb-1">{{ config('app.name') }}</h4>
        <p class="mb-0 opacity-75 small">Sign in to your account</p>
    </div>

    <div class="login-body">
        @if($errors->any())
            <div class="alert alert-danger d-flex gap-2 align-items-center py-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate>
            @csrf

           <div class="mb-3">
                <label class="form-label fw-semibold small">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" 
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="Masukkan username" 
                        value="{{ old('username') }}" 
                        autocomplete="username" autofocus>
                </div>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" autocomplete="current-password">
                    <span class="input-group-text toggle-password" id="togglePassword" style="border-left:none;border-radius:0 .6rem .6rem 0;cursor:pointer;">
                        <i class="bi bi-eye-fill" id="eyeIcon"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-primary w-100 text-white" id="btnLogin">
                <span id="btnText"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</span>
                <span id="btnLoader" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2"></span>Signing in...
                </span>
            </button>
        </form>

        <div class="text-center mt-4">
            <small class="text-muted">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </small>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // Toggle password visibility
    $('#togglePassword').on('click', function () {
        const input = $('#passwordInput');
        const icon = $('#eyeIcon');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
        }
    });

    // Loading state on submit
    $('#loginForm').on('submit', function () {
        $('#btnText').addClass('d-none');
        $('#btnLoader').removeClass('d-none');
        $('#btnLogin').prop('disabled', true);
    });
</script>
</body>
</html>
