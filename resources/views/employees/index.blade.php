<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Employees</h4>
                                <div class="card-header-action">
                                    <a href="{{route('employees.create')}}"
                                        class="btn btn-icon icon-left btn-primary"><i class="
                                        fas fa-plus-square"></i>
                                        Add Employee</a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('employees')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary mr-2" type="submit"><i class="fas fa-search fa-lg"></i></button>
                                                <button class="btn btn-primary filter-dropdown"
                                                    data-toggle="dropdown"><i class="fas fa-filter fa-lg"></i></button>
                                                 <button class="filter-remove_btn btn btn-danger ml-2">
                                                    <i class="fa fa-times"></i></button>
                                                <div class="edit-filter-modal dropdown-menu-right hidden">
                                                    <li class="dropdown-title">Filter By</li>
                                                    <select class="mt-2 select2" name="filter_status"
                                                        id="filter_status">
                                                        <option value="" selected>Status</option>
                                                        <option value="1" {{$filter_status == 1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="2" {{$filter_status == 2 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                    <select class="mt-2 select2" name="filter_role"
                                                        id="filter_role">
                                                        <option value="" selected>Role</option>
                                                         @foreach($roles as $index=>$role)
                                                            <option value="{{$role->id}}" {{$role->id == $filter_role ? 'selected' : ''}}>{{$role->access_role_name}}</option>
                                                         @endforeach   
                                                    </select>
                                                    <button type="submit"
                                                        class="mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                    <button type="button"
                                                        class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                            

                                        </div>
                                        
                                    </form>
                                    <div class="clearfix mb-3"></div>
                                   
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($employees) == 0)
                                            <tr class="text-center">
                                                <td colspan="6">No employees added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($employees as $index=>$employee)
                                            <tr key="{{$employee['id']}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{$employee['EMP_Name']}}</td>
                                                <td>{{$employee['EMP_MobileNumber']}}</td>
                                                <td>{{$employee['email']}}</td>
                                                <td>{{$employee['access_role_name']}}</td>
                                                <td> {!! $status[$employee['status']] !!}</td>
                                                <td>
                                                    <a href="{{route('employees.view',$employee['EMP_ID'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-eye"></i></a>
                                                    <a href="{{route('employees.edit',$employee['EMP_ID'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($employees->total())
                                        <p>Found {{ $employees->total()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $employees->links() }}
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
                $("#filter_role").val("");
                $(".edit-filter-modal").toggleClass("hidden");
                window.location.replace("employees");
                
            });
            $(".filter-remove_btn").click(function () {
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_status").val("");
                $("#filter_role").val("");
                window.location.replace("employees");
            });



        });
    </script>

    @stop
</x-app-layout>