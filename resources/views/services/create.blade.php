<x-app-layout>
    <style>
        .floating-label label {
            z-index: 10;
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
                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right;font-weight:bold">Service No.
                                                </span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input
                                                    class="disabled form-control text-box single-line @error('service_no') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The Customer Name field is required."
                                                    id="service_no" name="service_no" placeholder="" required="required"
                                                    type="text"
                                                    value="{{ $service->service_no ?? (old('service_no') ?? $service_no) }}" />
                                                <label for="service_no">Contract Number</label>
                                                @if ($errors->has('service_no'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="service_no"
                                                        data-valmsg-replace="true">{{ $errors->first('service_no') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="service_date"
                                                    name="service_date" placeholder="" type="date"
                                                    value="{{ $service->service_date ?? old('service_date') == '' ? date('Y-m-d') : old('service_date') }}" />
                                                <label for="service_date">Service Date</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="service_date" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Customer <span class="text-danger">*</span></span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                <select
                                                    class="{{ $update || $customer_id > 0 ? 'disabled' : 'select2' }} form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The Customer Name field is required."
                                                    id="customer_id" name="customer_id" placeholder=""
                                                    required="required" type="text"
                                                    value="{{ $service->customer_id ?? old('customer_id') }}">
                                                    <option value="">Select client</option>
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
                                                @if ($errors->has('customer_id'))
                                                    <span class="texnpm runnpm nnnnt-danger field-validation-valid"
                                                        data-valmsg-for="customer_id"
                                                        data-valmsg-replace="true">{{ $errors->first('customer_id') }}</span>
                                                @endif
                                            </div>
                                            <div
                                                class="col-md-3 contracted  {{ $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">

                                                <div class="input-group floating-label">
                                                    <input type="text"class="form-control" id="product_sr_no"
                                                        name="product_sr_no" />

                                                    <label style="left:15px;" for="product_sr_no">Product S/N
                                                        Number</label>
                                                    <button type="button" class="btn btn-icon btn-danger"
                                                        onclick="javascript:window.location.reload()"><i
                                                            class="material-icons"
                                                            style="top: 5px;position: relative;">refresh</i></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Contract <span class="text-danger">*</span></span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                <select
                                                    class="{{ $contractScheduleService->contractId ?? 0 > 0 || $update ? 'disabled' : 'select2' }} form-control text-box single-line @error('contract_id') is-invalid @enderror"
                                                    data-val="true" id="contract_id" name="contract_id"
                                                    placeholder="" type="text"
                                                    value="{{ $service->contract_id ?? old('contract_id') }}">
                                                    <option value="0">Select Contract</option>
                                                </select>
                                                @if ($errors->has('contract_id'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="contract_id"
                                                        data-valmsg-replace="true">{{ $errors->first('contract_id') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div
                                        class="form-group contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Contract
                                                    Information</span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="contract_no" name="contract_no" placeholder=""
                                                    value="{{ old('contract_no') }}" />
                                                <label>Contract Number</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_no" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="contract_type" name="contract_type" placeholder=""
                                                    value="{{ old('contract_type') }}" />
                                                <label>Contract Type</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_type" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="contract_status" name="contract_status" placeholder=""
                                                    value="{{ old('contract_status') }}" />
                                                <label>Contract Status</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_status"
                                                    data-valmsg-replace="true"></span>
                                            </div>


                                        </div>
                                    </div>
                                    <div
                                        class="form-group contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="CNRT_EndDate" name="CNRT_EndDate" placeholder=""
                                                    value="" />
                                                <label>Contract Expriy Date</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_EndDate" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="CNRT_Charges" name="CNRT_Charges" placeholder=""
                                                    type="number"
                                                    value="{{ $service->CNRT_Charges ?? (old('CNRT_Charges') ?? 0) }}" />
                                                <label>Total Amount</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_Charges" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input style="pointer-event:none;"
                                                    class="disabled form-control text-box single-line"
                                                    id="CNRT_Charges_Pending" name="CNRT_Charges_Pending"
                                                    placeholder="" type="number" value="0" />
                                                <label>Balance Amount</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_Charges_Pending"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Product</span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                <select
                                                    class="form-control select2 text-box single-line @error('product_id') is-invalid @enderror"
                                                    data-val="true" id="product_id" name="product_id" placeholder=""
                                                    type="text"
                                                    value="{{ $service->product_id ?? old('product_id') }}">
                                                    <option value="0">Select Product</option>
                                                </select>
                                                @if ($errors->has('product_id'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="product_id"
                                                        data-valmsg-replace="true">{{ $errors->first('product_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 {{ $update ? 'hide' : '' }}"
                                                id="without_product_div">
                                                <div class="form-check pt-3">
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
                                    <div
                                        class="form-group contracted {{ $service->contract_id == 0 && $update ? 'hide' : '' }} {{ old('selectedtab') == 'tab1' || old('selectedtab') == '' ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Product
                                                    Information</span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="disabled form-control text-box single-line product_name"
                                                    id="product_name" name="product_name" placeholder=""
                                                    value="{{ old('product_name') }}" />
                                                <label>Product Name</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_name" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="disabled form-control text-box single-line product_type"
                                                    id="product_type" name="product_type" placeholder=""
                                                    value="{{ old('product_type') }}" />
                                                <label>Product Type</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_type" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="disabled form-control text-box single-line product_sn"
                                                    id="product_sn" name="product_sn" placeholder=""
                                                    value="{{ old('product_sn') }}" />
                                                <label>Product S/N</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_sn" data-valmsg-replace="true"></span>
                                            </div>



                                        </div>
                                    </div>
                                    <div
                                        class="form-group noncontracted {{ old('selectedtab') == 'tab2' || $update    ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Product
                                                    Information</span>
                                            </div>
                                            <div class="col-md-4 floating-label">

                                                <input class="form-control text-box single-line product_name"
                                                    id="product_name" name="product_name" placeholder=""
                                                    value="{{ $update ? $service->product_name : old('product_name') }}" />
                                                <label>Product Name</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_name" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line product_type"
                                                    id="product_type" name="product_type" placeholder=""
                                                    value="{{ $update ? $service->product_type : old('product_type') }}" />
                                                <label>Product Type</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_type" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line product_sn"
                                                    id="product_sn" name="product_sn" placeholder=""
                                                    value="{{ $update ? $service->product_sn : old('product_sn') }}" />
                                                <label>Product S/N</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_sn" data-valmsg-replace="true"></span>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group noncontracted {{ old('selectedtab') == 'tab2' || $update    ? '' : 'hide' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Product Description</span>
                                            </div>
                                            <div class="col-md-6 floating-label">

                                                <textarea class="form-control text-box single-line" id="product_description" name="product_description"
                                                    placeholder="">{{ $update ? $service->product_description : old('product_description') }}</textarea>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_description"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right"
                                                    style="display: block">Contact Details</label>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_person"
                                                    name="contact_person" placeholder="" type="text"
                                                    value="{{ $service->contact_person ?? old('contact_person') }}" />
                                                <label for="first">Contact Name <span class="text-danger">*</span></label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_person"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_number1"
                                                    name="contact_number1" placeholder="" type="text"
                                                    value="{{ $service->contact_number1 ?? old('contact_number1') }}" />
                                                <label for="first">Contact Mobile</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_number1"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_number2"
                                                    name="contact_number2" placeholder="" type="text"
                                                    value="{{ $service->contact_number2 ?? old('contact_number2') }}" />
                                                <label for="first">Alternate Number</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_number2"
                                                    data-valmsg-replace="true"></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right" for="contact_email"
                                                    style="display: block"></label>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_email"
                                                    name="contact_email" placeholder="" type="text"
                                                    value="{{ $service->contact_email ?? old('contact_email') }}" />
                                                <label for="first">Contact Email</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_email" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <select name="areaId" id="areaId"
                                                    class="form-control text-box single-line select2" palceholder="">
                                                    <option value="">Select site location</option>
                                                    @foreach ($sitelocation as $location)
                                                        <option value="{{ $location->id }}"
                                                            {{ $location->id == $service->areaId ? 'selected' : (old('areaId') == $location->id ? 'selected' : '') }}>
                                                            {{ $location->SiteAreaName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right" for="site_address"
                                                    style="display: block">Site Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="site_address" name="site_address" placeholder="Site Address" rows="2">{{ $service->site_address ?? old('site_address') }}</textarea>
                                                </textarea>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="site_address" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right" for="service_note"
                                                    style="display: block">Issue Description</label>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" id="service_note" name="service_note" placeholder="Note" rows="2">{{ $service->service_note ?? old('service_note') }}</textarea>
                                                </textarea>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="service_note" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">

                                            </div>
                                            <div class="col-md-3 floating-label">
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
                                                        data-valmsg-for="issue_type"
                                                        data-valmsg-replace="true">{{ $errors->first('service_type') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-3 floating-label">
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
                                            <div class="col-md-3 floating-label">
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
                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right"
                                                    for="site_google_link" style="display: block">Google
                                                    Location
                                                    Link
                                                </label>
                                            </div>
                                            <div class="col-md-5 floating-label">
                                                <input class="form-control text-box single-line" id="site_google_link"
                                                    name="site_google_link" placeholder="" type="text"
                                                    value="{{ $service->site_google_link ?? old('site_google_link') }}" />
                                                <label>Google Location Link
                                                </label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="site_google_link"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-5 floating-label">
                                            <div class="form-check">
                                                   
                                                
                                                <label style="margin-top: 5px;" class="form-check-label" for="send_wp_notification">
                                                <svg  x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                                                <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path><path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                                                </svg>
                                                <input class="form-check-input mt-1" type="checkbox" id="send_wp_notification" name="send_wp_notification">
                                                            Send Whatsapp Notification
                                                        </label>    
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
                                                    class="btn-action btn btn-primary mr-2 ml-2">{{ $update ? 'Update' : 'Save' }}</button>
                                                
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
            $(document).on('change', '#product_sr_no', function() {

                $('#contract_no').val('');
                $('#contract_type').val('');
                $('#contract_status').val('');
                $('#CNRT_EndDate').val('');
                $('#CNRT_Charges').val('');
                $('#CNRT_Charges_Pending').val('');
                $('#product_id').html('');
                var value = $(this).val();
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
                            $('.product_name').val(product.product_name);
                            $('.product_type').val(product.type_name);
                            $('.product_sn').val(product.product_sn);
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

                        } else {
                            $('.product_name').val("");
                            $('.product_type').val("");
                            $('.product_sn').val("");
                            $("#without_product_div").show();
                        }

                    },
                    error: function() {
                        $("#without_product_div").show();
                        alert('Something went wrong, try again');
                    }
                });
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
                                $('.product_name').val(product.product_name);
                                $('.product_type').val(product.type_name);
                                $('.product_sn').val(product.product_sn);
                            } else {
                                $("#without_product_div").show();
                                $('.product_name').val("");
                                $('.product_type').val("");
                                $('.product_sn').val("");
                            }

                        },
                        error: function() {
                            alert('Something went wrong, try again');
                        }
                    });
                } else {
                    $("#without_product_div").show();
                    $('.product_name').val("");
                    $('.product_type').val("");
                    $('.product_sn').val("");
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
                                        $('.product_name').val(product.product_name);
                                        $('.product_type').val(product.type_name);
                                        $('.product_sn').val(product.nrnumber);
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
        </script>
    @stop
</x-app-layout>
