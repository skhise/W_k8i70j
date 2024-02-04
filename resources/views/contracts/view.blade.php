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
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#ContractProduct"
                                            role="tab" aria-controls="refclient" aria-selected="false">Contract
                                            Product</a>
                                    </li>

                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ClientDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{$contract->CST_Name}}</h4>
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
                                                                        {{$contract->CST_Code}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contact
                                                                        Name
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_CustomerContactPerson}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contact
                                                                        Mobile
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_CustomerContactNumber}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contact
                                                                        Email
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_CustomerEmail}}
                                                                    </p>


                                                                    <hr>

                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Website
                                                                    </strong>
                                                                    <p class="text-muted">{{$contract->CST_Website}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-muted">{!!$contract->CST_Status !=0 ?
                                                                        $status[$contract->CST_Status] : 'NA' !!}</p>
                                                                    <hr>
                                                                    <!-- <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Total
                                                                        Projects
                                                                    </strong>
                                                                    <p class="text-muted">{{$project_count}}</p>
                                                                    <hr> -->
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
                                                            <h5 class="">Contract Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contract Number</span>
                                                            </div>
                                                            <div class="col-md-9">{{$contract->CNRT_Number}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contrcat
                                                                    Type</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$contract->contract_type_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Site Type
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$contract->site_type_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Start Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{date("d-M-Y",strtotime($contract->CNRT_StartDate)) ??
                                                                "NA"}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">
                                                                    End Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{date("d-M-Y",strtotime($contract->CNRT_EndDate)) ??
                                                                "NA"}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Charges</span>
                                                            </div>
                                                            <div class="col-md-2 " style="float:left ;font-weight:bold">
                                                                {{$contract->CNRT_Charges}}</div>
                                                            <div class="col-md-1">
                                                                <span style="float:right ;font-weight:bold">Paid</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{$contract->CNRT_Charges_Paid}}</div>
                                                            <div class="col-md-2">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Pending</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{$contract->CNRT_Charges_Paid}}</div>
                                                        </div>

                                                        <hr />
                                                        <div>
                                                            <h5 class="">Other Information</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Google
                                                                    Location Link
                                                                </span>
                                                            </div>
                                                            <div class="col-md-1"><a
                                                                    href="{{$contract->CNRT_SiteLocation ?? '#'}}"
                                                                    target="_blank"><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i>
                                                                </a></div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Address</span>
                                                            </div>
                                                            <div class="col-md-4">{{$contract->CNRT_SiteAddress ??
                                                                "NA"}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Office
                                                                    Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$contract->CNRT_OfficeAddress ??
                                                                "NA"}}
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Note</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $contract->CNRT_Note != null ? $contract->CNRT_Note
                                                                :
                                                                'NA'}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Term &
                                                                    Condition
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{$contract->CNRT_TNC !=null ?
                                                                $contract->CNRT_TNC : "NA"}}
                                                            </div>
                                                        </div>
                                                        <hr />



                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" id="ContractProduct" role="tabpanel"
                                        aria-labelledby="profile-tab2">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Contract Product</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Type</th>
                                                                        <th>Sr. Number</th>
                                                                        <th>Description</th>
                                                                        <th>Price</th>
                                                                        <th>Branch</th>
                                                                        <th>Other</th>
                                                                        <th>Schedules</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($products->count() == 0)
                                                                    <tr>
                                                                        <td colspan="8" class="text-center">No
                                                                            products
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($products as $index => $product)
                                                                    <tr>
                                                                        <td>
                                                                            {{$product->product_name}}
                                                                        </td>
                                                                        <td>{{$product['product_type']}}</td>
                                                                        <td>{{$product['nrnumber']}}</td>
                                                                        <td>{{$product['product_description']}}</td>
                                                                        <th>{{$product['product_price']}}</th>
                                                                        <th>{{$product['branch']}}</th>
                                                                        <th>{{$product['other']}}</th>
                                                                        <th>{{$product['no_of_service']}}</th>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                id="showEditModal"
                                                                                data-name="{{$product['CNT_Name']}}"
                                                                                data-department="{{$product['CNT_Department']}}"
                                                                                data-email="{{$product['CNT_Email']}}"
                                                                                data-mobile="{{$product['CNT_Mobile']}}"
                                                                                data-phone="{{$product['CNT_Phone1']}}"
                                                                                data-cpid="{{$product   ['CNT_ID']}}"
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
                        <button type="button" class="btn btn-success" onclick="SaveContractProduct()">Save</button>
                        <button class="btn btn-danger" onclick="CancelModelBox()">Cancel</button>
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
            function SaveContractProduct() {
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