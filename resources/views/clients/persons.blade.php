<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Contact Persons</h4>
                                <div class="card-header-action">

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('persons')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary mr-2" type="submit"><i class="fas fa-search fa-lg"></i></button>
                                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-filter fa-lg"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <li class="dropdown-title">Search By</li>
                                                    <li><a href="#" data-field=""
                                                            class="dropdown-item {{$search_field == '' ? 'active':''}}">All</a>
                                                    </li>
                                                    <li><a href="#" data-field="client_name"
                                                            class="dropdown-item {{$search_field=='client_name' ? 'active' :''}}">Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="email"
                                                            class="dropdown-item {{$search_field=='email' ? 'active' :''}}">Email</a>
                                                    </li>
                                                    <li><a href="#" data-field="phone"
                                                            class="dropdown-item {{$search_field=='phone' ? 'active' :''}}">Phone</a>
                                                    </li>
                                                    <li><a href="#" data-field="clear" class="dropdown-item">Clear
                                                            Filter</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th class="table-width-30">Client Name</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($persons) == 0)
                                            <tr>
                                                <td colspan="4" class="text-center">No persons to show</td>
                                            </tr>
                                            @endif
                                            @foreach($persons as $person)
                                            <tr>
                                                <td>{{$person['full_name']}}</td>
                                                <td class="align-middle">
                                                    {{$person['mobile']}}
                                                </td>
                                                <td>
                                                    {{$person['email']}}
                                                </td>
                                                <td>
                                                    {{$person['client_name']}}
                                                </td>
                                                <!-- <td>
                                                    <a href="#" class="btn btn-icon btn-primary"><i
                                                            class="far fa-edit"></i></a>
                                                </td> -->
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $persons->links() }}
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