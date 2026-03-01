<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ isset($is_employee) && $is_employee ? 'My Spare Utilized Report' : 'Spare Utilized Report' }}</h4>
                        <small class="text-muted">{{ isset($is_employee) && $is_employee ? 'Spares you have utilized (DCs added by you) under service calls.' : 'View spare utilization by employee (DCs added by selected employee).' }}</small>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    @if (isset($is_employee) && !$is_employee)
                                    <div class="col-lg-3">
                                        <label>Employee <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="employee-id" name="employee_id">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees ?? [] as $emp)
                                                <option value="{{ $emp->id }}" {{ ($selected_employee_id ?? '') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-lg-3">
                                        <label>Date Range <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="date-range" name="date_range">
                                            @if (isset($is_employee) && $is_employee)
                                                <option value="">Date Range</option>
                                                <option value="-1" {{ ($date_range ?? '-1') == '-1' ? 'selected' : '' }}>Any</option>
                                            @else
                                                <option value="">Select Date Range</option>
                                            @endif
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
                                    <table class="table table-striped" id="employee-spare-utilized-report">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Issue Date</th>
                                                <th>Service No.</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>DC Type</th>
                                            </tr>
                                        </thead>
                                        <tbody id="employeeSpareUtilizedList">
                                            @include('reports.employee_spare_utilized_pagination')
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
                window.location.replace("{{ route('employee-spare-utilized-report') }}");
            });

            $(document).on("click", ".btn-fetch-report", function() {
                var date_range = $("#date-range option:selected").val();
                var date_range_val = (date_range === "" ? "-1" : date_range);
                var employee_id = $("#employee-id").length ? $("#employee-id option:selected").val() : "";
                @if (isset($is_employee) && !$is_employee)
                if (!employee_id) {
                    alert("Please select an employee.");
                    return;
                }
                if (!date_range) {
                    alert("Please select a date range.");
                    return;
                }
                @endif

                $.ajax({
                    type: "GET",
                    url: "{{ route('employee-spare-utilized-report-data') }}",
                    data: { date_range: date_range_val, employee_id: employee_id },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    success: function(html) {
                        $("#employeeSpareUtilizedList").empty();
                        $("#employeeSpareUtilizedList").append(html);
                        $(".loader").hide();
                    },
                    error: function(xhr) {
                        $(".loader").hide();
                        var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : "Error loading report.";
                        alert(msg);
                    }
                });
            });

            $(document).on("click", ".btn-export-report", function() {
                var date_range = $("#date-range option:selected").val();
                var date_range_export = (date_range === "" ? "-1" : date_range);
                var employee_id = $("#employee-id").length ? $("#employee-id option:selected").val() : "";
                @if (isset($is_employee) && !$is_employee)
                if (!employee_id) {
                    alert("Please select an employee.");
                    return;
                }
                if (!date_range) {
                    alert("Please select a date range.");
                    return;
                }
                @endif
                var url = "{{ route('employee-spare-utilized-report-export') }}?date_range=" + encodeURIComponent(date_range_export) + "&employee_id=" + encodeURIComponent(employee_id);
                window.location.href = url;
            });

            $(document).on("click", "#employeeSpareUtilizedList .pagination a", function(e) {
                e.preventDefault();
                var url = $(this).attr("href");
                if (!url) return;
                $.get(url, function(html) {
                    $("#employeeSpareUtilizedList").empty();
                    $("#employeeSpareUtilizedList").append(html);
                });
            });
        </script>
    @stop
</x-app-layout>
