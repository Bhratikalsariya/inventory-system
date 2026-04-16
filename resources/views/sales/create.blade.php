{{-- Sale Entry Modal --}}
<div class="modal fade" id="saleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-cash-coin text-success me-2"></i>New Sale Entry
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <div class="row g-3">
                        {{-- Product Code (Dropdown from stock) --}}
                        <div class="col-md-6">
                            <label class="form-label">Product Code <span class="text-danger">*</span></label>
                            <select name="product_code" id="s_product_code" class="form-select"
                                    required onchange="checkStock()">
                                <option value="">Select product...</option>
                                @foreach($productCodes ?? [] as $code)
                                    <option value="{{ $code }}"
                                        {{ old('product_code') == $code ? 'selected' : '' }}>
                                        {{ $code }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" id="s_stock_info"></small>
                            @error('product_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-6">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="s_quantity" class="form-control"
                                   min="1" placeholder="Enter quantity"
                                   value="{{ old('quantity') }}"
                                   required
                                   oninput="calculateSale()">
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Selling Price --}}
                        <div class="col-md-6">
                            <label class="form-label">Selling Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="selling_price" id="s_selling_price" class="form-control"
                                   step="0.01" min="0" placeholder="Enter selling price"
                                   value="{{ old('selling_price') }}"
                                   required
                                   oninput="calculateSale()">
                            @error('selling_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- GST Percent --}}
                        <div class="col-md-6">
                            <label class="form-label">GST Percent (%)</label>
                            <select name="gst_percent" id="s_gst_percent" class="form-select"
                                    onchange="calculateSale()">
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
                            <input type="text" id="s_gst_amount" class="form-control computed-field"
                                   value="₹ 0.00" readonly>
                        </div>

                        {{-- Total Amount (Auto-calculated) --}}
                        <div class="col-md-6">
                            <label class="form-label">Total Amount (₹)</label>
                            <input type="text" id="s_total_amount" class="form-control computed-field"
                                   value="₹ 0.00" readonly
                                   style="font-size:18px; font-weight:800; color:#111827;">
                        </div>

                        {{-- Sale Date --}}
                        <div class="col-md-6">
                            <label class="form-label">Sale Date</label>
                            <input type="date" name="sale_date" class="form-control"
                                   value="{{ old('sale_date', date('Y-m-d')) }}">
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-6">
                            <label class="form-label">Notes</label>
                            <input type="text" name="notes" class="form-control"
                                   placeholder="Optional notes"
                                   value="{{ old('notes') }}">
                        </div>
                    </div>

                    {{-- Subtotal Preview --}}
                    <div class="mt-3 p-3 rounded" style="background:#eff6ff; border:1px solid #bfdbfe;">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Subtotal:</span>
                            <strong id="s_subtotal">₹ 0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">+ GST:</span>
                            <strong id="s_gst_preview">₹ 0.00</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:700; font-size:16px;">Grand Total:</span>
                            <strong id="s_grand_total" style="font-size:18px; color:#1e40af;">₹ 0.00</strong>
                        </div>
                    </div>

                    {{-- Stock Warning --}}
                    <div class="mt-2 d-none" id="s_stock_warning"
                         style="background:#fef3c7; border:1px solid #fcd34d; border-radius:8px; padding:10px 14px;">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                        <span id="s_stock_warning_text"></span>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success-custom" id="s_submit_btn">
                            <i class="bi bi-check-lg me-1"></i> Record Sale
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
    // Stock data passed from controller
    const stockData = @json($stockData ?? []);

    function checkStock() {
        const code = document.getElementById('s_product_code').value;
        const infoEl = document.getElementById('s_stock_info');

        if (code && stockData[code] !== undefined) {
            infoEl.innerHTML = `<span class="text-success"><i class="bi bi-box-seam"></i> Available stock: <strong>${stockData[code]}</strong></span>`;
        } else if (code) {
            infoEl.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-circle"></i> Product not in stock</span>`;
        } else {
            infoEl.innerHTML = '';
        }

        calculateSale();
    }

    function calculateSale() {
        const qty = parseFloat(document.getElementById('s_quantity').value) || 0;
        const price = parseFloat(document.getElementById('s_selling_price').value) || 0;
        const gstPercent = parseFloat(document.getElementById('s_gst_percent').value) || 0;

        const subtotal = qty * price;
        const gstAmount = (subtotal * gstPercent) / 100;
        const total = subtotal + gstAmount;

        document.getElementById('s_gst_amount').value = '₹ ' + gstAmount.toFixed(2);
        document.getElementById('s_total_amount').value = '₹ ' + total.toFixed(2);
        document.getElementById('s_subtotal').textContent = '₹ ' + subtotal.toFixed(2);
        document.getElementById('s_gst_preview').textContent = '₹ ' + gstAmount.toFixed(2);
        document.getElementById('s_grand_total').textContent = '₹ ' + total.toFixed(2);

        // Stock validation warning
        const code = document.getElementById('s_product_code').value;
        const warningEl = document.getElementById('s_stock_warning');
        const warningText = document.getElementById('s_stock_warning_text');
        const submitBtn = document.getElementById('s_submit_btn');

        if (code && stockData[code] !== undefined && qty > stockData[code]) {
            warningEl.classList.remove('d-none');
            warningText.textContent = `Insufficient stock! Available: ${stockData[code]}, Requested: ${qty}`;
            submitBtn.disabled = true;
        } else {
            warningEl.classList.add('d-none');
            submitBtn.disabled = false;
        }
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('saleModal')).show();
        });
    @endif
</script>
@endpush