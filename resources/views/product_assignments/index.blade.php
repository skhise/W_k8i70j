<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Assign Product</h4>
                                <div class="card-header-action">
                                    <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#newAssignmentModal">
                                        <i class="fas fa-plus-square"></i> New Assignment
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

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee Name</th>
                                                <th>Total Quantity</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($assignments as $index => $assignment)
                                                @php
                                                    $totalQty = $assignment->items->sum('quantity');
                                                @endphp
                                                <tr data-assignment-id="{{ $assignment->id }}">
                                                    <td>{{ $assignments->firstItem() + $index }}</td>
                                                    <td>{{ $assignment->employee->EMP_Name ?? '—' }}</td>
                                                    <td class="assignment-total-qty">{{ $totalQty }}</td>
                                                    <td>{{ $assignment->created_at ? $assignment->created_at->format('d-M-Y H:i') : '—' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-icon btn-primary view-assignment-btn" title="View" data-id="{{ $assignment->id }}">
                                                            <i class="far fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No assignments yet. Create one using New Assignment.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($assignments->hasPages())
                                    <div class="d-flex justify-content-end mt-3">
                                        {{ $assignments->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- New Assignment Modal --}}
    <div class="modal fade" id="newAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="newAssignmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('product-assignments.store') }}" method="POST" id="newAssignmentForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="newAssignmentModalLabel">New Assignment</h5>
                        <button type="button" class="close" aria-label="Close" onclick="window.closeNewAssignmentModal(event)"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="assignment_employee_id">Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="assignment_employee_id" class="form-control" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->EMP_ID }}">{{ $emp->EMP_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Products</label>
                            <div id="assignment-rows">
                                <div class="assignment-row row align-items-end mb-2" data-row="0">
                                    <div class="col-md-5">
                                        <label class="small">Product</label>
                                        <select class="form-control assignment-product-select" name="items[0][product_id]" data-row="0">
                                            <option value="">Select Product</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->Product_ID }}" data-qty="{{ $p->quantity ?? 0 }}">{{ $p->Product_Name }}@if(!empty($p->product_type_name)) ({{ $p->product_type_name }})@endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small">Available</label>
                                        <div class="form-control-plaintext small text-info" id="avail-0">0</div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small">Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary btn-sm assignment-qty-minus" data-row="0" title="Decrease">−</button>
                                            </div>
                                            <input type="number" name="items[0][quantity]" class="form-control assignment-qty-input" value="1" min="1" data-row="0">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-sm assignment-qty-plus" data-row="0" title="Increase">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small d-block">&nbsp;</label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon remove-assignment-row d-none mr-1" data-row="0" title="First row cannot be removed"><i class="fas fa-trash-alt"></i></button>
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-icon" id="add-assignment-row" title="Add Product"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="assignment_notes">Notes</label>
                            <textarea name="notes" id="assignment_notes" class="form-control" rows="2" placeholder="Optional"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.closeNewAssignmentModal(event)">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View Assignment Modal --}}
    <div class="modal fade" id="viewAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="viewAssignmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAssignmentModalLabel">Assignment - <span id="view-employee-name"></span></h5>
                    <button type="button" class="close" aria-label="Close" onclick="window.closeViewAssignmentModal(event)"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="view-assignment-id" value="">
                    <div class="table-responsive mb-3">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Product</th><th>Quantity</th><th width="180">Action</th></tr>
                            </thead>
                            <tbody id="view-assignment-items"></tbody>
                        </table>
                    </div>
                    <div class="border-top pt-3">
                        <label class="small">Add product to this assignment</label>
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <select class="form-control" id="view-add-product-id">
                                    <option value="">Select Product</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->Product_ID }}">{{ $p->Product_Name }}@if(!empty($p->product_type_name)) ({{ $p->product_type_name }})@endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="small">Qty</label>
                                <input type="number" id="view-add-qty" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm btn-icon" id="view-add-item-btn" title="Add"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.closeViewAssignmentModal(event)">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function closeNewAssignmentModal(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        var modal = document.getElementById('newAssignmentModal');
        if (modal) { modal.classList.remove('show'); modal.style.display = 'none'; }
        document.body.classList.remove('modal-open'); document.body.style.paddingRight = '';
        document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
        if (typeof jQuery !== 'undefined') jQuery(modal).modal('hide');
    }
    window.closeNewAssignmentModal = closeNewAssignmentModal;

    function closeViewAssignmentModal(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        var modal = document.getElementById('viewAssignmentModal');
        if (modal) { modal.classList.remove('show'); modal.style.display = 'none'; }
        document.body.classList.remove('modal-open'); document.body.style.paddingRight = '';
        document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
        if (typeof jQuery !== 'undefined') jQuery(modal).modal('hide');
    }
    window.closeViewAssignmentModal = closeViewAssignmentModal;

    (function() {
        var products = @json($products->keyBy('Product_ID'));
        var rowIndex = 1;

        function getAvailableQty(productId) {
            var id = String(productId);
            var p = products[id] || products[parseInt(id, 10)];
            return p && p.quantity !== undefined ? parseInt(p.quantity, 10) : 0;
        }

        function updateRowAvailable(row) {
            var sel = document.querySelector('.assignment-row[data-row="' + row + '"] .assignment-product-select');
            var el = document.getElementById('avail-' + row);
            if (!el) return;
            var pid = sel ? sel.value : '';
            if (!pid) { el.textContent = '0'; return; }
            var qty = getAvailableQty(pid);
            el.textContent = qty;
        }

        function getSelectedProductIdsByRow() {
            var map = {};
            document.querySelectorAll('.assignment-row').forEach(function(r) {
                var row = r.getAttribute('data-row');
                var sel = r.querySelector('.assignment-product-select');
                if (sel && sel.value) map[row] = sel.value;
            });
            return map;
        }

        function syncProductOptions() {
            var selectedByRow = getSelectedProductIdsByRow();
            var countByProduct = {};
            Object.keys(selectedByRow).forEach(function(row) {
                var pid = selectedByRow[row];
                if (pid) countByProduct[pid] = (countByProduct[pid] || 0) + 1;
            });
            document.querySelectorAll('.assignment-row').forEach(function(r) {
                var sel = r.querySelector('.assignment-product-select');
                if (!sel) return;
                var currentVal = sel.value;
                [].slice.call(sel.options).forEach(function(opt) {
                    if (opt.value === '') { opt.disabled = false; return; }
                    var count = countByProduct[opt.value] || 0;
                    opt.disabled = (currentVal === opt.value) ? (count > 1) : (count > 0);
                });
            });
        }

        function addAssignmentRow() {
            var row = rowIndex++;
            var html = '<div class="assignment-row row align-items-end mb-2" data-row="' + row + '">' +
                '<div class="col-md-5"><label class="small">Product</label>' +
                '<select class="form-control assignment-product-select" name="items[' + row + '][product_id]" data-row="' + row + '">' +
                '<option value="">Select Product</option>' +
                @foreach($products as $p)
                '<option value="{{ $p->Product_ID }}" data-qty="{{ $p->quantity ?? 0 }}">{{ $p->Product_Name }}@if(!empty($p->product_type_name)) ({{ $p->product_type_name }})@endif</option>' +
                @endforeach
                '</select></div>' +
                '<div class="col-md-2"><label class="small">Available</label><div class="form-control-plaintext small text-info" id="avail-' + row + '">0</div></div>' +
                '<div class="col-md-2"><label class="small">Quantity</label><div class="input-group">' +
                '<div class="input-group-prepend"><button type="button" class="btn btn-outline-secondary btn-sm assignment-qty-minus" data-row="' + row + '" title="Decrease">−</button></div>' +
                '<input type="number" name="items[' + row + '][quantity]" class="form-control assignment-qty-input" value="1" min="1" data-row="' + row + '">' +
                '<div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm assignment-qty-plus" data-row="' + row + '" title="Increase">+</button></div></div></div>' +
                '<div class="col-md-2"><label class="small d-block">&nbsp;</label><button type="button" class="btn btn-outline-danger btn-sm btn-icon remove-assignment-row" data-row="' + row + '" title="Remove row"><i class="fas fa-trash-alt"></i></button></div></div>';
            document.getElementById('assignment-rows').insertAdjacentHTML('beforeend', html);
            var newRow = document.querySelector('.assignment-row[data-row="' + row + '"]');
            if (newRow) {
                var sel = newRow.querySelector('.assignment-product-select');
                if (sel) sel.addEventListener('change', function() {
                    updateRowAvailable(row);
                    var inp = newRow.querySelector('.assignment-qty-input');
                    if (inp) inp.setAttribute('max', getAvailableQty(this.value));
                    syncProductOptions();
                });
            }
            updateRowAvailable(row);
            syncProductOptions();
        }

        document.getElementById('assignment-rows').addEventListener('click', function(e) {
            e.preventDefault();
            var target = e.target.closest('button');
            if (!target) return;
            var row = target.getAttribute('data-row');
            if (row === null) return;
            var rowEl = document.querySelector('.assignment-row[data-row="' + row + '"]');
            if (!rowEl) return;
            var input = rowEl.querySelector('.assignment-qty-input');
            if (target.classList.contains('assignment-qty-minus')) {
                var v = parseInt(input.value, 10) || 1;
                if (v > 1) input.value = v - 1;
                e.stopPropagation();
                return;
            }
            if (target.classList.contains('assignment-qty-plus')) {
                var v = parseInt(input.value, 10) || 0;
                var max = parseInt(input.getAttribute('max'), 10) || 9999;
                if (v < max) input.value = v + 1;
                e.stopPropagation();
                return;
            }
            if (target.classList.contains('remove-assignment-row')) {
                if (row === '0') return;
                rowEl.remove();
                syncProductOptions();
                e.stopPropagation();
            }
        });

        document.getElementById('add-assignment-row').addEventListener('click', function(e) { e.preventDefault(); addAssignmentRow(); });

        document.querySelectorAll('.assignment-product-select').forEach(function(sel) {
            sel.addEventListener('change', function() {
                var row = this.getAttribute('data-row');
                updateRowAvailable(row);
                var r = document.querySelector('.assignment-row[data-row="' + row + '"]');
                var inp = r && r.querySelector('.assignment-qty-input');
                if (inp) inp.setAttribute('max', getAvailableQty(this.value));
                syncProductOptions();
            });
        });
        document.querySelectorAll('.assignment-row').forEach(function(r) { updateRowAvailable(r.getAttribute('data-row')); });
        syncProductOptions();

        function updateListRow(assignmentId, totalQuantity) {
            if (!assignmentId) return;
            var row = document.querySelector('tr[data-assignment-id="' + assignmentId + '"]');
            if (row) {
                var cell = row.querySelector('.assignment-total-qty');
                if (cell) cell.textContent = totalQuantity;
            }
        }
        function removeListRow(assignmentId) {
            if (!assignmentId) return;
            var row = document.querySelector('tr[data-assignment-id="' + assignmentId + '"]');
            if (row) row.remove();
        }

        // View assignment
        document.querySelectorAll('.view-assignment-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                document.getElementById('view-assignment-id').value = id;
                var url = '{{ url("product-assignments") }}/' + id;
                fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        document.getElementById('view-employee-name').textContent = data.employee_name || '';
                        var tbody = document.getElementById('view-assignment-items');
                        tbody.innerHTML = '';
                        (data.items || []).forEach(function(it) {
                            var tr = document.createElement('tr');
                            tr.setAttribute('data-item-id', it.id);
                            tr.innerHTML = '<td>' + (it.product_name || '') + '</td>' +
                                '<td><div class="input-group input-group-sm" style="max-width:120px">' +
                                '<div class="input-group-prepend"><button type="button" class="btn btn-outline-secondary btn-sm view-item-minus" title="Decrease">−</button></div>' +
                                '<input type="number" class="form-control view-item-qty" value="' + it.quantity + '" min="0" data-item-id="' + it.id + '">' +
                                '<div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm view-item-plus" title="Increase">+</button></div></div></td>' +
                                '<td><button type="button" class="btn btn-sm btn-icon btn-outline-danger view-item-remove" data-item-id="' + it.id + '" title="Remove"><i class="fas fa-trash-alt"></i></button></td>';
                            tbody.appendChild(tr);
                        });
                        bindViewItemEvents();
                        $('#viewAssignmentModal').modal('show');
                    })
                    .catch(function() {
                        alert('Failed to load assignment.');
                    });
            });
        });

        function bindViewItemEvents() {
            document.getElementById('view-assignment-items').querySelectorAll('tr').forEach(function(tr) {
                var itemId = tr.getAttribute('data-item-id');
                var input = tr.querySelector('.view-item-qty');
                var minus = tr.querySelector('.view-item-minus');
                var plus = tr.querySelector('.view-item-plus');
                var remove = tr.querySelector('.view-item-remove');

                function updateItemQty(newQty) {
                    fetch('{{ route("product-assignments.update-item") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: JSON.stringify({ item_id: itemId, quantity: newQty })
                    }).then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success && data.removed) {
                            tr.remove();
                            if (data.assignment_deleted) {
                                removeListRow(data.assignment_id);
                                window.closeViewAssignmentModal();
                            } else {
                                updateListRow(data.assignment_id, data.total_quantity);
                            }
                        } else if (data.success) {
                            input.value = (data.quantity !== undefined ? data.quantity : newQty);
                            updateListRow(data.assignment_id, data.total_quantity);
                        } else {
                            alert(data.message || 'Error');
                        }
                    }).catch(function() { alert('Error'); });
                }

                if (minus) minus.onclick = function() {
                    var v = parseInt(input.value, 10) || 0;
                    if (v > 0) updateItemQty(v - 1);
                };
                if (plus) plus.onclick = function() {
                    var v = parseInt(input.value, 10) || 0;
                    updateItemQty(v + 1);
                };
                input.addEventListener('change', function() {
                    var v = parseInt(this.value, 10);
                    if (isNaN(v) || v < 0) v = 0;
                    updateItemQty(v);
                });
                if (remove) remove.onclick = function() {
                    if (!confirm('Remove this product from assignment? Quantity will return to stock.')) return;
                    fetch('{{ route("product-assignments.remove-item") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: JSON.stringify({ item_id: itemId })
                    }).then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success) {
                            tr.remove();
                            if (data.assignment_deleted) {
                                removeListRow(data.assignment_id);
                                window.closeViewAssignmentModal();
                            } else {
                                updateListRow(data.assignment_id, data.total_quantity);
                            }
                        }
                    });
                };
            });
        }

        document.getElementById('view-add-item-btn').addEventListener('click', function() {
            var assignmentId = document.getElementById('view-assignment-id').value;
            var productId = document.getElementById('view-add-product-id').value;
            var qty = document.getElementById('view-add-qty').value;
            if (!assignmentId || !productId || !qty) {
                alert('Select product and quantity.');
                return;
            }
            var btn = this;
            btn.disabled = true;
            fetch('{{ route("product-assignments.add-item") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ assignment_id: assignmentId, product_id: productId, quantity: parseInt(qty, 10) })
            }).then(function(r) { return r.json(); })
            .then(function(data) {
                btn.disabled = false;
                if (data.success && data.item) {
                    var tbody = document.getElementById('view-assignment-items');
                    var it = data.item;
                    var tr = document.createElement('tr');
                    tr.setAttribute('data-item-id', it.id);
                    tr.innerHTML = '<td>' + (it.product && it.product.Product_Name ? it.product.Product_Name : '') + '</td>' +
                        '<td><div class="input-group input-group-sm" style="max-width:120px">' +
                        '<div class="input-group-prepend"><button type="button" class="btn btn-outline-secondary btn-sm view-item-minus" title="Decrease">−</button></div>' +
                        '<input type="number" class="form-control view-item-qty" value="' + it.quantity + '" min="0" data-item-id="' + it.id + '">' +
                        '<div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm view-item-plus" title="Increase">+</button></div></div></td>' +
                        '<td><button type="button" class="btn btn-sm btn-icon btn-outline-danger view-item-remove" data-item-id="' + it.id + '" title="Remove"><i class="fas fa-trash-alt"></i></button></td>';
                    tbody.appendChild(tr);
                    bindViewItemEvents();
                    document.getElementById('view-add-qty').value = '1';
                    if (data.assignment_id != null && data.total_quantity != null) {
                        updateListRow(data.assignment_id, data.total_quantity);
                    }
                } else if (!data.success) {
                    alert(data.message || 'Error');
                }
            }).catch(function() { btn.disabled = false; });
        });
    })();
    </script>
</x-app-layout>
