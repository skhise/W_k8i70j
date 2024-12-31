<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>System Logs</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
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
                                    <div class="col-lg-4 d-flex">
                                        <button class="btn btn-primary ml-2 btn-fetch-report">Fetch</button>
                                        <button class="btn btn-danger ml-2 btn-reset">Reset</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="contract-report">
                                        <thead>
                                            <tr>
                                                <th>User </th>
                                                <th>Description </th>
                                                <th>DateTime </th>
                                            </tr>
                                        </thead>
                                        <tbody id="logsList">
                                            @include('reports.log_pagination')
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
                window.location.reload();
            });
            $(document).on("click", ".btn-fetch-report", function() {
                var date_range = $("#date-range option:selected").val();
                $.ajax({
                        type: "GET",
                        url: "logs_data",
                        data: {
                            date_range: date_range,
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(html) {
                            $("#logsList").empty();
                            $("#logsList").append(html);
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
        </script>
    @stop
</x-app-layout>
