{{-- 
    Usage: @include('components.modal', [
        'id' => 'purchaseModal',
        'title' => 'New Purchase Entry',
        'size' => 'modal-lg',      // optional
    ])
    Put form content in the slot using @section / component approach
--}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{ $size ?? 'modal-lg' }} modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>