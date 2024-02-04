<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$update ?'Update Contract' :'Add Contract'}}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateclient" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('contracts.update', $contract->CNRT_ID) : route('contracts.store')}}">
                                    @csrf
                                    @if(!$update)
                                    <input type="hidden" id="CNRT_Created_By" name="CNRT_Created_By"
                                        value="{{Auth::user()->id}}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="CNRT_Number" name="CNRT_Number"
                                        value="{{$contract->CNRT_Number ?? $contract_code}}" />
                                    <div class="form-horizontal">

                                        <h3 style="color:orangered"></h3>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Contract Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">@if($errors->any())
                                                {!! implode('', $errors->all('<div class="alert alert-danger">:message
                                                </div>')) !!}
                                                @endif</div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Contract Details <span
                                                            class="text-danger">*</span></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="disabled form-control text-box single-line @error('CNRT_Number') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="CNRT_Number" name="CNRT_Number" placeholder=""
                                                        required="required" type="text"
                                                        value="{{$contract->CNRT_Number ?? old('CNRT_Number') ?? $contract_code}}" />
                                                    <label for="CNRT_Number">Contract Number</label>
                                                    @if($errors->has('CNRT_Number'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Number" data-valmsg-replace="true">{{
                                                        $errors->first('CNRT_Number') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">

                                                    <input class="form-control text-box single-line" id="CNRT_Date"
                                                        name="CNRT_Date" placeholder="" type="text"
                                                        value="{{$contract->CNRT_Date ?? old('CNRT_Date') == '' ? date('d-m-Y') :old ('CNRT_Date')}}" />
                                                    <label for="CNRT_Number">Contract Date</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Date" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">

                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <select
                                                        class="form-control text-box single-line @error('CNRT_Type') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="CNRT_Type" name="CNRT_Type" placeholder=""
                                                        required="required" type="text"
                                                        value="{{$contract->CNRT_Type ?? old('CNRT_Type')}}">
                                                        <option value="">Select contract type</option>
                                                        @foreach($contract_type as $contracttype)
                                                        <option value="{{$contracttype->id}}" {{$contracttype->id ==
                                                            $contract->CNRT_Type ? 'selected': (old('CNRT_Type') ==
                                                            $contracttype->id ? 'selected' :'') }}>
                                                            {{$contracttype->contract_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>Contarct Type</label>
                                                    @if($errors->has('CNRT_Type'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Type" data-valmsg-replace="true">{{
                                                        $errors->first('CNRT_Type') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <select
                                                        class="form-control text-box single-line @error('CNRT_SiteType') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="CNRT_SiteType" name="CNRT_SiteType" placeholder=""
                                                        required="required" type="text"
                                                        value="{{$contract->CNRT_SiteType ?? old('CNRT_SiteType')}}">
                                                        <option value="">Select site type</option>
                                                        @foreach($site_type as $sitetype)
                                                        <option value="{{$sitetype->id}}" {{$sitetype->id ==
                                                            $contract->CNRT_SiteType ? 'selected': (old('CNRT_SiteType')
                                                            ==
                                                            $sitetype->id ? 'selected' :'') }}>
                                                            {{$sitetype->site_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>Site Type</label>
                                                    @if($errors->has('CNRT_Type'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_SiteType" data-valmsg-replace="true">{{
                                                        $errors->first('CNRT_SiteType') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">

                                                    <input class="form-control text-box single-line" id="CNRT_RefNumber"
                                                        name="CNRT_RefNumber" placeholder="" type="text"
                                                        value="{{$contract->CNRT_RefNumber ?? old('CNRT_RefNumber')}}" />
                                                    <label for="CNRT_RefNumber">Ref. Number</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_RefNumber"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Customer Details</span>
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <select
                                                        class="form-control select2 text-box single-line @error('CNRT_CustomerID') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The Customer Name field is required."
                                                        id="CNRT_CustomerID" name="CNRT_CustomerID" placeholder=""
                                                        required="required" type="text"
                                                        value="{{$contract->CNRT_CustomerID ?? old('CNRT_CustomerID')}}">
                                                        <option value="">Select client</option>
                                                        @foreach($clients as $client)
                                                        <option value="{{$client->CST_ID}}" {{$client->CST_ID ==
                                                            $contract->CNRT_CustomerID ? 'selected':
                                                            (old('CNRT_CustomerID')
                                                            ==
                                                            $client->CST_ID ? 'selected' :'') }}>
                                                            {{$client->CST_Name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('CNRT_Type'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_CustomerID" data-valmsg-replace="true">{{
                                                        $errors->first('CNRT_CustomerID') }}</span>

                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">

                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_CustomerContactPerson"
                                                        name="CNRT_CustomerContactPerson" placeholder="" type="text"
                                                        value="{{$contract->CNRT_CustomerContactPerson ?? old('CNRT_CustomerContactPerson')}}" />
                                                    <label for="first">Contact Name</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_CustomerContactPerson"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_CustomerContactNumber"
                                                        name="CNRT_CustomerContactNumber" placeholder="" type="text"
                                                        value="{{$contract->CNRT_CustomerContactNumber ?? old('CNRT_CustomerContactNumber')}}" />
                                                    <label for="first">Contact Mobile</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_CustomerContactNumber"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_CustomerEmail" name="CNRT_CustomerEmail" placeholder=""
                                                        type="text"
                                                        value="{{$contract->CNRT_CustomerEmail ?? old('CNRT_CustomerEmail')}}" />
                                                    <label for="first">Contact Email</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_CustomerEmail"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Expiry Details</span>
                                                </div>
                                                <div class="col-md-3 floating-label">

                                                    <input class="form-control text-box single-line" id="CNRT_StartDate"
                                                        name="CNRT_StartDate" placeholder="" type="text"
                                                        value="{{$update ? date('d-m-Y',strtotime($contract->CNRT_StartDate)) : (old('CNRT_StartDate') != '' ? old('CNRT_StartDate') : date('d-m-Y')) }}" />
                                                    <label>Start Date</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_StartDate"
                                                        data-valmsg-replace="true"></span>
                                                </div>

                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="CNRT_EndDate"
                                                        name="CNRT_EndDate" placeholder="" type="text"
                                                        value="{{$update ? date('d-m-Y',strtotime($contract->CNRT_EndDate)) : (old('CNRT_EndDate') != '' ? old('CNRT_EndDate') : date('d-m-Y',strtotime('+1 year', strtotime(date('d-m-Y')))))}}" />
                                                    <label>End Date</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_EndDate"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Charges</span>
                                                </div>
                                                <div class="col-md-3 floating-label">

                                                    <input class="form-control text-box single-line" id="CNRT_Charges"
                                                        name="CNRT_Charges" placeholder="" type="number"
                                                        value="{{$contract->CNRT_Charges ?? old('CNRT_Charges')}}" />
                                                    <label>Total Amount</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Charges"
                                                        data-valmsg-replace="true"></span>
                                                </div>

                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_Charges_Paid" name="CNRT_Charges_Paid" placeholder=""
                                                        type="number"
                                                        value="{{$contract->CNRT_Charges_Paid ?? old('CNRT_Charges_Paid')}}" />
                                                    <label>Paid Amount</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Charges_Paid"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="disabled form-control text-box single-line"
                                                        id="CNRT_Charges_Pending" name="CNRT_Charges_Pending"
                                                        placeholder="" type="number"
                                                        value="{{$contract->CNRT_Charges_Pending ?? old('CNRT_Charges_Pending') }}" />
                                                    <label>Charges Pending</label>
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
                                                        for="CNRT_SiteLocation" style="display: block">Google Location
                                                        Link
                                                    </label>
                                                </div>
                                                <div class="col-md-5 floating-label">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_SiteLocation" name="CNRT_SiteLocation" placeholder=""
                                                        type="text"
                                                        value="{{$contract->CNRT_SiteLocation ?? old('CNRT_SiteLocation') }}" />
                                                    <label>Google Location Link
                                                    </label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_SiteLocation"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="col-form-label font-bold text-right"
                                                        for="CNRT_OfficeAddress" style="display: block">Address</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" id="CNRT_OfficeAddress"
                                                        name="CNRT_OfficeAddress" placeholder=""
                                                        rows="2">{{$contract->CNRT_OfficeAddress ?? old('CNRT_OfficeAddress')}}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_OfficeAddress"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="col-form-label font-bold text-right" for="CNRT_Note"
                                                        style="display: block">Note</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" id="CNRT_Note" name="CNRT_Note"
                                                        placeholder="Note"
                                                        rows="2">{{$contract->CNRT_Note?? old('CNRT_Note')}}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Note" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="col-form-label font-bold text-right" for="CNRT_TNC"
                                                        style="display: block">Term/Condition
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" id="CNRT_TNC" name="CNRT_TNC"
                                                        placeholder="Term / Condition"
                                                        rows="2">{{$contract->CNRT_TNC ?? old('CNRT_TNC')}}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_TNC" data-valmsg-replace="true"></span>
                                                </div>

                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <div class="card-footer text-right">


                                                <button type="submit" id="btnAddClient ml-2"
                                                    class="btn btn-primary">{{$update ? 'Update' : 'Save'}}</button>
                                                <a type="button" class="btn btn-danger mr-2"
                                                    href="{{route('clients')}}">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @section('script')
    <script>
        $(document).on('change', "#CNRT_Charges", function () {
            var total = $(this).val();
            var paid = $("#CNRT_Charges_Paid").val();
            var pending = total - paid;
            $("#CNRT_Charges_Pending").val(pending);
        });
        $(document).on('change', "#CNRT_Charges_Paid", function () {
            var total = $("#CNRT_Charges").val();
            var paid = $(this).val();
            var pending = total - paid;
            $("#CNRT_Charges_Pending").val(pending);
        });
    </script>
    @stop
</x-app-layout>