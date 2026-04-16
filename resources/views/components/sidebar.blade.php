<aside class="sidebar" id="sidebar">
    {{-- Header --}}
    <div class="sidebar-header">
        <div class="logo-icon">📦</div>
        <div>
            <h1>Inventory Pro</h1>
            <p>Management System</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-title">Transactions</div>
        <a href="{{ route('purchases.index') }}"
           class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <i class="bi bi-cart-fill"></i> Purchases
        </a>
        <a href="{{ route('sales.index') }}"
           class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="bi bi-currency-dollar"></i> Sales
        </a>

        <div class="nav-section-title">Inventory</div>
        <a href="{{ route('stock.index') }}"
           class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill"></i> Stock
        </a>

        <div class="nav-section-title">Reports</div>
        <a href="{{ route('reports.purchases.csv') }}"
           class="nav-link" target="_blank">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Purchases
        </a>
        <a href="{{ route('reports.sales.csv') }}"
           class="nav-link" target="_blank">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Sales
        </a>
        <a href="{{ route('reports.stock.csv') }}"
           class="nav-link" target="_blank">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Stock
        </a>
    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</aside>