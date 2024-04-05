<?php
$status = [
    '1' => '<div class="badge badge-info badge-shadow">Angebot</div>',
    '2' => '<div class="badge badge-success badge-shadow">AktiV</div>',
    '3' => '<div class="badge badge-danger badge-shadow">Unaktiv</div>',
    '4' => '<div class="badge badge-secondary badge-shadow">Ferting</div>',
    '5' => '<div class="badge badge-warning badge-shadow">Archiv</div>',
];
?>
<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Projects</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('projects.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                            class="
fas fa-plus-square"></i>
                                        Add Project</a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{ route('projects') }}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{ $search_field }}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $search }}"
                                                id="search" name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" data-toggle="dropdown"
                                                    class="btn btn-danger dropdown-toggle"><i
                                                        class="fas fa-filter"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <li class="dropdown-title">Search By</li>
                                                    <li><a href="javascript:void(0)" data-field=""
                                                            class="dropdown-item {{ $search_field == '' ? 'active' : '' }}">All</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" data-field="number"
                                                            class="dropdown-item {{ $search_field == 'number' ? 'active' : '' }}">Project
                                                            No.</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" data-field="name"
                                                            class="dropdown-item {{ $search_field == 'name' ? 'active' : '' }}">Name</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" data-field="client_name"
                                                            class="dropdown-item {{ $search_field == 'client_name' ? 'active' : '' }}">Client
                                                            Name</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" data-field="clear"
                                                            class="dropdown-item">Clear
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
                                                <th>
                                                    #Number
                                                </th>
                                                <th>Category</th>
                                                <th>Charakteristisch</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Client Name</th>
                                                <!-- <th>Place</th> -->
                                                <th>Status</th>
                                                <th class="action-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($projects) == 0)
                                                <tr>
                                                    <td colspan="8" class="text-center">No clients to show</td>
                                                </tr>
                                            @endif
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>
                                                        {{ $project['number'] }}
                                                    </td>
                                                    <td>{{ $project['category'] }}</td>
                                                    <td>
                                                        {{ $project['charakteristisch'] }}
                                                    </td>
                                                    <td>{{ $project['name'] }}</td>
                                                    <td>
                                                        {{ $project['type'] }}
                                                    </td>
                                                    <td>{{ $project['client_name'] }}</td>
                                                    <!-- <td>{{ $project['place'] }}</td> -->
                                                    <td>
                                                        {!! $status[$project['project_status']] !!}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('projects.view', $project['id']) }}"
                                                            class="btn btn-icon btn-sm btn-primary"><i
                                                                class="far fa-eye"></i></a>
                                                        <a href="{{ route('projects.edit', $project['id']) }}"
                                                            class="btn btn-icon btn-sm btn-primary"><i
                                                                class="far fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                    <div class="float-right">
                                        {{ $projects->links() }}
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
            $(document).on('change', '#search', function() {
                $("#search_form")[0].submit();
            })
            $(document).on('click', ".dropdown-item", function() {
                $(".dropdown-item").removeClass("active");
                var text = $(this).text();
                var field = $(this).data("field");
                if (text == "All") {
                    $("#search_field").val("");
                    // $("#search").val("");
                    $("#search").attr("placeholder", "Search");

                } else if (field === "clear") {
                    $("#search_field").val("");
                    $("#search").val("");
                    $("#search_form")[0].submit();
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
