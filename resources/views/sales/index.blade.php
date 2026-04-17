@extends('layouts.app')

@section('title', 'Sales')
@section('page-title', 'Sales Management')

@section('content')

    {{-- ── Actions Bar ────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            Total records: <strong>{{ $sales->total() }}</strong>
        </p>
        <div class="d-flex gap-2">
            <a href="{{ route('reports.sales.csv', request()->query()) }}"
               class="btn btn-outline-custom btn-sm">
                <i class="bi bi-download me-1"></i> Export CSV
            </a>
            <button class="btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#saleModal">
                <i class="bi bi-plus-lg me-1"></i> New Sale
            </button>
        </div>
    </div>

    {{-- ── Search / Filter ────────────────────────────── --}}
    @include('components.search-bar', [
        'action' => route('sales.index'),
        'showDates' => false,
    ])

    {{-- ── Sales Table ────────────────────────────────── --}}
    <div class="content-card">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Code</th>
                        <th>Quantity</th>
                        <th>Sell Price (₹)</th>
                        <th>GST %</th>
                        <th>GST Amount (₹)</th>
                        <th>Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td><strong>{{ $s->product_code }}</strong></td>
                            <td>{{ $s->quantity }}</td>
                            <td>₹{{ number_format($s->selling_price, 2) }}</td>
                            <td>{{ $s->gst_percent }}%</td>
                            <td>₹{{ number_format($s->gst_amount, 2) }}</td>
                            <td><strong>₹{{ number_format($s->total_amount, 2) }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="icon">🛒</div>
                                    <h4>No Sales Found</h4>
                                    <p>Record your first sale to see it here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
            <nav>
                <ul class="pagination justify-content-center align-items-center gap-2">

                    {{-- Previous Button --}}
                    @if ($sales->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link px-3 py-2">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $purchases->previousPageUrl() }}">‹</a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($sales as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($sales))
                            @foreach ($sales as $page => $url)
                                <li class="page-item {{ $page == $sales->currentPage() ? 'active' : '' }}">
                                    <a class="page-link px-3 py-2" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($sales->hasMorePages())
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $sales->nextPageUrl() }}">›</a>
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

    {{-- ── Create Sale Modal ──────────────────────────── --}}
    @include('sales.create')

@endsection