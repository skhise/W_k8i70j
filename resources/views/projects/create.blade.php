<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$update ? 'Update Project':'Add Project'}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message
                                    </div>')) !!}
                                    @endif
                                </div>
                                <form method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('projects.update',$project->id) : route('projects.store')}}">
                                    @csrf
                                    <div class="form-horizontal">
                                        <h3 style="color:orangered"></h3>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Kategorie</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Category</span>
                                                    @if(!$update)
                                                    <input data-val="true" data-val-required="The Id field is required."
                                                        id="new_project_number" name="new_project_number" type="hidden"
                                                        value="{{$project_number}}" />
                                                    <input data-val="true" data-val-required="The Id field is required."
                                                        id="created_by" name="created_by" type="hidden"
                                                        value="{{Auth::user()->id}}" />
                                                    @endif
                                                    <input data-val="true" data-val-required="The Id field is required."
                                                        id="updated_by" name="updated_by" type="hidden"
                                                        value="{{Auth::user()->id}}" />
                                                </div>
                                                <div class="col-md-3">
                                                    <select
                                                        class="form-control select2 @error('category_id') is-invalid @enderror"
                                                        id="category_id" name="category_id">
                                                        <option value="">-- Select Kategorie --</option>
                                                        @foreach($categories as $category )
                                                        <option value="{{$category->id}}"
                                                            data-prefix="{{$category->category_prefix}}"
                                                            {{old('category_id')==$category->id || $project->category_id
                                                            == $category->id ? 'selected' :''}}
                                                            >
                                                            {{$category->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('category_id'))
                                                    <span id="error_category_id"
                                                        class="text-danger field-validation-valid"
                                                        data-valmsg-for="category_id" data-valmsg-replace="true">
                                                        {{$errors->first('category_id') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Projektnummer</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Number</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input
                                                        class="disabled form-control text-box single-line @error('number') is-invalid @enderror"
                                                        id="number" name="number" placeholder="Number*" type="text"
                                                        value="{{old('number') ?? $project->number}}" />
                                                    @if($errors->has('number'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="number" data-valmsg-replace="true">{{
                                                        $errors->first('number') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Name</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Name</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input
                                                        class="form-control text-box single-line @error('name') is-invalid @enderror"
                                                        id="name" name="name" placeholder="Name*" type="text"
                                                        value="{{old('name') ?? $project->name}}" />
                                                    @if($errors->has('name'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="name" data-valmsg-replace="true">{{
                                                        $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Projekt
                                                        Charakteristisch</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Projekt
                                                        Charakteristisch</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select value="{{old('character_id')}}"
                                                        class="form-control select2 @error('character_id') is-invalid @enderror"
                                                        id="character_id" name="character_id">
                                                        <option value="">-- Select Charakteristisch --</option>
                                                        @if(!empty($charakteristischs))
                                                        @foreach($charakteristischs as $charakteristisch)
                                                        <option value="{{$charakteristisch->id}}" {{ $project->
                                                            character_id == $charakteristisch->id ? 'selected':'' }}>
                                                            {{$charakteristisch->charakteristisch}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    @if($errors->has('character_id'))
                                                    <span id="error_character_id"
                                                        class="text-danger field-validation-valid"
                                                        data-valmsg-for="character_id" data-valmsg-replace="true">{{
                                                        $errors->first('character_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Beschreibung
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Description</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" id="description" name="description"
                                                        rows="3">{{old('description') ?? $project->description}}</textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="description" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Projekt
                                                        Typ</span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Project Type</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select value="{{old('type_id')}}" class="form-control select2"
                                                        id="type_id" name="type_id">
                                                        <option value="">-- Select Projekt Typ --</option>
                                                        @foreach($projectType as $type )
                                                        @if(old('type_id') == $type->id || $project->type_id ==
                                                        $type->id)
                                                        <option value="{{$type->id}}" selected>{{$type->type_name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$type->id}}">{{$type->type_name}}
                                                        </option>
                                                        @endif
                                                        @endforeach

                                                    </select>
                                                    @if($errors->has('type_id'))
                                                    <span id="error_type_id" class="text-danger field-validation-valid"
                                                        data-valmsg-for="type_id" data-valmsg-replace="true">{{
                                                        $errors->first('type_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Projekt Status
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Project Status</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select2"
                                                        value="{{old('project_status')}}" id="project_status"
                                                        name="project_status">
                                                        <option value="">-- Select Projekt Status --</option>
                                                        @foreach($projectStatus as $status)
                                                        @if(old('project_status') == $status->id ||
                                                        $project->project_status == $status->id)
                                                        <option value="{{$status->id}}" selected>{{$status->name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$status->id}}">{{$status->name}}
                                                        </option>
                                                        @endif
                                                        @endforeach

                                                    </select>
                                                    @if($errors->has('project_status'))
                                                    <span id="error_project_status"
                                                        class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_status" data-valmsg-replace="true">{{
                                                        $errors->first('project_status') }}</span>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Projekt Leiter
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Project Leader</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" id="leader_id"
                                                        value="{{old('leader_id')}}" name="leader_id">
                                                        <option value="">-- Select Projekt Leiter --</option>
                                                        @forEach($employees as $employee)
                                                        <option value="{{$employee->id}}"
                                                            {{old('leader_id')==$employee->id ? 'selected' :''
                                                            }} {{$project->leader_id==$employee->id ? 'selected' :''
                                                            }}>{{$employee->full_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Projekt Assistent
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Project Assitant</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" id="assistant_id"
                                                        name="assistant_id">
                                                        <option value="">-- Select Projekt Assistent --</option>
                                                        @forEach($employees as $employee)
                                                        <option value="{{$employee->id}}"
                                                            {{old('assistant_id')==$employee->id ? 'selected' :''
                                                            }} {{$project->assistant_id==$employee->id ? 'selected' :''
                                                            }}>{{$employee->full_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Kunde
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Client</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select
                                                        class="form-control select2 @error('client_id') is-invalid @enderror"
                                                        id="client_id" name="client_id">
                                                        <option value="">-- Select Kunde --</option>
                                                        @foreach($clients as $client)
                                                        <option value="{{$client->id}}" {{old('client_id')==$client->id
                                                            ? 'selected' :''}} {{$project->client_id == $client->id
                                                            ? 'selected' :''}}>
                                                            {{$client->client_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('client_id'))
                                                    <span id="error_client_id"
                                                        class="text-danger field-validation-valid"
                                                        data-valmsg-for="client_id" data-valmsg-replace="true">{{
                                                        $errors->first('client_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    @if(!$update)
                                                    <input type="button" onclick="fnAddClient()" id="addclient"
                                                        value="+" class="btn btn-primary" />
                                                    @endif
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Anmerkungen
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Notes</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <textarea class="form-control" id="note" name="note"
                                                        rows="3">{{old('note') ?? $project->note}}</textarea>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="note" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Anschrift
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Address</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line"
                                                        id="project_address" name="project_address" type="text"
                                                        value="{{old('project_address') ?? $project->project_address}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_address"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Ort
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Place/location</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line" id="project_city"
                                                        name="project_city" type="text"
                                                        value="{{old('project_city') ?? $project->project_city}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_city"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Postleitzahl
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Zip Code</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control text-box single-line"
                                                        id="project_zipcode" name="project_zipcode" type="text"
                                                        value="{{old('project_zipcode') ?? $project->project_zipcode}}" />
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_zipcode"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Bundesland
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Federal state</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" id="project_state"
                                                        name="project_state">
                                                        <option value="">-- Select Bundesland --</option>
                                                        @foreach($states as $state )
                                                        @if(old('project_state') == $state->id ||
                                                        $project->project_state == $state->id)
                                                        <option value="{{$state->id}}" selected>{{$state->state_name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$state->id}}">{{$state->state_name}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_state"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                        Land
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Country</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" id="project_country"
                                                        name="project_country">
                                                        <option value="">-- Select Land --</option>
                                                        @foreach($country as $cntry )
                                                        @if(old('project_country') == $cntry->id ||
                                                        $project->project_country == $cntry->id)
                                                        <option value="{{$cntry->id}}" selected>{{$cntry->country_name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$cntry->id}}">{{$cntry->country_name}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="project_country"
                                                        data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                <input type="submit" id="submit" value="{{$update ? 'Update': 'Save' }}"
                                                    formmethod="post" class="btn btn-primary" />
                                                <a type="button" class="btn btn-danger"
                                                    href="{{route('projects')}}">Back</a>
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

    </div>

    @section('script')
    <script>
        $("input[type = 'text']").each(function () {
            $(this).change(function () {
                $(this).removeClass('is-invalid');
                $(this).siblings('span').text('');
            });
        });
        $(".select2").change(function () {
            var span_id = "error_" + $(this).attr('id');
            console.log(span_id);
            $("#" + span_id).text('');
        });

        $("#category_id").on("change", function () {
            var prefix = $(this).find('option:selected').data('prefix');
            if (typeof prefix != "undefined") {
                var project_number = "{{$project_number}}";
                $("#number").val(prefix + "" + project_number).change();
            }
            var category_id = $(this).find('option:selected').val();

            getcharakteristisch(category_id);
        });

        function getcharakteristisch(category_id) {
            $("#character_id").empty();
            if (category_id != "") {
                $.ajax({
                    type: 'GET',
                    contentType: "application/json; charset=utf-8",
                    url: "{{route('charakteristisch')}}",
                    data: {
                        category_id: category_id
                    },
                    success: function (responce) {
                        if (responce.status) {
                            var data = responce.data;
                            var option = "";
                            data.forEach((row, index) => {
                                var option1 = "<option value='" + row['id'] + "'>" + row[
                                    'charakteristisch'] +
                                    "</option>";
                                option += option1;
                            });
                            $("#character_id").append(option).change();
                        }
                    },
                    error: function (error) {
                        var option = "<option value="
                        ">-- Select Charakteristisch --</option>";
                        $("#character_id").append(option).change();
                        alert("something went wrong, try again");
                    }
                });
            } else {
                var option = "<option value="
                ">-- Select Charakteristisch --</option>";
                $("#character_id").append(option).change();
            }
        }

        $('#client_id').on('change', function () {
            var client_id = $(this).val();
            if (client_id != "") {
                $.ajax({
                    type: 'GET',
                    contentType: "application/json; charset=utf-8",
                    url: "{{route('projects.client_info')}}",
                    data: {
                        id: client_id
                    },
                    success: function (responce) {
                        if (responce.status) {
                            var data = responce.data;
                            $("#project_address").val(data.address_default).change();
                            $("#project_city").val(data.city_default).change();
                            $("#project_zipcode").val(data.zipcode_default).change();
                            $("#project_state").val(data.state_default).change();
                            $("#project_country").val(data.country_default).change();
                        }
                    },
                    error: function (error) {
                        alert("something went wrong, try again");
                    }
                });
            } else {

            }
        });
    </script>
    @stop
</x-app-layout>