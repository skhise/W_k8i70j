<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Engineer Ticket Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select id="employee" class="form-control select2">
                                            <option value="">Select Engineer</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->EMP_ID }}"
                                                    {{ $employee->EMP_ID == $selected_employee ? 'selected' : '' }}>
                                                    {{ $employee->EMP_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select id="report_service_status" class="form-control select2">
                                            <option value="">Select Status</option>
                                            <option value="0" {{ $sstatus == 0 ? 'selected' : '' }}>All</option>
                                            @foreach ($status as $status)
                                                <option value="{{ $status->Status_Id }}"
                                                    {{ $status->Status_Id == $sstatus ? 'selected' : '' }}>
                                                    {{ $status->Status_Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select id="report_service_type" class="form-control select2">
                                            <option value="">Select Service Type</option>
                                            <option value="0" {{ $service_type == 0 ? 'selected' : '' }}>All
                                            </option>
                                            @foreach ($service_types as $servicetype)
                                                <option value="{{ $servicetype->id }}"
                                                    {{ $servicetype->id == $service_type ? 'selected' : '' }}>
                                                    {{ $servicetype->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="date-range">
                                            <option value="">Date Range</option>
                                            <option value="-1">Any</option>
                                            <option value="0">Today</option>
                                            <option value="1">Yesterday</option>
                                            <option value="7">Last 7 Days</option>
                                            <option value="30">Last 30 Days</option>
                                            <option value="60">Last 60 Days</option>
                                            <option value="180">Last 180 Days</option>

                                        </select>
                                    </div>


                                </div>

                                <hr />
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 d-flex">
                                        <button class="btn btn-primary ml-2 btn-fetch-report">Generate</button>
                                        <button onclick="exportExcel()"
                                            class="btn btn-light ml-2 btn-export-report">Export</button>
                                        <button class="btn btn-danger ml-2 btn-reset">Reset</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="contract-report">
                                        <thead>
                                            <tr>
                                                <tr>
                                                <th>Ticket No. </th>
                                                <th>Type </th>
                                                <th>Contract No.</th>
                                                <th class="table-width-20">Customer Name</th>
                                                <th class="table-width-20">Product</th>
                                                <th>Service Type </th>
                                                <th>Issue Type </th>
                                                <th>Issue Description </th>
                                                <th>Contact Person</th>
                                                <th>Reported At</th>
                                                <th>Response Time (Hours) </th>
                                                <th>Action Taken By Engineer </th>
                                                <th>Status </th>
                                                <th>Engineer</th>
                                                <th>Resolved At </th>
                                                <th>Closed At </th>
                                                <th>Age(Hours) </th>
                                                <th>Expansion </th>
                                                <th>Customer Charges </th>
                                                <th>Remark</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody id="contractReportList">
                                            @include('reports.etr_pagination')
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
                window.location.replace("engineer-service-analysis");
            });
            $(document).on("click", ".btn-fetch-report", function() {
                var employee = $("#employee option:selected").val();
                var cust_Name = $("#employee option:selected").text();
                var status = $("#report_service_status option:selected").val();
                var service_type = $("#report_service_type option:selected").val();
                var date_range = $("#date-range option:selected").val();
                if (employee != "" && status != "") {
                    $.ajax({
                        type: "GET",
                        url: "engineer-ticket-report-data",
                        data: {
                            status: status,
                            employee: employee,
                            date_range: date_range,
                            service_type: service_type
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#contractReportList").empty();
                            $("#contractReportList").append(html);
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

                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Select filter values',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                }
            });

            function exportExcel() {
                var table = $(".contractReportListTable");
                if (table && table.length) {
                    var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                    $(table).table2excel({
                        exclude: ".noExl",
                        name: "Contract Reporte",
                        filename: "ContractReport" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        preserveColors: preserveColors
                    });
                }
            }
        </script>
    @stop
</x-app-layout>
