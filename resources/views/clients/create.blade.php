<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Client' : 'Add Client' }}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateclient" method="post" enctype="multipart/form-data"
                                    action="{{ $update ? route('clients.update', $client->CST_ID) : route('clients.store') }}">
                                    @csrf
                                    @if (!$update)
                                        <input type="hidden" id="created_by" name="created_by"
                                            value="{{ Auth::user()->id }}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{ Auth::user()->id }}" />
                                    <input type="hidden" id="CST_Code" name="CST_Code"
                                        value="{{ $client->client_code ?? $client_code }}" />
                                    <div class="form-horizontal">

                                        <h3 style="color:orangered"></h3>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Client Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                @if ($errors->any())
                                                    {!! implode(
                                                        '',
                                                        $errors->all('<div class="alert alert-danger">:message
                                                                                                                                                        </div>'),
                                                    ) !!}
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Client Name<span
                                                            class="text-danger">*</span></span>
                                                </div>
                                                <div class="col-md-5 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('CST_Name') is-invalid @enderror"
                                                        data-val="true" id="CST_Name" name="CST_Name" placeholder=""
                                                        data-val-required="The Customer Name field is required."
                                                        required="required" type="text"
                                                        value="{{ $client->CST_Name ?? old('CST_Name') }}" />
                                                    <label>Name</label>
                                                    @if ($errors->has('CST_Name'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="CST_Name"
                                                            data-valmsg-replace="true">{{ $errors->first('CST_Name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <input class="form-control text-box single-line" id="CST_Website"
                                                        name="CST_Website" placeholder="" type="text"
                                                        value="{{ $client->CST_Website ?? old('CST_Website') }}" />
                                                    <label>Website</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CST_Website" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Contact Person</span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="CCP_Name"
                                                        min="0" name="CCP_Name" placeholder="" step="1"
                                                        type="text"
                                                        value="{{ $client->CCP_Name ?? old('CCP_Name') }}" />
                                                    <label for="CCP_Name">Name</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CCP_Name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('CCP_Mobile') is-invalid @enderror"
                                                        id="CCP_Mobile" name="CCP_Mobile" placeholder=""
                                                        data-val-required="This field is required." required="required"
                                                        type="number"
                                                        value="{{ $client->CCP_Mobile ?? old('CCP_Mobile') }}" />
                                                    <label for="CCP_Name">Mobile<span
                                                            class="text-danger">*</span></label>
                                                    @if ($errors->has('CCP_Mobile'))
                                                        <span class=" text-danger field-validation-valid"
                                                            data-valmsg-for="CCP_Mobile" data-valmsg-replace="true">
                                                            {{ $errors->first('CCP_Mobile') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="CCP_Department"
                                                        name="CCP_Department" placeholder="" type="text"
                                                        value="{{ $client->CCP_Department ?? old('CCP_Department') }}" />
                                                    <label>Department</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CCP_Department"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <!-- <span style="float:right ;font-weight:bold">Contact Email</span> -->
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('CCP_Email') is-invalid @enderror"
                                                        id="CCP_Email" name="CCP_Email" placeholder=""
                                                        type="text"
                                                        value="{{ $client->CCP_Email ?? old('CCP_Email') }}" />
                                                    <label>Email
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CCP_Email" data-valmsg-replace="true"></span>
                                                    @if ($errors->has('CCP_Email'))
                                                        <span class=" text-danger field-validation-valid"
                                                            data-valmsg-for="CCP_Email" data-valmsg-replace="true">
                                                            {{ $errors->first('CCP_Email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Contact Phone</span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line numberType"
                                                        id="CCP_Phone2" name="CCP_Phone2" placeholder=""
                                                        type="text" maxlength="12"
                                                        value="{{ $client->CCP_Phone2 ?? old('CCP_Phone2') }}" />
                                                    <label>Alt Phone</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CCP_Phone2"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line numberType"
                                                        id="CCP_Phone1" name="CCP_Phone1" placeholder=""
                                                        type="text" maxlength="12"
                                                        value="{{ $client->CCP_Phone1 ?? old('CCP_Phone1') }}" />
                                                    <label>Phone</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CCP_Phone1"
                                                        data-valmsg-replace="true"></span>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold;">Taxes
                                                    </span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="gst_no"
                                                        name="gst_no" placeholder="" type="text"
                                                        value="{{ $client->gst_no ?? old('gst_no') }}" />
                                                    <label>GSTIN No.</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="gst_no" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input class="form-control text-box single-line" id="pan_no"
                                                        name="pan_no" placeholder="" type="text"
                                                        value="{{ $client->pan_no ?? old('pan_no') }}" />
                                                    <label>Pan No.</label>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="pan_no" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold;">Reference
                                                    </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select
                                                        class="form-control @error('Ref_Employee') is-invalid @enderror select2"
                                                        id="Ref_Employee" name="Ref_Employee">
                                                        <option value="">-- Select Reference --</option>
                                                        @foreach ($refrences as $refrence)
                                                            <option value="{{ $refrence->EMP_ID }}"
                                                                {{ $refrence->EMP_ID == old('Ref_Employee') ? 'selected' : '' }}
                                                                {{ $refrence->EMP_ID == $client->Ref_Employee && $update ? 'selected' : '' }}>
                                                                {{ $refrence->EMP_Name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('Ref_Employee'))
                                                        <span class=" text-danger field-validation-valid"
                                                            data-valmsg-for="Ref_Employee" data-valmsg-replace="true">
                                                            {{ $errors->first('Ref_Employee') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="col-form-label font-bold text-right" for="Memo"
                                                        style="display: block">Office Address</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" id="CST_OfficeAddress" name="CST_OfficeAddress" placeholder="Office Address"
                                                        rows="2">{{ $client->CST_OfficeAddress ?? old('CST_OfficeAddress') }}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="memo" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="col-form-label font-bold text-right" for="CST_Note"
                                                        style="display: block">Note</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" id="CST_Note" name="CST_Note" placeholder="Note" rows="2">{{ $client->CST_Note ?? old('CST_Note') }}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="CST_Note" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        @if (!$update)
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h4><i class="fa fa-file"></i> Contact Person Information</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group remove-class" id="addrow">
                                                <div id="divClientPerson" class="row" index="0">
                                                    <div class="input-group col-md-12 mb-1">
                                                        <input class="form-control" name="CNT_Name[]" id="CNT_Name"
                                                            placeholder="Name" type="text"
                                                            value="{{ old('CNT_Name[]') }}" />
                                                        <input class="form-control" name="CNT_Mobile[]"
                                                            id="CNT_Mobile" placeholder="Mobile " type="number"
                                                            value="{{ old('CNT_Mobile[]') }}" />
                                                        <input class="form-control" name="CNT_Phone1[]"
                                                            id="CNT_Phone1" type="number" placeholder="Alt Phone"
                                                            type="text" value="{{ old('CNT_Phone1[]') }}" />
                                                        <input class="form-control" name="CNT_Email[]" id="CNT_Email"
                                                            placeholder="Email" value="{{ old('CNT_Email[]') }}" />
                                                        <input class="form-control" name="CNT_Department[]"
                                                            id="CNT_Department" placeholder="Department"
                                                            type="text" value="{{ old('CNT_Department[]') }}" />
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <button type="button" onclick="fnAddPersonrow()"
                                                            id="btnaddPerson" value="+"
                                                            class="btn btn-icon btn-success">+</button>
                                                        &nbsp;&nbsp;
                                                        <button type="button" onclick="fnDeletePersonrow('', this)"
                                                            id="btndeletePerson"
                                                            class="hie btn btn-icon btn-danger">x</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <hr />
                                        <div class="form-group">
                                            <div class="card-footer text-right">


                                                <button type="submit" id="btnAddClient ml-2"
                                                    class="btn btn-primary">{{ $update ? 'Update' : 'Save' }}</button>
                                                <a type="button" class="btn btn-danger mr-2"
                                                    href="{{ route('clients') }}">Back</a>
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
            function fnCopyInvoiceAddress() {

                $("#address_invoice").val($("#address_default").val());
                $("#city_invoice").val($("#city_default").val());
                $("#place_invoice").val($("#place_default").val());
                $("#zipcode_invoice").val($("#zipcode_default").val());
                $("#state_invoice").val($("#state_default option:selected").val()).change();
                $("#country_invoice").val($("#country_default option:selected").val()).change();

            }

            function fnAddPersonrow() {
                $('#divClientPerson:last').clone(true).appendTo("#addrow");
            }

            function fnDeletePersonrow(id, ref) {
                //$().parents(".remove-class").remove();
                $(ref).parent().closest('div').remove();

            }
            $('#btnAddClient').on('click', function() {
                $("#frmcreateclient")[0].submit();
            });
        </script>
    @stop
</x-app-layout>
