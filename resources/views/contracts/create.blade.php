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
                                    <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Contract Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                @if($errors->any())
                                                {!! implode('', $errors->all('<div class="alert alert-danger">:message
                                                </div>')) !!}
                                                @endif</div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right;font-weight:bold">Contract Details </span>
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
                                                        name="CNRT_Date" placeholder="" type="date"
                                                        value="{{$contract->CNRT_Date ?? old('CNRT_Date') == '' ? date('Y-m-d') :old ('CNRT_Date')}}" />
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
                                                    <label for="CNRT_RefNumber">Ref. Name</label>
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
                                                    @if($update)
                                                    <input id="CNRT_CustomerID" name="CNRT_CustomerID"
                                                        value="{{$contract->CNRT_CustomerID}}" type="text"
                                                        style="display:none;" />
                                                    <input value="{{$contract->CST_Name}}" type="text"
                                                        class="form-control text-box single-line disabled" />
                                                    <label>Customer Name</label>

                                                        @else
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
                                                                $client->CST_ID ? 'selected' :'') }} data-client="{{$client}}">
                                                                {{$client->CST_Name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('CNRT_Type'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="CNRT_CustomerID"
                                                            data-valmsg-replace="true">{{
                                                            $errors->first('CNRT_CustomerID') }}</span>

                                                        @endif
                                                        @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                <label class="col-form-label font-bold text-right" style="display: block">Contact Details</label>
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
                                                    <input class="form-control text-box single-line" id="CNRT_Phone1"
                                                        name="CNRT_Phone1" placeholder="" type="text"
                                                        value="{{$contract->CNRT_Phone1 ?? old('CNRT_Phone1')}}" />
                                                    <label for="first">Contact Mobile</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Phone1" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="CNRT_Phone2"
                                                        name="CNRT_Phone2" placeholder="" type="text"
                                                        value="{{$contract->CNRT_Phone2 ?? old('CNRT_Phone2')}}" />
                                                    <label for="first">Alternate Number</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Phone2" data-valmsg-replace="true"></span>
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
                                                <div class="col-md-3 floating-label">

                                                    <select name="CNRT_Site" id="CNRT_Site" class="form-control text-box single-line select2" palceholder="">
                                                        <option value="">Select site location</option>
                                                        @foreach($sitelocation as $location)
                                                            <option value="{{$location->id}}" {{$location->id ==
                                                                $contract->CNRT_Site ? 'selected':
                                                                (old('CNRT_Site')
                                                                ==
                                                                $location->id ? 'selected' :'') }}>{{$location->SiteAreaName}}</option>    
                                                        @endforeach
                                                    </select>
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
                                                        name="CNRT_StartDate" placeholder="" type="date"
                                                        value="{{$update ? date('Y-m-d',strtotime($contract->CNRT_StartDate)) : (old('CNRT_StartDate') != '' ? old('CNRT_StartDate') : date('Y-m-d')) }}" />
                                                    <label>Start Date</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_StartDate"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">

                                                    <select id="period_span" class="form-control text-box single-line">
                                                        <option value="1">1 Year</option>
                                                        <option value="2">2 Year</option>
                                                        <option value="3">3 Year</option>
                                                        <option value="0">Custom</option>
                                                    </select>
                                                    <label>Contract Period Span</label>
                                                </div>

                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line disabled" id="CNRT_EndDate"
                                                        name="CNRT_EndDate" placeholder="" type="date"
                                                        value="{{$update ? date('Y-m-d',strtotime($contract->CNRT_EndDate)) : (old('CNRT_EndDate') != '' ? old('CNRT_EndDate') : date('Y-m-d',strtotime('+1 year', strtotime(date('d-m-Y')))))}}" />
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
                                                    <span style="float:right ;font-weight:bold">Contract Cost</span>
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

                                                <div class="col-md-3 floating-label" style="display:none;">
                                                    <input class="form-control text-box single-line"
                                                        id="CNRT_Charges_Paid" name="CNRT_Charges_Paid" placeholder=""
                                                        type="number"
                                                        value="0" />
                                                    <label>Paid Amount</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CNRT_Charges_Paid"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label"  style="display:none;">
                                                    <input class="disabled form-control text-box single-line"
                                                        id="CNRT_Charges_Pending" name="CNRT_Charges_Pending"
                                                        placeholder="" type="number"
                                                        value="0" />
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
        $(document).on('change', '#CNRT_Charges', function () {
            var total = $(this).val();
            var paid = $("#CNRT_Charges_Paid").val();
            var pending = total - paid;
            $("#CNRT_Charges_Pending").val(pending);
        });
        $(document).on('change', '#CNRT_Charges_Paid', function () {
            var total = $("#CNRT_Charges").val();
            var paid = $(this).val();
            var pending = total - paid;
            $("#CNRT_Charges_Pending").val(pending);
        });
        $(document).on('change','#CNRT_CustomerID',function(){
            var client = $("#CNRT_CustomerID option:selected").data('client');
            if(typeof client!='undefined'){
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
        $(document).on('change','#period_span',function(){
            var span = $(this).val();
            if(span == 0){
                $("#CNRT_EndDate").removeClass("disabled");
            } else {
                $("#CNRT_EndDate").addClass("disabled");
            }
            span = span == "" || span == 0 ? 1 : span;
            var date =$('#CNRT_StartDate').val();
            var nd = date.split("-");
            date = nd[0]+"/"+nd[1]+"/"+nd[2];
            var d = new Date(date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var c = new Date(year + parseInt(span), month+1, day-1);
                var month = c.getMonth() <10 ? "0"+c.getMonth():c.getMonth();
                var nday = c.getDate() <10 ? "0"+c.getDate():c.getDate();
                var fd = c.getFullYear()+"-"+month+"-"+nday;
            $("#CNRT_EndDate").val(fd);
        });
        $(document).on('change','#CNRT_StartDate',function(){
            var date =$(this).val();
            var span = $("#period_span").val();
            span = span == "" || span == 0 ? 1 : span;
            var nd = date.split("-");
            date = nd[0]+"/"+nd[1]+"/"+nd[2];
            var d = new Date(date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var c = new Date(year + parseInt(span), month+1, day-1);
                var month = c.getMonth() <10 ? "0"+c.getMonth():c.getMonth();
                var nday = c.getDate() <10 ? "0"+c.getDate():c.getDate();
                //var fd = nday+"-"+month+"-"+c.getFullYear();
                var fd = c.getFullYear()+"-"+month+"-"+nday;
            $("#CNRT_EndDate").val(fd);
        });
    </script>
    @stop
</x-app-layout>