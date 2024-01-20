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
$paymentstatus = [
    "1"=>'<div class="badge badge-success badge-shadow">Paid (Bezahlt)</div>',
    "2"=>'<div class="badge badge-danger badge-shadow">UnPaid (Offen)</div>',
    "3"=>'<div class="badge badge-info badge-shadow">Partially Paid</div>',
];
$prefixs=[
    ''=> '',
    0=>'',    
    1=>"Mr.",
    2=>"Mrs.",
    3=>"Ms.",
    4=>"Miss.",
    5=>"Dr."
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
                                <h4>Project Details</h4>
                                <input type="hidden" value="{{$project->id}}" id="current_project_id"
                                    style="display:none;" />
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ProjectDetails" role="tab" aria-controls="home"
                                            aria-selected="true">Project</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab"
                                            href="#ProjectRefClients" role="tab" aria-controls="refclient"
                                            aria-selected="false">Project Reference Clients</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab3" data-toggle="tab"
                                            href="#ProjectOfferDocument" role="tab" aria-controls="offerdoc"
                                            aria-selected="false">Project Documents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#ProjectInvoices"
                                            role="tab" aria-controls="invoicesdoc" aria-selected="false">Invoices</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Projecttimeline-tab5" data-toggle="tab"
                                            href="#Projecttimeline" role="tab" aria-controls="Projecttimeline"
                                            aria-selected="false">Project
                                            Timeline</a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ProjectDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{$project->name}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Projekt
                                                                        Nummer
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$project->number}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Projekt
                                                                        Typ</strong>
                                                                    <p class="text-muted">{{$type}}</p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Kategorie
                                                                    </strong>
                                                                    <p class="text-muted">{{$category}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-check-double margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <button
                                                                        class="btn btn-primary btn-sm btn-change-status">Change
                                                                        Status</button>
                                                                    <p class="text-muted">{!!
                                                                        $status[$project->project_status] !!}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fas fa-user-tie margin-r-5"></i>&nbsp;&nbsp;Projekt
                                                                        Führungskräfte </strong>
                                                                    <p class="text-muted"></p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fas fa-user-friends margin-r-5"></i>&nbsp;&nbsp;Projekt
                                                                        Assistent</strong>
                                                                    <p class="text-muted"></p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <br />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card card-success">
                                                    <div class="card-body">
                                                        <div>
                                                            <h5 class="">PROJECT DETAILS</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Kunden</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Client</span>
                                                            </div>
                                                            <div class="col-md-3"> {{$client->client_name}} - </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Projekt
                                                                    Beschreibung</span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Project
                                                                    Description</span>
                                                            </div>
                                                            <div class="col-md-7">{{$project->description}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    Standort der Website
                                                                </span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Location</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->website}}</div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5 class="">ADDRESS DETAILS</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Anschrift</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Address</span>
                                                            </div>
                                                            <div class="col-md-3">{{$project->project_address}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Ort</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Place/location</span>
                                                            </div>
                                                            <div class="col-md-3">{{$project->project_city}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    PLZ
                                                                </span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Zip
                                                                    Code</span>
                                                            </div>
                                                            <div class="col-md-3">{{$project->project_zipcode}}</div>

                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Bundesland</span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Federal
                                                                    State</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$state_name}}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Land</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Country</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$country_name}}
                                                            </div>
                                                        </div>
                                                        <hr />

                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" id="ProjectRefClients" role="tabpanel"
                                        aria-labelledby="profile-tab2">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Project Refrence Clients</h4>
                                                        <div class="card-header-action">
                                                            <input type="button" value="Add Client"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target="#bd-RefClient-modal-lg" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">

                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Client Name</th>
                                                                        <th>Email</th>
                                                                        <th>Mobile</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact Email</th>
                                                                        <th>Contact Phone</th>
                                                                        <th>Work Phone</th>
                                                                        <th>Type</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="project_clients">
                                                                    @foreach($projectclients as $index=>$projectclient)

                                                                    <tr>
                                                                        <td>{{$index+1}}</td>
                                                                        <td>{{$projectclient['client_name']}}</td>
                                                                        <td>{{$projectclient['email']}}</td>
                                                                        <td>{{$projectclient['phone']}}</td>
                                                                        <td>{{$prefixs[$projectclient['prefix']]}}
                                                                            {{" "}} {{$projectclient['first_name']}}
                                                                            {{" "}} {{$projectclient['last_name']}}
                                                                        </td>
                                                                        <td>{{$projectclient['email']}}</td>
                                                                        <td>{{$projectclient['mobile']}}</td>
                                                                        <td>{{$projectclient['work_phone']}}</td>
                                                                        <td>{{$projectclient['type_name']}}</td>

                                                                        <td>
                                                                            <button
                                                                                data-url="{{route('delete_ref_client',$projectclient['contact_person_id'])}}"
                                                                                class="btn-delete-clientref btn btn-icon btn-sm btn-danger"><i
                                                                                    class="fas fa-trash"></i></button>
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
                                    <div class="tab-pane fade" id="ProjectOfferDocument" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">Project Documents</h4>
                                                        <div class="card-header-action">
                                                            <a href="{{route('projects.document',$project->id)}}"
                                                                class="btn btn-icon icon-left btn-primary"><i class="
                                            fas fa-plus-square"></i>
                                                                Add Document</a>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped" id="tbRefClient">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>Number</th>
                                                                            <th>Date</th>
                                                                            <th>Name</th>
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
                                                                            <td>{{date('d.m.Y',
                                                                                strtotime($document['created_at']))}}
                                                                            </td>
                                                                            <td>
                                                                                {{$project->name}}
                                                                            </td>
                                                                            <td>
                                                                                {!!$document_type[$document['document_type']]!!}
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{route('projects.document_view',$document->id)}}"
                                                                                    class="btn btn-icon btn-sm btn-primary"><i
                                                                                        class="far fa-eye"></i></a>

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




                                    </div>
                                    <div class="tab-pane fade" id="ProjectInvoices" role="tabpanel"
                                        aria-labelledby="profile-tab4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">Project Invoices</h4>
                                                        <div class="card-header-action">
                                                            <a href="{{route('invoices.create')}}?flag=1&id={{$project->id}}"
                                                                class="btn btn-icon icon-left btn-primary"><i class="
                                            fas fa-plus-square"></i>
                                                                Add Invoice</a>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="table-1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            Invoice Number
                                                                        </th>
                                                                        <th>Invoice Date</th>
                                                                        <th>Project Name</th>
                                                                        <th>Client Name</th>
                                                                        <th>Amount</th>
                                                                        <th>Due In</th>
                                                                        <th>Due Date</th>
                                                                        <th>Status</th>
                                                                        <th class="action-1">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(count($invoices) == 0)
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">No invoices
                                                                            to show</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($invoices as $key=>$invoice_item)
                                                                    <tr>
                                                                        <td>
                                                                            {{$invoice_item['invoice_number']}}
                                                                        </td>
                                                                        <td>
                                                                            {{date('d.m.Y',strtotime($invoice_item['invoice_date']))}}
                                                                        </td>
                                                                        <td>{{$project->name}}</td>
                                                                        <td>
                                                                            {{$client->client_name}}
                                                                        </td>

                                                                        <td>{{$invoice_item['total_amount']}} $</td>

                                                                        <td>{{$invoice_item['due_in'] == "" ? 'None':
                                                                            $invoice_item['due_in']."
                                                                            days"}}</td>
                                                                        <td>

                                                                        </td>
                                                                        <td>{!! $invoice_item['payment_status']!=null ?
                                                                            $paymentstatus[$invoice_item['payment_status']]
                                                                            :
                                                                            '' !!}</td>
                                                                        <td>
                                                                            <a href="{{route('invoices.view',$invoice_item['id'])}}"
                                                                                class="btn btn-icon btn-sm btn-primary"><i
                                                                                    class="fas fa-download"></i></a>
                                                                            <a href="{{route('invoices.edit',$invoice_item['id'])}}?flag=1"
                                                                                class="btn btn-icon btn-sm btn-primary"><i
                                                                                    class="far fa-edit"></i></a>

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
                                    <div class="tab-pane fade" role="tabpanel" id="Projecttimeline">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="activities">
                                                    @foreach($timeline as $time_line)
                                                    <div class="activity">
                                                        <div class="activity-icon bg-primary text-white">
                                                            <i class="fas fa-clock" style="font-size: 16px;"></i>
                                                        </div>
                                                        <div class="activity-detail" style="width:50%;">
                                                            <div class="mb-2">
                                                                <a class="text-job"
                                                                    href="#">{!!$status[$time_line['status']]!!}</a>
                                                                <span class="text-job float-right"
                                                                    style="font-size: 14px;">{{date("d.m.Y
                                                                    H:i:s",strtotime($time_line['created_at']))}}</span>

                                                            </div>
                                                            <p style="font-size: 14px;">{{$time_line['status_note']}}.
                                                            </p>
                                                        </div>
                                                    </div>

                                                    @endforeach
                                                </div>
                                            </div>
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
    <div class="modal fade" id="bd-RefClient-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Client Reference</h5>
                    <button type="button" id="btn_close" data-toggle="modal" data-target="#bd-RefClient-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <select id="client_to_add" name="client_to_add" class="form-control select2">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                    <option data-value="{{$client->contact_person}}"
                                        data-id="{{$client->contact_person_count}}" value="{{$client->id}}"
                                        {{old('client_id')==$client->id ? 'selected' :''}}>
                                        {{$client->client_name}} ({{$client->contact_person_count}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div id="client_cp_div" class="hide" style="display:none;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <select class="form-control select2" id="client_contact_person">
                                        <option value="0">Select Contact Person</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select name="prefix" class="form-control select mr-1" id="prefix" disabled>
                                        <option value="5">Dr.</option>
                                        <option value="4">Miss.</option>
                                        <option value="1">Mr.</option>
                                        <option value="2">Mrs.</option>
                                        <option value="3">Ms.</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <input class="form-control" name="first_name" id="first_name" placeholder="Vorname"
                                        type="text" value="" disabled />
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <input class="form-control mr-1" name="last_name" id="last_name"
                                        placeholder="Nachname " type="text" value="" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <input class="form-control" name="email" id="email" placeholder="Email" type="text"
                                    disabled />
                            </div>
                            <div class="col-lg-4">
                                <input class="form-control mr-1" name="work_phone" id="work_phone"
                                    placeholder="Arbeitshandy" disabled />
                            </div>
                            <div class="col-lg-4">
                                <input class="form-control" name="mobile" id="mobile" placeholder="Mobiltelefon"
                                    disabled />
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type="button" class="btn btn-primary" onclick="actionSaveProjectClient()">Add</button>
                        <button type="button" class="btn btn-danger ml-1"
                            onclick="actionCloseClientModal()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_change_status">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Update Status</h4>
                    <button type="button" class="close btn-close-modal" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <select class="form-control select2" value="{{old('project_status')}}" id="status"
                                name="status">
                                <option value="">-- Select Projekt Status --</option>
                                @foreach($projectStatus as $status)
                                <option value="{{$status->id}}" {{$project_status==$status->id ? 'selected'
                                    :''}}>{{$status->name}}
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <textarea class="form-control" id="status_note" name="status_note"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-update-status">Update</button>
                    <button type="button" class="btn btn-danger btn-close-modal" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    @section('script')
    <script>
        $(document).on("click", ".btn-delete-clientref", function () {
            var url = $(this).data('url');
            swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (responce) {
                                if (responce.success) {
                                    swal('Deleted!', {
                                        icon: 'success',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    swal('Alert!', responce.message, 'error');
                                }
                            },
                            error: function (error) {
                                swal('Alert!', "Something went wrong, try again.", 'error');
                            }

                        });

                    } else {

                    }
                });
        });
        $(document).on("click", ".btn-update-status", function () {

            var status = $("#status option:selected").val();
            var status_note = $("#status_note").val();
            console.log(status + "" + status_note);
            $.ajax({
                type: "POST",
                url: "project_status",
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: status,
                    status_note: status_note,
                    project_id: "<?=$project->id?>"
                },
                success: function (responce) {
                    if (responce.status) {
                        window.location.reload();
                    } else {
                        alert(responce.message);
                    }
                },
                error: function (error) {
                    alert("Something went wrong, try again.");
                }

            });

        });
        $(document).on("click", ".btn-close-modal", function () {
            $("#modal_change_status").modal("hide");
        });
        $(document).on('click', '.btn-change-status', function () {
            var status = "<?= $project_status?>";
            $("#status").val(status);
            $("#status_note").text("");
            $("#modal_change_status").modal("show");
        });
        $(document).on('change', "#client_to_add", function () {
            var count = $(this).find(':selected').attr('data-id');
            $("#client_contact_person").empty();
            $("#client_cp_div").hide();
            if (count > 0) {
                $("#client_cp_div").show();
                var cp = $(this).find(':selected').attr('data-value');
                $("#client_contact_person").append(cp);
            }
        });
        $(document).on('change', "#client_contact_person", function () {
            $("#prefix").val($(this).find(':selected').attr('data-prefix'));
            $("#first_name").val($(this).find(':selected').attr('data-fname'));
            $("#last_name").val($(this).find(':selected').attr('data-lname'));
            $("#email").val($(this).find(':selected').attr('data-email'));
            $("#mobile").val($(this).find(':selected').attr('data-mobile'));
            $("#work_phone").val($(this).find(':selected').attr('data-bmobile'));
        });
        function actionSaveProjectClient() {
            var project_id = $("#current_project_id").val();
            var client_to_add = $("#client_to_add option:selected").val();
            var scp = $("#client_contact_person option:selected").val();
            $.ajax({
                url: '/add_ref_client',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    client_id: client_to_add,
                    contact_person_id: scp,
                    project_id: project_id
                },
                success: function (result) {
                    if (result.success) {
                        window.location.reload();
                    } else {
                        alert("something went wrong, try again");
                    }
                },
                error: function (error) {
                    alert("something went wrong, try again");
                }
            });
        }
        function actionCloseClientModal() {
            $("#btn_close").trigger('click');
            $("#prefix").val("");
            $("#first_name").val("");
            $("#last_name").val("");
            $("#email").val("");
            $("#mobile").val("");
        }

    </script>

    @stop


</x-app-layout>