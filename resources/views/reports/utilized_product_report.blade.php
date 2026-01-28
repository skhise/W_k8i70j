<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Utilized Product Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Select Client</label>
                                        <select id="client" class="form-control select2">
                                            <option value="">Select Customer</option>
                                            <option value="0" {{ $customer_id == 0 ? 'selected' : '' }}>All</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->CST_ID }}"
                                                    {{ $client->CST_ID == $customer_id ? 'selected' : '' }}>
                                                    {{ $client->CST_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>DC Type</label>
                                        <select id="dc_type" class="form-control select2">
                                            <option value="">Select DC Type</option>
                                            <option value="0" {{ $dc_type == 0 ? 'selected' : '' }}>All</option>
                                            @foreach ($dc_types as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ $type->id == $dc_type ? 'selected' : '' }}>
                                                    {{ $type->dc_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Date Range</label>
                                        <select class="form-control select2" id="date-range">
                                            <option value="">Date Range</option>
                                            <option value="-1" {{ $date_range == '-1' ? 'selected' : '' }}>Any</option>
                                            <option value="0" {{ $date_range == '0' ? 'selected' : '' }}>Today</option>
                                            <option value="1" {{ $date_range == '1' ? 'selected' : '' }}>Yesterday</option>
                                            <option value="7" {{ $date_range == '7' ? 'selected' : 'selected' }}>Last 7 Days</option>
                                            <option value="30" {{ $date_range == '30' ? 'selected' : '' }}>Last 30 Days</option>
                                            <option value="60" {{ $date_range == '60' ? 'selected' : '' }}>Last 60 Days</option>
                                            <option value="180" {{ $date_range == '180' ? 'selected' : '' }}>Last 180 Days</option>
                                        </select>
                                    </div>
                                </div>

                                <hr />
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 d-flex">
                                        <button class="btn btn-primary ml-2 btn-fetch-report">Generate</button>
                                        <button class="btn btn-light ml-2 btn-export-report">Export</button>
                                        <button class="btn btn-danger ml-2 btn-reset">Reset</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="utilized-product-report">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Client Name</th>
                                                <th>Contract No.</th>
                                                <th>Service No.</th>
                                                <th>Product Name</th>
                                                <th>Serial Number</th>
                                                <th>DC Type</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Issue Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="utilizedProductList">
                                            @include('reports.utilized_product_pagination')
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
        </section>
    </div>
    @section('script')
        <script>
            $(document).on("click", ".btn-reset", function() {
                window.location.replace("utilized-product-report");
            });
            
            $(document).on("click", ".btn-fetch-report", function() {
                var cust_id = $("#client option:selected").val();
                var dc_type = $("#dc_type option:selected").val();
                var date_range = $("#date-range option:selected").val();
                
                if (cust_id === "" || dc_type === "" || date_range === "") {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select all filter values',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "utilized-product-report-data",
                    data: {
                        customer_id: cust_id,
                        dc_type: dc_type,
                        date_range: date_range
                    },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    success: function(html) {
                        $("#utilizedProductList").empty();
                        $("#utilizedProductList").append(html);
                        $(".loader").hide();
                    },
                    error: function(error) {
                        $(".loader").hide();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong, try again',
                            dangerMode: true,
                            icon: 'warning',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                        });
                    }
                });
            });
            
            $(document).on("click", ".btn-export-report", function() {
                var cust_id = $("#client option:selected").val();
                var dc_type = $("#dc_type option:selected").val();
                var date_range = $("#date-range option:selected").val();
                
                if (cust_id === "" || dc_type === "" || date_range === "") {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select all filter values',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "utilized-product-report-export",
                    data: {
                        customer_id: cust_id,
                        dc_type: dc_type,
                        date_range: date_range
                    },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    success: function(result, status, xhr) {
                        $(".loader").hide();
                        var disposition = xhr.getResponseHeader('content-disposition');
                        var matches = /"([^"]*)"/.exec(disposition);
                        var timestamp = new Date().toISOString().replace(/[:\-T]/g, '').slice(0, 15);
                        var filename = (matches != null && matches[1] ? matches[1] : `utilized_product_report_${timestamp}.csv`);

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;

                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function(error) {
                        $(".loader").hide();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong, try again',
                            dangerMode: true,
                            icon: 'warning',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                        });
                    }
                });
            });

            // Handle pagination clicks
            $(document).on("click", ".pagination a", function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if (url) {
                    var match = url.match(/page=(\d+)/);
                    var page = match ? match[1] : null;
                    var cust_id = $("#client option:selected").val();
                    var dc_type = $("#dc_type option:selected").val();
                    var date_range = $("#date-range option:selected").val();
                    
                    $.ajax({
                        type: "GET",
                        url: "utilized-product-report-data",
                        data: {
                            customer_id: cust_id,
                            dc_type: dc_type,
                            date_range: date_range,
                            page: page
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#utilizedProductList").empty();
                            $("#utilizedProductList").append(html);
                            $(".loader").hide();
                        },
                        error: function(error) {
                            $(".loader").hide();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong, try again',
                                dangerMode: true,
                                icon: 'warning',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            });
                        }
                    });
                }
            });
        </script>
    @stop
</x-app-layout>
