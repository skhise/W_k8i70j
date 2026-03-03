<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Spares Utilized Report (Products / Spares)</h4>
                        <small class="text-muted">Based on products under Spares Management – shows utilized quantity per product from service DCs.</small>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Product Type</label>
                                        <select id="filter_type" class="form-control select2">
                                            <option value="">All</option>
                                            <option value="0" {{ ($filter_type ?? '') == '0' ? 'selected' : '' }}>All</option>
                                            @foreach ($product_types as $pt)
                                                <option value="{{ $pt->id }}" {{ ($filter_type ?? '') == $pt->id ? 'selected' : '' }}>{{ $pt->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Date Range (utilization)</label>
                                        <select class="form-control select2" id="date-range">
                                            <option value="">Date Range</option>
                                            <option value="0" {{ ($date_range ?? '') == '0' ? 'selected' : '' }}>Today</option>
                                            <option value="1" {{ ($date_range ?? '') == '1' ? 'selected' : '' }}>Yesterday</option>
                                            <option value="7" {{ ($date_range ?? '') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                                            <option value="30" {{ ($date_range ?? '') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                                            <option value="60" {{ ($date_range ?? '') == '60' ? 'selected' : '' }}>Last 60 Days</option>
                                            <option value="180" {{ ($date_range ?? '') == '180' ? 'selected' : '' }}>Last 180 Days</option>
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
                                    <table class="table table-striped" id="spares-utilized-report">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Product Name</th>
                                                <th>Product Type</th>
                                                <th>Available Qty</th>
                                                <th>Reserved Qty</th>
                                                <th>Utilized Qty</th>
                                                <th>Last Used Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sparesUtilizedList">
                                            @include('reports.spares_utilized_pagination')
                                        </tbody>
                                    </table>
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
            $(document).on("click", ".btn-reset", function() {
                window.location.replace("{{ route('spares-utilized-report') }}");
            });

            $(document).on("click", ".btn-fetch-report", function() {
                var filter_type = $("#filter_type option:selected").val();
                var date_range = $("#date-range option:selected").val();

                var date_range_val = (date_range === "" ? "-1" : date_range);

                $.ajax({
                    type: "GET",
                    url: "{{ route('spares-utilized-report-data') }}",
                    data: {
                        filter_type: filter_type,
                        date_range: date_range_val
                    },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    success: function(html) {
                        $("#sparesUtilizedList").empty();
                        $("#sparesUtilizedList").append(html);
                        $(".loader").hide();
                    },
                    error: function() {
                        $(".loader").hide();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong, try again',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                        });
                    }
                });
            });

            $(document).on("click", ".btn-export-report", function() {
                var filter_type = $("#filter_type option:selected").val();
                var date_range = $("#date-range option:selected").val();

                var date_range_export = (date_range === "" ? "-1" : date_range);
                var url = "{{ route('spares-utilized-report-export') }}?filter_type=" + encodeURIComponent(filter_type) + "&date_range=" + encodeURIComponent(date_range_export);
                window.location.href = url;
            });

            $(document).on("click", "#sparesUtilizedList .pagination a", function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if (url) {
                    var match = url.match(/page=(\d+)/);
                    var page = match ? match[1] : null;
                    var filter_type = $("#filter_type option:selected").val();
                    var date_range = $("#date-range option:selected").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('spares-utilized-report-data') }}",
                        data: {
                            filter_type: filter_type,
                            date_range: (date_range === "" ? "-1" : date_range),
                            page: page
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#sparesUtilizedList").empty();
                            $("#sparesUtilizedList").append(html);
                            $(".loader").hide();
                        },
                        error: function() {
                            $(".loader").hide();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong',
                                icon: 'warning',
                                confirmButtonColor: '#3085d6',
                            });
                        }
                    });
                }
            });
        </script>
    @stop
</x-app-layout>
