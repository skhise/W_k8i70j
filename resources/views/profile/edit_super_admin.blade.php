<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card author-box">
                            <div class="card-body">
                                <div class="author-box-center">
                                    <img alt="image" src="{{asset('img/logo.png')}}"
                                        class="rounded-circle author-box-picture">
                                        
                                    <div class="clearfix"></div>
                                    <div class="author-box-name mt-3">
                                        <a href="#">Super Admin</a>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Personal Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="py-4">
                                    <p class="clearfix">
                                        <span class="float-left">
                                            Name
                                        </span>
                                        <span class="float-right text-muted">
                                        {{Auth::user()->name}}
                                        </span>
                                    </p>
                                    <p class="clearfix">
                                        <span class="float-left">
                                            Email
                                        </span>
                                        <span class="float-right text-muted">
                                            {{Auth::user()->email}}
                                        </span>
                                    </p>
                                    <p class="clearfix">
                                        <span class="float-left">
                                            Role
                                        </span>
                                        <span class="float-right text-muted">
                                            <span class="badge badge-primary">Super Admin</span>
                                        </span>
                                    </p>
                                    <p class="clearfix mt-4">
                                        <button data-target=".bd-RefPasswordReset-modal-lg"
                                                data-toggle="modal" type="button"
                                                class="btn btn-primary btn-block">
                                            <i class="fas fa-key"></i> Change Password
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Account Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h5 class="alert-heading"><i class="fas fa-info-circle"></i> Super Admin Account</h5>
                                    <p class="mb-0">
                                        As a Super Admin, you have access to manage all admin users (role 1). 
                                        You can view, create, edit, and delete admin users from the Customers menu.
                                    </p>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="mb-3">Quick Actions</h6>
                                        <div class="list-group">
                                            <a href="{{ route('customers.index') }}" class="list-group-item list-group-item-action">
                                                <i class="fas fa-users"></i> Manage Customers (Admin Users)
                                            </a>
                                            <a href="{{ route('customers.create') }}" class="list-group-item list-group-item-action">
                                                <i class="fas fa-user-plus"></i> Create New Admin User
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="mb-3">Account Details</h6>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">User ID</th>
                                                    <td>{{ $user->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email Address</th>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Account Status</th>
                                                    <td>
                                                        @if($user->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created On</th>
                                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i A') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        @include('profile.change_password')
    </div>

    @section('script')
    <script>
        $(document).on("click", "#btn_password_save", function() {
            $('.text-danger-error').html('');
            $(this).attr("disabled", true);
            $(this).html("Saving...");
            var url = '{{ route('profile.change-password') }}';
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
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Password changed successfully',
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                            }).then(() => {
                                CancelModelBoxPassword();
                            });
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
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong, try again',
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                        });
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

        // Toggle password visibility
        $(document).on('click', '#togglePassword', function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    </script>
    @endsection
</x-app-layout>

