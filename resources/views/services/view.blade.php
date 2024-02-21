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
                                        href="{{route('services')}}">Back</a>
                                    <a class="btn btn-primary" href="{{route('services.edit',$service['id'])}}">Edit</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ClientDetails" role="tab" aria-controls="home"
                                            aria-selected="true">Details</a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ClientDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{$service->CST_Name}}</h4>

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
                                                                        {{$service->CST_Code}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Client
                                                                        Name
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->CNRT_CustomerContactPerson}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contact
                                                                        Name
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->CNRT_CustomerContactPerson}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Mobile
                                                                        Number
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->CNRT_Phone1}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Alternate
                                                                        Number
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->CNRT_Phone2}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contact
                                                                        Email
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->CNRT_CustomerEmail}}
                                                                    </p>


                                                                    <hr>

                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Website
                                                                    </strong>
                                                                    <p class="text-muted">{{$service->CST_Website}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-muted">{!!$service->CST_Status !=0 ?
                                                                        $status[$service->CST_Status] : 'NA' !!}</p>
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
                                                            <h5 class="">Contract Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contract Number</span>
                                                            </div>
                                                            <div class="col-md-9">{{$service->CNRT_Number}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contrcat
                                                                    Type</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{$service->contract_type_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Site Type
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$service->site_type_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Start Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{date("d-M-Y",strtotime($service->CNRT_StartDate)) ??
                                                                "NA"}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">
                                                                    End Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{date("d-M-Y",strtotime($service->CNRT_EndDate)) ??
                                                                "NA"}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contract
                                                                    Cost</span>
                                                            </div>
                                                            <div class="col-md-2 " style="float:left ;font-weight:bold">
                                                                {{$service->CNRT_Charges}}</div>
                                                            <div class="col-md-1">
                                                                <span style="float:right ;font-weight:bold">Paid</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{$service->CNRT_Charges_Paid}}</div>
                                                            <div class="col-md-2">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Pending</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{$service->CNRT_Charges_Paid}}</div>
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
                                                                    href="{{$service->CNRT_SiteLocation ?? '#'}}"
                                                                    target="_blank"><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i>
                                                                </a></div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Location</span>
                                                            </div>
                                                            <div class="col-md-4">{{$service->SiteAreaName ??
                                                                "NA"}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$service->CNRT_OfficeAddress ??
                                                                "NA"}}
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Note</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $service->CNRT_Note != null ? $service->CNRT_Note
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
                                                                {{$service->CNRT_TNC !=null ?
                                                                $service->CNRT_TNC : "NA"}}
                                                            </div>
                                                        </div>
                                                        <hr />



                                                    </div>
                                                    <hr />
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