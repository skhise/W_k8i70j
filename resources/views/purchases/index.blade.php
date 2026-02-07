<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Purchases (Product)</h4>
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
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Reference No.</th>
                                                <th>Notes</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($purchases as $index => $purchase)
                                                <tr>
                                                    <td>{{ $purchases->firstItem() + $index }}</td>
                                                    <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('d-M-Y') : '—' }}</td>
                                                    <td>{{ $purchase->product->Product_Name ?? '—' }}</td>
                                                    <td>{{ $purchase->quantity }}</td>
                                                    <td>{{ $purchase->reference_no ?? '—' }}</td>
                                                    <td>{{ \Str::limit($purchase->notes, 40) ?: '—' }}</td>
                                                    <td>{{ $purchase->created_at ? $purchase->created_at->format('d-M-Y H:i') : '—' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No purchases yet. Add one using the button above.</td>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPurchaseModalLabel">New Purchase</h5>
                        <button type="button" class="close" aria-label="Close" onclick="window.closeAddPurchaseModal(event)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_id">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-control select2 @error('product_id') is-invalid @enderror" required>
                                <option value="">Select Product</option>
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
                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="purchase_date">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                            @error('purchase_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reference_no">Reference No.</label>
                            <input type="text" name="reference_no" id="reference_no" class="form-control @error('reference_no') is-invalid @enderror" value="{{ old('reference_no') }}" placeholder="PO / Invoice ref">
                            @error('reference_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="2" placeholder="Optional">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.closeAddPurchaseModal(event)">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Purchase</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    });
    </script>
</x-app-layout>
