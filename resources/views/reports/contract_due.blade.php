<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Contract Due Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="row">
                                
                                <div class="col-lg-2">
                                    <select class="form-control select2" id="duein-range">
                                            <option value="">Due In</option>
                                            <option value="0">Today</option>
                                            <option value="7">In 7 Days</option>
                                            <option value="30">in 30 Days</option>
                                            <option value="60">In 60 Days</option>
                                            <option value="90">In 90 Days</option>

                                        </select>

                                    
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <button class="btn btn-primary ml-2 btn-fetch-report">Generate</button>
                                    <button type="submit" class="btn-export-report btn btn-light ml-2">Export</button>
                                    <button class="btn btn-danger ml-2 btn-reset">Reset</button>
                                </div>
                            </div>
                            <div class="form-group">

                                <hr />
                                <div class="table-responsive">
                                    <table class="table table-striped" id="contract-report">
                                        <thead>
                                            <tr>
                                                <th>Contract No.</th>
                                                <th>Contract Type</th>
                                                <th>Customer Name</th>
                                                <th>Ref. Name</th>
                                                <th>Site</th>
                                                <th>AMC Charges</th>
                                                <th>Payment Received</th>
                                                <th>Payment Pending</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Summary</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contractReportList">
                                            @include('reports.cr_pagination')
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
                window.location.replace("contract-due-report");
            });
            $(document).on("click", ".btn-fetch-report", function() {
                var duein = $("#duein-range option:selected").val();
                if (duein != "") {
                    $.ajax({
                        type: "GET",
                        url: "contract-due-report-data",
                        data: {
                            duein: duein,
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
                var status = $("#report_contract_status option:selected").val();
                if (cust_id != "" && status != "") {
                    $.ajax({
                        type: "GET",
                        url: "contract-report-export",
                        data: {
                            status: status,
                            customer: cust_id
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(result, status, xhr) {
                            console.log(result);
                            $(".loader").hide();
                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var filename = (matches != null && matches[1] ? matches[1] : 'salary.csv');

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