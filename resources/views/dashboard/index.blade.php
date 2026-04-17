@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- ── Summary Cards ──────────────────────────────── --}}
    <div class="row g-4 mb-4">
        @include('components.summary-card', [
            'icon' => 'bi-cart-fill',
            'iconClass' => 'icon-blue',
            'title' => 'Total Purchases',
            'value' => '₹' . number_format($totalPurchases, 2),
        ])

        @include('components.summary-card', [
            'icon' => 'bi-currency-dollar',
            'iconClass' => 'icon-green',
            'title' => 'Total Sales',
            'value' => '₹' . number_format($totalSales, 2),
        ])

        @include('components.summary-card', [
            'icon' => 'bi-box-seam-fill',
            'iconClass' => 'icon-purple',
            'title' => 'Inventory Value',
            'value' => '₹' . number_format($inventoryValue, 2),
        ])

        @include('components.summary-card', [
            'icon' => 'bi-exclamation-triangle-fill',
            'iconClass' => 'icon-orange',
            'title' => 'Low Stock Alerts',
            'value' => $lowStockCount,
        ])
    </div>

    {{-- ── Recent Purchases & Sales (Side by Side) ──── --}}
    <div class="row g-4 mb-4">

        {{-- Recent Purchases --}}
        <div class="col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h3><i class="bi bi-cart-fill text-primary me-2"></i>Recent Purchases</h3>
                    <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-custom">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPurchases as $purchase)
                                <tr>
                                    <td><strong>{{ $purchase->product_code }}</strong></td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>₹{{ number_format($purchase->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No purchases yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Sales --}}
        <div class="col-lg-6">
            <div class="content-card">
                <div class="card-header-custom">
                    <h3><i class="bi bi-currency-dollar text-success me-2"></i>Recent Sales</h3>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-custom">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td><strong>{{ $sale->product_code }}</strong></td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No sales yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Low Stock Alerts ───────────────────────────── --}}
    @if($lowStockItems->count() > 0)
        <div class="content-card mb-4">
            <div class="card-header-custom">
                <h3><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Low Stock Alerts (≤ 10 units)</h3>
            </div>
            <div class="table-responsive">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Current Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockItems as $item)
                            <tr>
                                <td><strong>{{ $item->product_code }}</strong></td>
                                <td>{{ $item->current_stock }}</td>
                                <td>
                                    @if($item->current_stock == 0)
                                        <span class="badge badge-stock-out rounded-pill px-3 py-1">Out of Stock</span>
                                    @else
                                        <span class="badge badge-stock-low rounded-pill px-3 py-1">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ── Product-wise Profit ────────────────────────── --}}
    @if($profitData->count() > 0)
        <div class="content-card">
            <div class="card-header-custom">
                <h3><i class="bi bi-graph-up-arrow text-primary me-2"></i>Product-wise Profit / Loss</h3>
            </div>
            <div class="table-responsive">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total Purchased</th>
                            <th>Total Sold</th>
                            <th>Profit / Loss</th>
                            <th>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profitData as $row)
                            <tr>
                                <td><strong>{{ $row->product_code }}</strong></td>
                                <td>₹{{ number_format($row->total_purchase_amount, 2) }}</td>
                                <td>₹{{ number_format($row->total_sale_amount, 2) }}</td>
                                <td class="{{ $row->profit >= 0 ? 'text-profit' : 'text-loss' }}">
                                    {{ $row->profit >= 0 ? '+' : '' }}₹{{ number_format($row->profit, 2) }}
                                </td>
                                <td>{{ $row->current_stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection