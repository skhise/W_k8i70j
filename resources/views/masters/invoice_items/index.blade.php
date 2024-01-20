<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Incoice Items</h4>
                                <div class="card-header-action">
                                    <a href="{{route('invoice-item-create')}}"
                                        class="btn btn-icon icon-left btn-primary"><i class="
fas fa-plus-square"></i>
                                        Add Item</a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('invoice-items')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <!-- <div class="input-group-append">
                                                <button class="btn btn-primary" data-toggle="dropdown"
                                                    class="btn btn-danger dropdown-toggle"><i
                                                        class="fas fa-filter"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <li class="dropdown-title">Search By</li>
                                                    <li><a href="#" data-field=""
                                                            class="dropdown-item {{$search_field == '' ? 'active':''}}">All</a>
                                                    </li>
                                                    <li><a href="#" data-field="full_name"
                                                            class="dropdown-item {{$search_field=='full_name' ? 'active' :''}}">Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="emp_email"
                                                            class="dropdown-item {{$search_field=='emp_email' ? 'active' :''}}">Email</a>
                                                    </li>
                                                    <li><a href="#" data-field="phone"
                                                            class="dropdown-item {{$search_field=='phone' ? 'active' :''}}">Phone</a>
                                                    </li>
                                                    <li><a href="#" data-field="clear" class="dropdown-item">Clear
                                                            Filter</a>
                                                    </li>
                                                </ul>
                                            </div> -->
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($invoiceitems) == 0)
                                            <tr class="text-center">
                                                <td colspan="6">No invoice items added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($invoiceitems as $index=>$invoiceitem)
                                            <tr key="{{$invoiceitem['id']}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{$invoiceitem['description']}}</td>
                                                <td>
                                                    <a href="{{route('invoice-item-edit',$invoiceitem['id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        {{ $invoiceitems->links() }}
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
            } else if ($(this).data("field") == "clear") {
                $("#search_field").val("");
                $("#search").val("");
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
    </script>

    @stop
</x-app-layout>