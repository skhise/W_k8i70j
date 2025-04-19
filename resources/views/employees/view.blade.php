<x-app-layout>
    <style>
        #toggleButton {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #toggleButton:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Employee Details</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('employees') }}" class="btn btn-icon btn-sm btn-danger">Back</a>
                                    <div class="dropdown d-inline  ml-2">

                                        <button class="btn btn-light dropleft  dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                            More
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-start"
                                            style="position: absolute; transform: translate3d(0px, -133px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            @if (auth()->user()->role == 1)
                                                <a class="dropdown-item has-icon"
                                                    href="{{ route('employees.edit', $employee['EMP_ID']) }}"><i
                                                        class="far fa-edit"></i> Edit</a>
                                                <a class="delete-btn action-btn dropdown-item has-icon"
                                                    href="{{ route('employees.delete', $employee['EMP_ID']) }}"><i
                                                        class="fa fa-trash"></i>
                                                    Delete</a>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="text-uppercase">{{ $employee->EMP_Name }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group ">
                                                    <li class="list-group-item">
                                                        <div class="box-body">

                                                            <strong>
                                                                <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Status
                                                            </strong>
                                                            <div class="emp_status_div">
                                                                {!! $status[$employee['status']] !!}
                                                            </div>
                                                            <hr>
                                                            <strong>
                                                                <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Last
                                                                Login At
                                                            </strong>
                                                            <div class="emp_status_div">
                                                                {{ date('d-M-Y H:i', strtotime($employee['updated_at'])) }}
                                                            </div>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                ID
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{ $employee->EMP_Code }}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                Role
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{ $employee->access_role_name }}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                Designation
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{ $employee->designation_name }}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Qualification

                                                            </strong>
                                                            <p class="text-muted">
                                                                {{ $employee->EMP_Qualification }}
                                                            </p>


                                                        </div>
                                                    </li>
                                                </ul>
                                                <br />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div>
                                                    <h5 class="">Contact Details</h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Mobile</span>
                                                    </div>
                                                    <div class="col-md-9">{{ $employee->EMP_MobileNumber }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Alt Mobile</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $employee->EMP_CompanyMobile }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold;">
                                                            E-Mail
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $employee->EMP_Email }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ; font-weight:bold;">Technical
                                                            Abilities</span>
                                                    </div>
                                                    <div class="col-md-3">{{ $employee->EMP_TechnicalAbilities }}</div>

                                                </div>

                                                <hr />
                                                <div>
                                                    <h5 class="">Login Details</h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Login Name</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $employee->email }}
                                                    </div>

                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Login Status</span>
                                                    </div>
                                                    <div class="col-md-3 emp_status_div" id="emp_status_div">
                                                        {!! $employee->status == 1
                                                            ? '<span class="badge badge-success">Active</span>'
                                                            : '<span class="badge badge-danger">De-active</span>' !!}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="pretty p-switch">
                                                            <input type="checkbox" id="btn_user_status"
                                                                {{ $employee->status == 1 ? 'checked' : '' }} />
                                                            <div class="state p-success">
                                                                <label>Active</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button data-target=".bd-RefPasswordReset-modal-lg"
                                                            data-toggle="modal" type="button"
                                                            class="float-left btn btn-primary">Reset
                                                            Password</button>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div>
                                                    <h5 class="">Address Details</h5>
                                                </div>
                                                <hr />
                                                <div class="row">

                                                    <div class="col-md-3">{{ $employee->EMP_Address }}</div>
                                                </div>
                                                <hr />
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('employees.employee_reset');
    </div>
    @section('script')
        <script>
            $(document).on('click', '#btn_user_status', function() {
                var current_state = $("#btn_user_status").prop('checked');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'are you sure to perform this action?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if ($("#btn_user_status").prop('checked')) {
                            toggleUser(1);
                        } else {
                            toggleUser(2);
                        }
                    } else {
                        window.location.reload();;
                    }
                });

            });

            function toggleUser(status) {
                var userId = "{{ $employee->EMP_ID }}"; // Replace with the actual user ID
                var ref = $(this);
                $.ajax({
                    method: 'POST',
                    url: '{{ route('employees.status_change') }}',
                    data: {
                        userId: userId,
                        status: status
                    },
                    success: function(response) {
                        if (response) {
                            if ($("#btn_user_status").prop('checked')) {
                                $(".emp_status_div").html('<span class="badge badge-success">Active</span>')
                            } else {
                                $(".emp_status_div").html('<span class="badge badge-danger">De-active</span>')
                            }
                            showSuccessSwal("Updated");
                        } else {
                            showErrorSwal("Something went wrong, try again");
                        }
                    },
                    error: function(error) {
                        showErrorSwal("Something went wrong, try again");
                    }
                })
            }
            $(document).on("click", "#btn_password_save", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                var url = '{{ route('employees.setpassword', $employee->EMP_ID) }}';
                var isValid = true;

                // Loop through each input field and validate
                $('#form_password_reset .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_password_save").attr("disabled", false);
                        $("#btn_password_save").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_password_reset").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            if (response.success) {
                                CancelModelBoxPassword();
                                window.location.reload();
                            } else {
                                $("#btn_password_save").attr("disabled", false);
                                $("#btn_password_save").html("Save");
                                $('.errorMsgntainer').html("");
                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_password_save").attr("disabled", false);
                            $("#btn_password_save").html("Save");
                            alert("something went wrong, try again.");
                        }
                    })
                }

            });

            function CancelModelBoxPassword() {
                $("#btn_password_save").attr("disabled", false);
                $("#btn_password_save").html("Save");
                $('.text-danger-error').html('');
                $("#form_password_reset")[0].reset();
                $(".required").removeClass('error_border')
                $("#btn_close_password").trigger('click');
            }
        </script>
    @stop
</x-app-layout>
