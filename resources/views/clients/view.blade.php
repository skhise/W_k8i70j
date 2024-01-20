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
                                <h4>Client Details</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ClientDetails" role="tab" aria-controls="home"
                                            aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#ContactPerson"
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
                                                        <h4 class="text-uppercase">{{$client->name}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">m
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Kunde
                                                                        Nummer
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$client->client_code}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Kundentyp
                                                                    </strong>
                                                                    <p class="text-muted">{{$customer_type}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Kunde
                                                                        Typ</strong>
                                                                    <p class="text-muted">{{$type}}</p>
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
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Kunde</span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Client
                                                                    Name</span>
                                                            </div>
                                                            <div class="col-md-9">{{$client->client_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    Telefon
                                                                </span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Telphone</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$client->phone}}<br />{{$client->phone_alt}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    Fax
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->fax}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    Webseite
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->website}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                                    E-Mail
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$client->email}}<br />{{$client->email_alt}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline;">Anmerkungen</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Description</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->description}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline;">Memo</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->memo}}</div>

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
                                                            <div class="col-md-3">{{$client->address_default}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Ort</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Place/location</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->place_default}}</div>
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
                                                            <div class="col-md-3">{{$client->zipcode_default}}</div>

                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Bundesland</span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Federal
                                                                    State</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$default_state_name ?? ""}}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Land</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Country</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$default_country_name ?? ""}}
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5 class="">INVOICE ADDRESS DETAILS</h5>
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
                                                            <div class="col-md-3">{{$client->address_invoice}}</div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Ort</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Place/location</span>
                                                            </div>
                                                            <div class="col-md-3">{{$client->place_invoice}}</div>
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
                                                            <div class="col-md-3">{{$client->zipcode_invoice}}</div>

                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Bundesland</span>
                                                                <br />
                                                                <span style="float:right ;font-weight:bold">Federal
                                                                    State</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$invoice_state_name ?? ""}}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Land</span>
                                                                <br />
                                                                <span
                                                                    style="float:right ;font-weight:bold">Country</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$invoice_country_name ?? ""}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" id="ContactPerson" role="tabpanel"
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
                                                                        <th>Type</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(count($contacts) == 0)
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">No
                                                                            contacts
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($contacts as $index => $contact)
                                                                    <tr>
                                                                        <td>
                                                                            {{$contact['full_name']}}
                                                                        </td>
                                                                        <td>{{$contact['email']}}</td>
                                                                        <td>{{$contact['work_phone']}}</td>
                                                                        <td>{{$contact['mobile']}}</td>
                                                                        <th>{{$contact['mobile']}}</th>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                id="showEditModal"
                                                                                data-prefix="{{$contact['prefix']}}"
                                                                                data-fname="{{$contact['first_name']}}"
                                                                                data-lname="{{$contact['last_name']}}"
                                                                                data-email="{{$contact['email']}}"
                                                                                data-wphone="{{$contact['work_phone']}}"
                                                                                data-mobile="{{$contact['mobile']}}"
                                                                                data-cpid="{{$contact['id']}}"
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
                        <input type="hidden" id="cp_id" name="cp_id" value="0" style="display:none;" />
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select name="prefix" class="form-control select mr-1" id="prefix">
                                        <option value="1">Mr.</option>
                                        <option value="2">Mrs.</option>
                                        <option value="4">Miss.</option>
                                        <option value="5">Dr.</option>
                                        <option value="3">Ms.</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <input class="form-control" name="first_name" id="first_name" placeholder="Vorname"
                                        type="text" value="" />
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <input class="form-control mr-1" name="last_name" id="last_name"
                                        placeholder="Nachname " type="text" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <input class="form-control" name="email" id="email" placeholder="Email" type="text" />
                            </div>
                            <div class="col-lg-4">
                                <input type="number" class="form-control mr-1" name="work_phone" id="work_phone"
                                    placeholder="Arbeitshandy" />
                            </div>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="mobile" id="mobile"
                                    placeholder="Mobiltelefon" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" onclick="SaveContactPerson()">Save</button>
                        <button class="btn btn-danger" onclick="CancelModelBox()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        <script>
            $(document).on("click", "#showEditModal", function () {
                $("#btn_cp_add").trigger('click');
                $("#prefix").val($(this).data('prefix'));
                $("#first_name").val($(this).data('fname'));
                $("#last_name").val($(this).data('lname'));
                $("#email").val($(this).data('email'));
                $("#work_phone").val($(this).data('wphone'));
                $("#mobile").val($(this).data('mobile'));
                var cpid = $(this).data('cpid');
                $("#cp_id").val(cpid);
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