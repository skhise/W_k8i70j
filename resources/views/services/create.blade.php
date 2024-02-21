<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$update ?'Update Service' :'Add Service'}}</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" id="myTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{old('selectedtab')=='tab1' || old('selectedtab') == ''  ? 'active':'' }}"
                                            name="tab1" id="tab1" onclick="toggleForm('tab1')" data-toggle="tab"
                                            href="#contracted" role="tab" aria-controls="tab1"
                                            aria-selected="true">Contracted</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{old('selectedtab')=='tab2' ? 'active':'' }}" name="tab2"
                                            id="tab2" data-toggle="tab" onclick="toggleForm('tab2')"
                                            href="#noncontracted" role="tab" aria-controls="tab2"
                                            aria-selected="false">Non Contracted</a>
                                    </li>
                                </ul>
                                <form id="frmcreateclient" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('services.update', $service->id) : route('services.store')}}">
                                    @csrf
                                    <input name="selectedtab" value="{{old('selectedtab') ?? 'tab1'}}" id="selectedtab"
                                        style="display:none;" />
                                    <div class="row">
                                        @if($errors->any())
                                        {!! implode('', $errors->all('<div class="alert alert-danger">
                                            :message
                                        </div>')) !!}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Customer</span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                @if($update)
                                                <input id="customer_id" name="customer_id"
                                                    value="{{$service->customer_id}}" type="text"
                                                    style="display:none;" />
                                                <label>Customer Name</label>
                                                @else
                                                <select
                                                    class="form-control select2 text-box single-line @error('customer_id') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The Customer Name field is required."
                                                    id="customer_id" name="customer_id" placeholder=""
                                                    required="required" type="text"
                                                    value="{{$service->customer_id ?? old('customer_id')}}">
                                                    <option value="">Select client</option>
                                                    @foreach($clients as $client)
                                                    <option value="{{$client->CST_ID}}" {{$client->CST_ID ==
                                                        $service->customer_id ? 'selected':
                                                        (old('customer_id')
                                                        ==
                                                        $client->CST_ID ? 'selected' :'') }}
                                                        data-client="{{$client}}">
                                                        {{$client->CST_Name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('customer_id'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="customer_id" data-valmsg-replace="true">{{
                                                    $errors->first('customer_id') }}</span>
                                                @endif
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group contracted">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Contract</span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                <select
                                                    class="form-control select2 text-box single-line @error('contract_id') is-invalid @enderror"
                                                    data-val="true" id="contract_id" name="contract_id" placeholder=""
                                                    type="text" value="{{$service->contract_id ?? old('contract_id')}}">
                                                    <option value="">Select Contract</option>
                                                </select>
                                                @if($errors->has('contract_id'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_id" data-valmsg-replace="true">{{
                                                    $errors->first('contract_id') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group contracted">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Select
                                                    Product</span>
                                            </div>
                                            <div class="col-md-4 floating-label">
                                                <select
                                                    class="form-control select2 text-box single-line @error('product_id') is-invalid @enderror"
                                                    data-val="true" id="product_id" name="product_id" placeholder=""
                                                    type="text" value="{{$service->product_id ?? old('product_id')}}">
                                                    <option value="">Select Product</option>
                                                </select>
                                                @if($errors->has('product_id'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_id" data-valmsg-replace="true">{{
                                                    $errors->first('product_id') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check pt-3">
                                                    <input class="form-check-input" type="checkbox" value="0"
                                                        id="without_product" name="without_product">
                                                    <label class="form-check-label" for="without_product">
                                                        Without Product
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group contracted">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Contract
                                                    Information</span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="contract_no"
                                                    name="contract_no" placeholder="" value="{{old('contract_no')}}" />
                                                <label>Contract Number</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_no" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="contract_type"
                                                    name="contract_type" placeholder=""
                                                    value="{{old('contract_type')}}" />
                                                <label>Contract Type</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_type" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="contract_status"
                                                    name="contract_status" placeholder=""
                                                    value="{{old('contract_status')}}" />
                                                <label>Contract Status</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contract_status" data-valmsg-replace="true"></span>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group contracted">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="CNRT_StartDate"
                                                    name="CNRT_StartDate" placeholder="" type="date"
                                                    value="{{$update ? date('Y-m-d',strtotime($service->CNRT_StartDate)) : (old('CNRT_StartDate') != '' ? old('CNRT_StartDate') : date('Y-m-d')) }}" />
                                                <label>Contract Expriy Date</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_StartDate" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="CNRT_Charges"
                                                    name="CNRT_Charges" placeholder="" type="number"
                                                    value="{{$service->CNRT_Charges ?? old('CNRT_Charges')}}" />
                                                <label>Total Amount</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_Charges" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="disabled form-control text-box single-line"
                                                    id="CNRT_Charges_Pending" name="CNRT_Charges_Pending" placeholder=""
                                                    type="number" value="0" />
                                                <label>Balance Amount</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_Charges_Pending"
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
                                                    value="{{$service->contact_person ?? old('contact_person')}}" />
                                                <label for="first">Contact Name</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_person" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_number1"
                                                    name="contact_number1" placeholder="" type="text"
                                                    value="{{$service->contact_number1 ?? old('contact_number1')}}" />
                                                <label for="first">Contact Mobile</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_number1" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <input class="form-control text-box single-line" id="contact_number2"
                                                    name="contact_number2" placeholder="" type="text"
                                                    value="{{$service->contact_number2 ?? old('contact_number2')}}" />
                                                <label for="first">Alternate Number</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_number2" data-valmsg-replace="true"></span>
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
                                                    value="{{$service->contact_email ?? old('contact_email')}}" />
                                                <label for="first">Contact Email</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="contact_email" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <select name="areaId" id="areaId"
                                                    class="form-control text-box single-line select2" palceholder="">
                                                    <option value="">Select site location</option>
                                                    @foreach($sitelocation as $location)
                                                    <option value="{{$location->id}}" {{$location->id ==
                                                        $service->CNRT_Site ? 'selected':
                                                        (old('CNRT_Site')
                                                        ==
                                                        $location->id ? 'selected' :'')
                                                        }}>{{$location->SiteAreaName}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group noncontracted hide">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Product
                                                    Information</span>
                                            </div>
                                            <div class="col-md-4 floating-label">

                                                <input class="form-control text-box single-line" id="product_name"
                                                    name="product_name" placeholder=""
                                                    value="{{old('product_name')}}" />
                                                <label>Product Name</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_name" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="product_type"
                                                    name="product_type" placeholder=""
                                                    value="{{old('product_type')}}" />
                                                <label>Product Type</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_type" data-valmsg-replace="true"></span>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="form-group noncontracted hide">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="float:right ;font-weight:bold">Product Description</span>
                                            </div>
                                            <div class="col-md-6 floating-label">

                                                <textarea class="form-control text-box single-line"
                                                    id="product_description" name="product_description"
                                                    placeholder="">{{old('product_description')}}</textarea>
                                                <label>Product Description</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="product_description"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right" for="CNRT_Note"
                                                    style="display: block">Note</label>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" id="CNRT_Note" name="CNRT_Note"
                                                    placeholder="Note"
                                                    rows="2">{{$service->CNRT_Note?? old('CNRT_Note')}}</textarea>
                                                </textarea>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="CNRT_Note" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
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
                                                    value="{{$service->service_no ?? old('service_no') ?? $service_no}}" />
                                                <label for="service_no">Contract Number</label>
                                                @if($errors->has('service_no'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="service_no" data-valmsg-replace="true">{{
                                                    $errors->first('service_no') }}</span>

                                                @endif
                                            </div>
                                            <div class="col-md-3 floating-label">

                                                <input class="form-control text-box single-line" id="service_date"
                                                    name="service_date" placeholder="" type="date"
                                                    value="{{$service->service_date ?? old('service_date') == '' ? date('Y-m-d') :old ('service_date')}}" />
                                                <label for="CNRT_Number">Service Date</label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="service_date" data-valmsg-replace="true"></span>
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
                                                    data-val-required="The issue type field is required."
                                                    id="service_type" name="service_type" placeholder=""
                                                    required="required" type="text"
                                                    value="{{$service->service_type ?? old('service_type')}}">
                                                    <option value="">Select issue type</option>
                                                    @foreach($serviceType as $issuetype)
                                                    <option value="{{$issuetype->id}}" {{$issuetype->id ==
                                                        $service->service_type ? 'selected':
                                                        (old('service_type') ==
                                                        $issuetype->id ? 'selected' :'') }}>
                                                        {{$issuetype->type_name}}</option>
                                                    @endforeach
                                                </select>
                                                <label>Service Type</label>
                                                @if($errors->has('service_type'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="issue_type" data-valmsg-replace="true">{{
                                                    $errors->first('service_type') }}</span>

                                                @endif
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <select
                                                    class="form-control text-box single-line @error('issue_type') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The issue type field is required."
                                                    id="issue_type" name="issue_type" placeholder="" required="required"
                                                    type="text" value="{{$service->issue_type ?? old('issue_type')}}">
                                                    <option value="">Select issue type</option>
                                                    @foreach($issue_type as $issuetype)
                                                    <option value="{{$issuetype->id}}" {{$issuetype->id ==
                                                        $service->issue_type ? 'selected':
                                                        (old('issue_type') ==
                                                        $issuetype->id ? 'selected' :'') }}>
                                                        {{$issuetype->issue_name}}</option>
                                                    @endforeach
                                                </select>
                                                <label>Issue Type</label>
                                                @if($errors->has('issue_type'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="issue_type" data-valmsg-replace="true">{{
                                                    $errors->first('issue_type') }}</span>

                                                @endif
                                            </div>
                                            <div class="col-md-3 floating-label">
                                                <select
                                                    class="form-control text-box single-line @error('service_priority') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The Customer Name field is required."
                                                    id="service_priority" name="service_priority" placeholder=""
                                                    required="required" type="text"
                                                    value="{{$service->service_priority ?? old('service_priority')}}">
                                                    <option value="">Select priority</option>
                                                    @foreach($priorities as $priority)
                                                    <option value="{{$priority->id}}" {{$priority->id ==
                                                        $service->service_priority ? 'selected':
                                                        (old('service_priority')
                                                        ==
                                                        $priority->id ? 'selected' :'') }}>
                                                        {{$priority->priority_name}}</option>
                                                    @endforeach
                                                </select>
                                                <label>Select priority</label>
                                                @if($errors->has('service_priority'))
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="service_priority" data-valmsg-replace="true">{{
                                                    $errors->first('service_priority') }}</span>

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
                                                    value="{{$service->site_google_link ?? old('site_google_link') }}" />
                                                <label>Google Location Link
                                                </label>
                                                <span class="text-danger field-validation-valid"
                                                    data-valmsg-for="site_google_link"
                                                    data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group">
                                        <div class="card-footer text-right">


                                            <button type="submit" id="btnAddClient ml-2"
                                                class="btn btn-primary">{{$update ? 'Update' :
                                                'Save'}}</button>
                                            <a type="button" class="btn btn-danger mr-2"
                                                href="{{route('services')}}">Back</a>
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
        function toggleForm(tab) {
            $('#selectedtab').val(tab);
            if (tab == 'tab1') {
                $('.noncontracted').hide();
                $('.contracted').show();
            }
            if (tab == 'tab2') {
                $('.contracted').hide();
                $('.noncontracted').show();
            }

        }
        $(document).ready(function () {

            $('#customer_id').trigger('change');
            $('#customer_id').trigger('change');

        });
        $(document).on('change', '#contract_id', function () {

            $('#contract_no').val('');
            $('#contract_type').val('');
            $('#contract_status').val('');
            $('#CNRT_EndDate').val('');
            $('#CNRT_Charges').val('');
            $('#CNRT_Charges_Pending').val('');

            $.ajax({
                method: 'GET',
                url: '/contracts/contract_by_id',
                data: {
                    CNRT_ID: $('#contract_id option:selected').val(),
                },
                success: function (resp) {
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
                        $('#product_id').html('');
                        var products = obj.products ?? [];
                        var options = '<option>Select product</option>';
                        if (products.length > 0) {
                            products.forEach(function (product) {
                                options += '<option value="' + product.id + '">' + product.product_name + '</option>'
                            });
                        }
                        $('#product_id').html(options);

                    }

                },
                error: function () {
                    alert('Something went wrong, try again');
                }
            });
        });
        $(document).on('change', '#customer_id', function () {
            $('#contract_id').empty();
            $.ajax({
                method: 'GET',
                url: '/contracts/customer_contract',
                data: {
                    customer_id: $('#customer_id option:selected').val(),
                },
                success: function (contracts) {
                    var options = '<option>Select Contract</option>';

                    console.log(contracts);
                    if (contracts.length > 0) {

                        contracts.forEach(function (contract) {
                            options += '<option value="' + contract.id + '">' + contract.title + '</option>'
                        });
                    }
                    console.log(options);
                    console.log(contracts.length);
                    $('#contract_id').html(options);

                },
                error: function () {
                    $('#contract_id').html('<option>Select Contract</option>');
                    alert('Something went wrong, try again');
                }
            });
        });
        $(document).on('change', '#CNRT_Charges', function () {
            var total = $(this).val();
            var paid = $('#CNRT_Charges_Paid').val();
            var pending = total - paid;
            $('#CNRT_Charges_Pending').val(pending);
        });
        $(document).on('change', '#CNRT_Charges_Paid', function () {
            var total = $('#CNRT_Charges').val();
            var paid = $(this).val();
            var pending = total - paid;
            $('#CNRT_Charges_Pending').val(pending);
        });
        $(document).on('change', '#CNRT_CustomerID', function () {
            var client = $('#CNRT_CustomerID option:selected').data('client');
            if (typeof client != 'undefined') {
                $('#CNRT_CustomerContactPerson').val(client.CCP_Name);
                $('#CNRT_Phone1').val(client.CCP_Mobile);
                $('#CNRT_Phone2').val(client.CCP_Phone1);
                $('#CNRT_CustomerEmail').val(client.CCP_Email);
                $('#CNRT_OfficeAddress').val(client.CST_OfficeAddress);
            } else {
                $('#CNRT_CustomerContactPerson').val("");
                $('#CNRT_Phone1').val("");
                $('#CNRT_Phone2').val("");
                $('#CNRT_CustomerEmail').val("");
                $('#CNRT_OfficeAddress').val("");
            }
        });
        $(document).on('change', '#period_span', function () {
            var span = $(this).val();
            if (span == 0) {
                $('#CNRT_EndDate').removeClass('disabled');
            } else {
                $('#CNRT_EndDate').addClass('disabled');
            }
            span = span == '' || span == 0 ? 1 : span;
            var date = $('#CNRT_StartDate').val();
            var nd = date.split('-');
            date = nd[0] + '/' + nd[1] + '/' + nd[2];
            var d = new Date(date);
            var year = d.getFullYear();
            var month = d.getMonth();
            var day = d.getDate();
            var c = new Date(year + parseInt(span), month + 1, day - 1);
            var month = c.getMonth() < 10 ? '0' + c.getMonth() : c.getMonth();
            var nday = c.getDate() < 10 ? '0' + c.getDate() : c.getDate();
            var fd = c.getFullYear() + '-' + month + '-' + nday;
            $('#CNRT_EndDate').val(fd);
        });
        $(document).on('change', '#CNRT_StartDate', function () {
            var date = $(this).val();
            var span = $('#period_span').val();
            span = span == '' || span == 0 ? 1 : span;
            var nd = date.split('-');
            date = nd[0] + "/" + nd[1] + "/" + nd[2];
            var d = new Date(date);
            var year = d.getFullYear();
            var month = d.getMonth();
            var day = d.getDate();
            var c = new Date(year + parseInt(span), month + 1, day - 1);
            var month = c.getMonth() < 10 ? '0' + c.getMonth() : c.getMonth();
            var nday = c.getDate() < 10 ? '0' + c.getDate() : c.getDate();
            //var fd = nday+'-'+month+'-'+c.getFullYear();
            var fd = c.getFullYear() + '-' + month + '-' + nday;
            $('#CNRT_EndDate')(fd);
        });
    </script>
    @stop
</x-app-layout>