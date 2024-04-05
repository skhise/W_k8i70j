<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Contract Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <select class="form-control select2">
                                            <option value="">Select Customer</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->CST_ID }}">{{ $client->CST_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2">
                                            <option value="">Select Status</option>
                                            @foreach ($status as $status)
                                                <option value="{{ $status->id }}">{{ $status->Status_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 d-flex">
                                        <button class="btn btn-primary ml-2">Fetch</button>
                                        <button class="btn btn-info ml-2">Export to Excel</button>
                                        <button class="btn btn-danger ml-2">Reset</button>
                                    </div>

                                </div>
                                <hr />
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="contract-report">
                                        <thead>
                                            <tr>
                                                <th>#Code</th>
                                                <th class="table-width-20">Customer Name</th>
                                                <th>Contract Type</th>
                                                <th>Site Type</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center">No report generated yet.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
        </section>
    </div>
    @section('script')
        function get_reportPrint() {



        var cust_id = $("#client option:selected").val();

        var cust_Name = $("#client option:selected").text();

        var status = $("#report_contract_status option:selected").val();

        if (cust_id != "" && status != "") {

        $.ajax({

        type: "GET",
        url: "../../api/product/getContractReportList.php",
        data: "show=10000&pagenum=1&status=" + status + "&customerId=" + cust_id +
        "&cust_Name=" +
                            cust_Name,

                        cache: false,

                        beforeSend: function() {

                            $("#wait").modal("show");

        },

        success: function(html) {

        $("#contractReportListPrint").html(html);

        exportExcel();

        $("#wait").modal("hide");

        }

        });

        $("#wait").modal("hide");

        } else {

        alert("Select filter values");

        }

        }

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

        // $(".thead").css("color","#fff");

        }

        function get_report(numRecords, pageNum) {



        var cust_id = $("#report_cust_name option:selected").val();

        var cust_Name = $("#report_cust_name option:selected").text();

        var status = $("#report_contract_status option:selected").val();

        if (cust_id != "" && status != "") {

        $.ajax({

        type: "GET",

        url: "../../api/product/getContractReportList.php",

        data: "show=" + numRecords + "&pagenum=" + pageNum + "&status=" + status + "&customerId=" +
        cust_id +
        "&cust_Name=" + cust_Name,

                        cache: false,

                        beforeSend: function() {

                            $("#wait").modal("show");

        },

        success: function(html) {

        $("#contractReportList").html(html);

        $("#wait").modal("hide");

        }

        });

        $("#wait").modal("hide");

        } else {

        alert("Select filter values");

        }

        }

    @stop
</x-app-layout>
