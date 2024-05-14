<x-app-layout>
    <style>
        .canvasjs-chart-credit {
            dispaly: none !important;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Service Analysis Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control select2" id="client">
                                            <option value="">Select Client</option>
                                            <option value="0">All</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->CST_ID }}">{{ $client->CST_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="date-range">
                                            <option value="">Date Range</option>
                                            <option value="1">Any</option>
                                            <option value="2">Today</option>
                                            <option value="3">Yesterday</option>
                                            <option value="5">Last 7 Days</option>
                                            <option value="6">Last 30 Days</option>
                                            <option value="7">Last 60 Days</option>
                                            <option value="8">Last 180 Days</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-2 hide date-range">
                                        <input placeholder="From Date" type="date" id="from-date"
                                            class="form-control" />
                                    </div>
                                    <div class="col-lg-2 hide  date-range">
                                        <input type="date" placeholder="To Date" id="to-date"
                                            class="form-control" />
                                    </div>
                                    <div class="col-lg-2 d-flex">
                                        <button id="btn-generate" class="btn btn-primary mr-1">Generate</button>
                                        <button id="btn-reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <hr />
                                <div class="row hide report-div">
                                    <div class="col-12 col-sm-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Contract Type</h4>
                                            </div>
                                            <div class="card-body">
                                                <div id="contract_type" class="chartsh"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Team</h4>
                                            </div>
                                            <div class="card-body">
                                                <div id="team" class="chartsh"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Service Type</h4>
                                            </div>
                                            <div class="card-body">
                                                <div id="service_type" class="chartsh"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Issue Type</h4>
                                            </div>
                                            <div class="card-body">
                                                <div id="issue_type" class="chartsh"></div>
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
            function resetSelection() {
                window.location.reload();
            }

            function get_report() {

                var cust_id = $("#client option:selected").val();
                var dayFilter = $("#date-range option:selected").val();
                var ss = [];

                if (cust_id != "" && dayFilter != "") {

                    var ContractType = [];

                    var chartContractType = new CanvasJS.Chart("contract_type", {

                        animationEnabled: true,

                        title: {

                            text: "Contract Type"

                        },
                        axisX: {

                            interval: 1

                        },

                        data: [{

                            type: "bar",

                            yValueFormatString: "##0",

                            indexLabel: "{label} {y}",

                            dataPoints: ContractType

                        }]

                    });

                    $.get("GetAnalysisReport?dayFilter=" + dayFilter + "&cust_id=" +
                        cust_id + "&type=json",
                        function(data) {
                            console.log(data.contractTypeArr);
                            var obj = data.contractTypeArr;

                            for (var i = 0; i < obj.length; i++) {

                                ContractType.push({
                                    y: parseInt(obj[i].y),
                                    label: obj[i].label
                                });

                            }

                            chartContractType.render();

                        });



                    //pieChartTeam

                    var ChartTeam = [];

                    var chartpieChartTeam = new CanvasJS.Chart("team", {

                        animationEnabled: true,

                        title: {

                            text: "Team"

                        },
                        axisX: {

                            interval: 1

                        },

                        data: [{

                            type: "bar",


                            yValueFormatString: "##0",

                            indexLabel: "{label} {y}",

                            dataPoints: ChartTeam

                        }]

                    });

                    $.get("GetAnalysisReport?dayFilter=" + dayFilter + "&cust_id=" + cust_id +
                        "&type=json",
                        function(data) {



                            var obj = data.employee;
                            var objd = data.employeeData;

                            for (var i = 0; i < obj.length; i++) {

                                ChartTeam.push({
                                    y: parseInt(objd[i]),
                                    label: obj[i]
                                });

                            }

                            chartpieChartTeam.render();

                        });





                    //Issue Type

                    var IssueType = [];

                    var chartIssueType = new CanvasJS.Chart("issue_type", {

                        animationEnabled: true,

                        title: {

                            text: "Issue Type"

                        },
                        axisX: {

                            interval: 1

                        },

                        data: [{

                            type: "bar",


                            yValueFormatString: "##0",

                            indexLabel: "{label} {y}",

                            dataPoints: IssueType

                        }]

                    });

                    $.get("GetAnalysisReport?dayFilter=" + dayFilter + "&cust_id=" + cust_id +
                        "&type=json",
                        function(data) {



                            var obj = data.issueType;
                            var objd = data.issueTypeData;

                            for (var i = 0; i < obj.length; i++) {

                                IssueType.push({
                                    y: parseInt(objd[i]),
                                    label: obj[i]
                                });

                            }

                            chartIssueType.render();

                        });

                    //Service Type

                    var serviceType = [];

                    var chartServiceType = new CanvasJS.Chart("service_type", {

                        animationEnabled: true,

                        title: {

                            text: "Service Type"

                        },

                        axisX: {

                            interval: 1

                        },

                        data: [{

                            type: "bar",

                            name: "Service Type",

                            yValueFormatString: "##0",

                            indexLabel: "{label} {y}",

                            dataPoints: serviceType

                        }]

                    });

                    $.get("GetAnalysisReport?dayFilter=" + dayFilter + "&cust_id=" +
                        cust_id + "&type=json",
                        function(data) {

                            var obj = data.serviceType;
                            var objd = data.serviceTypeData;

                            for (var i = 0; i < obj.length; i++) {

                                serviceType.push({
                                    y: parseInt(objd),
                                    label: obj[i]
                                });

                            }

                            chartServiceType.render();

                        });


                    $(".canvasjs-chart-credit").addClass("hide");
                }
                $(".canvasjs-chart-credit").css("dispaly", "none");
            }
            $(document).on("click", "#btn-generate", function(e) {
                var client = $("#client option:selected").val();
                var date_range = $("#date-range option:selected").val();
                var from_date = $("#from-date").val();
                var to_date = $("#to-date").val();
                if (client == "") {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Client can not be blank',
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                } else if (date_range == "") {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Select valid date range',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                } else {
                    get_report();
                    $(".report-div").removeClass("hide");
                }

            });
            $(document).on("change", "#date-range", function(e) {
                e.preventDefault();
                if ($(this).val() == 0 && $(this).val() != "") {
                    $(".date-range").removeClass("hide");
                } else {
                    $(".date-range").addClass("hide");
                }
            });
        </script>
    @stop
</x-app-layout>
