<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$update ?'Update Client' :'Add Client'}}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateclient" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('clients.update', $client->id) : route('clients.store')}}">
                                    @csrf
                                    @if(!$update)
                                    <input type="hidden" id="created_by" name="created_by"
                                        value="{{Auth::user()->id}}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="client_code" name="client_code"
                                        value="{{$client->client_code ?? $client_code}}" />
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
                                            <div class="row">@if($errors->any())
                                                {!! implode('', $errors->all('<div class="alert alert-danger">:message
                                                </div>')) !!}
                                                @endif</div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Kunde
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Client Name</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <input
                                                        class="form-control text-box single-line @error('client_name') is-invalid @enderror"
                                                        data-val="true"
                                                        data-val-required="The ClientName field is required."
                                                        id="client_name" name="client_name" placeholder="Kunde *"
                                                        required="required" type="text"
                                                        value="{{$client->client_name ?? old('client_name')}}" />
                                                    @if($errors->has('client_name'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="client_name" data-valmsg-replace="true">{{
                                                        $errors->first('client_name') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="col-form-label font-bold text-right">
                                                        <input id="customer_type_1" name="customer_type" text="Business"
                                                            type="radio" value="1" {{$client->customer_type == 1 ?
                                                        "checked" :''}} />
                                                        <label for="customer_type_1">Business</label>
                                                        &nbsp;&nbsp;
                                                    </span>
                                                    <span class="col-form-label font-bold text-right">
                                                        <input id="customer_type_2" name="customer_type"
                                                            text="Individual" type="radio" value="2"
                                                            {{$client->customer_type == 2 ?
                                                        "checked" :''}} />
                                                        <label for="customer_type_2">Individual</label>
                                                        &nbsp;&nbsp;
                                                    </span><br />
                                                    @if($errors->has('customer_type'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="customer_type" data-valmsg-replace="true">{{
                                                        $errors->first('customer_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Customer
                                                        Type</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Kundentyp</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select
                                                        class="form-control @error('client_type') is-invalid @enderror select2"
                                                        id="client_type" name="client_type">
                                                        <option value="">-- Select CustomerType --</option>
                                                        @foreach($customer_type as $cstype )
                                                        <option value="{{$cstype->id}}" {{$cstype->id ==
                                                            old('client_type') ? 'selected' : ''}} {{$cstype->id ==
                                                            $client->client_type ? 'selected' : ''}}>
                                                            {{$cstype->type_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('client_type'))
                                                    <span class=" text-danger field-validation-valid"
                                                        data-valmsg-for="client_type" data-valmsg-replace="true">
                                                        {{ $errors->first('client_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Telefon</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Telphone</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="phone	" min="0"
                                                        name="phone" placeholder="Telefon" step="1" type="number"
                                                        value="{{$client->phone ?? old('phone')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="phone" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="phone_alt"
                                                        min="0" name="phone_alt" placeholder="Telefon 2" step="1"
                                                        type="number"
                                                        value="{{$client->phone_alt ??  old('phone_alt')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="phone_alt" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="fax" name="fax"
                                                        placeholder="Fax" type="text"
                                                        value="{{$client->fax ?? old('fax')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="fax" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Webseite</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Website</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="website"
                                                        name="website" placeholder="Webseite" type="text"
                                                        value="{{$client->website ?? old('website')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="website" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="email"
                                                        name="email" placeholder="Abrechnung Per E-Mail" type="text"
                                                        value="{{$client->email ?? old('email')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="email" data-valmsg-replace="true"></span>
                                                </div>

                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="email_alt"
                                                        name="email_alt" placeholder="E-Mail" type="text"
                                                        value="{{$client->email_alt ?? old('email_alt')}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="email_alt" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="col-form-label font-bold text-right" for="Memo"
                                                        style="display: block">Memo</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <textarea class="form-control" id="memo" name="memo"
                                                        placeholder="Memo"
                                                        rows="4">{{$client->memo ?? old('memo')}}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="memo" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <textarea class="form-control" id="description" name="description"
                                                        placeholder="Anmerkungen"
                                                        rows="4">{{$client->description ?? old('description')}}</textarea>
                                                    </textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="description" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        @if(!$update)
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-file"></i> Contact Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group remove-class" id="addrow">
                                            <div id="divClientPerson" class="row" index="0">
                                                <div class="input-group col-md-12 mb-1">
                                                    <select class="form-control select" value="{{old('phone')}}"
                                                        name="cp_prefix[]" id="prefix">
                                                        <option value="1">Mr.</option>
                                                        <option value="2">Mrs.</option>
                                                        <option value="4">Miss.</option>
                                                        <option value="5">Dr.</option>
                                                        <option value="3">Ms.</option>
                                                    </select>
                                                    <input class="form-control" name="cp_first_name[]" id="first_name"
                                                        placeholder="Vorname" type="text" value="{{old('phone')}}" />
                                                    <input class="form-control" name="cp_last_name[]" id="last_name"
                                                        placeholder="Nachname " type="text" value="{{old('phone')}}" />
                                                    <input class="form-control" name="cp_email[]" id="email"
                                                        placeholder="Email" type="text" value="{{old('phone')}}" />
                                                    <input class="form-control" name="cp_work_phone[]" id="work_phone"
                                                        placeholder="Arbeitshandy" type="number"
                                                        value="{{old('phone')}}" />
                                                    <input class="form-control" name="cp_mobile[]" id="mobile"
                                                        placeholder="Mobiltelefon" type="number"
                                                        value="{{old('cp_mobile[]')}}" />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="button" onclick="fnAddPersonrow()" id="btnaddPerson"
                                                        value="+" class="btn btn-icon btn-success" />
                                                    &nbsp;&nbsp;
                                                    <input type="button" onclick="fnDeletePersonrow('', this)"
                                                        id="btndeletePerson" value="x"
                                                        class="hie btn btn-icon btn-danger" />
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        @endif
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4 class="">
                                                        <i class="fa fa-location-arrow"></i> Addres Information(Adresse)
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Anschrift</span>
                                                                    <br />
                                                                    <span style="float:right ;font-weight:bold">Default
                                                                        Address</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <textarea class="form-control" id="address_default"
                                                                        name="address_default" placeholder="Anschrift"
                                                                        rows="4">{{$client->address_default ?? old('address_default')}}</textarea>
                                                                    </textarea>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="address_default"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Stadt</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">City</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="city_default" name="city_default"
                                                                        placeholder="Stadt" type="text"
                                                                        value="{{$client->city_default ?? old('city_default')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="city_default"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Ort</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Place/location</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="place_default" name="place_default"
                                                                        placeholder="Ort" type="text"
                                                                        value="{{$client->place_default ?? old('place_default')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="place_default"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Postleitzahl</span>
                                                                    <br />
                                                                    <span style="float:right ;font-weight:bold">Zip Code
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="zipcode_default" name="zipcode_default"
                                                                        placeholder="Postleitzahl" type="text"
                                                                        value="{{$client->zipcode_default ?? old('zipcode_default')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="zipcode_default"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Bundesland</span>
                                                                    <br />
                                                                    <span style="float:right ;font-weight:bold">Federal
                                                                        State </span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control select2"
                                                                        id="state_default" name="state_default"
                                                                        value="">
                                                                        <option value="">-- Select State --</option>
                                                                        @foreach($states as $state )
                                                                        <option value="{{$state->id}}" {{$state->id ==
                                                                            old('state_default') ? "selected" :
                                                                            ""}} {{$state->id ==
                                                                            $client->state_default ? "selected" :
                                                                            ""}}>{{$state->state_name}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="state_default"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Land</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Country</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control select2"
                                                                        value="{{old('country_default')}}"
                                                                        id="country_default" name="country_default">
                                                                        <option value="">-- Select Country --</option>
                                                                        @foreach($country as $cntry )
                                                                        <option value="{{$cntry->id}}" {{$cntry->id ==
                                                                            old('country_default') ? "selected" :
                                                                            ""}} {{$cntry->id ==
                                                                            $client->country_default ? "selected" :
                                                                            ""}}>{{$cntry->country_name}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="CountryId"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        @if(!$update)
                                                                        <button type="button"
                                                                            onclick="fnCopyInvoiceAddress()"
                                                                            title=" Same as Billing Address"
                                                                            class="btn btn-icon btn-sm btn-dark"><i
                                                                                class="fas fa-file"></i></button>
                                                                        @endif
                                                                        <span
                                                                            style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Invoice
                                                                            Anschrift</span>
                                                                        <br />
                                                                        <span
                                                                            style="float:right ;font-weight:bold">Invoice
                                                                            Address</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <textarea class="form-control" id="address_invoice"
                                                                        name="address_invoice"
                                                                        placeholder="Invoice Anschrift"
                                                                        rows="4">{{$client->address_invoice ?? old('address_invoice')}}</textarea>
                                                                    </textarea>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="address_invoice"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Stadt</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">City</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="city_invoice" name="city_invoice"
                                                                        placeholder="Stadt" type="text"
                                                                        value="{{$client->city_invoice ?? old('city_invoice')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="city_invoice"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Ort</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Place/location</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="place_invoice" name="place_invoice"
                                                                        placeholder="Ort" type="text"
                                                                        value="{{$client->place_invoice ?? old('place_invoice')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="place_invoice"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Postleitzahl</span>
                                                                    <br />
                                                                    <span style="float:right ;font-weight:bold">Zip Code
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input class="form-control text-box single-line"
                                                                        id="zipcode_invoice" name="zipcode_invoice"
                                                                        placeholder="Postleitzahl" type="text"
                                                                        value="{{$client->zipcode_invoice ?? old('zipcode_invoice')}}" />
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="zipcode_invoice"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Bundesland</span>
                                                                    <br />
                                                                    <span style="float:right ;font-weight:bold">Federal
                                                                        State </span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control select2"
                                                                        value="{{old('state_invoice')}}"
                                                                        id="state_invoice" name="state_invoice">
                                                                        <option value="">-- Select State --</option>
                                                                        @foreach($states as $state )
                                                                        <option value="{{$state->id}}" {{$state->id ==
                                                                            old('state_invoice') ? "selected" :
                                                                            ""}} {{$state->id ==
                                                                            $client->state_invoice ? "selected" :
                                                                            ""}}>{{$state->state_name}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="state_invoice"
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <span
                                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Land</span>
                                                                    <br />
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Country</span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control select2"
                                                                        value="{{old('country_invoice')}}"
                                                                        id="country_invoice" name="country_invoice">
                                                                        <option value="">-- Select Country --</option>
                                                                        @foreach($country as $cntry )
                                                                        <option value="{{$cntry->id}}" {{$cntry->id ==
                                                                            old('country_invoice') ? "selected" :
                                                                            ""}} {{$cntry->id ==
                                                                            $client->country_invoice ? "selected" :
                                                                            ""}}>{{$cntry->country_name}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid"
                                                                        data-valmsg-for="country_invoice    "
                                                                        data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <hr />

                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                <input type="button" id="btnAddClient"
                                                    value="{{$update ? 'Update' : 'Save'}}" class="btn btn-primary">
                                                <a type="button" class="btn btn-danger"
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
    </script>
    @section('script')
    <script>
        $('#btnAddClient').on('click', function () {
            $("#frmcreateclient")[0].submit();
        });
    </script>

    @stop
</x-app-layout>