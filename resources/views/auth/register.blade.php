<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Inventory Management</title>
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
            padding: 20px;
        }

        .register-card {
            background: #fff;
            border-radius: 20px;
            padding: 44px 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 60px rgba(0,0,0,.2);
        }

        .register-logo {
            width: 60px;
            height: 60px;
            background: #10b981;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 16px;
        }

        .register-card h2 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            text-align: center;
            margin-bottom: 4px;
        }

        .register-card .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group label .required { color: #ef4444; }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all .15s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            margin-top: 6px;
        }

        .btn-register:hover { background: #059669; transform: translateY(-1px); }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .field-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 4px;
        }

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

        .login-box {
            text-align: center;
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #f3f4f6;
        }

        .login-box p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .login-box a {
            color: #4f46e5;
            font-weight: 700;
            text-decoration: none;
            transition: all .15s;
        }

        .login-box a:hover {
            color: #3730a3;
            text-decoration: underline;
        }

        .password-strength {
            height: 4px;
            border-radius: 4px;
            background: #e5e7eb;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength .bar {
            height: 100%;
            border-radius: 4px;
            transition: width .3s, background .3s;
            width: 0%;
        }

        .strength-text {
            font-size: 11px;
            margin-top: 4px;
            font-weight: 500;
        }

        @media (max-width: 500px) {
            .form-row { grid-template-columns: 1fr; }
            .register-card { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="register-logo">🔐</div>
        <h2>Create Account</h2>
        <p class="subtitle">Join Inventory Pro to manage your stock</p>

        {{-- Errors --}}
        @if($errors->any())
            <div class="error-message">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            {{-- Full Name & Username --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="name"
                           placeholder="John Doe"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Username <span class="required">*</span></label>
                    <input type="text" name="username"
                           placeholder="johndoe"
                           value="{{ old('username') }}">
                    @error('username')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email"
                       placeholder="john@example.com"
                       value="{{ old('email') }}">
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password & Confirm --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" id="password"
                           placeholder="Min 8 characters"
                           minlength="8"
                           oninput="checkPasswordStrength(this.value)">
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                    {{-- Password Strength Bar --}}
                    <div class="password-strength">
                        <div class="bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label>Confirm Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation"
                           placeholder="Re-enter password"
                           minlength="8">
                </div>
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus-fill"></i> Create Account
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider">
            <span>OR</span>
        </div>

        {{-- Login Link --}}
        <div class="login-box">
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </div>

    <script>
        function checkPasswordStrength(password) {
            const bar  = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let score  = 0;

            if (password.length >= 8)              score++;
            if (password.length >= 12)             score++;
            if (/[a-z]/.test(password))            score++;
            if (/[A-Z]/.test(password))            score++;
            if (/[0-9]/.test(password))            score++;
            if (/[^a-zA-Z0-9]/.test(password))    score++;

            const levels = [
                { width: '0%',   color: '#e5e7eb', label: '',           labelColor: '#9ca3af' },
                { width: '16%',  color: '#ef4444', label: 'Very Weak',  labelColor: '#ef4444' },
                { width: '33%',  color: '#f59e0b', label: 'Weak',       labelColor: '#f59e0b' },
                { width: '50%',  color: '#f59e0b', label: 'Fair',       labelColor: '#f59e0b' },
                { width: '70%',  color: '#10b981', label: 'Good',       labelColor: '#10b981' },
                { width: '85%',  color: '#10b981', label: 'Strong',     labelColor: '#10b981' },
                { width: '100%', color: '#059669', label: 'Very Strong', labelColor: '#059669' },
            ];

            const level = levels[Math.min(score, levels.length - 1)];
            bar.style.width      = level.width;
            bar.style.background = level.color;
            text.textContent     = level.label;
            text.style.color     = level.labelColor;
        }
    </script>

</body>
</html>