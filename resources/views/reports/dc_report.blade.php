<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>DC Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-horizontal">
                                    <form action="dc-report-data" id="dc_filter">
                                        <div class="form-group">
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label>Select Client</label>
                                                    <select
                                                        class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="customer_id" name="customer_id" placeholder=""
                                                        required="required" type="text">
                                                        <option value="">Select</option>
                                                        <option value="0">All</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->CST_ID }}"
                                                                {{ $customer_id == $client->CST_ID ? 'selected' : '' }}>
                                                                {{ $client->CST_Name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-3">
                                                    <label>Select Type</label>
                                                    <select
                                                        class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                        data-val="true" id="type" name="type" placeholder=""
                                                        required="required">
                                                        <option value="">Select</option>
                                                        <option value="0">All
                                                        </option>
                                                        @foreach ($type as $tp)
                                                            <option value="{{ $tp->id }}"
                                                                {{ $dc_type == $tp->id ? 'selected' : '' }}>
                                                                {{ $tp->dc_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="d-flex mt-4">
                                                        <button class="action-btn btn-fetch-report btn btn-primary"
                                                            type="button">Generate</button>
                                                        <button class="action-btn btn-light btn-dc-export btn"
                                                            type="button">Export</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tbRefClient">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Client Name</th>
                                                <th>Contract No.</th>
                                                <th>Service. No.</th>
                                                <th>QTY</th>
                                                <th>Total Amount</th>
                                                <th>Issue Date</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dcReportList">
                                            @include('reports.dc_pagination')
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
            $(document).on("click", ".btn-dc-export", function() {
                var cust_id = $("#customer_id option:selected").val();
                var cust_Name = $("#customer_id option:selected").text();
                var type = $("#type option:selected").val();
                $.ajax({
                        type: "GET",
                        url: "dec-report-export",
                        data: {
                            customer: cust_id,
                            type:type
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

                            var filename = (matches != null && matches[1] ? matches[1] : `dc_report_${timestamp}.csv`);

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
           
            $(document).on("click", ".btn-fetch-report", function() {
                var cust_id = $("#customer_id option:selected").val();
                var type = $("#type option:selected").val();
                if (cust_id != "" && type != "") {
                    $.ajax({
                        type: "GET",
                        url: "dc-report-data",
                        data: {
                            type: type,
                            customer_id: cust_id
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#dcReportList").empty();
                            $("#dcReportList").append(html);
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
        </script>
    @stop
</x-app-layout>
