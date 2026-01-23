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
                                            <tbody>
                                                @if (count($products) == 0)
                                                    <tr>
                                                        <td colspan="9" class="text-center">No products found</td>
                                                    </tr>
                                                @endif
                                                @foreach ($products as $key => $product)
                                                    <tr>
                                                        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}</td>
                                                        <td>
                                                            <a href="{{ route('contracts.view', $product->CNRT_ID) }}">
                                                                {{ $product->CNRT_Number }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $product->CST_Name ?? 'N/A' }}
                                                            @if($product->CNRT_Phone1)
                                                                <br><small class="text-muted">{{ $product->CNRT_Phone1 }}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->type_name ?? 'N/A' }}</td>
                                                        <td>{{ $product->nrnumber ?? 'N/A' }}</td>
                                                        <td>{{ $product->branch ?? 'N/A' }}</td>
                                                        <td>
                                                            <span class="text-white badge badge-shadow {{ $product->status_color ?? 'bg-light' }}">
                                                                {{ $product->contract_status_name ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('contracts.view', $product->CNRT_ID) }}"
                                                                class="btn btn-primary btn-sm"><i class="far fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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
