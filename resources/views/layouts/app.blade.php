<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory Management System')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ─── Root Variables ─────────────────────────────── */
        :root {
            --sidebar-width: 260px;
            --navbar-height: 64px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #818cf8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * { font-family: 'Inter', sans-serif; }
        body { background: var(--gray-50); overflow-x: hidden; }

        /* ─── Sidebar ────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--gray-900) 0%, #1a1a2e 100%);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo-icon {
            width: 42px;
            height: 42px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .sidebar-header h1 { font-size: 16px; font-weight: 700; margin: 0; }
        .sidebar-header p { font-size: 11px; color: var(--gray-400); margin: 2px 0 0; }

        .sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }

        .nav-section-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--gray-500);
            padding: 16px 12px 6px;
            font-weight: 600;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-300);
            transition: all .15s;
            margin-bottom: 2px;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79,70,229,.4);
        }

        .sidebar .nav-link i { font-size: 18px; width: 22px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        /* ─── Main Area ──────────────────────────────────── */
        .main-area {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Navbar ─────────────────────────────────────── */
        .top-navbar {
            height: var(--navbar-height);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .top-navbar h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        /* ─── Content ────────────────────────────────────── */
        .main-content { padding: 28px 32px; flex: 1; }

        /* ─── Summary Cards ──────────────────────────────── */
        .summary-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            border: 1px solid var(--gray-100);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .15s, box-shadow .15s;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,.1);
        }

        .summary-card .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .icon-blue   { background: #dbeafe; color: var(--info); }
        .icon-green  { background: #d1fae5; color: var(--success); }
        .icon-purple { background: #ede9fe; color: #7c3aed; }
        .icon-orange { background: #fef3c7; color: var(--warning); }
        .icon-red    { background: #fee2e2; color: var(--danger); }

        .summary-card .info h4 {
            font-size: 13px;
            color: var(--gray-500);
            font-weight: 500;
            margin: 0 0 4px;
        }

        .summary-card .info .value {
            font-size: 28px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
        }

        /* ─── Tables ─────────────────────────────────────── */
        .custom-table thead th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--gray-500);
            font-weight: 600;
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-200);
            padding: 12px 16px;
            white-space: nowrap;
        }

        .custom-table tbody td {
            padding: 14px 16px;
            font-size: 14px;
            color: var(--gray-700);
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-100);
        }

        .custom-table tbody tr:hover { background: var(--gray-50); }

        /* ─── Badges ─────────────────────────────────────── */
        .badge-stock-ok { background: #d1fae5; color: #065f46; }
        .badge-stock-low { background: #fef3c7; color: #92400e; }
        .badge-stock-out { background: #fee2e2; color: #991b1b; }

        /* ─── Cards ──────────────────────────────────────── */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            border: 1px solid var(--gray-100);
            overflow: hidden;
        }

        .content-card .card-header-custom {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }

        .content-card .card-header-custom h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        /* ─── Forms ──────────────────────────────────────── */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            padding: 10px 14px;
            font-size: 14px;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }

        .computed-field {
            background: var(--gray-50) !important;
            color: var(--gray-600);
            font-weight: 600;
        }

        /* ─── Buttons ────────────────────────────────────── */
        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            transition: all .15s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-success-custom {
            background: var(--success);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
        }

        .btn-success-custom:hover {
            filter: brightness(.9);
            color: #fff;
        }

        .btn-outline-custom {
            background: #fff;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            font-weight: 500;
            padding: 10px 22px;
            border-radius: 8px;
        }

        .btn-outline-custom:hover { background: var(--gray-50); }

        /* ─── Filter Bar ─────────────────────────────────── */
        .filter-bar {
            background: #fff;
            border-radius: 14px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border: 1px solid var(--gray-100);
            margin-bottom: 20px;
        }

        /* ─── Empty State ────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-400);
        }

        .empty-state .icon { font-size: 52px; margin-bottom: 12px; }
        .empty-state h4 { font-size: 16px; color: var(--gray-500); }
        .empty-state p { font-size: 14px; }

        /* ─── Modal Overrides ────────────────────────────── */
        .modal-content { border-radius: 16px; border: none; box-shadow: 0 25px 50px rgba(0,0,0,.15); }
        .modal-header { border-bottom: 1px solid var(--gray-200); padding: 20px 24px; }
        .modal-header .modal-title { font-size: 18px; font-weight: 700; }
        .modal-body { padding: 24px; }

        /* ─── Responsive ─────────────────────────────────── */
        .sidebar-toggle { display: none; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-area { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 1035;
            }
            .sidebar-overlay.show { display: block; }
        }

        /* ─── Profit Colors ──────────────────────────────── */
        .text-profit { color: var(--success); font-weight: 700; }
        .text-loss { color: var(--danger); font-weight: 700; }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Area --}}
    <div class="main-area">
        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Page Content --}}
        <main class="main-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"
                     style="border-radius:10px; border:none; background:#d1fae5; color:#065f46;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                     style="border-radius:10px; border:none; background:#fee2e2; color:#991b1b;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                     style="border-radius:10px; border:none; background:#fee2e2; color:#991b1b;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Auto-hide alerts after 5s
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>