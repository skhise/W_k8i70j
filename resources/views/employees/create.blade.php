<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    @if ($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Employee' : 'Add Employee' }}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateemployee" method="post" enctype="multipart/form-data"
                                    action="{{ $update ? route('employees.update', $employee->EMP_ID) : route('employees.store') }}">
                                    @csrf
                                    @if (!$update)
                                        <input type="hidden" id="created_by" name="created_by"
                                            value="{{ Auth::user()->id }}" />
                                        <input type="hidden" id="client_id" name="client_id"
                                            value="{{ Auth::user()->id }}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{ Auth::user()->id }}" />
                                    <input type="hidden" id="account_id" name="account_id"
                                        value="{{ Auth::user()->account_id }}" />
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
                                                    <span style="float:right ;font-weight:bold">Employee</span>
                                                </div>

                                                <div class="col-md-4 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('EMP_Name') is-invalid @enderror"
                                                        data-val="true" id="EMP_Name" name="EMP_Name" placeholder=""
                                                        required="required" type="text"
                                                        value="{{ old('EMP_Name') ?? $employee->EMP_Name }}" />
                                                    <label for="EMP_Name">Name <span
                                                            class="text-danger">*</span></label>
                                                    @if ($errors->has('EMP_Name'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_Name"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_Name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <select name="EMP_Designation"
                                                        class="select2 form-control select2 mr-1" id="EMP_Designation">
                                                        <option value="">Designation</option>
                                                        @foreach ($designations as $designation)
                                                            <option value="{{ $designation->id }}"
                                                                {{ $designation->id == old('EMP_Designation') ? 'selected' : '' }}
                                                                {{ $designation->id == $employee->EMP_Designation ? 'selected' : '' }}>
                                                                {{ $designation->designation_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <!-- <label>Designation</label> -->
                                                    @if ($errors->has('EMP_Designation'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_Designation"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_Designation') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <select name="Access_Role" class="select2 form-control select2 mr-1"
                                                        id="Access_Role">
                                                        <option value="">Access Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                {{ $role->id == old('Access_Role') ? 'selected' : '' }}
                                                                {{ $role->id == $employee->Access_Role ? 'selected' : '' }}>
                                                                {{ $role->access_role_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <!-- <label>Access Role</label> -->
                                                    @if ($errors->has('Access_Role'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="Access_Role"
                                                            data-valmsg-replace="true">{{ $errors->first('Access_Role') }}</span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Employee Contact</span>
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('EMP_MobileNumber') is-invalid @enderror"
                                                        data-val="true" id="EMP_MobileNumber" name="EMP_MobileNumber"
                                                        placeholder="" required="required" type="text"
                                                        onkeypress="return isNumberKey(event)"
                                                        value="{{ old('EMP_MobileNumber') ?? $employee->EMP_MobileNumber }}" />
                                                    <label>Mobile <span class="text-danger">*</span></label>
                                                    @if ($errors->has('EMP_MobileNumber'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_MobileNumber"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_MobileNumber') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('EMP_CompanyMobile') is-invalid @enderror"
                                                        data-val="true" id="EMP_CompanyMobile" name="EMP_CompanyMobile"
                                                        placeholder="" onkeypress="return isNumberKey(event)"
                                                        required="required" type="text"
                                                        value="{{ old('EMP_CompanyMobile') ?? $employee->EMP_CompanyMobile }}" />
                                                    <label>Alternate Mobile</label>
                                                    @if ($errors->has('EMP_CompanyMobile'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="phone"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_CompanyMobile') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('EMP_Email') is-invalid @enderror"
                                                        data-val="true" id="EMP_Email" name="EMP_Email"
                                                        placeholder="" required="required" type="text"
                                                        value="{{ old('EMP_Email') ?? $employee->EMP_Email }}" />
                                                    <label>Email</label>
                                                    @if ($errors->has('EMP_Email'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_Email"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_Email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <!-- <span style="float:right ;font-weight:bold">Employee Contact</span> -->
                                                </div>
                                                <div class="col-md-4">
                                                    <textarea class="form-control text-box single-line @error('EMP_Address') is-invalid @enderror" data-val="true"
                                                        id="EMP_Address" name="EMP_Address" placeholder="" required="required" type="text">{{ old('EMP_Address') ?? $employee->EMP_Address }}</textarea>
                                                    @if ($errors->has('EMP_Address'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_Address"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_Address') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <textarea class="form-control text-box single-line @error('EMP_Qualification') is-invalid @enderror" data-val="true"
                                                        id="EMP_Qualification" name="EMP_Qualification" placeholder="Qualification" required="required" type="text">{{ old('EMP_Qualification') ?? $employee->EMP_Qualification }}</textarea>
                                                    @if ($errors->has('EMP_Qualification'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_Qualification"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_Qualification') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <textarea class="form-control text-box single-line @error('EMP_TechnicalAbilities') is-invalid @enderror"
                                                        data-val="true" id="EMP_TechnicalAbilities" name="EMP_TechnicalAbilities" placeholder="Technical Abilities"
                                                        required="required" type="text">{{ old('EMP_TechnicalAbilities') ?? $employee->EMP_TechnicalAbilities }}</textarea>
                                                    @if ($errors->has('EMP_TechnicalAbilities'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="EMP_TechnicalAbilities"
                                                            data-valmsg-replace="true">{{ $errors->first('EMP_TechnicalAbilities') }}</span>
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
                                                    <select name="EMP_Status" class="form-control select mr-1"
                                                        id="EMP_Status">
                                                        <option value="">Status</option>
                                                        <option value="1"
                                                            {{ old('EMP_Status') == 1 ? 'selected' : '' }}
                                                            {{ $employee->EMP_Status == 1 ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="2"
                                                            {{ old('EMP_Status') == 2 ? 'selected' : '' }}
                                                            {{ $employee->EMP_Status == 2 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="status"
                                                            data-valmsg-replace="true">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 floating-label">

                                                    <input
                                                        class="form-control text-box single-line @error('EMP_Code') is-invalid @enderror"
                                                        data-val="true" id="EMP_Code" name="EMP_Code"
                                                        placeholder="" required="required" type="text"
                                                        value="{{ old('EMP_Code') ?? $employee->EMP_Code }}" />

                                                    <label>EMP Code</label>
                                                </div>
                                                @if ($errors->has('EMP_Code'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="EMP_Code"
                                                        data-valmsg-replace="true">{{ $errors->first('EMP_Code') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            @if (!$update)
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Login</span>
                                                </div>

                                                <div class="col-md-4 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('email') is-invalid @enderror"
                                                        data-val="true" id="email" name="email" placeholder=""
                                                        required="required" type="text"
                                                        value="{{ old('email') }}" />
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    @if ($errors->has('email'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="email"
                                                            data-valmsg-replace="true">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <div class="password-container">
                                                        <input
                                                            class="form-control text-box single-line @error('password') is-invalid @enderror"
                                                            data-val="true" id="password" name="password"
                                                            placeholder="" required="required" type="password"
                                                            value="{{ old('password') }}" />
                                                        <label>Password <span class="text-danger">*</span></label>
                                                        <span id="togglePassword" class="toggle-password"><i
                                                                class="fas fa-eye"></i></span>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger field-validation-valid"
                                                            data-valmsg-for="password"
                                                            data-valmsg-replace="true">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 item-v-center">
                                                    <button type="button" class="btn btn-primary float-left"
                                                        id="generatePasswordBtn">Generate Password</button>
                                                </div>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="card-footer text-right">
                                            <input type="button" id="btnAddEmployee"
                                                value="{{ $update ? 'Update' : 'Save' }}" class="btn btn-primary">
                                            <a type="button" class="btn btn-danger"
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
            $("input[type = 'text']").each(function() {
                $(this).change(function() {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('span').text('');
                });
            });
            $('#btnAddEmployee').on('click', function() {
                $("#frmcreateemployee")[0].submit();
            });
            $(document).ready(function() {
                $('#generatePasswordBtn').click(function() {
                    var password = generatePassword(8); // Change 12 to desired password length
                    $('#password').val(password);
                });
            });

            function generatePassword(length) {
                var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
                var password = "";
                for (var i = 0; i < length; i++) {
                    var randomIndex = Math.floor(Math.random() * charset.length);
                    password += charset[randomIndex];
                }
                return password;
            }
            $('#togglePassword').click(function() {
                var passwordInput = $('#password');
                //const togglePassword = document.querySelector(".password-toggle-icon i");
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find("i").toggleClass('fa-eye fa-eye-slash');
            });
        </script>

    @stop
</x-app-layout>
