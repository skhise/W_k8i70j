<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Defective Inwards/Repairs</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('repairinwards.create') }}" class="btn btn-icon icon-left btn-primary">
                                        <i class="fas fa-plus-square"></i> New
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
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

                                <div class="form-horizontal">
                                    <form id="repair_inward_filter">
                                        <div class="form-group">
                                            <div class="row mb-2">
                                                <div class="col-md-2">
                                                    <label>Days Filter</label>
                                                    <select class="form-control" id="days_filter" name="days_filter">
                                                        <option value="any" {{ (isset($days_filter) && $days_filter == 'any') ? 'selected' : '' }}>Any</option>
                                                        <option value="30" {{ (!isset($days_filter) || $days_filter == '30') ? 'selected' : '' }}>Last 30 Days</option>
                                                        <option value="60" {{ (isset($days_filter) && $days_filter == '60') ? 'selected' : '' }}>Last 60 Days</option>
                                                        <option value="90" {{ (isset($days_filter) && $days_filter == '90') ? 'selected' : '' }}>Last 90 Days</option>
                                                        <option value="180" {{ (isset($days_filter) && $days_filter == '180') ? 'selected' : '' }}>Last 180 Days</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Search</label>
                                                    <input type="text" class="form-control" value="{{ $search }}" id="search" name="search" placeholder="Search">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Select Status</label>
                                                    <select class="select2 form-control" id="status_filter" name="status">
                                                        <option value="all" {{ $filter_status == 'all' ? 'selected' : '' }}>All</option>
                                                        @foreach($repairStatuses as $status)
                                                            <option value="{{ $status->id }}" {{ $filter_status == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex mt-4">
                                                        <button class="action-btn btn-fetch-report btn btn-primary" type="button">Generate</button>
                                                        <button class="action-btn btn-light btn-export btn ml-2" type="button">Export</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="repair-inward-table">
                                        <thead>
                                            <tr>
                                                <th>Defective No.</th>
                                                <th>Defective Date</th>
                                                <th>Customer Name</th>
                                                <th>Products</th>
                                                <th>Ticket No.</th>
                                                <th>Status/Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="repairInwardList">
                                            @if (isset($repairInwards) && $repairInwards)
                                                @include('repairinward.pagination')
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center">Click Generate to load data</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
        function fetchRepairInwardData(page = null) {
            var search = $("#search").val();
            var status = $("#status_filter option:selected").val();
            var daysFilter = $("#days_filter option:selected").val();
            var data = {
                search: search,
                status: status,
                days_filter: daysFilter,
            };
            
            if (page) {
                data.page = page;
            }
            
            $.ajax({
                type: "GET",
                url: "{{ route('repairinwards.get-data') }}",
                data: data,
                beforeSend: function() {
                    $(".loader").show();
                },
                success: function(html) {
                    $("#repairInwardList").empty();
                    $("#repairInwardList").append(html);
                    $(".loader").hide();
                },
                error: function(error) {
                    $(".loader").hide();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong, try again',
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
                }
            });
        }

        $(document).on("click", ".btn-fetch-report", function() {
            fetchRepairInwardData();
        });

        $(document).on("click", ".btn-export", function() {
            var search = $("#search").val();
            var status = $("#status_filter option:selected").val();
            var daysFilter = $("#days_filter option:selected").val();
            
            // Build URL with query parameters
            var url = "{{ route('repairinwards.export') }}";
            var params = [];
            if (daysFilter) {
                params.push('days_filter=' + encodeURIComponent(daysFilter));
            }
            if (search) {
                params.push('search=' + encodeURIComponent(search));
            }
            if (status && status !== 'all') {
                params.push('status=' + encodeURIComponent(status));
            }
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            // Create a temporary form to submit
            var form = document.createElement('form');
            form.method = 'GET';
            form.action = url;
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });

        // Handle pagination links
        $(document).on("click", ".pagination a", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url) {
                // Extract page number from URL
                var match = url.match(/page=(\d+)/);
                var page = match ? match[1] : null;
                fetchRepairInwardData(page);
            }
        });

        // Auto-load data on page load with default last 30 days
        $(document).ready(function() {
            // Always load data on page load (with default last 30 days)
            fetchRepairInwardData();
        });
    </script>
    @stop
</x-app-layout>

