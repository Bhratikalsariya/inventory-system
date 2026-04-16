<header class="top-navbar">
    <div class="d-flex align-items-center gap-3">
        {{-- Mobile Toggle --}}
        <button class="btn sidebar-toggle p-1" onclick="toggleSidebar()">
            <i class="bi bi-list" style="font-size:24px;"></i>
        </button>
        <h2>@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="d-flex align-items-center gap-3">
        <span class="text-muted" style="font-size:14px;">
            Welcome, <strong>{{ Auth::user()->full_name ?? Auth::user()->username ?? 'Admin' }}</strong>
        </span>
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->username ?? 'A', 0, 1)) }}
        </div>
    </div>
</header>