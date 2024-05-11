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
                                <h4>Contracts</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('contracts.create') }}"
                                        class="btn btn-icon icon-left btn-primary"><i class="
fas fa-plus-square"></i>
                                        Add Contract</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('contracts') }}" id="search_form">
                                            <input type="hidden" name="search_field" value="{{ $search_field }}"
                                                id="search_field" />
                                            <input type="hidden" value="{{ $filter_status }}" name="filter_status"
                                                id="filter_status" />
                                            <div class="buttons d-flex float-left">
                                                <button data-key ="1" type="button"
                                                    class="btn-status-filter btn btn-outline-success {{ $filter_status == 1 ? ' active' : '' }}">
                                                    Active <span class="badge badge-success">{{ $active }}</span>
                                                </button>
                                                <button data-key ="2" type="button"
                                                    class="btn-status-filter btn btn-outline-warning {{ $filter_status == 2 ? ' active' : '' }}">
                                                    Upcoming Renewal <span
                                                        class="badge badge-warning">{{ $renewal }}</span>
                                                </button>
                                                <button data-key ="3" type="button"
                                                    class="btn-status-filter btn btn-outline-danger {{ $filter_status == 3 ? ' active' : '' }}">
                                                    Expired <span class="badge badge-danger">{{ $expired }}</span>
                                                </button>
                                            </div>
                                            <div class="d-flex float-right justify-space-between" style="width:30%;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $search }}" id="search" name="search"
                                                        placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary filter-dropdown"
                                                            data-toggle="dropdown"><i
                                                                class="fas fa-filter"></i></button>
                                                        <div class="edit-filter-modal dropdown-menu-right hidden">
                                                            <li class="dropdown-title">Filter By</li>
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
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #Code
                                                </th>
                                                <th class="table-width-20">Customer Name</th>
                                                <th>Contract Type</th>
                                                <th>Site Type</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($contracts) == 0)
                                                <tr>
                                                    <td colspan="6" class="text-center">No contracts to show</td>
                                                </tr>
                                            @endif
                                            @foreach ($contracts as $key => $contract)
                                                <tr>
                                                    <td>
                                                        {{ $contract['CNRT_Number'] }}
                                                    </td>
                                                    <td>
                                                        {{ $contract['CST_Name'] }}
                                                    </td>
                                                    <td>{{ $contract['contract_type_name'] }}</td>
                                                    <td>
                                                        {{ $contract['site_type_name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $contract['CNRT_EndDate'] != '' ? date('d-M-Y', strtotime($contract['CNRT_EndDate'])) : 'NA' }}
                                                    </td>
                                                    <td><span
                                                            class="text-white badge badge-shadow {{ $contract['status_color'] ?? 'bg-light' }}">
                                                            {{ $contract['contract_status_name'] }}</span></td>
                                                    <td>
                                                        <a href="{{ route('contracts.view', $contract['CNRT_ID']) }}"
                                                            class="btn btn-primary"><i class="far fa-eye"></i></a>
                                                        <a href="{{ route('contracts.edit', $contract['CNRT_ID']) }}"
                                                            class="btn btn-primary"><i class="far fa-edit"></i></a>

                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if ($contracts->total())
                                            <p>Found {{ $contracts->total() }} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $contracts->links() }}
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
                $("#search_form")[0].submit();
            });
            $(document).on('change', '#search', function() {
                $("#search_form")[0].submit();
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
                    $("#search_form")[0].submit();
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
                    $("#search").val("");
                    $("#filter_status").val("");
                    $("#search_form")[0].submit();
                    $(".edit-filter-modal").toggleClass("hidden");
                });




            });
        </script>

    @stop
</x-app-layout>
