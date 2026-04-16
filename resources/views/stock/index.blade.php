@extends('layouts.app')

@section('title', 'Stock')
@section('page-title', 'Stock Inventory')

@section('content')

    {{-- ── Actions Bar ────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            Total products: <strong>{{ $stocks->total() }}</strong>
        </p>
        <a href="{{ route('reports.stock.csv') }}" class="btn btn-outline-custom btn-sm">
            <i class="bi bi-download me-1"></i> Export CSV
        </a>
    </div>

    {{-- ── Search ─────────────────────────────────────── --}}
    @include('components.search-bar', [
        'action' => route('stock.index'),
        'showDates' => false,
    ])

    {{-- ── Stock Summary Cards ────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="summary-card">
                <div class="icon-box icon-blue"><i class="bi bi-box-seam-fill"></i></div>
                <div class="info">
                    <h4>Total Products</h4>
                    <div class="value">{{ $totalProducts }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="icon-box icon-green"><i class="bi bi-check-circle-fill"></i></div>
                <div class="info">
                    <h4>In Stock</h4>
                    <div class="value">{{ $inStockCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="icon-box icon-red"><i class="bi bi-exclamation-circle-fill"></i></div>
                <div class="info">
                    <h4>Out of Stock</h4>
                    <div class="value">{{ $outOfStockCount }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Stock Table ────────────────────────────────── --}}
    <div class="content-card">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Code</th>
                        <th>Total Purchased</th>
                        <th>Total Sold</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th>Stock Bar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr>
                            <td>{{ $stock->id }}</td>
                            <td><strong>{{ $stock->product_code }}</strong></td>
                            <td>
                                <span style="color:#3b82f6; font-weight:600;">
                                    <i class="bi bi-arrow-down-circle-fill me-1"></i>{{ $stock->total_purchased_qty }}
                                </span>
                            </td>
                            <td>
                                <span style="color:#10b981; font-weight:600;">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i>{{ $stock->total_sold_qty }}
                                </span>
                            </td>
                            <td style="font-size:18px; font-weight:800;">{{ $stock->current_stock }}</td>
                            <td>
                                @if($stock->current_stock == 0)
                                    <span class="badge badge-stock-out rounded-pill px-3 py-1">Out of Stock</span>
                                @elseif($stock->current_stock <= 10)
                                    <span class="badge badge-stock-low rounded-pill px-3 py-1">Low Stock</span>
                                @else
                                    <span class="badge badge-stock-ok rounded-pill px-3 py-1">In Stock</span>
                                @endif
                            </td>
                            <td style="min-width:150px;">
                                @php
                                    $percent = $stock->total_purchased_qty > 0
                                        ? round(($stock->current_stock / $stock->total_purchased_qty) * 100)
                                        : 0;
                                    $barColor = $percent > 50 ? '#10b981' : ($percent > 20 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <div style="background:#f3f4f6; border-radius:10px; height:8px; overflow:hidden;">
                                    <div style="width:{{ min($percent, 100) }}%; height:100%; background:{{ $barColor }}; border-radius:10px; transition:width .3s;"></div>
                                </div>
                                <small class="text-muted">{{ $percent }}% remaining</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="icon">📦</div>
                                    <h4>No Stock Records</h4>
                                    <p>Stock is auto-created when you add purchases</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stocks->hasPages())
            <nav>
                <ul class="pagination justify-content-center align-items-center gap-2">

                    {{-- Previous Button --}}
                    @if ($stocks->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link px-3 py-2">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $stocks->previousPageUrl() }}">‹</a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($stocks as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($stocks))
                            @foreach ($stocks as $page => $url)
                                <li class="page-item {{ $page == $stocks->currentPage() ? 'active' : '' }}">
                                    <a class="page-link px-3 py-2" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($stocks->hasMorePages())
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $stocks->nextPageUrl() }}">›</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link px-3 py-2">›</span>
                        </li>
                    @endif

                </ul>
            </nav>
        @endif
    </div>

@endsection