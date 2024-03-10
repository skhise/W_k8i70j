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
                                        href="{{route('contracts.edit', $contract['CNRT_ID'])}}">Edit</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'details' || session('contract_activeTab') == "" ? ' active' : '' }}" id="details" data-toggle="tab"
                                            href="#ClientDetails" role="tab" aria-controls="details"
                                            aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  {{ session('contract_activeTab') === 'contract_product' ? ' active' : '' }}" id="contract_product" data-toggle="tab" href="#ContractProduct"
                                            role="tab" aria-selected="false" aria-controls="contract_product">Contract
                                            Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'services' ? ' active' : '' }}" id="services" data-toggle="tab" href="#ContractServices"
                                            role="tab" aria-selected="false" aria-controls="services">Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'checklist' ? ' active' : '' }}" id="checklist" data-toggle="tab" href="#ContractCheckList"
                                            role="tab" aria-selected="false" aria-controls="checklist">CheckList</a>
                                    </li>

                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'details' || session('contract_activeTab') == "" ? ' show active' : '' }} " id="ClientDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contract Type
                                                                        
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{$contract->contract_type_name}}
                                                                    </p>
                                                                    <hr/>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Total Service
                                                                    </strong>
                                                                    <p class="text-muted">{{$contract->Total_Services ?? 0}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-calendar margin-r-5"></i>&nbsp;&nbsp;End Date</strong>
                                                                    <p class="text-muted">{{date("d-M-Y", strtotime($contract->CNRT_EndDate)) ??
    "NA"}}</p><hr/>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Website
                                                                    </strong>
                                                                    <p class="text-muted">{{$contract->CST_Website}}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-muted">{!!$contract->CST_Status != 0 ?
    $status[$contract->CST_Status] : 'NA' !!}</p>
                                                                    
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
                                                            <div class="col-md-3"><span style="float:right ;font-weight:bold">Client Name</span></div>
                                                            <div class="col-md-9">
                                                            <h6 class="text-uppercase">{{$contract->CST_Name}}</h6>

                                                            </div>
                                                        </div>
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
                                                                {{date("d-M-Y", strtotime($contract->CNRT_StartDate)) ??
    "NA"}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">
                                                                    End Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{date("d-M-Y", strtotime($contract->CNRT_EndDate)) ??
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
                                                            <h5 class="">Contact Information</h5>
                                                        </div>
                                                        <hr/>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact Person
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{$contract->CCP_Name ?? ""}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Mobile Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{$contract->CCP_Mobile ?? ""}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Alternate Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{$contract->CCP_Phone1 ?? ""}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact Email
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{$contract->CCP_Email ?? ""}}</div>
                                                        </div>
                                                        <hr/>
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
                                                                {{$contract->CNRT_TNC != null ?
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
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'contract_product' ? ' show active' : '' }}" id="ContractProduct" role="tabpanel"
                                        aria-labelledby="profile-tab2">
                                        @include('contracts.products_tab')                                
                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'contract_services' ? ' show active' : '' }}" role="tabpanel"
                                        aria-labelledby="profile-tab3" id="ContractServices">
                                        @include('contracts.services_tab')
                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === '' ? ' show active' : '' }}" role="tabpanel"
                                        aria-labelledby="profile-tab4" id="ContractCheckList">
                                        @include('contracts.checklist_tab')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
     @include('contracts.product_add');
    @include('contracts.checklist_add');
    @include('contracts.service_add');
    @include('contracts.service_edit');

    @section('script')
    <script>
        $(document).ready(function() {
            
          // Remember selected tab and set active class
            $('.nav-tabs a').on('click', function (e) {
                localStorage.setItem('contract_activeTab', $(e.target).attr('aria-controls'));
            });

            // Restore selected tab on page load
            var activeTab = localStorage.getItem('contract_activeTab');
            if (activeTab) {
                $('#' + activeTab).tab('show');
            }
        });
        $(document).ready(function () {
            var max_fields = 100;
            var wrapper = $("#multipeInput");
            var add_button = $(".add_form_field");
            var x = 1;
            $(add_button).click(function (e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $("#add_sr_no").text(x);
                    $(wrapper).prepend('<div class="input-group mt-2"><input type="text" class="form-control nrnumber" id="nrnumber_' + x + '" name="nrnumber[]"/><span class="btn btn-danger input-group-addon add_form_field delete"><i class="fa fa-trash" aria-hidden="true"></i></span></div > '); //add input box
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
            $("#product_name").val($(this).data('product_name'));
            $("#product_type").val($(this).data('product_type'));
            $("#product_description").val($(this).data('product_description'));
            $("#product_price").val($(this).data('product_price'));
            $("#nrnumber_0").val($(this).data('nrnumber'));
            $("#branch").val($(this).data('branch'));
            $("#service_period").val($(this).data('service_period'));
            $("#remark").val($(this).data('remark'));
            $("#product_id").val($(this).data('product_id'));
            $(".add_form_field").hide();

        });
        function SaveContractProduct() {
            $('.text-danger-error').html('');
            $(".nrnumber").removeClass("error_border");
            var product_id = $("#product_id").val();
            var url = 'add_product';
            if(product_id != "") {
                url = 'update_product';
            }
            $.ajax({
                url: url,
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
                                console.log(index);
                                if (index == "product_type" || index == "product_name") {
                                    $('.' + index + "-field-validation-valid").html(value);

                                } else {
                                    var id = index.replace(".", "_");
                                    $("#" + id).addClass('error_border');
                                    $('.srnumber-field-validation-valid').html("markd sr. number dublicate");
                                    // $("#" + index).('<div id="cmprivacy">' + value + '</div>');
                                }
                            });
                        } else {
                            $('.srnumber-field-validation-valid').html(response.message);
                        }


                    }

                },
                error: function (error) {
                    alert("something went wrong, try again.");
                }
            })
        }
        function CancelModelBox() { 
            $("#product_id").val("");
            $(".add_form_field").hide();
            $('.text-danger-error').html('');
            $(".nrnumber").removeClass("error_border");
            $("#form_cp")[0].reset();
            $("#btn_close").trigger('click');
        }
      
    </script>
    <script>
      $(document).on("click", "#showChkEditModal", function () {
            $("#btn_checklist_add").trigger('click');
            $("#description").val($(this).data('description'));
            $("#checklist_id").val($(this).data('id'));

        });
        $(document).on("click","#btn_checklist_save",function() {
            $('.text-danger-error').html('');
            $(this).attr("disabled",true);
            $(this).html("Saving...");
            $(".nrnumber").removeClass("error_border");
            var product_id = $("#product_id").val();
            var url = '{{route('checklist.store', $contract['CNRT_ID'])}}';
            
            $.ajax({
                url: url,
                type: "POST",
                data: $("#form_checklist").serialize(),
                success: function (response) {
                    //  var obj = JSON.parse(response);
                    if (response.success) {
                        CancelModelBoxChecklist();
                        window.location.reload();
                    } else {
                        $("#btn_checklist_save").attr("disabled",false);
                        $("#btn_checklist_save").html("Save");
                        $('.errorMsgntainer').html("");
                        if (typeof response.validation_error != 'undefined') {
                            $.each(response.validation_error, function (index, value) {
                                $('.' + index + "-field-validation-valid").html(value);
                            });
                        } else {
                            $('.errorMsgntainer').html(response.message);
                        }
                    }

                },
                error: function (error) {
                    $("#btn_checklist_save").attr("disabled",false);
                    $("#btn_checklist_save").html("Save");
                        
                    alert("something went wrong, try again.");
                }
            })
        });
        function CancelModelBoxChecklist() { 
            $("#btn_checklist_save").attr("disabled",false);
            $("#btn_checklist_save").html("Save");
            $("#checklist_id").val("0");
            $('.text-danger-error').html('');
            $("#form_checklist")[0].reset();
            $("#btn_close_checklist").trigger('click');
        }
