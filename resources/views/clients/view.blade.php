<?php

$status = [
    "1"=>'<div class="badge badge-success badge-shadow">Active</div>',
    "2"=>'<div class="badge badge-info badge-shadow">Suspendes</div>',
    "3"=>'<div class="badge badge-danger badge-shadow">Deactive</div>',
    "4"=>'<div class="badge badge-secondary badge-shadow">Ferting</div>',
    "5"=>'<div class="badge badge-warning badge-shadow">Archiv</div>',
];
$add_cp_url = "{{route('clients.view',$client->id)}}";
?>

<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Contract Details</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ClientDetails" role="tab" aria-controls="home"
                                            aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#ContactPersons"
                                            role="tab" aria-controls="refclient" aria-selected="false">Contact
                                            Persons</a>
                                    </li>

                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ClientDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{$client->CST_Name}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Client
                                                                        Code
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$client->CST_Code}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Website
                                                                    </strong>
                                                                    <p class="text-muted">{{$client->CST_Website}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-muted">{!! $client->CST_Status !=0 ?
                                                                        $status[$client->CST_Status] : 'NA' !!}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Total
                                                                        Projects
                                                                    </strong>
                                                                    <p class="text-muted">{{$project_count}}</p>
                                                                    <hr>
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
                                                            <h5 class="">DETAILS</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Client
                                                                    Name</span>
                                                            </div>
                                                            <div class="col-md-9">{{$client->CST_Name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">GSTIN
                                                                    No.</span>
                                                            </div>
                                                            <div class="col-md-9">{{$client->gst_no}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Pan
                                                                    No.</span>
                                                            </div>
                                                            <div class="col-md-9">{{$client->pan_no}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Office
                                                                    Address</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$client->CST_OfficeAddress}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Site Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->CST_SiteAddress}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Description</span>
                                                            </div>
                                                            <div class="col-md-6">{{$client->CST_Note}}</div>
                                                        </div>

                                                        <hr />
                                                        <div>
                                                            <h5 class="">Contact Person Details</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Name</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->CCP_Name}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Mobile</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->CCP_Mobile}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Email</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->CCP_Email}}</div>

                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Department</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$client->CCP_Department !=null ?
                                                                $client->CCP_Department : "NA"}}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Alt.
                                                                    Mobile</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$client->CCP_Phone1 != null ? $client->CCP_Phone1 :
                                                                'NA'}}
                                                            </div>
                                                        </div>
                                                        <hr />



                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" id="ContactPersons" role="tabpanel"
                                        aria-labelledby="profile-tab2">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Contact Person</h4>
                                                        <div class="card-header-action">
                                                            <input type="button" id="btn_cp_add" value="Add Contact"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target=".bd-RefClient-modal-lg" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">

                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>
                                                                        <th>Mobile</th>
                                                                        <th>Department</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($contacts->count() == 0)
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">No
                                                                            contacts
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($contacts as $index => $contact)
                                                                    <tr>
                                                                        <td>
                                                                            {{$contact->CNT_Name}}
                                                                        </td>
                                                                        <td>{{$contact['CNT_Email']}}</td>
                                                                        <td>{{$contact['CNT_Mobile']}}</td>
                                                                        <td>{{$contact['CNT_Phone1']}}</td>
                                                                        <th>{{$contact['CNT_Department']}}</th>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                id="showEditModal"
                                                                                data-name="{{$contact['CNT_Name']}}"
                                                                                data-department="{{$contact['CNT_Department']}}"
                                                                                data-email="{{$contact['CNT_Email']}}"
                                                                                data-mobile="{{$contact['CNT_Mobile']}}"
                                                                                data-phone="{{$contact['CNT_Phone1']}}"
                                                                                data-cpid="{{$contact['CNT_ID']}}"
                                                                                class="btn btn-icon btn-sm btn-primary"><i
                                                                                    class="far fa-edit"></i></a></td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade bd-RefClient-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Contact Person</h5>
                    <button type="button" id="btn_close" data-toggle="modal" data-target=".bd-RefClient-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_cp" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="CNT_ID" name="CNT_ID" value="0" style="display:none;" />
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2"><label for="CNT_Name">Name <span
                                            class="text-danger">*</span></label></div>
                                <div class="col-lg-4">
                                    <input class="form-control" name="CNT_Name" id="CNT_Name" placeholder="Name"
                                        type="text" value="" />
                                </div>
                                <div class="col-lg-2"><label for="CNT_Mobile">Mobile <span
                                            class="text-danger">*</span></label>
                                </div>

                                <div class="col-lg-4">
                                    <input class="form-control mr-1" maxlength="10" name="CNT_Mobile" id="CNT_Mobile"
                                        placeholder="Mobile" type="number" value="" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label for="CNT_Email">Email </label>
                                </div>
                                <div class="col-lg-4">
                                    <input type="email" class="form-control mr-1" name="CNT_Email" id="CNT_Email"
                                        placeholder="Email" />
                                </div>
                                <div class="col-lg-2">
                                    <label for="CNT_Email">Alt Mobile </label>
                                </div>
                                <div class="col-lg-4">
                                    <input type="number" maxlength="10" class="form-control" name="CNT_Phone1"
                                        id="CNT_Phone1" placeholder="Alt Mobile" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2"><label for="CNT_Department">Department</label></div>
                                <div class="col-lg-4">
                                    <input class="form-control" name="CNT_Department" id="CNT_Department"
                                        placeholder="Department" type="text" />
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" onclick="SaveContactPerson()">Save</button> &nbsp;
                        <button class="btn btn-danger pull-right" onclick="CancelModelBox()">Cancel</button>&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        <script>
            $(document).on("click", "#showEditModal", function () {
                $("#btn_cp_add").trigger('click');
                $("#CNT_Name").val($(this).data('name'));
                $("#CNT_Department").val($(this).data('department'));
                $("#CNT_Email").val($(this).data('email'));
                $("#CNT_Mobile").val($(this).data('mobile'));
                $("#CNT_Phone1").val($(this).data('phone'));
                var cpid = $(this).data('cpid');
                $("#CNT_ID").val(cpid);
            });
            function SaveContactPerson() {
                $.ajax({
                    url: 'add_cp',
                    type: "POST",
                    data: $("#form_cp").serialize(),
                    success: function (response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBox();
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }

                    },
                    error: function (error) {
                        alert("something went wrong, try again.");
                    }
                })
            }
            function CancelModelBox() {

                $("#form_cp")[0].reset();
                $("#btn_close").trigger('click');
            }
        </script>
        @stop
</x-app-layout>