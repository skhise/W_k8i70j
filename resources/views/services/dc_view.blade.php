<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">DC Details</h4>
                                <div class="card-header-action">
                                    @if ($flag == 1)
                                        <a class="btn btn-danger" href="{{ route('dc-report') }}">Back</a>
                                    @else
                                        <a class="btn btn-info" target="_blank"
                                            href="{{ route('services.dc_print', $service_dc->dcp_id) }}">Print</a>
                                        <a class="btn btn-danger" href="{{ route('dcmanagements') }}">Back</a>
                                    @endif
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">DC
                                                            No.: {{ $service_dc->id }}</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">DC Type:
                                                            {{ $service_dc->dc_type_name }}</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Service
                                                            No.:{{ $service_dc->service_no }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">Client Name :
                                                            {{ $service_dc->CST_Name }}</span>
                                                    </div>

                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">Description</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $service_dc->Product_Description }}
                                                    </div>
                                                </div>
                                            </div>

                                            @include('services.dc_product')

                                            @if ($flag != 1)
                                                <div class="row m-3">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addSpareProductModal">
                                                            <i class="fas fa-plus"></i> Add Spare Product
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                            <hr />
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    @if ($flag != 1)
    <div class="modal fade" id="addSpareProductModal" tabindex="-1" role="dialog" aria-labelledby="addSpareProductModalLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('services.dc_add_spare', $service_dc->dcp_id) }}" method="POST" id="addSpareProductForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSpareProductModalLabel">Add Spare Product to DC</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.closeAddSpareModal(event)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="spare_product_id">Spare Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="spare_product_id" class="form-control" required>
                                <option value="">Select spare product</option>
                                @foreach ($spare_products as $sp)
                                    <option value="{{ $sp->Product_ID }}" data-price="{{ $sp->Product_Price ?? 0 }}">{{ $sp->Product_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="spare_quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="spare_quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="spare_amount">Amount (Rs.) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="spare_amount" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="spare_description">Description</label>
                            <textarea name="description" id="spare_description" class="form-control" rows="2" placeholder="Optional"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.closeAddSpareModal(event)">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addSpareSubmitBtn">
                            <span class="btn-spare-text"><i class="fas fa-plus mr-1"></i> Add Spare</span>
                            <span class="btn-spare-loader spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @section('script')
        <script>
            function closeAddSpareModal(e) {
                if (e) { e.preventDefault(); e.stopPropagation(); }
                var modal = document.getElementById('addSpareProductModal');
                if (modal) {
                    if (typeof jQuery !== 'undefined' && jQuery(modal).data('bs.modal')) {
                        jQuery(modal).modal('hide');
                    } else {
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                    }
                }
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
                document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
                var form = document.getElementById('addSpareProductForm');
                if (form) {
                    form.reset();
                    var btn = document.getElementById('addSpareSubmitBtn');
                    if (btn) {
                        btn.disabled = false;
                        var text = btn.querySelector('.btn-spare-text');
                        var loader = btn.querySelector('.btn-spare-loader');
                        if (text) text.classList.remove('d-none');
                        if (loader) loader.classList.add('d-none');
                    }
                }
            }
            window.closeAddSpareModal = closeAddSpareModal;

            $(document).on('change', '#Image_Path', function() {
                var value = $(this).val();
                if (value != "") {
                    $('#image_upload')[0].submit();
                }
            });
            $(document).on('change', '#spare_product_id', function() {
                var price = $(this).find('option:selected').data('price');
                if (price != null && price !== '') {
                    $('#spare_amount').val(parseFloat(price) || '');
                }
            });
            $(document).on('click', '[data-dismiss="modal"]', function(e) {
                var $target = $(e.target).closest('.modal');
                if ($target.attr('id') === 'addSpareProductModal') {
                    e.preventDefault();
                    closeAddSpareModal(e);
                }
            });
            $('#addSpareProductModal').on('show.bs.modal', function() {
                var form = document.getElementById('addSpareProductForm');
                if (form) form.reset();
                $('#spare_quantity').val(1);
                var btn = document.getElementById('addSpareSubmitBtn');
                if (btn) {
                    btn.disabled = false;
                    var text = btn.querySelector('.btn-spare-text');
                    var loader = btn.querySelector('.btn-spare-loader');
                    if (text) text.classList.remove('d-none');
                    if (loader) loader.classList.add('d-none');
                }
            });
            $('#addSpareProductModal').on('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
                document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
                var form = document.getElementById('addSpareProductForm');
                if (form) form.reset();
                $('#spare_quantity').val(1);
            });
            $('#addSpareProductForm').on('submit', function() {
                var $btn = $('#addSpareSubmitBtn');
                $btn.prop('disabled', true);
                $btn.find('.btn-spare-text').addClass('d-none');
                $btn.find('.btn-spare-loader').removeClass('d-none');
            });
        </script>
    @stop
</x-app-layout>
