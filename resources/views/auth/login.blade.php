<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Inventory Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.2);
        }

        .login-logo {
            width: 60px;
            height: 60px;
            background: #4f46e5;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 16px;
        }

        .login-card h2 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            text-align: center;
            margin-bottom: 4px;
        }

        .login-card .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all .15s;
        }

        .form-group input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-login:hover { background: #3730a3; transform: translateY(-1px); }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            text-align: center;
        }

        /* ─── Divider ────────────────────────────────── */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 14px;
            font-size: 12px;
            color: #9ca3af;
            font-weight: 500;
        }

        /* ─── Register Link Box ──────────────────────── */
        .register-box {
            text-align: center;
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #f3f4f6;
        }

        .register-box p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .register-box a {
            color: #4f46e5;
            font-weight: 700;
            text-decoration: none;
            transition: all .15s;
        }

        .register-box a:hover {
            color: #3730a3;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-logo">📦</div>
        <h2>Inventory Pro</h2>
        <p class="subtitle">Sign in to your account</p>

        {{-- Errors --}}
        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; text-align:center;">
                <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       placeholder="Enter your email"
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider">
            <span>OR</span>
        </div>

        {{-- Register Link --}}
        <div class="register-box">
            <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
        </div>
    </div>

</body>
</html>