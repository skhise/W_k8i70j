<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Renewal Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-lg-4">
                                    <select name="client" id="client" class="form-control select2">
                                        <option value="">Select Customer</option>
                                        <option value="0" {{ (isset($customer) && $customer == 0) ? 'selected' : '' }}>All</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->CST_ID }}"
                                                {{ (isset($customer) && $client->CST_ID == $customer) ? 'selected' : '' }}>
                                                {{ $client->CST_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control select2" id="date-range">
                                        <option value="">Select Date Range</option>
                                        <option value="30" {{ (isset($date_range) && $date_range == 30) ? 'selected' : '' }}>30 Days</option>
                                        <option value="60" {{ (isset($date_range) && $date_range == 60) ? 'selected' : '' }}>60 Days</option>
                                        <option value="90" {{ (isset($date_range) && $date_range == 90) ? 'selected' : '' }}>90 Days</option>
                                        <option value="180" {{ (isset($date_range) && $date_range == 180) ? 'selected' : '' }}>180 Days</option>
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
                                    <table class="table table-striped" id="renewal-report">
                                        <thead>
                                            <tr>
                                                <th>Contract No.</th>
                                                <th>Contract Type</th>
                                                <th>Customer Name</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
                                                <th>Cost</th>
                                                <th>Note</th>
                                                <th>Renewal Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="renewalReportList">
                                            @if(isset($renewals) && is_object($renewals) && $renewals->count() > 0)
                                                @include('reports.renewal_pagination')
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">Report not generated yet.</td>
                                                </tr>
                                            @endif
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
                window.location.replace("{{ route('renewal-report') }}");
            });
            $(document).on("click", ".btn-fetch-report", function() {
                var cust_id = $("#client option:selected").val();
                var date_range = $("#date-range option:selected").val();
                
                if (cust_id == "" || cust_id == null) {
                    cust_id = 0;
                }
                
                if (date_range != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('renewal-report-data') }}",
                        data: {
                            date_range: date_range,
                            customer: cust_id
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#renewalReportList").empty();
                            $("#renewalReportList").append(html);
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
                        text: 'Please select a date range',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                }
            });
            $(document).on("click", ".btn-export-report", function() {
                var cust_id = $("#client option:selected").val();
                var date_range = $("#date-range option:selected").val();
                
                if (cust_id == "" || cust_id == null) {
                    cust_id = 0;
                }
                
                if (date_range != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('renewal-report-export') }}",
                        data: {
                            date_range: date_range,
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
                            var timestamp = new Date().toISOString().replace(/[:\-T]/g, '').slice(0, 15);

                            var filename = (matches != null && matches[1] ? matches[1] : `renewal_report_${timestamp}.csv`);

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
                        text: 'Please select a date range',
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
