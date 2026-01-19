<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contract Details</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('contracts') }}" class="btn btn-icon btn-sm btn-danger">Back</a>
                                    <div class="dropdown d-inline  ml-2">

                                        <button class="btn btn-light dropleft  dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                            More
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-start"
                                            style="position: absolute; transform: translate3d(0px, -133px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            @if (auth()->user()->role == 1)
                                                <a class="dropdown-item has-icon"
                                                    href="{{ route('contracts.edit', $contract['CNRT_ID']) }}"><i
                                                        class="far fa-edit"></i> Edit</a>
                                                <a class="delete-btn action-btn dropdown-item has-icon"
                                                    href="{{ route('contracts.delete', $contract['CNRT_ID']) }}"><i
                                                        class="fa fa-trash"></i>
                                                    Delete</a>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'details' || session('contract_activeTab') == '' ? ' active' : '' }}"
                                            id="details" data-toggle="tab" href="#ClientDetails" role="tab"
                                            aria-controls="details" aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  {{ session('contract_activeTab') === 'contract_product' ? ' active' : '' }}"
                                            id="contract_product" data-toggle="tab" href="#ContractProduct"
                                            role="tab" aria-selected="false"
                                            aria-controls="contract_product">Products &nbsp;&nbsp;<span
                                                class="badge badge-light">{{ $products->count() }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'services' ? ' active' : '' }}"
                                            id="services" data-toggle="tab" href="#ContractServices" role="tab"
                                            aria-selected="false" aria-controls="services">Schedules Services&nbsp;&nbsp;<span
                                                class="badge badge-light">{{ $services->count() }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'checklist' ? ' active' : '' }}"
                                            id="checklist" data-toggle="tab" href="#ContractCheckList" role="tab"
                                            aria-selected="false" aria-controls="checklist">Checklist Note
                                            &nbsp;&nbsp;<span
                                                class="badge badge-light">{{ $checklists->count() }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('contract_activeTab') === 'renewal' ? ' active' : '' }}"
                                            id="renewal" data-toggle="tab" href="#ContractRenewList" role="tab"
                                            aria-selected="false" aria-controls="renewal">Renewal History
                                            &nbsp;&nbsp;<span
                                                class="badge badge-light">{{ $renewals->count() }}</span></a>
                                    </li>

                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'details' || session('contract_activeTab') == '' ? ' show active' : '' }} "
                                        id="ClientDetails" role="tabpanel" aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Contract
                                                                        Type

                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $contract->contract_type_name }}
                                                                    </p>
                                                                    <hr />
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Total
                                                                        Service
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $contract->Total_Services ?? 0 }}</p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-calendar margin-r-5"></i>&nbsp;&nbsp;End
                                                                        Date</strong>
                                                                    <p class="text-muted">
                                                                        {{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) ?? 'NA' }}
                                                                    </p>
                                                                    <hr />
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-ellipsis-h margin-r-5"></i>&nbsp;&nbsp;Website
                                                                    </strong>
                                                                    <p class="text-muted">{{ $contract->CST_Website }}
                                                                    </p>
                                                                    <hr>
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-muted">{!! $contract->CST_Status != 0 ? $status[$contract->CNRT_Status] : 'NA' !!}</p>

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
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Client
                                                                    Name</span></div>
                                                            <div class="col-md-9">
                                                                <h6 class="text-uppercase">{{ $contract->CST_Name }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contract Number</span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CNRT_Number }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contrcat
                                                                    Type</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $contract->contract_type_name }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Site Type
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">{{ $contract->site_type_name }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Start Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ date('d-M-Y', strtotime($contract->CNRT_StartDate)) ?? 'NA' }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">
                                                                    End Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) ?? 'NA' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contract
                                                                    Cost</span>
                                                            </div>
                                                            <div class="col-md-2 "
                                                                style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges }}</div>
                                                            <div class="col-md-1">
                                                                <span style="float:right ;font-weight:bold">Paid</span>
                                                            </div>
                                                            <div class="col-md-2"
                                                                style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges_Paid }}</div>
                                                            <div class="col-md-2">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Pending</span>
                                                            </div>
                                                            <div class="col-md-2"
                                                                style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges_Pending }}</div>
                                                        </div>

                                                        <hr />

                                                        <div>
                                                            <h5 class="">Contact Information</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact
                                                                    Person
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Name ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Mobile
                                                                    Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Mobile ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Alternate
                                                                    Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Phone1 ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact
                                                                    Email
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Email ?? '' }}
                                                            </div>
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
                                                                    href="{{ $contract->CNRT_SiteLocation ?? '#' }}"
                                                                    target="_blank"><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i>
                                                                </a></div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Location</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ $contract->SiteAreaName ?? 'NA' }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $contract->CNRT_OfficeAddress ?? 'NA' }}
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Note</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $contract->CNRT_Note != null ? $contract->CNRT_Note : 'NA' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Term &
                                                                    Condition
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $contract->CNRT_TNC != null ? $contract->CNRT_TNC : 'NA' }}
                                                            </div>
                                                        </div>
                                                        <hr />



                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'contract_product' ? ' show active' : '' }}"
                                        id="ContractProduct" role="tabpanel" aria-labelledby="profile-tab2">
                                        @include('contracts.products_tab')
                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'contract_services' ? ' show active' : '' }}"
                                        role="tabpanel" aria-labelledby="profile-tab3" id="ContractServices">
                                        @include('contracts.services_tab')
                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === '' ? ' show active' : '' }}"
                                        role="tabpanel" aria-labelledby="profile-tab4" id="ContractCheckList">
                                        @include('contracts.checklist_tab')
                                    </div>
                                    <div class="tab-pane fade {{ session('contract_activeTab') === 'renewal' ? ' show active' : '' }}"
                                        role="tabpanel" aria-labelledby="profile-tab4" id="ContractRenewList">
                                        @include('contracts.renew_tab')
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
                var max_fields = 100;
                var wrapper = $("#multipeInput");
                var add_button = $(".add_form_field");
                var x = 1;
                $(add_button).click(function(e) {
                    e.preventDefault();
                    if (x < max_fields) {
                        x++;
                        $("#add_sr_no").text(x);
                        $(wrapper).prepend(
                            '<div class="input-group mt-2"><input type="text" class="form-control nrnumber" id="nrnumber_' +
                            x +
                            '" name="nrnumber[]"/><span class="btn btn-danger input-group-addon add_form_field delete"><i class="fa fa-trash" aria-hidden="true"></i></span></div > '
                        ); //add input box
                    } else {
                        alert('You Reached the limits')
                    }
                });
                $(wrapper).on("click", ".delete", function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                    $("#add_sr_no").text(x);

                })
            });
            
            // Handle Add Product button click - ensure it shows Add mode
            $(document).on("click", "#btn_cp_add", function() {
                // Reset to Add mode
                $("#myLargeModalLabel").text("Add Contract Products");
                $("#btn_save_product .btn-text").text("Save");
                $("#product_id").val("");
                $(".add_form_field").show();
            });
            
            $(document).on("click", "#showEditModal", function() {
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
                
                // Update modal header and button text for edit mode
                $("#myLargeModalLabel").text("Update Contract Product");
                $("#btn_save_product .btn-text").text("Update");

            });

            function SaveContractProduct() {
                var saveBtn = $("#btn_save_product");
                var btnText = saveBtn.find('.btn-text');
                var btnLoader = saveBtn.find('.btn-loader');
                
                // Show loading state
                saveBtn.prop('disabled', true);
                btnText.hide();
                btnLoader.show();
                
                $('.text-danger-error').html('');
                $(".nrnumber").removeClass("error_border");
                var product_id = $("#product_id").val();
                var contractId = $("#contractId").val();
                var url = '{{ route("contracts.add_product", $contract["CNRT_ID"]) }}';
                if (product_id != "") {
                    url = '{{ route("contracts.update_product", $contract["CNRT_ID"]) }}';
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $("#form_cp").serialize(),
                    success: function(response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBox();
                            // Reload only the products tab instead of the whole page
                            reloadProductsTab();
                        } else {
                            // Hide loading state on error
                            saveBtn.prop('disabled', false);
                            btnText.show();
                            btnLoader.hide();
                            
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function(index, value) {
                                    console.log(index);
                                    if (index == "product_type" || index == "product_name") {
                                        $('.' + index + "-field-validation-valid").html(value);

                                    } else {
                                        var id = index.replace(".", "_");
                                        $("#" + id).addClass('error_border');
                                        $('.srnumber-field-validation-valid').html(
                                            "markd sr. number dublicate");
                                        // $("#" + index).('<div id="cmprivacy">' + value + '</div>');
                                    }
                                });
                            } else {
                                $('.srnumber-field-validation-valid').html(response.message);
                            }


                        }

                    },
                    error: function(error) {
                        // Hide loading state on error
                        saveBtn.prop('disabled', false);
                        btnText.show();
                        btnLoader.hide();
                        alert("something went wrong, try again.");
                    }
                })
            }

            function reloadProductsTab() {
                var contractId = $("#contractId").val();
                $.ajax({
                    url: '{{ route("contracts.get-products-tab", $contract["CNRT_ID"]) }}',
                    type: "GET",
                    beforeSend: function() {
                        // Show loading indicator if needed
                        $("#ContractProduct").html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
                    },
                    success: function(html) {
                        // Replace only the products tab content
                        $("#ContractProduct").html(html);
                        // Update the product count badge
                        // Count rows that don't have colspan (actual product rows)
                        var productRows = $("#ContractProduct table tbody tr").filter(function() {
                            return $(this).find("td[colspan]").length === 0;
                        });
                        var productCount = productRows.length;
                        $("#contract_product .badge").text(productCount);
                    },
                    error: function(error) {
                        console.error("Error loading products:", error);
                        alert("Failed to reload products. Please refresh the page.");
                    }
                });
            }

            function CancelModelBox() {
                // Reset button state
                var saveBtn = $("#btn_save_product");
                var btnText = saveBtn.find('.btn-text');
                var btnLoader = saveBtn.find('.btn-loader');
                saveBtn.prop('disabled', false);
                btnText.show();
                btnLoader.hide();
                
                // Reset modal header and button text to default
                $("#myLargeModalLabel").text("Add Contract Products");
                $("#btn_save_product .btn-text").text("Save");
                
                $(".add_form_field").show();
                $("#product_id").val("");
                $('.text-danger-error').html('');
                $(".nrnumber").removeClass("error_border");
                $("#form_cp")[0].reset();
                $("#btn_close").trigger('click');
            }
        </script>
        <script>
            $(document).on("click", "#showChkEditModal", function() {
                $("#btn_checklist_add").trigger('click');
                $("#description").val($(this).data('description'));
                $("#checklist_id").val($(this).data('id'));
                

            });
            $(document).on("click", "#btn_checklist_save", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                $(".nrnumber").removeClass("error_border");
                var product_id = $("#product_id").val();
                var url = '{{ route('checklist.store', $contract['CNRT_ID']) }}';

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $("#form_checklist").serialize(),
                    success: function(response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBoxChecklist();
                            // Reload only the checklist tab instead of the whole page
                            reloadChecklistTab();
                        } else {
                            $("#btn_checklist_save").attr("disabled", false);
                            $("#btn_checklist_save").html("Save");
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function(index, value) {
                                    $('.' + index + "-field-validation-valid").html(value);
                                });
                            } else {
                                $('.errorMsgntainer').html(response.message);
                            }
                        }

                    },
                    error: function(error) {
                        $("#btn_checklist_save").attr("disabled", false);
                        $("#btn_checklist_save").html("Save");

                        alert("something went wrong, try again.");
                    }
                })
            });

            function CancelModelBoxChecklist() {
                $("#btn_checklist_save").attr("disabled", false);
                $("#btn_checklist_save").html("Save");
                $("#checklist_id").val("0");
                $('.text-danger-error').html('');
                $("#form_checklist")[0].reset();
                $("#btn_close_checklist").trigger('click');
            }
        </script>
        <script>
            $(document).on("click", "#showServiceEditModal", function() {
                $("#serviceType_edit").val($(this).data('servicetype')).trigger("change");
                $("#issueType_edit").val($(this).data('issuetype')).trigger("change");
                $("#product_Id_edit").val($(this).data('product_id')).trigger("change");
                $("#description_edit").val($(this).data('description'));
                $("#service_id").val($(this).data('service_id'));
                $("#Schedule_Date_edit").val($(this).data('schedule_date')).trigger("change");

            });
            $(document).on("click", "#btn_service_save", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                $(".nrnumber").removeClass("error_border");
                var product_id = $("#product_id").val();
                var url = '{{ route('contract_service.store', $contract['CNRT_ID']) }}';
                var isValid = true;

                // Loop through each input field and validate
                $('.service_row_add .required').each(function() {
                    if (!validateInput($(this))) {
                        console.log($(this).id);
                        isValid = false;
                        $("#btn_service_save").attr("disabled", false);
                        $("#btn_service_save").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_service").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            if (response.success) {
                                CancelModelBoxService();
                                // Reload only the services tab instead of the whole page
                                reloadServicesTab();
                            } else {
                                $("#btn_service_save").attr("disabled", false);
                                $("#btn_service_save").html("Save");
                                $('.errorMsgntainer').html("");
                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_service_save").attr("disabled", false);
                            $("#btn_service_save").html("Save");

                            alert("something went wrong, try again.");
                        }
                    })
                }

            });
            $(document).on("click", "#btn_service_update", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                var url = '{{ route('contract_service.update', $contract['CNRT_ID']) }}';
                var isValid = true;
                // Loop through each input field and validate
                $('.service_row .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_service_update").attr("disabled", false);
                        $("#btn_service_update").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_service_edit").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            $("#btn_service_update").attr("disabled", false);
                            $("#btn_service_update").html("Save");

                            if (response.success) {
                                CancelModelBoxServiceEdit();
                                // Reload only the services tab instead of the whole page
                                reloadServicesTab();
                            } else {
                                $('.errorMsgntainer').html("");
                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_service_update").attr("disabled", false);
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
                $("#btn_service_save").attr("disabled", false);
                $("#btn_service_save").html("Save");
                $("#service_id").val("0");
                $('.text-danger-error').html('');
                $("#form_service")[0].reset();
                $("#service_div").html("");
                $("#btn_close_service").trigger('click');
            }

            function CancelModelBoxServiceEdit() {
                $("#btn_service_edit").attr("disabled", false);
                $("#btn_service_edit").html("Save");
                $("#service_id").val("0");
                $('.text-danger-error').html('');
                $("#form_service_edit")[0].reset();
                $("#btn_close_service_edit").trigger('click');
            }
            $(document).on('click', "#add_servies_rows", function() {
                $('#service_div').empty();
                var n = $("#number_of_services").val();
                var rowCount = 0; // Initialize row count


                // Get contract start and end dates
                var startDateStr = "{{ date('Y-m-d', strtotime($contract['CNRT_StartDate'])) }}";
                var endDateStr = "{{ date('Y-m-d', strtotime($contract['CNRT_EndDate'])) }}";
                
                var startDate = new Date(startDateStr);
                var endDate = new Date(endDateStr);
                
                // Calculate total period in months
                var totalMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12 + 
                                  (endDate.getMonth() - startDate.getMonth());
                
                // Calculate interval: Divide period by (totalServices + 1)
                // Example: 12 months / (1 + 1) = 6 months, 12 months / (3 + 1) = 3 months
                var intervalMonths = totalMonths / (parseInt(n) + 1);

                for (var i = 0; i < n; i++) {
                    // Calculate service date based on interval
                    var serviceDate = new Date(startDate);
                    var monthsToAdd = Math.round(intervalMonths * (i + 1));
                    serviceDate.setMonth(serviceDate.getMonth() + monthsToAdd);
                    
                    // Make sure we don't exceed end date
                    if (serviceDate > endDate) {
                        serviceDate = new Date(endDate);
                    }
                    
                    var result2 = formatDate(serviceDate);
                    rowCount++; // Increment row count
                    var newRow = '<div class="form-group row service_row_add">' +
                        '<span class="service_rowserial">' + rowCount + '. </span>' +
                        '<input class="required col-md-3 input-item form-control" value="' + result2 +
                        '"  type="date" name="schedule[' + i + '][Schedule_Date]">' +
                        '<select class="input-item form-control col-md-3" name="schedule[' + i +
                        '][service_product]">{!! $productOption !!}</select>' +
                        '<select class="required input-item form-control col-md-3" name="schedule[' + i +
                        '][issue_type]">{!! $issueType !!}</select>' +
                        '<select  class="required input-item form-control col-md-3" name="schedule[' + i +
                        '][service_type]">{!! $serviceType !!}</select>' +
                        '<textarea  class="input-item form-control col-md-3" name="schedule[' + i +
                        '][descriptions]"></textarea>' +
                        '<button class="btn btn-sm btn-icon btn-danger removeRow">x</button>' +
                        '</div>';
                    $('#service_div').append(newRow);
                    updateSerialNumbers(); // Update serial numbers
                }
            });
            $(document).on('click', '.removeRow', function() {
                $(this).closest('.service_row').remove();
                updateSerialNumbers(); // Update serial numbers
            });

            // Function to update serial numbers
            function updateSerialNumbers() {
                $('.service_row').each(function(index) {
                    $(this).find('.service_rowserial').text(index + 1 + ". ");
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

            function reloadServicesTab() {
                $.ajax({
                    url: '{{ route("contracts.get-services-tab", $contract["CNRT_ID"]) }}',
                    type: "GET",
                    beforeSend: function() {
                        // Show loading indicator if needed
                        $("#ContractServices").html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
                    },
                    success: function(html) {
                        // Replace only the services tab content
                        $("#ContractServices").html(html);
                        // Update the service count badge
                        // Count rows that don't have colspan (actual service rows)
                        var serviceRows = $("#ContractServices table tbody tr").filter(function() {
                            return $(this).find("td[colspan]").length === 0;
                        });
                        var serviceCount = serviceRows.length;
                        $("#services .badge").text(serviceCount);
                    },
                    error: function(error) {
                        console.error("Error loading services:", error);
                        alert("Failed to reload services. Please refresh the page.");
                    }
                });
            }

            function reloadChecklistTab() {
                $.ajax({
                    url: '{{ route("contracts.get-checklist-tab", $contract["CNRT_ID"]) }}',
                    type: "GET",
                    beforeSend: function() {
                        // Show loading indicator if needed
                        $("#ContractCheckList").html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
                    },
                    success: function(html) {
                        // Replace only the checklist tab content
                        $("#ContractCheckList").html(html);
                        // Update the checklist count badge
                        // Count rows that don't have colspan (actual checklist rows)
                        var checklistRows = $("#ContractCheckList table tbody tr").filter(function() {
                            return $(this).find("td[colspan]").length === 0;
                        });
                        var checklistCount = checklistRows.length;
                        $("#checklist .badge").text(checklistCount);
                    },
                    error: function(error) {
                        console.error("Error loading checklist:", error);
                        alert("Failed to reload checklist. Please refresh the page.");
                    }
                });
            }

            // Handle delete service with AJAX
            $(document).on("click", ".delete-service-btn", function(e) {
                e.preventDefault();
                var serviceId = $(this).data('service-id');
                var deleteUrl = '{{ route("contract_service.delete", ":id") }}'.replace(':id', serviceId);
                var row = $(this).closest('tr');

                // Confirm deletion
                if (confirm('Are you sure you want to delete this service?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: "GET",
                        beforeSend: function() {
                            // Show loading on the row
                            row.css('opacity', '0.5');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Reload only the services tab instead of the whole page
                                reloadServicesTab();
                            } else {
                                row.css('opacity', '1');
                                alert(response.message || 'Failed to delete service. Please try again.');
                            }
                        },
                        error: function(error) {
                            row.css('opacity', '1');
                            console.error("Error deleting service:", error);
                            alert("Failed to delete service. Please refresh the page and try again.");
                        }
                    });
                }
            });

            // Handle delete checklist with AJAX
            $(document).on("click", ".delete-checklist-btn", function(e) {
                e.preventDefault();
                var checklistId = $(this).data('checklist-id');
                var deleteUrl = '{{ route("checklist.delete", ":id") }}'.replace(':id', checklistId);
                var row = $(this).closest('tr');

                // Confirm deletion
                if (confirm('Are you sure you want to delete this checklist note?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: "GET",
                        beforeSend: function() {
                            // Show loading on the row
                            row.css('opacity', '0.5');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Reload only the checklist tab instead of the whole page
                                reloadChecklistTab();
                            } else {
                                row.css('opacity', '1');
                                alert(response.message || 'Failed to delete checklist. Please try again.');
                            }
                        },
                        error: function(error) {
                            row.css('opacity', '1');
                            console.error("Error deleting checklist:", error);
                            alert("Failed to delete checklist. Please refresh the page and try again.");
                        }
                    });
                }
            });
        </script>
    @stop
</x-app-layout>
