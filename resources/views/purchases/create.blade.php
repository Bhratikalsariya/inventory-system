{{-- Purchase Entry Modal --}}
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-cart-plus-fill text-primary me-2"></i>New Purchase Entry
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
                    @csrf

                    <div class="row g-3">
                        {{-- Product Code --}}
                        <div class="col-md-6">
                            <label class="form-label">Product Code <span class="text-danger">*</span></label>
                            <input type="text" name="product_code" class="form-control"
                                   placeholder="e.g. PRD-001"
                                   value="{{ old('product_code') }}"
                                   oninput="this.value = this.value.toUpperCase(); calculatePurchase();">
                            @error('product_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-6">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="p_quantity" class="form-control"
                                   min="1" placeholder="Enter quantity"
                                   value="{{ old('quantity') }}"
                                   oninput="calculatePurchase()">
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Rate --}}
                        <div class="col-md-6">
                            <label class="form-label">Rate per Unit (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="rate" id="p_rate" class="form-control"
                                   step="0.01" min="0" placeholder="Enter rate"
                                   value="{{ old('rate') }}"
                                   oninput="calculatePurchase()">
                            @error('rate')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- GST Percent --}}
                        <div class="col-md-6">
                            <label class="form-label">GST Percent (%) <span class="text-danger">*</span></label>
                            <select name="gst_percent" id="p_gst_percent" class="form-select"
                                    onchange="calculatePurchase()">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="18" selected>18%</option>
                                <option value="28">28%</option>
                            </select>
                        </div>

                        {{-- GST Amount (Auto-calculated) --}}
                        <div class="col-md-6">
                            <label class="form-label">GST Amount (₹)</label>
                            <input type="text" id="p_gst_amount" class="form-control computed-field"
                                   value="₹ 0.00" readonly>
                        </div>

                        {{-- Total Amount (Auto-calculated) --}}
                        <div class="col-md-6">
                            <label class="form-label">Total Amount (₹)</label>
                            <input type="text" id="p_total_amount" class="form-control computed-field"
                                   value="₹ 0.00" readonly
                                   style="font-size:18px; font-weight:800; color:#111827;">
                        </div>
                    </div>

                    {{-- Subtotal Preview --}}
                    <div class="mt-3 p-3 rounded" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Subtotal:</span>
                            <strong id="p_subtotal">₹ 0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">+ GST:</span>
                            <strong id="p_gst_preview">₹ 0.00</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:700; font-size:16px;">Grand Total:</span>
                            <strong id="p_grand_total" style="font-size:18px; color:#065f46;">₹ 0.00</strong>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i> Save Purchase
                        </button>
                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function calculatePurchase() {
        const qty = parseFloat(document.getElementById('p_quantity').value) || 0;
        const rate = parseFloat(document.getElementById('p_rate').value) || 0;
        const gstPercent = parseFloat(document.getElementById('p_gst_percent').value) || 0;

        const subtotal = qty * rate;
        const gstAmount = (subtotal * gstPercent) / 100;
        const total = subtotal + gstAmount;

        document.getElementById('p_gst_amount').value = '₹ ' + gstAmount.toFixed(2);
        document.getElementById('p_total_amount').value = '₹ ' + total.toFixed(2);
        document.getElementById('p_subtotal').textContent = '₹ ' + subtotal.toFixed(2);
        document.getElementById('p_gst_preview').textContent = '₹ ' + gstAmount.toFixed(2);
        document.getElementById('p_grand_total').textContent = '₹ ' + total.toFixed(2);
    }

    // Show modal on validation error
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('purchaseModal')).show();
        });
    @endif
</script>
@endpush