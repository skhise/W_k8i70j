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
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <label for="filter_days" class="mr-2" style="font-weight: 500;">Filter by Days:</label>
                                                    <select class="select2" name="filter_days" id="filter_days" style="width: 150px;">
                                                        <option value="">All Days</option>
                                                        <option value="30" {{($filter_days ?? '30') == '30' ? 'selected':''}}>30 Days</option>
                                                        <option value="60" {{($filter_days ?? '') == '60' ? 'selected':''}}>60 Days</option>
                                                        <option value="90" {{($filter_days ?? '') == '90' ? 'selected':''}}>90 Days</option>
                                                        <option value="180" {{($filter_days ?? '') == '180' ? 'selected':''}}>180 Days</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <form action="{{ route('dcmanagements') }}" id="search_form" class="d-flex">
                                                <input type="hidden" name="search_field" value="{{ $search_field }}"
                                                    id="search_field" />
                                                <input type="hidden" name="filter_days" value="{{ $filter_days ?? '30' }}" id="filter_days_hidden" />
                                                <div class="input-group">
                                                    <input type="text" class="filter_values form-control"
                                                        value="{{ $search }}" id="search" name="search"
                                                        placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary mr-2" type="submit"><i
                                                                class="fas fa-search fa-lg"></i></button>
                                                        <button class="btn btn-primary filter-dropdown"
                                                            data-toggle="dropdown"><i
                                                                class="fas fa-filter fa-lg"></i></button>
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
                                            </form>
                                        </div>
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
        // Handle days filter change - auto submit form
        $(document).on('change', '#filter_days', function() {
            var selectedDays = $(this).val();
            $('#filter_days_hidden').val(selectedDays);
            $('#search_form').submit();
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
                $("#filter_days").val("");
                $("#filter_days_hidden").val("");
                window.location.replace("/dcmanagements");
                $(".edit-filter-modal").toggleClass("hidden");
            });
            $(".filter-remove_btn").click(function () {
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_type").val("");
                $("#filter_days").val("");
                $("#filter_days_hidden").val("");
                window.location.replace("dcmanagements");
            });



        });
    </script>

    @stop   
    
</x-app-layout>
