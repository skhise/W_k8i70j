<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Purchases (Product/Spare)</h4>
                                <div class="card-header-action">
                                    <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#addPurchaseModal">
                                        <i class="fas fa-plus-square"></i> New Purchase
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif

                                <form method="GET" action="{{ route('purchases') }}" class="mb-4 d-flex flex-wrap justify-content-end align-items-center">
                                    <div class="form-group mb-0 mr-2" style="max-width: 280px;">
                                        <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search by product name or reference no.">
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-icon" title="Search"><i class="fas fa-search"></i></button>
                                        <a href="{{ route('purchases') }}" class="btn btn-outline-secondary btn-icon mr-2" title="Clear"><i class="fas fa-times"></i></a>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Purchase Date</th>
                                                <th>Vendor</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Reference No.</th>
                                                <th>Notes</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($purchases as $index => $purchase)
                                                <tr>
                                                    <td>{{ $purchases->firstItem() + $index }}</td>
                                                    <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('d-M-Y') : '—' }}</td>
                                                    <td>{{ $purchase->vendor->name ?? '—' }}</td>
                                                    <td>{{ $purchase->product->Product_Name ?? '—' }}</td>
                                                    <td>{{ $purchase->quantity }}</td>
                                                    <td>{{ $purchase->reference_no ?? '—' }}</td>
                                                    <td>{{ \Str::limit($purchase->notes, 40) ?: '—' }}</td>
                                                    <td>{{ $purchase->created_at ? $purchase->created_at->format('d-M-Y H:i') : '—' }}</td>
                                                    <td>
                                                        <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-primary btn-purchase-edit" title="Edit">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        @php
                                                            $dbQty = $purchase->product ? (int)($purchase->product->quantity ?? 0) : 0;
                                                            $purchasedQty = (int)$purchase->quantity;
                                                            $canDelete = ($dbQty >= $purchasedQty);
                                                        @endphp
                                                        @if($canDelete)
                                                            <a href="{{ route('purchases.destroy', $purchase) }}" class="delete-btn btn btn-sm btn-danger" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @else
                                                            <span class="btn btn-sm btn-secondary" title="Cannot delete — current stock ({{ $dbQty }}) is less than this purchase quantity ({{ $purchasedQty }}). You need at least {{ $purchasedQty }} in stock." style="cursor: not-allowed; opacity: 0.7;">
                                                                <i class="fa fa-trash"></i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No purchases yet. Add one using the button above.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($purchases->hasPages())
                                    <div class="d-flex justify-content-end mt-3">
                                        {{ $purchases->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </section>
    </div>

    {{-- Add Purchase Modal --}}
    <div class="modal fade" id="addPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="addPurchaseForm" action="{{ route('purchases.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" id="addPurchaseModalLabel">New Purchase (Product/Spare)</h5>
                        <button type="button" class="close" aria-label="Close" onclick="window.closeAddPurchaseModal(event)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vendor_input" class="font-weight-bold">Vendor <span class="text-danger">*</span></label>
                                    <input type="text" name="vendor_input" id="vendor_input" class="form-control form-control-lg @error('vendor_input') is-invalid @enderror" value="{{ old('vendor_input') }}" list="vendor_list" placeholder="Type vendor name or pick from list" required autocomplete="off">
                                    <datalist id="vendor_list">
                                        @foreach($vendors as $vendor)
                                            <option value="{{ e($vendor->name) }}">
                                        @endforeach
                                    </datalist>
                                    <small class="form-text text-muted">Type a new name or choose from the list. New vendors are created when you save.</small>
                                    @error('vendor_input')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id" class="font-weight-bold">Product/Spare <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control form-control-lg select2 @error('product_id') is-invalid @enderror" required>
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->Product_ID }}" {{ old('product_id') == $product->Product_ID ? 'selected' : '' }}>
                                                {{ $product->Product_Name }}@if(!empty($product->product_type_name)) ({{ $product->product_type_name }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity" class="font-weight-bold">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" class="form-control form-control-lg @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" required>
                                    @error('quantity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_date" class="font-weight-bold">Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control form-control-lg @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                    @error('purchase_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_no" class="font-weight-bold">Reference No.</label>
                                    <input type="text" name="reference_no" id="reference_no" class="form-control form-control-lg @error('reference_no') is-invalid @enderror" value="{{ old('reference_no') }}" placeholder="e.g. PO / Invoice #">
                                    @error('reference_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="notes" class="font-weight-bold">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="2" placeholder="Optional notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <button type="button" class="btn btn-secondary px-4" onclick="window.closeAddPurchaseModal(event)">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 btn-save-purchase" id="addPurchaseSubmitBtn">
                            <span class="btn-text"><i class="fas fa-save mr-1"></i> Save Purchase</span>
                            <span class="btn-loader spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Purchase Modal --}}
    @if(isset($editPurchase))
    <div class="modal fade show d-block" id="editPurchaseModal" tabindex="-1" role="dialog" aria-modal="true" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="editPurchaseForm" action="{{ route('purchases.update', $editPurchase) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title">Edit Purchase (Product/Spare)</h5>
                        <a href="{{ route('purchases') }}" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="modal-body pt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_vendor_input" class="font-weight-bold">Vendor <span class="text-danger">*</span></label>
                                    <input type="text" name="vendor_input" id="edit_vendor_input" class="form-control form-control-lg @error('vendor_input') is-invalid @enderror" value="{{ old('vendor_input', $editPurchase->vendor->name ?? '') }}" list="vendor_list_edit" required autocomplete="off">
                                    @error('vendor_input')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    <datalist id="vendor_list_edit">
                                        @foreach($vendors as $v)
                                            <option value="{{ e($v->name) }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_product_id" class="font-weight-bold">Product/Spare <span class="text-danger">*</span></label>
                                    <select name="product_id" id="edit_product_id" class="form-control form-control-lg select2-edit @error('product_id') is-invalid @enderror" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->Product_ID }}" {{ old('product_id', $editPurchase->product_id) == $product->Product_ID ? 'selected' : '' }}>
                                                {{ $product->Product_Name }}@if(!empty($product->product_type_name)) ({{ $product->product_type_name }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_quantity" class="font-weight-bold">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="edit_quantity" class="form-control form-control-lg @error('quantity') is-invalid @enderror" value="{{ old('quantity', $editPurchase->quantity) }}" min="1" required>
                                    @error('quantity')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_purchase_date" class="font-weight-bold">Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" name="purchase_date" id="edit_purchase_date" class="form-control form-control-lg" value="{{ old('purchase_date', $editPurchase->purchase_date?->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_reference_no" class="font-weight-bold">Reference No.</label>
                                    <input type="text" name="reference_no" id="edit_reference_no" class="form-control form-control-lg" value="{{ old('reference_no', $editPurchase->reference_no) }}" placeholder="e.g. PO / Invoice #">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="edit_notes" class="font-weight-bold">Notes</label>
                            <textarea name="notes" id="edit_notes" class="form-control" rows="2">{{ old('notes', $editPurchase->notes) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <a href="{{ route('purchases') }}" class="btn btn-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 btn-save-purchase" id="editPurchaseSubmitBtn">
                            <span class="btn-text"><i class="fas fa-save mr-1"></i> Update Purchase</span>
                            <span class="btn-loader spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
    function closeAddPurchaseModal(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        var modal = document.getElementById('addPurchaseModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
        var backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(function(el) { el.remove(); });
        if (typeof jQuery !== 'undefined' && jQuery(modal).data('bs.modal')) {
            jQuery(modal).modal('hide');
        }
        var sel = document.getElementById('product_id');
        if (sel && typeof jQuery !== 'undefined' && jQuery(sel).hasClass('select2-hidden-accessible')) {
            try { jQuery(sel).select2('destroy'); } catch (err) {}
        }
    }
    window.closeAddPurchaseModal = closeAddPurchaseModal;

    $(document).ready(function() {
        var $modal = $('#addPurchaseModal');
        var $productSelect = $('select#product_id');

        function initSelect2() {
            if (typeof $().select2 === 'function' && !$productSelect.hasClass('select2-hidden-accessible')) {
                $productSelect.select2({ width: '100%', dropdownParent: $modal });
            }
        }

        function destroySelect2() {
            try {
                if (typeof $().select2 === 'function' && $productSelect.hasClass('select2-hidden-accessible')) {
                    $productSelect.select2('destroy');
                }
            } catch (e) {}
        }

        $modal.on('show.bs.modal', function() { initSelect2(); });
        $modal.on('hidden.bs.modal', function() { destroySelect2(); });

        $modal.on('click', function(e) {
            if (e.target === this) { closeAddPurchaseModal(e); }
        });

        @if($errors->any())
            $modal.modal('show');
        @else
            initSelect2();
        @endif

        function setButtonLoading(btn, loading) {
            if (!btn || !btn.length) return;
            var $text = btn.find('.btn-text');
            var $loader = btn.find('.btn-loader');
            if (loading) {
                btn.prop('disabled', true);
                $text.addClass('d-none');
                $loader.removeClass('d-none');
            } else {
                btn.prop('disabled', false);
                $text.removeClass('d-none');
                $loader.addClass('d-none');
            }
        }

        $('#addPurchaseForm').on('submit', function() {
            setButtonLoading($('#addPurchaseSubmitBtn'), true);
        });

        $('#editPurchaseForm').on('submit', function() {
            setButtonLoading($('#editPurchaseSubmitBtn'), true);
        });

        $(document).on('click', '.delete-btn[href*="purchases"]', function() {
            var $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span>');
        });

        @if(isset($editPurchase))
        if (typeof $().select2 === 'function') {
            $('#edit_product_id').select2({ width: '100%', dropdownParent: $('#editPurchaseModal') });
        }
        @endif
    });
    </script>
</x-app-layout>
