<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>DC Management</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                    <button class="action-btn btn-info btn-dc-export btn p-2"
                                    type="button">Export</button>
                                        <form action="{{ route('dcmanagements') }}" id="search_form">
                                            <input type="hidden" name="search_field" value="{{ $search_field }}"
                                                id="search_field" />
                                            <div class="d-flex float-right justify-space-between" style="width:30%;">
                                                <div class="input-group">
                                                    <input type="text" class="filter_values form-control"
                                                        value="{{ $search }}" id="search" name="search"
                                                        placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary filter-dropdown"
                                                            data-toggle="dropdown"><i
                                                                class="fas fa-filter"></i></button>
                                                        <button class="filter-remove_btn btn btn-danger ml-2">
                                                            <i class="fa fa-times"></i></button>
                                                        <div class="edit-filter-modal dropdown-menu-right hidden">
                                                            <li class="dropdown-title">Filter By</li>
                                                            <select class="mt-2 select2" name="filter_type"
                                                                id="filter_type">
                                                                <option value="" selected>Type</option>
                                                                @foreach($dcType as $dc)
                                                                    <option value="{{$dc->id}}" {{$dc->id == $filter_type ? 'selected':''}}>{{$dc->dc_type_name}}</option>                
                                                                @endforeach
                                                            </select>

                                                            <button type="submit"
                                                                class="filter_values mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                            <button type="button"
                                                                class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tbRefClient">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Client Name</th>
                                                <th>Service. No.</th>
                                                <th>QTY</th>
                                                <th>Total Amount</th>
                                                <th>Issue Date</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($service_dcs->count() == 0)
                                                <tr>
                                                    <td colspan="8" class="text-center">No
                                                        quotation
                                                        added yet.</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_dcs as $index => $dcp)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $dcp['CST_Name'] }}</td>
                                                    <td>{{ $dcp['service_no'] }}</td>
                                                    <td>{{ $dcp->totalProduct($dcp['dcp_id']) }}</td>
                                                    <td>{{ $dcp['dc_amount'] }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($dcp['issue_date'])) }}</td>
                                                    <td>{{ $dcp['dc_type_name'] }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="delete-btn action-btn btn btn-sm btn-danger"
                                                                href="{{ route('services.dc_delete', $dcp['dcp_id']) }}"><i
                                                                    class="fa fa-trash"></i></a>
                                                            <a class="action-btn btn btn-sm btn-primary"
                                                                href="{{ route('services.dc_view', $dcp['dcp_id']) }}"><i
                                                                    class="fa fa-eye" style="color:white;"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                var type = $("#type option:selected").val();
                $.ajax({
                        type: "GET",
                        url: "reports/dec-report-export",
                        data: {
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
        $(document).on('change', '#search', function () {
            $("#search_form")[0].submit();
        })
        $(document).on('click', ".dropdown-item", function () {
            $(".dropdown-item").removeClass("active");
            var text = $(this).text();
            if (text == "All") {
                $("#search_field").val("");
                // $("#search").val("");
                $("#search").attr("placeholder", "Search");
            } else {
                $("#search_field").val($(this).data("field"));
                $("#search").attr("placeholder", "Search by " + text);
            }
            $(this).addClass('active');
            if ($("#search").val() != "") {
                $("#search_form")[0].submit();
            }
        });
        $(document).ready(function () {
            $(".filter-dropdown, .text-button").click(function () {
                $(".edit-filter-modal").toggleClass("hidden");

            });
            $(".apply-button").click(function () {
                $(".edit-filter-modal").toggleClass("hidden");
                $(".filter, .fa-plus, .fa-filter").toggleClass("filter-hidden");
                $(".filter-dropdown-text").text("Add filter");
            });

            $(".filter-remove").click(function () {
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_type").val("");
                window.location.replace("/dcmanagements");
                $(".edit-filter-modal").toggleClass("hidden");
            });
            $(".filter-remove_btn").click(function () {
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_type").val("");
                window.location.replace("dcmanagements");
            });



        });
    </script>

    @stop   
    
</x-app-layout>
