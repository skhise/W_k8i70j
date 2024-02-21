<style>
    .select2-container {
        margin-bottom: 5px !important;
    }
</style>
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
                                    <a href="{{route('services.create')}}" class="btn btn-icon icon-left btn-primary"><i
                                            class="
fas fa-plus-square"></i>
                                        Add Service</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form action="{{route('services')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary filter-dropdown"
                                                    data-toggle="dropdown"><i class="fas fa-filter"></i></button>
                                                <div class="edit-filter-modal dropdown-menu-right hidden">
                                                    <li class="dropdown-title">Filter By</li>
                                                    <select class="mt-2 select2" name="filter_status"
                                                        id="filter_status">
                                                        <option value="" selected>Status</option>
                                                        <option value="1" {{$filter_status==1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="2" {{$filter_status==2 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                        <option value="3" {{$filter_status==3 ? 'selected' : '' }}>
                                                            Suspended</option>
                                                    </select>
                                                    <br />
                                                    <select class="mt-2 select2" name="filter_contract_type"
                                                        id="filter_contract_type">
                                                        <option value="" selected>Contact Type</option>
                                                    </select>
                                                    <br />
                                                    <select class="mt-2 select2" name="filter_site_type"
                                                        id="filter_site_type">
                                                        <option value="" selected>Site Type</option>
                                                    </select>

                                                    <button type="submit"
                                                        class="mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                    <button type="button"
                                                        class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
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
                                                <th>Date</th>
                                                <th class="table-width-30">Customer Name</th>
                                                <th>Issue Type</th>
                                                <th>Status</th>
                                                <th class="action-1">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($services) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">No services to show</td>
                                            </tr>
                                            @endif
                                            @foreach($services as $key=>$service)
                                            <tr>
                                                <td>
                                                    {{$service['service_no']}}
                                                </td>
                                                <td>
                                                    {{$service['service_date']!="" ?
                                                    date('d-M-Y',strtotime($service['service_date'])) : 'NA'}}
                                                </td>

                                                <td>
                                                    {{$service['CST_Name']}}
                                                </td>
                                                <td>{{$service['issue_name']}}</td>
                                                <td>
                                                    <div
                                                        class="badge badge-shadow {{$service['status_color'] ?? 'bg-primary'}}">
                                                        {{$service['Status_Name']}}</div>
                                                </td>
                                                <td>
                                                    <a href="{{route('services.view',$service['service_id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-eye"></i></a>
                                                    <a href="{{route('services.edit',$service['service_id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-edit"></i></a>

                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($services->total())
                                        <p>Found {{ $services->total()}} records</p>
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
        </section>
    </div>
    @section('script')

    <script>
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
                $("#filter_status").val("");
                $("#search_form")[0].submit();
                $(".edit-filter-modal").toggleClass("hidden");
            });




        });
    </script>

    @stop
</x-app-layout>