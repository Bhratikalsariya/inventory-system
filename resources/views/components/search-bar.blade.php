{{-- 
    Usage: @include('components.search-bar', [
        'action' => route('purchases.index'),
        'showDates' => true,
    ])
--}}
<div class="filter-bar">
    <form action="{{ $action }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Product Code</label>
                <input type="text" name="product_code" class="form-control"
                       placeholder="Search product..."
                       value="{{ request('product_code') }}">
            </div>

            @if($showDates ?? true)
                <div class="col-md-2">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control"
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control"
                           value="{{ request('end_date') }}">
                </div>
            @endif

            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>
            <div class="col-md-auto">
                <a href="{{ $action }}" class="btn btn-outline-custom">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
            </div>
        </div>
    </form>
</div>