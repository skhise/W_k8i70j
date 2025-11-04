<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New User</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Validation Errors:</strong>
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('customers.store') }}" id="createUserForm">
                                            @csrf

                                            <!-- Name -->
                                            <div class="form-group">
                                                <label for="name">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name') }}" 
                                                       required 
                                                       placeholder="Enter full name"
                                                       autofocus>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group">
                                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" 
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       required 
                                                       placeholder="Enter email address">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">This will be used for login</small>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" 
                                                           name="password" 
                                                           required 
                                                           minlength="6"
                                                           placeholder="Enter password (min 6 characters)">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Minimum 6 characters required</small>
                                            </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                            <!-- Role -->
                                            <div class="form-group">
                                                <label for="role">User Role <span class="text-danger">*</span></label>
                                                <select class="form-control @error('role') is-invalid @enderror" 
                                                        id="role" 
                                                        name="role" 
                                                        required>
                                                    <option value="">-- Select Role --</option>
                                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>
                                                        Admin (Full Access)
                                                    </option>
                                                    <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>
                                                        Customer
                                                    </option>
                                                    <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>
                                                        Employee
                                                    </option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">
                                                    <strong>Admin:</strong> Full system access<br>
                                                    <strong>Customer:</strong> Limited access for clients<br>
                                                    <strong>Employee:</strong> Staff access for field operations
                                                </small>
                                            </div>

                                            <!-- Status -->
                                            <div class="form-group">
                                                <label for="status">Status <span class="text-danger">*</span></label>
                                                <select class="form-control @error('status') is-invalid @enderror" 
                                                        id="status" 
                                                        name="status" 
                                                        required>
                                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Alert Box for Admin -->
                                            <div class="alert alert-warning" id="superAdminWarning" style="display: none;">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <strong>Warning:</strong> You are creating an Admin account. This user will have full access to all system features.
                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <!-- Submit Buttons -->
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                                <i class="fas fa-user-plus"></i> Create User
                                            </button>
                                            <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-lg ml-2">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
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
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Show warning when Super Admin is selected
            $('#role').on('change', function() {
                if ($(this).val() === '1') {
                    $('#superAdminWarning').slideDown();
                } else {
                    $('#superAdminWarning').slideUp();
                }
            });

            // Show warning on page load if Super Admin is already selected
            if ($('#role').val() === '1') {
                $('#superAdminWarning').show();
            }

            // Form submission with confirmation for Super Admin
            $('#createUserForm').on('submit', function(e) {
                const role = $('#role').val();
                
                if (role === '1') {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Create Super Admin?',
                        html: 'You are about to create a <strong>Super Admin</strong> account.<br><br>This user will have full system access including:<br>- Customer Management<br>- User Control<br>- System Settings<br><br>Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, create Super Admin!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Disable submit button to prevent double submission
                            $('#submitBtn').attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
                            // Submit the form
                            this.submit();
                        }
                    });
                    
                    return false;
                } else {
                    // For non-admin roles, disable button and allow submission
                    $('#submitBtn').attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
                }
            });
        });
    </script>
    @endsection
</x-app-layout>