</script>
<script>
      $(document).on("click", "#showServiceEditModal", function () {
            $("#serviceType_edit").val($(this).data('servicetype')).trigger("change");
            $("#issueType_edit").val($(this).data('issuetype')).trigger("change");
            $("#product_Id_edit").val($(this).data('product_id')).trigger("change");
            $("#description_edit").val($(this).data('description'));
            $("#service_id").val($(this).data('service_id'));
            $("#Schedule_Date_edit").val($(this).data('schedule_date')).trigger("change");
            
        });
        $(document).on("click","#btn_service_save",function() {
            $('.text-danger-error').html('');
            $(this).attr("disabled",true);
            $(this).html("Saving...");
            $(".nrnumber").removeClass("error_border");
            var product_id = $("#product_id").val();
            var url = '{{route('contract_service.store', $contract['CNRT_ID'])}}';
            var isValid = true;

                // Loop through each input field and validate
                $('.service_row_add .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_service_save").attr("disabled",false);
                        $("#btn_service_save").html("Save");
                    }
                });
            if(isValid){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $("#form_service").serialize(),
                    success: function (response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBoxService();
                            window.location.reload();
                        } else {
                            $("#btn_service_save").attr("disabled",false);
                            $("#btn_service_save").html("Save");
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function (index, value) {
                                    $('.' + index + "-field-validation-valid").html(value);
                                });
                            } else {
                                $('.errorMsgntainer').html(response.message);
                            }
                        }

                    },
                    error: function (error) {
                        $("#btn_service_save").attr("disabled",false);
                        $("#btn_service_save").html("Save");
                            
                        alert("something went wrong, try again.");
                    }
                })
            }    
            
        });
        $(document).on("click","#btn_service_update",function() {
            $('.text-danger-error').html('');
            $(this).attr("disabled",true);
            $(this).html("Saving...");
            var url = '{{route('contract_service.update', $contract['CNRT_ID'])}}';
            var isValid = true;
                // Loop through each input field and validate
                $('.service_row .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_service_update").attr("disabled",false);
                        $("#btn_service_update").html("Save");
                    }
                });
            if(isValid){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $("#form_service_edit").serialize(),
                    success: function (response) {
                        //  var obj = JSON.parse(response);
                        $("#btn_service_update").attr("disabled",false);
                        $("#btn_service_update").html("Save");
                            
                        if (response.success) {
                            CancelModelBoxServiceEdit();
                            window.location.reload();
                        } else {
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function (index, value) {
                                    $('.' + index + "-field-validation-valid").html(value);
                                });
                            } else {
                                $('.errorMsgntainer').html(response.message);
                            }
                        }

                    },
                    error: function (error) {
                        $("#btn_service_update").attr("disabled",false);
                        $("#btn_service_update").html("Save");
                            
                        alert("something went wrong, try again.");
                    }
                })
            }    
            
        });
        function validateInput(input) {
            var value = input.val().trim();
            var isValid = true;
            if (value === '') {
                input.addClass('error_border');
                isValid = false;
            } else {
                input.removeClass('error_border');
            }
            return isValid;
        }
        function CancelModelBoxService() { 
            $("#btn_service_save").attr("disabled",false);
            $("#btn_service_save").html("Save");
            $("#service_id").val("0");
            $('.text-danger-error').html('');
            $("#form_service")[0].reset();
            $("#service_div").html("");
            $("#btn_close_service").trigger('click');
        }
        function CancelModelBoxServiceEdit() { 
            $("#btn_service_edit").attr("disabled",false);
            $("#btn_service_edit").html("Save");
            $("#service_id").val("0");
            $('.text-danger-error').html('');
            $("#form_service_edit")[0].reset();
            $("#btn_close_service_edit").trigger('click');
        }
        $(document).on('click',"#add_servies_rows",function(){
            var n = $("#number_of_services").val();
            var rowCount = 0; // Initialize row count
            

             for(var i=0;i<n;i++){
                var myDate = new Date("{{$contract['CNRT_StartDate']}}");
                var result1 = myDate.setMonth(myDate.getMonth()+i);
                var result2 =  formatDate(new Date(result1));
                rowCount++; // Increment row count
                    var newRow = '<div class="form-group row service_row_add">' +
                        '<span class="service_rowserial">' + rowCount + '. </span>' +
                        '<input class="required input-item form-control" value="'+result2+'"  type="date" name="schedule[' + i + '][Schedule_Date]">' +
                        '<select class="input-item form-control select2" name="schedule[' + i + '][service_product]">{!! $productOption !!}</select>' +
                        '<select class="required input-item form-control" name="schedule[' + i + '][issue_type]">{!! $issueType !!}</select>' +
                        '<select  class="required input-item form-control" name="schedule[' + i + '][service_type]">{!! $serviceType !!}</select>' +
                        '<textarea  class="input-item form-control" name="schedule[' + i + '][descriptions]"></textarea>' +
                        '<button class="btn btn-sm btn-icon btn-danger removeRow">x</button>' +
                        '</div>';
                    $('#service_div').append(newRow);
                    updateSerialNumbers(); // Update serial numbers
             }   
        });
        $(document).on('click', '.removeRow', function(){
            $(this).closest('.service_row').remove();
            updateSerialNumbers(); // Update serial numbers
        });

    // Function to update serial numbers
    function updateSerialNumbers() {
        $('.service_row').each(function(index) {
            $(this).find('.service_rowserial').text(index + 1+". ");
        });
    }
    function formatDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1; // Month starts from 0
        var year = date.getFullYear();

        // Add leading zeros if necessary
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }

        return year + '-' + month + '-' + day;
    }
</script>
    @stop
</x-app-layout>