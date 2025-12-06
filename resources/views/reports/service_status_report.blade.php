<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Service Status Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select id="client" class="form-control select2">
                                            <option value="">Select Customer</option>
                                            <option value="0" {{ $customer == 0 ? 'selected' : '' }}>All</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->CST_ID }}"
                                                    {{ $client->CST_ID == $customer ? 'selected' : '' }}>
                                                    {{ $client->CST_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select id="type" class="form-control select2">
                                            <option value="">Select Type</option>
                                            <option value="" selected>All</option>
                                            <option value="1">Contracted</option>
                                            <option value="0">Non-Contracted</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select id="report_service_status" class="form-control select2">
                                            <option value="">Select Status</option>
                                            <option value="0" {{ $sstatus == 0 ? 'selected' : 'selected' }}>All</option>
                                            @foreach ($status as $status)
                                                <option value="{{ $status->Status_Id }}"
                                                    {{ $status->Status_Id == $sstatus ? 'selected' : '' }}>
                                                    {{ $status->Status_Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select id="report_service_type" class="form-control select2">
                                            <option value="">Service Type</option>
                                            <option value="0" {{ $service_type == 0 ? 'selected' : 'selected' }}>All
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
                                            <option value="7" selected>Last 7 Days</option>
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
                                        <button class="btn btn-light ml-2 btn-export-report">Export</button>
                                        <button class="btn btn-danger ml-2 btn-reset">Reset</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="contract-report">
                                        <thead>
                                            <tr>
                                                <th>Ticket No. </th>
                                                <th>Type </th>
                                                <th>Contract No.</th>
                                                <th class="table-width-20">Customer Name</th>
                                                <th>Service Type </th>
                                                <th>Issue Type </th>
                                                <th>Issue Description </th>
                                                <th>Contact Person</th>
                                                <th>Status </th>
                                                <th>Engineer</th>
                                                <th>Resolved At </th>
                                                <th>Closed At </th>
                                                <th>Expenses </th>
                                                <th>Customer Charges </th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contractReportList">
                                            @include('reports.strs_pagination')
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
                window.location.replace("service-status-report");
            });
            $(document).on("click", ".btn-fetch-report", function() {
                var cust_id = $("#client option:selected").val();
                var cust_Name = $("#client option:selected").text();
                var type = $("#type option:selected").val();
                var status = $("#report_service_status option:selected").val();
                var service_type = $("#report_service_type option:selected").val();
                var date_range = $("#date-range option:selected").val();
                if (cust_id != "" && status != "") {
                    $.ajax({
                        type: "GET",
                        url: "service-status-report-data",
                        data: {
                            status: status,
                            customer: cust_id,
                            type:type,
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
            $(document).on("click", ".btn-export-report", function() {
                var cust_id = $("#client option:selected").val();
                var cust_Name = $("#client option:selected").text();
                var status = $("#report_service_status option:selected").val();
                //var type = $("#report_service_type option:selected").val();
                 var type = $("#type option:selected").val();
                var daterange = $("#date-range option:selected").val();
                if (cust_id != "" && status != "") {
                    $.ajax({
                        type: "GET",
                        url: "service-status-report-export",
                        data: {
                            status: status,
                            customer: cust_id,
                            daterange: daterange,
                            type:type
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(result, status, xhr) {
                            console.log(result);
                            const currentDateInSeconds = Math.floor(Date.now() / 1000);

                            $(".loader").hide();
                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var filename = (matches != null && matches[1] ? matches[1] : "service_report_" +
                                cust_Name + "_" +
                                currentDateInSeconds + '.csv');

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
        </script>
    @stop
</x-app-layout>
