<x-app-layout>
    <style>
        .floating-label {
            position: relative;
            margin-bottom: 20px;
        }
        .floating-label label {
            position: absolute;
            top: 12px;
            left: 20px;
            font-size: 14px;
            color: #666;
            pointer-events: none;
            transition: all 0.2s ease;
            background-color: white;
            padding: 0 4px;
            z-index: 10;
            margin-bottom: 0;
            line-height: 1;
        }
        /* For select fields - label always floats above */
        .floating-label select ~ label {
            top: -10px;
            left: 30px;
            font-size: 12px;
            color: #007bff;
            z-index: 11;
            background-color: white;
        }
        /* For input fields - label floats when focused or has value */
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label,
        .floating-label input.has-value ~ label,
        .floating-label input:not([value=""]) ~ label,
        .floating-label label.floating,
        .floating-label.has-value label {
            top: -10px;
            left: 30px;
            font-size: 12px;
            color: #007bff;
            z-index: 11;
            background-color: white;
        }
        .floating-label input {
            padding-left: 15px;
            padding-top: 12px;
            padding-bottom: 10px;
        }
        .floating-label input:focus,
        .floating-label input:not(:placeholder-shown),
        .floating-label input.has-value,
        .floating-label.has-value input {
            padding-top: 20px;
            padding-bottom: 8px;
        }
        /* Adjust label background for blue sections */
        [style*="background-color: #e3f2fd"] .floating-label select ~ label,
        [style*="background-color: #e3f2fd"] .floating-label label.floating,
        [style*="background-color: #e3f2fd"] .floating-label.has-value label {
            background-color: #e3f2fd;
        }
        .floating-label select {
            padding-left: 15px;
            padding-top: 20px;
            padding-bottom: 8px;
            height: auto;
            min-height: 38px;
        }
        .floating-label .select2-container {
            height: auto;
        }
        .floating-label .select2-container .select2-selection {
            min-height: 38px;
            border: 1px solid #ced4da;
            display: flex;
            align-items: center;
        }
        .floating-label .select2-container .select2-selection__rendered {
            padding-left: 15px;
            padding-right: 20px;
            line-height: 22px;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .floating-label .select2-container .select2-selection__arrow {
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .floating-label input[readonly],
        .floating-label input.disabled {
            pointer-events: none;
            cursor: not-allowed;
        }
        .floating-label select[readonly],
        .floating-label select.disabled {
            pointer-events: none;
            cursor: not-allowed;
        }
        .floating-label .select2-container--disabled {
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Service' : 'Add Service' }}</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" id="myTabs" role="tablist">
                                    <li class="nav-item {{ $service->contract_id == 0 && $update ? 'hide' : '' }}">
                                        <a class="nav-link {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' || $service->contract_id != 0 ? 'active' : '' }}"
                                            name="tab1" id="tab1" onclick="toggleForm('tab1')" data-toggle="tab"
                                            href="#contracted" role="tab" aria-controls="tab1"
                                            aria-selected="true">Contracted</a>
                                    </li>
                                    @if ($contractScheduleService == null || $update)
                                        <li class="nav-item {{ $service->contract_id != 0 && $update ? 'hide' : '' }}">
                                            <a class="nav-link {{ old('selectedtab') == 'tab2' || ($update && $service->contract_id == 0) ? 'active' : '' }}"
                                                name="tab2" id="tab2" data-toggle="tab"
                                                onclick="toggleForm('tab2')" href="#noncontracted" role="tab"
                                                aria-controls="tab2" aria-selected="false">Non Contracted</a>
                                        </li>
                                    @endif
                                </ul>
                                <form id="frmcreateService" method="post" enctype="multipart/form-data"
                                    action="{{ $update ? route('services.update', $service->service_id) : route('services.store') }}">
                                    @csrf
                                    <input style="display:none;" type="text" value="tab1" name="selectedtab"
                                        id="selectedtab" />
                                    <input style="display:none;" type="text"
                                        value="{{ $contractScheduleService->id ?? 0 }}" name="contractserviceid"
                                        id="contractserviceid" />

                                    <div class="row">
                                        @if ($errors->any())
                                            {!! implode(
                                                '',
                                                $errors->all('<div class="alert alert-danger">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            :message
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>'),
                                            ) !!}
                                        @endif
                                    </div>
                                    <div style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                    <i class="fas fa-info-circle"></i> Basic Information
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 floating-label">
                                                    <input
                                                        class="disabled form-control text-box single-line @error('service_no') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Service No field is required."
                                                        id="service_no" name="service_no" placeholder="" required="required"
                                                        type="text"
                                                        value="{{ $service->service_no ?? (old('service_no') ?? $service_no) }}"
                                                        readonly />
                                                    <label for="service_no">Service No.</label>
                                                    @if ($errors->has('service_no'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="service_no"
                                                            data-valmsg-replace="true">{{ $errors->first('service_no') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 floating-label">
                                                    <input class="form-control text-box single-line" id="service_date"
                                                        name="service_date" placeholder="" type="date"
                                                        value="{{ $service->service_date ?? old('service_date') == '' ? date('Y-m-d') : old('service_date') }}" />
                                                    <label for="service_date">Service Date <span class="text-danger">*</span></label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="service_date" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 floating-label">
                                                    <select
                                                        class="{{ $update || $customer_id > 0 ? 'disabled' : 'select2' }} form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="customer_id" name="customer_id" placeholder=""
                                                        required="required" type="text"
                                                        value="{{ $service->customer_id ?? old('customer_id') }}">
                                                        <option value="">Select Customer</option>
                                                        @foreach ($clients as $client)
                                                            <option data-client="{{ $client }}"
                                                                value="{{ $client->CST_ID }}"
                                                                {{ $client->CST_ID == $service->customer_id
                                                                    ? 'selected'
                                                                    : (old('customer_id') == $client->CST_ID
                                                                        ? 'selected'
                                                                        : '') }}
                                                                {{ $customer_id == $client->CST_ID ? 'selected' : '' }}>
                                                                {{ $client->CST_Name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>Select Customer <span class="text-danger">*</span></label>
                                                    @if ($errors->has('customer_id'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="customer_id"
                                                            data-valmsg-replace="true">{{ $errors->first('customer_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    <label>OR</label>
                                                </div>
                                                <div
                                                    class="col-md-5 contracted {{ $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="product_sr_no"
                                                            name="product_sr_no" placeholder="Enter Product S/N Number" />
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-info" id="refresh_product_sr_no" title="Search">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger ml-2" onclick="javascript:window.location.reload()" title="Reset">
                                                                <i class="fas fa-redo"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Search product by Serial Number</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                class="contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}"
                                                style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                            <i class="fas fa-info-circle"></i> Contract Information
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <select
                                                                class="{{ $contractScheduleService->contractId ?? 0 > 0 || $update ? 'disabled' : 'select2' }} form-control text-box single-line @error('contract_id') is-invalid @enderror"
                                                                data-val="true" id="contract_id" name="contract_id"
                                                                placeholder="" type="text"
                                                                value="{{ $service->contract_id ?? old('contract_id') }}">
                                                                <option value="0">Select Contract</option>
                                                            </select>
                                                            <label>Select Contract <span class="text-danger">*</span></label>
                                                            @if ($errors->has('contract_id'))
                                                                <span class="text-danger field-validation-valid"
                                                                    data-valmsg-for="contract_id"
                                                                    data-valmsg-replace="true">{{ $errors->first('contract_id') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="contract_no" name="contract_no" placeholder=""
                                                                value="{{ old('contract_no') }}" />
                                                            <label>Contract Number</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contract_no" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="contract_type" name="contract_type" placeholder=""
                                                                value="{{ old('contract_type') }}" />
                                                            <label>Contract Type</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contract_type" data-valmsg-replace="true"></span>
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="contract_status" name="contract_status" placeholder=""
                                                                value="{{ old('contract_status') }}" />
                                                            <label>Contract Status</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contract_status"
                                                                data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="CNRT_EndDate" name="CNRT_EndDate" placeholder=""
                                                                value="" />
                                                            <label>Contract Expiry Date</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="CNRT_EndDate" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="CNRT_Charges" name="CNRT_Charges" placeholder=""
                                                                type="number"
                                                                value="{{ $service->CNRT_Charges ?? (old('CNRT_Charges') ?? 0) }}" />
                                                            <label>Total Amount</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="CNRT_Charges" data-valmsg-replace="true"></span>
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line"
                                                                id="CNRT_Charges_Pending" name="CNRT_Charges_Pending"
                                                                placeholder="" type="number" value="0" />
                                                            <label>Balance Amount</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="CNRT_Charges_Pending"
                                                                data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                class="contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}"
                                                style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                            <i class="fas fa-box"></i> Product Information
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-8 floating-label">
                                                            <select
                                                                class="form-control select2 text-box single-line @error('product_id') is-invalid @enderror"
                                                                data-val="true" id="product_id" name="product_id" placeholder=""
                                                                type="text"
                                                                value="{{ $service->product_id ?? old('product_id') }}">
                                                                <option value="0">Select Product</option>
                                                            </select>
                                                            <label>Select Product</label>
                                                            @if ($errors->has('product_id'))
                                                                <span class="text-danger field-validation-valid"
                                                                    data-valmsg-for="product_id"
                                                                    data-valmsg-replace="true">{{ $errors->first('product_id') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4 {{ $update ? 'hide' : '' }}"
                                                            id="without_product_div">
                                                            <div class="form-check pt-4">
                                                                <input class="form-check-input" type="checkbox" value="0"
                                                                    id="without_product" name="without_product"
                                                                    {{ $update && ($service->product_id == 0 || $service->product_id == null) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="without_product">
                                                                    Without Product
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line product_name"
                                                                id="product_name" name="product_name" placeholder=""
                                                                value="{{ old('product_name') }}" />
                                                            <label>Product Name</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="product_name" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line product_type"
                                                                id="product_type" name="product_type" placeholder=""
                                                                value="{{ old('product_type') }}" />
                                                            <label>Product Type</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="product_type" data-valmsg-replace="true"></span>
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <input readonly disabled
                                                                style="background-color: #ffffff; cursor: not-allowed; pointer-events: none;"
                                                                class="form-control text-box single-line product_sn"
                                                                id="product_sn" name="product_sn" placeholder=""
                                                                value="{{ old('product_sn') }}" />
                                                            <label>Product S/N</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="product_sn" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noncontracted {{ old('selectedtab') == 'tab2' || $update ? '' : 'hide' }}" style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                    <i class="fas fa-box"></i> Product Details
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="noncontracted_product_name" name="product_name" placeholder=""
                                                        value="{{ $update ? $service->product_name : old('product_name') }}" />
                                                    <label>Product Name</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="product_name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="noncontracted_product_type" name="product_type" placeholder=""
                                                        value="{{ $update ? $service->product_type : old('product_type') }}" />
                                                    <label>Product Type</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="product_type" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="noncontracted_product_sn" name="product_sn" placeholder=""
                                                        value="{{ $update ? $service->product_sn : old('product_sn') }}" />
                                                    <label>Product S/N</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="product_sn" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label style="color: #666; font-weight: 500; font-size: 12px; margin-bottom: 5px;">Product Description</label>
                                                    <textarea class="form-control" id="product_description" name="product_description"
                                                        placeholder="Product Description" rows="3">{{ $update ? $service->product_description : old('product_description') }}</textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="product_description"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-6">
                                            <div style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                            <i class="fas fa-tools"></i> Service Details
                                                        </h6>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <select
                                                                class="form-control text-box single-line @error('service_type') is-invalid @enderror"
                                                                data-val="true"
                                                                data-val-required="The service type field is required."
                                                                id="service_type" name="service_type" placeholder=""
                                                                required="required" type="text"
                                                                value="{{ $service->service_type ?? old('service_type') }}">
                                                                <option value="">Select Service type</option>
                                                                @foreach ($serviceType as $issuetype)
                                                                    <option value="{{ $issuetype->id }}"
                                                                        {{ $issuetype->id == $service->service_type
                                                                            ? 'selected'
                                                                            : (old('service_type') == $issuetype->id
                                                                                ? 'selected'
                                                                                : '') }}>
                                                                        {{ $issuetype->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label>Service Type <span class="text-danger">*</span></label>
                                                            @if ($errors->has('service_type'))
                                                                <span class="text-danger field-validation-valid"
                                                                    data-valmsg-for="service_type"
                                                                    data-valmsg-replace="true">{{ $errors->first('service_type') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <select
                                                                class="form-control text-box single-line @error('issue_type') is-invalid @enderror"
                                                                data-val="true"
                                                                data-val-required="The issue type field is required."
                                                                id="issue_type" name="issue_type" placeholder=""
                                                                required="required" type="text"
                                                                value="{{ $service->issue_type ?? old('issue_type') }}">
                                                                <option value="">Select issue type</option>
                                                                @foreach ($issue_type as $issuetype)
                                                                    <option value="{{ $issuetype->id }}"
                                                                        {{ $issuetype->id == $service->issue_type
                                                                            ? 'selected'
                                                                            : (old('issue_type') == $issuetype->id
                                                                                ? 'selected'
                                                                                : '') }}>
                                                                        {{ $issuetype->issue_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label>Issue Type <span class="text-danger">*</span></label>
                                                            @if ($errors->has('issue_type'))
                                                                <span class="text-danger field-validation-valid"
                                                                    data-valmsg-for="issue_type"
                                                                    data-valmsg-replace="true">{{ $errors->first('issue_type') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <select class="form-control text-box single-line" data-val="true"
                                                                data-val-required="The Customer Name field is required."
                                                                id="service_priority" name="service_priority" placeholder=""
                                                                required="required" type="text"
                                                                value="{{ $service->service_priority ?? old('service_priority') }}">
                                                                <option value="">Select priority</option>
                                                                @foreach ($priorities as $priority)
                                                                    <option value="{{ $priority->id }}"
                                                                        {{ $priority->id == $service->service_priority
                                                                            ? 'selected'
                                                                            : (old('service_priority') == $priority->id
                                                                                ? 'selected'
                                                                                : ($priority->priority_name == "Low"
                                                                                ? 'selected'
                                                                                : '')) }}>
                                                                        {{ $priority->priority_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label>Select priority <span class="text-danger">*</span></label>
                                                            @if ($errors->has('service_priority'))
                                                                <span class="text-danger field-validation-valid"
                                                                    data-valmsg-for="service_priority"
                                                                    data-valmsg-replace="true">{{ $errors->first('service_priority') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label style="color: #666; font-weight: 500; font-size: 12px; margin-bottom: 5px;">Issue Description</label>
                                                            <textarea class="form-control" id="service_note" name="service_note" placeholder="Note" rows="3">{{ $service->service_note ?? old('service_note') }}</textarea>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="service_note" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                            <i class="fas fa-address-book"></i> Contact Details
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12 floating-label">
                                                            <input class="form-control text-box single-line" id="contact_person"
                                                                name="contact_person" placeholder="" type="text"
                                                                value="{{ $service->contact_person ?? old('contact_person') }}" />
                                                            <label>Contact Name <span class="text-danger">*</span></label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contact_person"
                                                                data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <input class="form-control text-box single-line" id="contact_number1"
                                                                name="contact_number1" placeholder="" type="text"
                                                                value="{{ $service->contact_number1 ?? old('contact_number1') }}" />
                                                            <label>Contact Mobile</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contact_number1"
                                                                data-valmsg-replace="true"></span>
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <input class="form-control text-box single-line" id="contact_number2"
                                                                name="contact_number2" placeholder="" type="text"
                                                                value="{{ $service->contact_number2 ?? old('contact_number2') }}" />
                                                            <label>Alternate Number</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contact_number2"
                                                                data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6 floating-label">
                                                            <input class="form-control text-box single-line" id="contact_email"
                                                                name="contact_email" placeholder="" type="text"
                                                                value="{{ $service->contact_email ?? old('contact_email') }}" />
                                                            <label>Contact Email</label>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="contact_email" data-valmsg-replace="true"></span>
                                                        </div>
                                                        <div class="col-md-6 floating-label">
                                                            <select name="areaId" id="areaId"
                                                                class="form-control text-box single-line select2">
                                                                <option value="">Select site location</option>
                                                                @foreach ($sitelocation as $location)
                                                                    <option value="{{ $location->id }}"
                                                                        {{ $location->id == $service->areaId ? 'selected' : (old('areaId') == $location->id ? 'selected' : '') }}>
                                                                        {{ $location->SiteAreaName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <label>Site Location</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label style="color: #666; font-weight: 500; font-size: 12px; margin-bottom: 5px;">Site Address</label>
                                                            <textarea class="form-control" id="site_address" name="site_address" placeholder="Site Address" rows="2">{{ $service->site_address ?? old('site_address') }}</textarea>
                                                            <span class="text-danger field-validation-valid"
                                                                data-valmsg-for="site_address" data-valmsg-replace="true"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <h6 style="color: #1976d2; font-weight: bold; margin-bottom: 15px;">
                                                    <i class="fas fa-map-marker-alt"></i> Additional Information
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 floating-label">
                                                    <input class="form-control text-box single-line" id="site_google_link"
                                                        name="site_google_link" placeholder="" type="text"
                                                        value="{{ $service->site_google_link ?? old('site_google_link') }}" />
                                                    <label>Google Location Link</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="site_google_link"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check pt-4">
                                                        <input class="form-check-input" type="checkbox" id="send_wp_notification" name="send_wp_notification">
                                                        <label class="form-check-label" for="send_wp_notification">
                                                            <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 5px;"></i>
                                                            Send WhatsApp Notification
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group">
                                        <div class="card-footer float-right">
                                            <button style='display:none;' type='reset' id="btn_reset"></button>
                                            <div class="d-flex">
                                            <a type="button" class="btn-action btn btn-danger "
                                                    href="{{ $update ? route('services.view', $service->service_id) : route('services') }}">Cancel</a>
                                                <button type="submit" id="btnAddClient"
                                                    class="btn-action btn btn-primary mr-2 ml-2">
                                                    <span class="btn-text">{{ $update ? 'Update' : 'Save' }}</span>
                                                    <span class="btn-loading" style="display: none;">
                                                        <i class="fas fa-spinner fa-spin" style="color: white;"></i>
                                                    </span>
                                                </button>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    @section('script')
        <script>
            // Add loading state to save button on form submit
            $(document).on('submit', '#frmcreateService', function(e) {
                var $btn = $('#btnAddClient');
                var $btnText = $btn.find('.btn-text');
                var $btnLoading = $btn.find('.btn-loading');
                
                // Show loading icon, hide text, disable button
                $btnText.hide();
                $btnLoading.show();
                $btn.prop('disabled', true);
            });

            $(document).on('click', '#refresh_product_sr_no', function() {

                $('#contract_no').val('');
                $('#contract_type').val('');
                $('#contract_status').val('');
                $('#CNRT_EndDate').val('');
                $('#CNRT_Charges').val('');
                $('#CNRT_Charges_Pending').val('');
                $('#product_id').html('');
                var value = $("#product_sr_no").val();
                if(value != ''){
                $.ajax({
                    method: 'GET',
                    url: '/products/product_by_id',
                    data: {
                        product_id: value,
                    },
                    success: function(resp) {
                        var obj = resp;
                        if (obj.success && obj.product != null) {
                            var product = obj.product;
                            $('#contract_no').val(product.CNRT_Number);
                            $('#contract_type').val(product.contract_type_name);
                            $('#contract_status').val(product.contract_status_name);
                            $('#CNRT_EndDate').val(product.contractEndDate);
                            $('#CNRT_Charges').val(product.CNRT_Charges);
                            $('#CNRT_Charges_Pending').val(product.CNRT_Charges_Pending);
                            $('#contact_person').val(product.CNRT_CustomerContactPerson);
                            $('#contact_number1').val(product.CNRT_Phone1);
                            $('#contact_number2').val(product.CNRT_Phone2);
                            $('#contact_email').val(product.CNRT_CustomerEmail);
                            $('#contact_email').val(product.CNRT_CustomerEmail);
                            $('#product_id').html('');
                            $('#contract_id').html('');
                            $('#customer_id').html('');
                            // Only update contracted section product fields
                            $('.contracted .product_name').val(product.product_name);
                            $('.contracted .product_type').val(product.type_name);
                            $('.contracted .product_sn').val(product.product_sn);
                            $("#without_product_div").hide();
                            var options = '';
                            options += '<option value="' + product.mainPId + '" selected>' +  product.nrnumber+" / "+product.product_name+" / "+product.branch + '</option>';
                            $('#product_id').html(options);
                            var ref = product.CNRT_RefNumber!=null ? "/"+product.CNRT_RefNumber : '';
                            var optionsC = '<option value="' + product.contractId + '" selected>' + product
                                .CNRT_Number + " / " + product.contract_type_name+""+ref + '</option>';
                            $('#contract_id').html(optionsC);
                            var optionsCustomer = '<option value="' + product.CNRT_CustomerID +
                                '" selected>' + product.client_name + '</option>';
                            $('#customer_id').html(optionsCustomer);
                            
                            // Update floating labels after setting values
                            setTimeout(function() {
                                updateFloatingLabel($('#customer_id')[0]);
                                updateFloatingLabel($('#contract_id')[0]);
                                updateFloatingLabel($('#product_id')[0]);
                                if ($('#customer_id').hasClass('select2')) {
                                    $('#customer_id').trigger('change.select2');
                                }
                                if ($('#contract_id').hasClass('select2')) {
                                    $('#contract_id').trigger('change.select2');
                                }
                                if ($('#product_id').hasClass('select2')) {
                                    $('#product_id').trigger('change.select2');
                                }
                            }, 200);

                        } else {
                            // Only clear contracted section product fields
                            $('.contracted .product_name').val("");
                            $('.contracted .product_type').val("");
                            $('.contracted .product_sn').val("");
                            $("#without_product_div").show();
                        }

                    },
                    error: function() {
                        $("#without_product_div").show();
                        alert('Something went wrong, try again');
                        Swal.fire({
                                    title: 'Action failed',
                                    icon: 'warning',
                                    text: 'Something went wrong, try again.'
                                });
                    }
                });
            }else {
                Swal.fire({
                                    title: 'Action failed',
                                    icon: 'warning',
                                    text: 'Product S/N Number is required.'
                                });
            }

            });
            $(document).on("change", "#product_id", function() {
                var value = $('#product_id option:selected').val();
                if (value != "") {
                    $.ajax({
                        method: 'GET',
                        url: '/products/product_by_id',
                        data: {
                            product_id: value,
                        },
                        success: function(resp) {
                            var obj = resp;
                            if (obj.success) {
                                $("#without_product_div").hide();
                                var product = obj.product;
                                // Only update contracted section product fields
                                $('.contracted .product_name').val(product.product_name);
                                $('.contracted .product_type').val(product.type_name);
                                $('.contracted .product_sn').val(product.product_sn);
                            } else {
                                $("#without_product_div").show();
                                // Only clear contracted section product fields
                                $('.contracted .product_name').val("");
                                $('.contracted .product_type').val("");
                                $('.contracted .product_sn').val("");
                            }

                        },
                        error: function() {
                            alert('Something went wrong, try again');
                        }
                    });
                } else {
                    $("#without_product_div").show();
                    // Only clear contracted section product fields
                    $('.contracted .product_name').val("");
                    $('.contracted .product_type').val("");
                    $('.contracted .product_sn').val("");
                }

            });

            function toggleForm(tab) {
                if (tab == 'tab1') {
                    $('.noncontracted').hide();
                    $('.contracted').show();
                }
                if (tab == 'tab2') {
                    $('.contracted').hide();
                    $('.noncontracted').show();
                    // Clear product fields when switching to non-contracted (only non-contracted fields)
                    $('#noncontracted_product_name').val('');
                    $('#noncontracted_product_type').val('');
                    $('#noncontracted_product_sn').val('');
                    $('#product_description').val('');
                    // Update floating labels
                    $('#noncontracted_product_name, #noncontracted_product_type, #noncontracted_product_sn').each(function() {
                        updateFloatingLabel(this);
                    });
                }
                $('#btn_reset').trigger('click');
                $('.select2').val('').trigger('change')
                $('#selectedtab').val(tab);

            }
            $(document).ready(function() {

                $('#customer_id').trigger('change');


            });
            $(document).on('change', '#contract_id', function() {

                $('#contract_no').val('');
                $('#contract_type').val('');
                $('#contract_status').val('');
                $('#CNRT_EndDate').val('');
                $('#CNRT_Charges').val('');
                $('#CNRT_Charges_Pending').val('');
                var product_id = '{{ $service->product_id ?? ($contractScheduleService->product_Id ?? 0) }}';
                $.ajax({
                    method: 'GET',
                    url: '/contracts/contract_by_id',
                    data: {
                        CNRT_ID: $('#contract_id option:selected').val(),
                    },
                    success: function(resp) {
                        var obj = resp;
                        if (obj.success) {
                            var contract = obj.contract;
                            $('#contract_no').val(contract.CNRT_Number);
                            $('#contract_type').val(contract.contract_type_name);
                            $('#contract_status').val(contract.contract_status_name);
                            $('#CNRT_EndDate').val(contract.contractEndDate);
                            $('#CNRT_Charges').val(contract.CNRT_Charges);
                            $('#CNRT_Charges_Pending').val(contract.CNRT_Charges_Pending);
                            $('#contact_person').val(contract.CNRT_CustomerContactPerson);
                            $('#contact_number1').val(contract.CNRT_Phone1);
                            $('#contact_number2').val(contract.CNRT_Phone2);
                            $('#contact_email').val(contract.CNRT_CustomerEmail);
                            $('#site_address').val(contract.CNRT_OfficeAddress);
                            $('#site_google_link').val(contract.CNRT_SiteLocation);
                            $('#product_id').html('');
                            var products = obj.products ?? [];
                            var options = '<option value="0">Select product</option>';
                            if (products.length > 0) {
                                products.forEach(function(product) {
                                    if (product_id == product.prodcutId) {
                                        options += '<option value="' + product.prodcutId +
                                            '" selected>' +
                                            product.nrnumber+" / "+product.product_name+" / "+product.branch + '</option>'
                                        // Only update contracted section product fields
                                        $('.contracted .product_name').val(product.product_name);
                                        $('.contracted .product_type').val(product.type_name);
                                        $('.contracted .product_sn').val(product.nrnumber);
                                    } else {
                                        options += '<option value="' + product.prodcutId + '">' +
                                        product.nrnumber+" / "+product.product_name+" / "+product.branch+ '</option>'
                                    }
                                });
                            }
                            $('#product_id').html(options);

                        }

                    },
                    error: function() {
                        alert('Something went wrong, try again');
                    }
                });
            });
            $(document).on('change', '#customer_id', function() {
                $('#contract_id').empty();
                var tab = $('#selectedtab').val();
                var constract_id = '{{ $service->contract_id ?? ($contractScheduleService->contractId ?? 0) }}';
                if (tab == 'tab1') {
                    $.ajax({
                        method: 'GET',
                        url: '/contracts/customer_contract',
                        data: {
                            customer_id: $('#customer_id option:selected').val(),
                        },
                        success: function(contracts) {
                            var options = '<option value="0">Select Contract</option>';

                            console.log(contracts);
                            if (contracts.length > 0) {

                                contracts.forEach(function(contract) {
                                    var ref = contract.CNRT_RefNumber!=null ? "/"+contract.CNRT_RefNumber : '';
                                    if (constract_id == contract.id) {
                                        options += '<option value="' + contract.id + '" selected>' +
                                            contract.title+""+ref + '</option>'

                                    } else {
                                        options += '<option value="' + contract.id + '">' + contract
                                            .title+""+ref + '</option>'

                                    }
                                });

                            }
                            $('#contract_id').html(options);
                            $('#contract_id').trigger('change');
                        },
                        error: function() {
                            $('#contract_id').html('<option value="0">Select Contract</option>');
                            alert('Something went wrong, try again');
                        }
                    });
                } else {
                    var client = $('#customer_id option:selected').data('client');
                    console.log(client);
                    if (typeof client != 'undefined') {
                        $('#contact_person').val(client.CCP_Name);
                        $('#contact_number1').val(client.CCP_Mobile);
                        $('#contact_number2').val(client.CCP_Phone1);
                        $('#contact_email').val(client.CCP_Email);
                        $('#site_address').val(client.CST_OfficeAddress);
                    } else {
                        $('#contact_person').val('');
                        $('#contact_number1').val('');
                        $('#contact_number2').val('');
                        $('#contact_email').val('');
                        $('#site_address').val('');
                    }

                }

            });

            // Function to update floating label position
            function updateFloatingLabel(element) {
                var $element = $(element);
                var $label = $element.siblings('label');
                var $container = $element.closest('.floating-label');
                
                if ($element.is('select')) {
                    // For select fields, label always floats above (CSS handles this)
                    $label.addClass('floating');
                    $container.addClass('has-value');
                } else if ($element.is('input')) {
                    // For input fields, label floats when has value or focused
                    var hasValue = $element.val() && $element.val() !== '';
                    if (hasValue || $element.is(':focus')) {
                        $label.addClass('floating');
                        $container.addClass('has-value');
                    } else {
                        $label.removeClass('floating');
                        $container.removeClass('has-value');
                    }
                }
            }

            // Initialize floating labels on page load
            $(document).ready(function() {
                // Handle select2 events for floating labels (UI only, no initialization)
                if ($.fn.select2) {
                    // Wait for Select2 to be initialized elsewhere, then update labels
                    setTimeout(function() {
                        $('.select2').each(function() {
                            updateFloatingLabel(this);
                        });
                    }, 500);

                    // Add event handlers for Select2 (only for floating label UI)
                    $(document).on('select2:open.floatingLabel', '.select2', function() {
                        var $select = $(this);
                        var $container = $select.closest('.floating-label');
                        if ($container.length) {
                            $container.addClass('has-value');
                            $container.find('label').addClass('floating');
                        }
                    });

                    $(document).on('select2:close.floatingLabel select2:select.floatingLabel select2:unselect.floatingLabel', '.select2', function() {
                        updateFloatingLabel(this);
                    });
                    
                    // Handle focus events on Select2
                    $(document).on('focus.floatingLabel', '.select2-selection', function() {
                        var $select = $(this).closest('.floating-label').find('select');
                        if ($select.length) {
                            updateFloatingLabel($select[0]);
                        }
                    });
                }

                // Handle regular select changes
                $('.floating-label select').on('change', function() {
                    updateFloatingLabel(this);
                });

                // Handle input focus/blur and input events
                $('.floating-label input').on('focus blur input', function() {
                    updateFloatingLabel(this);
                });
                
                // Update labels after a short delay to ensure Select2 is fully initialized
                setTimeout(function() {
                    $('.floating-label select').each(function() {
                        updateFloatingLabel(this);
                    });
                    $('.floating-label input').each(function() {
                        updateFloatingLabel(this);
                    });
                }, 500);
            });
            
            // Update labels when Select2 triggers change events
            $(document).on('change', '.select2', function() {
                updateFloatingLabel(this);
            });
            
            // Handle input value changes dynamically
            $(document).on('input change', '.floating-label input', function() {
                updateFloatingLabel(this);
            });
        </script>
    @stop
</x-app-layout>
