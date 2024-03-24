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
                                <h4>Schedule Services</h4>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Schedule Date</th>
                                                                        <th>Issue Type</th>
                                                                        <th>Service Type</th>
                                                                        <th>Product</th>
                                                                        <th>Issue Description</th>
                                                                        <th>Status</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($schedules->count() == 0)
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No
                                                                            schedule service
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($schedules as $index => $service)
                                                                    <tr>
                                                                        <td>
                                                                            {{$index + 1}}
                                                                        </td>
                                                                        <td>
                                                                            {{$service->Schedule_Date}}
                                                                        </td>
                                                                        <td>{{$service['issue_name']}}</td>
                                                                        <td>{{$service['type_name']}}</td>
                                                                        <td>{{$service['product_Id'] != 0 ? $service['nrnumber'] . "/" . $service['product_name'] : "NA"}}</td>
                                                                        <td>{{$service['description']}}</td>
                                                                        <td></td>
                                                                        <td>
                                                                            
                                                                                @if($service['Service_Call_Id'] == 0)
                                                                                <div class="flex-d">
                                                                                    <a href="{{route('contract_service.delete', $service['cupId'])}}" class="action-btn delete-btn btn btn-danger"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                                    
                                                                                    <a title="lock ticket" href="{{route('services.schedulecreate', $service['cupId'])}}?flag=1" class="action-btn btn btn-primary"><i
                                                                                    class="fa fa-lock"></i></a>
                                                                                    </div>
                                                                                 @else 
                                                                                    <a title="view ticket" href="{{route('services.view', $service['Service_Call_Id'])}}?flag=1" class="btn btn-primary"><i
                                                                                    class="fa fa-eye"></i></a>
                                                                                
                                                                                @endif   
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                    <div class="float-left">
                                        @if($schedules->total())
                                        <p>Found {{ $schedules->total()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $schedules->links() }}
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