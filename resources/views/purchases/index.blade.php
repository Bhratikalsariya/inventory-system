@extends('layouts.app')

@section('title', 'Purchases')
@section('page-title', 'Purchase Management')

@section('content')

    {{-- ── Actions Bar ────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            Total records: <strong>{{ $purchases->total() }}</strong>
        </p>
        <div class="d-flex gap-2">
            <a href="{{ route('reports.purchases.csv', request()->query()) }}"
               class="btn btn-outline-custom btn-sm">
                <i class="bi bi-download me-1"></i> Export CSV
            </a>
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#purchaseModal">
                <i class="bi bi-plus-lg me-1"></i> New Purchase
            </button>
        </div>
    </div>

    {{-- ── Search / Filter ────────────────────────────── --}}
    @include('components.search-bar', [
        'action' => route('purchases.index'),
        'showDates' => true,
    ])

    {{-- ── Purchases Table ────────────────────────────── --}}
    <div class="content-card">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Code</th>
                        <th>Quantity</th>
                        <th>Rate (₹)</th>
                        <th>GST %</th>
                        <th>GST Amount (₹)</th>
                        <th>Total (₹)</th>
                        <th>Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td><strong>{{ $p->product_code }}</strong></td>
                            <td>{{ $p->quantity }}</td>
                            <td>₹{{ number_format($p->rate, 2) }}</td>
                            <td>{{ $p->gst_percent }}%</td>
                            <td>₹{{ number_format($p->gst_amount, 2) }}</td>
                            <td><strong>₹{{ number_format($p->total_amount, 2) }}</strong></td>
                            <td>{{ $p->purchase_date->format('d M Y') }}</td>
                            <td>{{ Str::limit($p->notes, 30) ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="icon">📋</div>
                                    <h4>No Purchases Found</h4>
                                    <p>Add your first purchase to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($purchases->hasPages())
            <nav>
                <ul class="pagination justify-content-center align-items-center gap-2">

                    {{-- Previous Button --}}
                    @if ($purchases->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link px-3 py-2">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $purchases->previousPageUrl() }}">‹</a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($purchases as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($purchases))
                            @foreach ($purchases as $page => $url)
                                <li class="page-item {{ $page == $purchases->currentPage() ? 'active' : '' }}">
                                    <a class="page-link px-3 py-2" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($purchases->hasMorePages())
                        <li class="page-item">
                            <a class="page-link px-3 py-2" href="{{ $purchases->nextPageUrl() }}">›</a>
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

    {{-- ── Create Purchase Modal ──────────────────────── --}}
    @include('purchases.create')

@endsection