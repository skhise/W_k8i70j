<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Service Details</h4>
                                <div class="card-header-action"><a class="btn btn-danger"
                                        href="{{route('services')}}">Back</a>
                                    <a class="btn btn-primary"
                                        href="{{route('services.edit',$service->service_id)}}">Edit</a>
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
                                        <a class="nav-link" id="Servicetimeline-tab5" data-toggle="tab"
                                            href="#servicetimeline" role="tab" aria-controls="Servicetimeline"
                                            aria-selected="true">Timeline</a>
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
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Service
                                                                        No.
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->service_no}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Date
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->service_date !='' ?
                                                                        date('d-M-Y',strtotime($service->service_date))
                                                                        : 'NA'}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Service
                                                                        Type
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->type_name}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Issue
                                                                        Type
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$service->issue_name}}
                                                                    </p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-white"><span
                                                                            class="badge badge-shadow {{$service->status_color ?? 'bg-primary'}}">
                                                                            {{$service->Status_Name}}</span></p>
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

                                                        @if($service->contract_id !=0 )
                                                        <div>
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
                                                                <div class="col-md-3">{{$contract->site_type_name}}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Start Date
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {{date("d-M-Y",strtotime($contract->CNRT_StartDate))
                                                                    ??
                                                                    "NA"}}
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Expriy Date
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {{date("d-M-Y",strtotime($contract->CNRT_EndDate))
                                                                    ??
                                                                    "NA"}}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Contract
                                                                        Cost</span>
                                                                </div>
                                                                <div class="col-md-2 "
                                                                    style="float:left ;font-weight:bold">
                                                                    {{$contract->CNRT_Charges}}</div>
                                                                <div class="col-md-1">
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Paid</span>
                                                                </div>
                                                                <div class="col-md-2"
                                                                    style="float:left ;font-weight:bold">
                                                                    {{$contract->CNRT_Charges_Paid}}</div>
                                                                <div class="col-md-2">
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Pending</span>
                                                                </div>
                                                                <div class="col-md-2"
                                                                    style="float:left ;font-weight:bold">
                                                                    {{$contract->CNRT_Charges_Paid}}</div>
                                                            </div>

                                                            <hr />
                                                        </div>
                                                        @endif
                                                        <div>
                                                            <h5 class="">Contact Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contact Person</span>
                                                            </div>
                                                            <div class="col-md-9">{{$service->contact_person}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Email</span>
                                                            </div>
                                                            <div class="col-md-9">{{$service->contact_email}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Phone Numbers</span>
                                                            </div>
                                                            <div class="col-md-3">{{$service->contact_number1}}
                                                                &nbsp;&nbsp;
                                                                {{$service->contact_number2}}</div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5 class="">Product Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        @if($service->product_id ==0)
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Name</span>
                                                            </div>
                                                            <div class="col-md-9">{{$service->product_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Type</span>
                                                            </div>
                                                            <div class="col-md-3">{{$service->product_type}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Description</span>
                                                            </div>
                                                            <div class="col-md-9">{{$service->product_description}}
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        @endif
                                                        @if($service->product_id !=0)
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Name</span>
                                                            </div>
                                                            <div class="col-md-9">{{$product->product_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Type</span>
                                                            </div>
                                                            <div class="col-md-3">{{$product->type_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Description</span>
                                                            </div>
                                                            <div class="col-md-9">{{$product->product_description}}
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        @endif
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
                                                            <div class="col-md-1">
                                                                @if($service->site_location !="")
                                                                <a href="{{$service->site_location ?? '#'}}"
                                                                    target="_blank"><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i>

                                                                </a>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Area</span>
                                                            </div>
                                                            <div class="col-md-4">{{$service->SiteAreaName ??
                                                                "NA"}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{$service->CST_OfficeAddress ??
                                                                "NA"}}
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Note</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $service->service_note != null ?
                                                                $service->service_note
                                                                :
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
                                    <div class="tab-pane fade" role="tabpanel" id="servicetimeline">
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
                                                                <a class="text-white" href="#"><span
                                                                        class="badge badge-shadow {{$time_line['status_color'] ?? 'bg-primary'}}">
                                                                        {{$time_line['Status_Name']}}</span></a>
                                                                <span class="text-job float-right"
                                                                    style="font-size: 14px;">{{date("d.m.Y
                                                                    H:i:s",strtotime($time_line['created_at']))}}</span>

                                                            </div>
                                                            <p style="font-size: 14px;">
                                                                {{$time_line['action_description']}}.
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