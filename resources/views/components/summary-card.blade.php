{{-- 
    Usage: @include('components.summary-card', [
        'icon' => 'bi-cart-fill',
        'iconClass' => 'icon-blue',
        'title' => 'Total Purchases',
        'value' => '₹1,25,000',
    ])
--}}
<div class="col">
    <div class="summary-card">
        <div class="icon-box {{ $iconClass }}">
            <i class="bi {{ $icon }}"></i>
        </div>
        <div class="info">
            <h4>{{ $title }}</h4>
            <div class="value">{{ $value }}</div>
        </div>
    </div>
</div>