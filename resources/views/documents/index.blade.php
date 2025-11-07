<?php 
$document_type = [
    "1"=>'<div class="badge badge-info badge-shadow">Prufing</div>',
];
$status = [
    "1"=>'<div class="badge badge-info badge-shadow">Angebot</div>',
    "2"=>'<div class="badge badge-success badge-shadow">AktiV</div>',
    "3"=>'<div class="badge badge-danger badge-shadow">Unaktiv</div>',
    "4"=>'<div class="badge badge-secondary badge-shadow">Ferting</div>',
    "5"=>'<div class="badge badge-warning badge-shadow">Archiv</div>',
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
                                <h4>Documents</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('documents')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Document Number">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search fa-lg"></i></button>
                                                <!-- <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <li class="dropdown-title">Search By</li>
                                                    <li><a href="#" data-field=""
                                                            class="dropdown-item {{$search_field == '' ? 'active':''}}">All</a>
                                                    </li>
                                                    <li><a href="#" data-field="number"
                                                            class="dropdown-item {{$search_field=='number' ? 'active' :''}}">Project
                                                            No.</a>
                                                    </li>
                                                    <li><a href="#" data-field="name"
                                                            class="dropdown-item {{$search_field=='name' ? 'active' :''}}">Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="client_name"
                                                            class="dropdown-item {{$search_field=='client_name' ? 'active' :''}}">Client
                                                            Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="clear" class="dropdown-item">Clear
                                                            Filter</a>
                                                    </li>
                                                </ul> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tbRefClient">
                                        <thead>
                                            <tr>

                                                <th>Document No.</th>
                                                <th>Project</th>
                                                <th class="table-width-30">Client Name</th>
                                                <th>DateTime</th>
                                                <th>Type</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($documents) == 0)
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    documents not added yet.</td>
                                            </tr>
                                            @endif
                                            @foreach($documents as $document)
                                            <tr>
                                                <td>{{$document['document_number']}}</td>
                                                <td>
                                                    {{$document['project_name']}}
                                                </td>
                                                <td>
                                                    {{$document['client_name']}}
                                                </td>
                                                <td>{{date('d.m.Y',
                                                    strtotime($document['created_at']))}}
                                                </td>
                                                <td>
                                                    {!!$document_type[$document['document_type']]!!}
                                                </td>
                                                <td>
                                                    <a href="{{route('projects.document_view',$document['doc_id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-eye"></i></a>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $documents->links() }}
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