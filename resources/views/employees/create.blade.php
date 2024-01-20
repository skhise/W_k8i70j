<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Employee' : 'Add Employee'}}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateemployee" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('employees.update',$employee->id) : route('employees.store')}}">
                                    @csrf
                                    @if(!$update)
                                    <input type="hidden" id="created_by" name="created_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="client_id" name="client_id" value="{{Auth::user()->id}}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="account_id" name="account_id"
                                        value="{{Auth::user()->account_id}}" />
                                    <div class="form-horizontal">

                                        <h3 style="color:orangered"></h3>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Employee Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span
                                                        style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Employee
                                                    </span>
                                                    <br />
                                                    <span style="float:right ;font-weight:bold">Employee Name</span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <select name="prefix" class="form-control select mr-1"
                                                            id="prefix">
                                                            <option value="5" {{old('prefix')==5 ? 'selected' :''}}
                                                                {{$employee->prefix == 5 ? 'selected':''}}>Dr.</option>
                                                            <option value="4" {{old('prefix')==4 ? 'selected' :''}}
                                                                {{$employee->prefix == 4 ? 'selected':''}}>Miss.
                                                            </option>
                                                            <option value="1" {{old('prefix')==1 ? 'selected' :''}}
                                                                {{$employee->prefix == 1 ? 'selected':''}}>Mr.</option>
                                                            <option value="2" {{old('prefix')==2 ? 'selected' :''}}
                                                                {{$employee->prefix == 2 ? 'selected':''}}>Mrs.</option>
                                                            <option value="3" {{old('prefix')==3 ? 'selected' :''}}
                                                                {{$employee->prefix == 3 ? 'selected':''}}>Ms.</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input
                                                        class="form-control text-box single-line @error('first_name') is-invalid @enderror"
                                                        data-val="true" id="first_name" name="first_name"
                                                        placeholder="Name *" required="required" type="text"
                                                        value="{{old('first_name') ?? $employee->first_name}}" />
                                                    @if($errors->has('first_name'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="first_name" data-valmsg-replace="true">{{
                                                        $errors->first('first_name') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input class="form-control text-box single-line"
                                                            name="last_name" id="last_name" placeholder="Nachname "
                                                            type="text"
                                                            value="{{old('last_name')  ?? $employee->last_name}}" />
                                                        @if($errors->has('last_name'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="last_name" data-valmsg-replace="true">{{
                                                            $errors->first('last_name') }}</span>

                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Employee Info</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input
                                                        class="disable form-control text-box single-line @error('emp_id') is-invalid @enderror"
                                                        data-val="true" id="emp_id" name="emp_id"
                                                        placeholder="Employee Id *" required="required" type="text"
                                                        value="{{old('emp_id') ?? $emp_id}}" />
                                                    @if($errors->has('emp_id'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="emp_id" data-valmsg-replace="true">{{
                                                        $errors->first('emp_id') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="role" class="form-control select2 mr-1" id="role">
                                                        <option value="">Role</option>
                                                        @foreach($roles as $role)
                                                        <option value="{{$role->id}}" {{$role->id ==
                                                            old('role') ? 'selected' :
                                                            ''}} {{$role->id ==
                                                            $employee->role ? 'selected' :
                                                            ''}}>{{$role->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('role'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="role" data-valmsg-replace="true">{{
                                                        $errors->first('role') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="qualification" class="form-control select2 mr-1"
                                                        id="qualification">
                                                        <option value="">Qualification</option>
                                                        @foreach($qualifications as $qualification)
                                                        <option value="{{$qualification->id}}" {{$qualification->id ==
                                                            old('qualification') ? 'selected' :
                                                            ''}} {{$qualification->id ==
                                                            $employee->qualification ? 'selected' :
                                                            ''}}>
                                                            {{$qualification->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('qualification'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="qualification" data-valmsg-replace="true">{{
                                                        $errors->first('qualification') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Employee Contact</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <input
                                                        class="form-control text-box single-line @error('phone') is-invalid @enderror"
                                                        data-val="true" id="phone" name="phone" placeholder="Phone *"
                                                        required="required" type="text"
                                                        onkeypress="return isNumberKey(event)"
                                                        value="{{old('phone') ?? $employee->phone}}" />
                                                    @if($errors->has('phone'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="phone" data-valmsg-replace="true">{{
                                                        $errors->first('phone') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <input
                                                        class="form-control text-box single-line @error('phone_1') is-invalid @enderror"
                                                        data-val="true" id="phone_1" name="phone_1"
                                                        placeholder="Phone Alt *" onkeypress="return isNumberKey(event)"
                                                        required="required" type="text"
                                                        value="{{old('phone_1') ?? $employee->phone_1}}" />
                                                    @if($errors->has('phone_1'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="phone" data-valmsg-replace="true">{{
                                                        $errors->first('phone_1') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <input
                                                        class="form-control text-box single-line @error('emp_email') is-invalid @enderror"
                                                        data-val="true" id="emp_email" name="emp_email"
                                                        placeholder="Email *" required="required" type="text"
                                                        value="{{old('emp_email') ?? $employee->emp_email}}" />
                                                    @if($errors->has('emp_email'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="emp_email" data-valmsg-replace="true">{{
                                                        $errors->first('emp_email') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <!-- <span style="float:right ;font-weight:bold">Employee Contact</span> -->
                                                </div>
                                                <div class="col-md-5">
                                                    <textarea
                                                        class="form-control text-box single-line @error('address') is-invalid @enderror"
                                                        data-val="true" id="address" name="address"
                                                        placeholder="Address *" required="required"
                                                        type="text">{{old('address') ?? $employee->address}}</textarea>
                                                    @if($errors->has('address'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="address" data-valmsg-replace="true">{{
                                                        $errors->first('address') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-5">
                                                    <textarea
                                                        class="form-control text-box single-line @error('memo') is-invalid @enderror"
                                                        data-val="true" id="memo" name="memo" placeholder="Memo *"
                                                        required="required"
                                                        type="text">{{old('memo') ?? $employee->memo}}</textarea>
                                                    @if($errors->has('memo'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="memo" data-valmsg-replace="true">{{
                                                        $errors->first('memo') }}</span>

                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Status</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="status" class="form-control select mr-1" id="status">
                                                        <option value="">Status</option>
                                                        <option value="1" {{old('status')==1 ? 'selected' : '' }}
                                                            {{$employee->status==1 ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="2" {{old('status')==2 ? 'selected' : '' }}
                                                            {{$employee->status==2 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                    @if($errors->has('status'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="status" data-valmsg-replace="true">{{
                                                        $errors->first('status') }}</span>

                                                    @endif
                                                </div>
                                                @if(!$update)
                                                <div class="col-md-4">
                                                    <input
                                                        class="form-control text-box single-line @error('email') is-invalid @enderror"
                                                        data-val="true" id="email" name="email" placeholder="Username *"
                                                        required="required" type="text" value="{{old('email')}}" />
                                                    @if($errors->has('email'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="email" data-valmsg-replace="true">{{
                                                        $errors->first('email') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <input
                                                        class="form-control text-box single-line @error('password') is-invalid @enderror"
                                                        data-val="true" id="password" name="password"
                                                        placeholder="Password *" required="required" type="password"
                                                        value="{{old('password')}}" />
                                                    @if($errors->has('password'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="password" data-valmsg-replace="true">{{
                                                        $errors->first('password') }}</span>

                                                    @endif
                                                </div>
                                                @endif


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                <input type="button" id="btnAddEmployee"
                                                    value="{{$update ? 'Update' :'Save'}}" class="btn btn-primary">
                                                <a type="button" class="btn btn-primary"
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
        $("input[type = 'text']").each(function () {
            $(this).change(function () {
                $(this).removeClass('is-invalid');
                $(this).siblings('span').text('');
            });
        });
        $('#btnAddEmployee').on('click', function () {
            $("#frmcreateemployee")[0].submit();
        });
    </script>

    @stop
</x-app-layout>