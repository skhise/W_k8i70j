<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Management</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i> Create New User
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Filters -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <form method="GET" action="{{ route('customers.index') }}" class="form-inline">
                                            <div class="form-group mr-2 mb-2">
                                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, code..." value="{{ $search }}">
                                            </div>
                                            <div class="form-group mr-2 mb-2">
                                                <select name="filter_role" class="form-control">
                                                    <option value="">All Roles</option>
                                                    <option value="1" {{ $filter_role == '1' ? 'selected' : '' }}>Admin</option>
                                                    <option value="2" {{ $filter_role == '2' ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ $filter_role == '3' ? 'selected' : '' }}>Employee</option>
                                                </select>
                                            </div>
                                            <div class="form-group mr-2 mb-2">
                                                <select name="filter_status" class="form-control">
                                                    <option value="">All Status</option>
                                                    <option value="1" {{ $filter_status == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $filter_status == '0' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Filter</button>
                                            <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-2 ml-2"><i class="fas fa-redo"></i> Reset</a>
                                        </form>
                                    </div>
                                </div>

                                <!-- Success/Error Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
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

                                <!-- Customers Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Company Name</th>
                                                <th>Clients Count</th>
                                                <th>Employees Count</th>
                                                <th>Allowed Users</th>
                                                <th>Role</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($customers as $customer)
                                                <tr>
                                                    <td>{{ $customer->id }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->company_name ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $customer->client_count ?? 0 }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $customer->employee_count ?? 0 }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $customer->allowed_users ?? 0 }}</span>
                                                    </td>
                                                    <td>
                                                        @if($customer->role == 1)
                                                            <span class="badge badge-danger">Admin</span>
                                                        @elseif($customer->role == 2)
                                                            <span class="badge badge-info">Customer</span>
                                                        @elseif($customer->role == 3)
                                                            <span class="badge badge-warning">Employee</span>
                                                        @else
                                                            <span class="badge badge-secondary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                                                    <td>
                                                        @if($customer->status == 1)
                                                            {!! $status['1'] !!}
                                                        @else
                                                            {!! $status['2'] !!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Reset Password Button -->
                                                            <button type="button" class="btn btn-warning btn-sm" onclick="resetPassword({{ $customer->id }}, '{{ $customer->email }}')" title="Reset Password to 123456">
                                                                <i class="fas fa-key"></i>
                                                            </button>

                                                            <!-- Toggle Status Button -->
                                                            @if($customer->status == 1)
                                                                <button type="button" class="btn btn-danger btn-sm ml-1" onclick="updateStatus({{ $customer->id }}, 0, '{{ $customer->email }}')" title="Deactivate User">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-success btn-sm ml-1" onclick="updateStatus({{ $customer->id }}, 1, '{{ $customer->email }}')" title="Activate User">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No customers found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @section('script')
    <script>
        function resetPassword(userId, userEmail) {
            Swal.fire({
                title: 'Reset Password?',
                text: `Reset password to default (123456) for ${userEmail}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/customers/${userId}/reset-password`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to reset password. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545',
                            });
                        }
                    });
                }
            });
        }

        function updateStatus(userId, status, userEmail) {
            const action = status == 1 ? 'activate' : 'deactivate';
            Swal.fire({
                title: `${action.charAt(0).toUpperCase() + action.slice(1)} User?`,
                text: `Are you sure you want to ${action} ${userEmail}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: status == 1 ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/customers/${userId}/update-status`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update status. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545',
                            });
                        }
                    });
                }
            });
        }
    </script>
    @endsection
</x-app-layout>

