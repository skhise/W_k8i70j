<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>AMC Products</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('contracts.create') }}"
                                        class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus-square"></i>
                                        Add Contract</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('contracts.products') }}" id="search_form" method="GET">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <select class="form-control select2" name="filter_customer"
                                                        id="filter_customer">
                                                        <option value="">All Clients</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{$customer->CST_ID}}" {{$filter_customer == $customer->CST_ID ? "selected" : ""}}>{{$customer->CST_Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            value="{{ $search }}" id="search" name="search"
                                                            placeholder="Search by product name, serial number, contract number, or client name">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="button" id="search-btn"><i class="fas fa-search"></i></button>
                                                            <button type="button" class="btn btn-danger" id="clear-btn" style="display: {{($search || $filter_customer) ? 'block' : 'none'}};">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <div id="products-table-container">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Contract Number</th>
                                                    <th>Customer Name</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Serial Number</th>
                                                    <th>Branch/Location</th>
                                                    <th>Contract Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @include('contracts.products_table', ['products' => $products])
                                        </table>
                                        <div class="float-left">
                                            @if ($products->total())
                                                <p>Found {{ $products->total() }} records</p>
                                            @endif
                                        </div>
                                        <div class="float-right">
                                            {{ $products->links() }}
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

    {{-- Service Call (Lock call) modal - wide, no scroll --}}
    <style>
        #serviceCallModal .modal-dialog { max-width: 95%; width: 1100px; }
    </style>
    <div class="modal fade" id="serviceCallModal" tabindex="-1" role="dialog" aria-labelledby="serviceCallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceCallModalLabel">Service Call</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="service-call-error" class="alert alert-danger d-none"></div>
                    <form id="form_service_call">
                        @csrf
                        <input type="hidden" name="contract_id" id="sc_contract_id" value="">
                        <input type="hidden" name="product_id" id="sc_product_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-primary border-bottom pb-1">Service Details</h6>
                                <div class="form-group">
                                    <label>Service Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="service_type" id="sc_service_type" required>
                                        <option value="">Select Service type</option>
                                        @isset($service_types)
                                            @foreach($service_types as $st)
                                                <option value="{{ $st->id }}">{{ $st->type_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Issue Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="issue_type" id="sc_issue_type" required>
                                        <option value="">Select issue type</option>
                                        @isset($issue_types)
                                            @foreach($issue_types as $it)
                                                <option value="{{ $it->id }}">{{ $it->issue_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select priority <span class="text-danger">*</span></label>
                                    <select class="form-control" name="service_priority" id="sc_service_priority" required>
                                        <option value="">Select priority</option>
                                        @isset($priorities)
                                            @foreach($priorities as $p)
                                                <option value="{{ $p->id }}" {{ ($p->priority_name ?? '') == 'Low' ? 'selected' : '' }}>{{ $p->priority_name ?? $p->id }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Service Date</label>
                                    <input type="date" class="form-control" name="service_date" id="sc_service_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Issue Description</label>
                                    <textarea class="form-control" name="service_note" id="sc_service_note" rows="2" placeholder="Note"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-primary border-bottom pb-1">Contact Details</h6>
                                <div class="form-group">
                                    <label>Contact Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="contact_person" id="sc_contact_person" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label>Contact Mobile</label>
                                        <input type="text" class="form-control" name="contact_number1" id="sc_contact_number1">
                                    </div>
                                    <div class="col-6">
                                        <label>Alternate Number</label>
                                        <input type="text" class="form-control" name="contact_number2" id="sc_contact_number2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Contact Email</label>
                                    <input type="email" class="form-control" name="contact_email" id="sc_contact_email">
                                </div>
                                <div class="form-group">
                                    <label>Site Location</label>
                                    <select class="form-control" name="areaId" id="sc_site_location">
                                        <option value="">Select site location</option>
                                        @isset($sitelocation)
                                            @foreach($sitelocation as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->SiteAreaName ?? $loc->id }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Site Address</label>
                                    <textarea class="form-control" name="site_address" id="sc_site_address" rows="2" placeholder="Site Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-primary border-bottom pb-1">Additional Information</h6>
                                <div class="form-group">
                                    <label>Google Location Link</label>
                                    <input type="text" class="form-control" name="site_google_link" id="sc_site_google_link" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Assign to engineer</label>
                                    <select class="form-control" name="assigned_to" id="sc_assigned_to">
                                        <option value="">Select engineer</option>
                                        @isset($employees)
                                            @foreach($employees as $emp)
                                                <option value="{{ $emp->EMP_ID }}">{{ $emp->EMP_Name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="send_whatsapp" id="sc_send_whatsapp" value="1">
                                    <label class="form-check-label" for="sc_send_whatsapp">Send WhatsApp Notification</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn_service_call_save">
                        <span class="btn-text">Save</span>
                        <span class="btn-loader d-none"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                // Initialize select2 for customer dropdown
                $('#filter_customer').select2({
                    placeholder: 'Select Clinet',
                    allowClear: true
                });

                // Function to load products via AJAX
                function loadProducts() {
                    var search = $('#search').val();
                    var filter_customer = $('#filter_customer').val();
                    
                    // Show loading indicator
                    $('#products-table-container').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Loading...</p></div>');
                    
                    $.ajax({
                        url: "{{ route('contracts.products') }}",
                        type: 'GET',
                        data: {
                            search: search,
                            filter_customer: filter_customer
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            if (response.html) {
                                $('#products-table-container').html(response.html);
                                
                                // Update clear button visibility
                                if (search || filter_customer) {
                                    $('#clear-btn').show();
                                } else {
                                    $('#clear-btn').hide();
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#products-table-container').html('<div class="alert alert-danger">Error loading products. Please try again.</div>');
                            console.error('Error:', error);
                        }
                    });
                }

                // Customer dropdown change event
                $('#filter_customer').on('change', function() {
                    loadProducts();
                });

                // Search button click event
                $('#search-btn').on('click', function() {
                    loadProducts();
                });

                // Search on Enter key press
                $('#search').on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        loadProducts();
                    }
                });

                // Clear button click event
                $('#clear-btn').on('click', function() {
                    $('#search').val('');
                    $('#filter_customer').val('').trigger('change');
                    loadProducts();
                });

                // Service Call (Lock call) modal: open and pre-fill from contract
                $(document).on('click', '.btn-service-call', function() {
                    var contractId = $(this).data('contract-id');
                    var productId = $(this).data('product-id') || '';
                    $('#sc_contract_id').val(contractId);
                    $('#sc_product_id').val(productId);
                    $('#service-call-error').addClass('d-none').text('');
                    $('#form_service_call')[0].reset();
                    $('#sc_contract_id').val(contractId);
                    $('#sc_product_id').val(productId);
                    $('#sc_service_date').val(new Date().toISOString().slice(0, 10));
                    $('#serviceCallModal').modal('show');
                    $.ajax({
                        url: "{{ route('contracts.contract-details-for-service-call') }}",
                        type: 'GET',
                        data: { contract_id: contractId },
                        success: function(res) {
                            if (res.success) {
                                $('#sc_contact_person').val(res.contact_person || '');
                                $('#sc_contact_number1').val(res.contact_number1 || '');
                                $('#sc_contact_number2').val(res.contact_number2 || '');
                                $('#sc_contact_email').val(res.contact_email || '');
                                $('#sc_site_address').val(res.site_address || '');
                                $('#sc_site_google_link').val(res.site_google_link || '');
                                if (res.site_location) $('#sc_site_location').val(res.site_location);
                            }
                        },
                        error: function() {
                            $('#service-call-error').removeClass('d-none').text('Could not load contract details.').show();
                        }
                    });
                });

                // Service Call Save (AJAX with loader)
                $('#btn_service_call_save').on('click', function() {
                    var $btn = $(this);
                    var $btnText = $btn.find('.btn-text');
                    var $btnLoader = $btn.find('.btn-loader');
                    var $err = $('#service-call-error');
                    $err.addClass('d-none').text('');
                    if (!$('#sc_contract_id').val()) {
                        $err.removeClass('d-none').text('Contract is required.').show();
                        return;
                    }
                    $btn.prop('disabled', true);
                    $btnText.addClass('d-none');
                    $btnLoader.removeClass('d-none');
                    $.ajax({
                        url: "{{ route('services.store-from-contract') }}",
                        type: 'POST',
                        data: $('#form_service_call').serialize(),
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(res) {
                            $btn.prop('disabled', false);
                            $btnText.removeClass('d-none');
                            $btnLoader.addClass('d-none');
                            if (res.success) {
                                $('#serviceCallModal').modal('hide');
                                loadProducts();
                                if (typeof res.service_no !== 'undefined') {
                                    alert('Service call created: ' + res.service_no);
                                }
                            } else {
                                $err.removeClass('d-none').text(res.message || 'Failed to create service call.').show();
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false);
                            $btnText.removeClass('d-none');
                            $btnLoader.addClass('d-none');
                            var msg = 'Request failed. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            $err.removeClass('d-none').text(msg).show();
                        }
                    });
                });

                // Handle pagination links (they will be inside the container after AJAX load)
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    if (url) {
                        // Extract query parameters from URL
                        var urlParams = new URLSearchParams(url.split('?')[1]);
                        var search = urlParams.get('search') || '';
                        var filter_customer = urlParams.get('filter_customer') || '';
                        
                        // Update form values
                        $('#search').val(search);
                        $('#filter_customer').val(filter_customer).trigger('change');
                        
                        // Load products with pagination
                        $('#products-table-container').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Loading...</p></div>');
                        
                        $.ajax({
                            url: url,
                            type: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.html) {
                                    $('#products-table-container').html(response.html);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#products-table-container').html('<div class="alert alert-danger">Error loading products. Please try again.</div>');
                                console.error('Error:', error);
                            }
                        });
                    }
                });
            });
        </script>
    @stop
</x-app-layout>
