<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Services</h4>
                                <div class="card-header-action">
                                    @if (auth()->user()->role == 1)
                                        <a href="{{ route('services.create') }}"
                                            class="btn btn-icon icon-left btn-primary"><i
                                                class="
fas fa-plus-square"></i>
                                            Add Service</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('services') }}" id="search_form_all">
                                            <input type="hidden" name="search_field" value="{{ $search_field }}"
                                                id="search_field" />
                                            <div class="buttons d-flex float-left">
                                                <input type="hidden" value="{{ $filter_status }}" name="filter_status"
                                                    id="filter_status" />
                                                <button data-key ="1" type="button"
                                                    class="btn-status-filter btn btn-outline-primary {{ $filter_status == 1 ? ' active' : '' }}">
                                                    New <span class="badge badge-primary">{{ $new }}</span>
                                                </button>
                                                <button data-key ="2" type="button"
                                                    class="btn-status-filter btn btn-outline-success {{ $filter_status == 2 ? ' active' : '' }}">
                                                    Open <span class="badge badge-success">{{ $open }}</span>
                                                </button>
                                                <button data-key ="6" type="button"
                                                    class="btn-status-filter btn btn-outline-success {{ $filter_status == 6 ? ' active' : '' }}">
                                                    Assigned <span class="badge badge-success">{{ $assigned }}</span>
                                                </button>
                                                <button data-key ="3" type="button"
                                                    class="btn-status-filter btn btn-outline-warning {{ $filter_status == 3 ? ' active' : '' }}">
                                                    Pending <span class="badge badge-warning">{{ $pending }}</span>
                                                </button>
                                                <button data-key ="4" type="button"
                                                    class="btn-status-filter btn btn-outline-success {{ $filter_status == 4 ? ' active' : '' }}">
                                                    Resolved <span
                                                        class="badge badge-success">{{ $resolved }}</span>
                                                </button>
                                                <button data-key ="5" type="button"
                                                    class="btn-status-filter btn btn-outline-secondary {{ $filter_status == 5 ? ' active' : '' }}">
                                                    Closed <span
                                                        class="badge badge-secondary">{{ $closed }}</span>
                                                </button>
                                            </div>
                                            <div class="d-flex float-right justify-space-between" style="width:45%;">
                                                <select class="form-control select2 mr-2" id="dayFilter"
                                                    name="dayFilter">
                                                    <option value="" {{ $dayFilter == '' ? 'selected' : '' }}>Any
                                                    </option>
                                                    <option value="0" {{ $dayFilter == 0 ? 'selected' : '' }}>
                                                        Today</option>
                                                    <option value="1" {{ $dayFilter == 1 ? 'selected' : '' }}>
                                                        Yesterday</option>
                                                    <option value="7" {{ $dayFilter == 7 ? 'selected' : '' }}>Last
                                                        7 Days</option>
                                                    <option value="30" {{ $dayFilter == 30 ? 'selected' : '' }}>
                                                        Last 30 Days</option>
                                                    <option value="60" {{ $dayFilter == 60 ? 'selected' : '' }}>
                                                        Last 60 Days</option>
                                                    <option value="180" {{ $dayFilter == 180 ? 'selected' : '' }}>
                                                        Last 180 Days</option>
                                                </select>
                                                <div class="input-group ml-2">

                                                    <input type="text" class="form-control"
                                                        value="{{ $search }}" id="search" name="search"
                                                        placeholder="Search">
                                                    <div class="input-group-append ml-2">
                                                        <button class="btn btn-primary filter-dropdown"
                                                            data-toggle="dropdown"><i
                                                                class="fas fa-filter"></i></button>
                                                        <div class="edit-filter-modal dropdown-menu-right hidden">
                                                            <li class="dropdown-title">Filter By</li>
                                                            <select class="mt-2 select2" name="filter_type"
                                                                id="filter_type">
                                                                <option value="">Type</option>
                                                                <option value="1" {{$filter_type ==0 ? 'selected':''}}>Contracted</option>
                                                                <option value="0" {{$filter_type ==1 ? 'selected':''}}>Non-Contracted</option>
                                                            </select>   
                                                            <br />
                                                            <select class="mt-2 select2" name="filter_service_type"
                                                                id="filter_type">
                                                                <option value="" selected>Service Type</option>
                                                                @foreach($service_types as $sts)
                                                                     <option value={{$sts->id}} {{$filter_service_type == $sts->id ? 'selected':''}}>{{$sts->type_name}}</option>               
                                                                @endforeach
                                                            </select>   
                                                            <br />
                                                            <select class="mt-2 select2" name="filter_issue_type"
                                                                id="filter_issue_type">
                                                                <option value="" selected>Issue Type</option>
                                                                @foreach($issue_type as $it)
                                                                    <option value="{{$it->id}}" {{$filter_issue_type == $it->id ? 'selected':''}}>{{$it->issue_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <select class="mt-2 select2" name="filter_status_type"
                                                                id="filter_status_type">
                                                                <option value="" selected>Status</option>
                                                                @foreach($service_status as $ss)
                                                                    <option value="{{$ss->Status_Id}}" {{$filter_status_type == $ss->Status_Id ? 'selected' : ''}}>{{$ss->Status_Name}}</option>
                                                                @endforeach
                                                            </select>

                                                            <button type="submit"
                                                                class="mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                            <button type="button"
                                                                class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>
                                                #Code
                                            </th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="table-width-20">Customer Name</th>
                                            <th>Issue Type</th>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($services) == 0)
                                            <tr>
                                                <td colspan="8" class="text-center">No services to show</td>
                                            </tr>
                                        @endif
                                        @foreach ($services as $key => $service)
                                            <tr>
                                                <td>
                                                    @if ($service->wasRecentlyUpdated())
                                                        <i class="fa-spin fa fa-circle" style=""
                                                            aria-hidden="true"></i>
                                                    @endif
                                                    {{ $service['service_no'] }}
                                                </td>
                                                <td>
                                                    {{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}
                                                </td>
                                                <td>
                                                    {{ $service['service_date'] != '' ? date('d-M-Y', strtotime($service['service_date'])) : 'NA' }}
                                                </td>

                                                <td>
                                                    {{ $service['CST_Name'] }}
                                                </td>
                                                <td>{{ $service['issue_name'] }}</td>
                                                <td>
                                                    {{ $service['last_updated'] != null ? date('d-M-Y h:i', strtotime($service['last_updated'])) : 'NA' }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                        {{ $service['Status_Name'] }}</span>
                                                </td>

                                                <td>
                                                    <div class="flex-d">
                                                        <a href="{{ route('services.view', $service['service_id']) }}"
                                                            class="action-btn btn btn-sm btn-info"><i
                                                                class="far fa-eye"></i></a>
                                                        @if (auth()->user()->role == 1)
                                                            <a href="{{ route('services.edit', $service['service_id']) }}"
                                                                class="action-btn btn btn-sm btn-primary"><i
                                                                    class="far fa-edit"></i></a>
                                                        @endif
                                                    </div>


                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>


                            </div>
                            <div class="row ml-1 mr-1">
                                <div class="col-lg-12">
                                    <div class="float-left">
                                        @if ($services->total())
                                            <p>Found {{ $services->total() }} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $services->links() }}
                                    </div>

                                </div>
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
            $(document).on('click', '.btn-status-filter', function() {
                $("#filter_status").val($(this).data("key"));
                $("#search_form_all")[0].submit();
            });
            $(document).on('change', '#dayFilter', function() {
                $("#search_form_all")[0].submit();
            });
            $(document).on('change', '#search', function() {
                $("#search_form_all")[0].submit();
            })
            $(document).on('click', ".dropdown-item", function() {
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
                    $("#search_form_all")[0].submit();
                }
            });
            $(document).ready(function() {
                $(".filter-dropdown, .text-button").click(function() {
                    $(".edit-filter-modal").toggleClass("hidden");

                });
                $(".apply-button").click(function() {
                    $(".edit-filter-modal").toggleClass("hidden");
                    $(".filter, .fa-plus, .fa-filter").toggleClass("filter-hidden");
                    $(".filter-dropdown-text").text("Add filter");
                });

                $(".filter-remove").click(function() {
                    $("#search_field").val("");
                    $("#filter_type").val("");
                    $("#filter_service_type").val("");
                    $("#filter_issue_type").val("");
                    $("#filter_status_type").val("");
                    $("#search").val("");
                    $("#filter_status").val("");
                    $("#dayFilter").val("180");
                    window.location.replace("services");
                    //$("#search_form_all")[0].submit();
                    $(".edit-filter-modal").toggleClass("hidden");
                });




            });
        </script>

    @stop
</x-app-layout>
