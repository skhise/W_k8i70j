<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contract Details</h4>
                                <div class="card-header-action"><a class="btn btn-danger"
                                        href="{{route('contracts')}}">Back</a>
                                    <a class="btn btn-primary"
                                        href="{{route('contracts.edit',$contract['CNRT_ID'])}}">Edit</a>
                                </div>
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
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Client
                                                                        Name
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_CustomerContactPerson}}
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
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Mobile
                                                                        Number
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_Phone1}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Alternate
                                                                        Number
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->CNRT_Phone2}}
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
                                                                <span style="float:right ;font-weight:bold">Contract
                                                                    Cost</span>
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
                                                                    Location</span>
                                                            </div>
                                                            <div class="col-md-4">{{$contract->SiteAreaName ??
                                                                "NA"}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Address
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
                                                        <div class="card-header-action">
                                                            <input type="button" id="btn_cp_add" value="Add Contact"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target=".bd-RefClient-modal-lg" />
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Name</th>
                                                                        <th>Type</th>
                                                                        <th>Sr. Number</th>
                                                                        <th>Description</th>
                                                                        <th>Price</th>
                                                                        <th>Location</th>
                                                                        <th>Remark</th>
                                                                        <th>Service Period</th>
                                                                        <th>Actions</th>
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
                                                                            {{$index+1}}
                                                                        </td>
                                                                        <td>
                                                                            {{$product->product_name}}
                                                                        </td>
                                                                        <td>{{$product['product_type']}}</td>
                                                                        <td>{{$product['nrnumber']}}</td>
                                                                        <td>{{$product['product_description']}}</td>
                                                                        <th>{{$product['product_price']}}</th>
                                                                        <th>{{$product['branch']}}</th>
                                                                        <th>{{$product['remark']}}</th>
                                                                        <th>{{$product['service_period']}}</th>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                id="showEditModal"
                                                                                data-product_type="{{$product['product_type']}}"
                                                                                data-nrnumber="{{$product['nrnumber']}}"
                                                                                data-product_description="{{$product['product_description']}}"
                                                                                data-product_price="{{$product['product_price']}}"
                                                                                data-branch="{{$product['branch']}}"
                                                                                data-remark="{{$product['remark']}}"
                                                                                data-service_period="{{$product['service_period']}}"
                                                                                data-cpid="{{$product['CNT_ID']}}"
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
                    <h5 class="modal-title" id="myLargeModalLabel">Add Contract Products</h5>
                    <button type="button" id="btn_close" data-toggle="modal" data-target=".bd-RefClient-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_cp" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="contractId" name="contractId" value="{{$contract['CNRT_ID']}}"
                            style="display:none;" />
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <select class="form-control text-box single-line" id="product_type"
                                        name="product_type" placeholder="">
                                        <option value="">Select Type</option>
                                        @foreach($productType as $product_type)
                                        <option value="{{$product_type->id}}">{{$product_type->type_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="first">Product Type</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="product_name"
                                        name="product_name" placeholder="" type="text" value="" />
                                    <label for="first">Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="product_description"
                                        name="product_description" placeholder="" type="text" value="" />
                                    <label for="first">Description</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="product_price"
                                        name="product_price" placeholder="" type="number" value="" />
                                    <label for="first">Product Value</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Sr. Number (Total: <span id="add_sr_no"></span>)</label>
                            <div class="row">
                                <div class="col-md-12 mb-2" id="multipeInput">

                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control text-box single-line" id="nrnumber.0"
                                            name="nrnumber[]" placeholder="" type="text" value="" />
                                        <span class="btn btn-primary input-group-addon add_form_field"><i
                                                class="fa fa-plus" aria-hidden="true"></i></span>

                                    </div>


                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="branch" name="branch"
                                        placeholder="" type="text" value="" />
                                    <label for="first">Location</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="service_period"
                                        name="service_period" placeholder="" type="text" value="" />
                                    <label for="first">Support Period</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="remark" name="remark"
                                        placeholder="" type="text" value="" />
                                    <label for="first">Remark (Note)</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" onclick="SaveContractProduct()">Save</button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBox()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        <script>
            $(document).ready(function () {
                var max_fields = 100;
                var wrapper = $("#multipeInput");
                var add_button = $(".add_form_field");
                var x = 0;
                $(add_button).click(function (e) {
                    e.preventDefault();
                    if (x < max_fields) {
                        x++;
                        $("#add_sr_no").text(x);
                        $(wrapper).prepend('<div class="input-group mt-2"><input type="text" class="form-control nrnumber" id="nrnumber.' + x + '" name="nrnumber[]"/><span class="btn btn-danger input-group-addon add_form_field delete"><i class="fa fa-trash" aria-hidden="true"></i></span></div > '); //add input box
                    } else {
                        alert('You Reached the limits')
                    }
                });
                $(wrapper).on("click", ".delete", function (e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                    $("#add_sr_no").text(x);

                })
            });
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
                    url: 'add_product',
                    type: "POST",
                    data: $("#form_cp").serialize(),
                    success: function (response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBox();
                            window.location.reload();
                        } else {
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function (index, value) {
                                    $("#" + index).addClass('required');
                                    $('.errorMsgntainer').append('<span class="text-danger">' + value + '<span>' + '<br>');
                                });
                            } else {
                                alert(response.message);
                            }


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