<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Services</h4>
                                <div class="card-header-action">
                                    @if (auth()->user()->role == 1)
                                        <a href="{{ route('services.create') }}" class="btn btn-icon icon-left btn-primary">
                                            <i class="fas fa-plus-square"></i> Add Service
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('services') }}" id="search_form_all">
                                            <input type="hidden" name="search_field" value="{{ $search_field }}" id="search_field" />
                                            <div class="buttons d-flex float-left">
                                                <input type="hidden" value="{{ $filter_status }}" name="filter_status" id="filter_status" />
                                                <button data-key="" type="button" class="btn-status-filter btn btn-outline-secondary mr-2 {{ $filter_status === null || $filter_status === '' ? ' active' : '' }}">
                                                    All <span class="badge badge-secondary">{{ $new + $open + $assigned + $pending + $resolved + $closed }}</span>
                                                </button>
                                                <button data-key="1" type="button" class="btn-status-filter btn btn-outline-primary mr-2 {{ $filter_status == 1 ? ' active' : '' }}">
                                                    New <span class="badge badge-primary">{{ $new }}</span>
                                                </button>
                                                <button data-key="2" type="button" class="btn-status-filter btn btn-outline-success mr-2 {{ $filter_status == 2 ? ' active' : '' }}">
                                                    Open <span class="badge badge-success">{{ $open }}</span>
                                                </button>
                                                <button data-key="6" type="button" class="btn-status-filter btn btn-outline-success mr-2 {{ $filter_status == 6 ? ' active' : '' }}">
                                                    Assigned <span class="badge badge-success">{{ $assigned }}</span>
                                                </button>
                                                <button data-key="3" type="button" class="btn-status-filter btn btn-outline-warning mr-2 {{ $filter_status == 3 ? ' active' : '' }}">
                                                    Pending <span class="badge badge-warning">{{ $pending }}</span>
                                                </button>
                                                <button data-key="4" type="button" class="btn-status-filter btn btn-outline-success mr-2 {{ $filter_status == 4 ? ' active' : '' }}">
                                                    Resolved <span class="badge badge-success">{{ $resolved }}</span>
                                                </button>
                                                <button data-key="5" type="button" class="btn-status-filter btn btn-outline-secondary {{ $filter_status == 5 ? ' active' : '' }}">
                                                    Closed <span class="badge badge-secondary">{{ $closed }}</span>
                                                </button>
                                            </div>
                                            <div class="d-flex float-right justify-space-between" style="width:45%;">
                                                <select class="form-control select2 mr-2" id="dayFilter" name="dayFilter">
                                                    <option value="" {{ $dayFilter == '' ? 'selected' : '' }}>Any</option>
                                                    <option value="0" {{ $dayFilter == 0 ? 'selected' : '' }}>Today</option>
                                                    <option value="1" {{ $dayFilter == 1 ? 'selected' : '' }}>Yesterday</option>
                                                    <option value="7" {{ $dayFilter == 7 ? 'selected' : '' }}>Last 7 Days</option>
                                                    <option value="30" {{ $dayFilter == 30 ? 'selected' : '' }}>Last 30 Days</option>
                                                    <option value="60" {{ $dayFilter == 60 ? 'selected' : '' }}>Last 60 Days</option>
                                                    <option value="180" {{ $dayFilter == 180 ? 'selected' : '' }}>Last 180 Days</option>
                                                </select>
                                                <div class="input-group ml-2">
                                                    <input type="text" class="form-control" value="{{ $search }}" id="search" name="search" placeholder="Search" />
                                                    <div class="input-group-append ml-2">
                                                        <button class="btn btn-primary mr-2" type="submit"><i class="fas fa-search fa-lg"></i></button>
                                                        <button class="btn btn-primary filter-dropdown" data-toggle="dropdown"><i class="fas fa-filter fa-lg"></i></button>
                                                        <button class="filter-remove btn btn-danger ml-2"><i class="fa fa-times"></i></button>
                                                        <div class="edit-filter-modal dropdown-menu-right hidden">
                                                            <li class="dropdown-title">Filter By</li>
                                                            <select class="mt-2 select2" name="filter_type" id="filter_type_select">
                                                                <option value="">Type</option>
                                                                <option value="1" {{ $filter_type == 1 ? 'selected' : '' }}>Contracted</option>
                                                                <option value="0" {{ $filter_type == 0 ? 'selected' : '' }}>Non-Contracted</option>
                                                            </select>
                                                            <br />
                                                            <select class="mt-2 select2" name="filter_service_type" id="filter_service_type_select">
                                                                <option value="" selected>Service Type</option>
                                                                @foreach($service_types as $sts)
                                                                    <option value="{{ $sts->id }}" {{ $filter_service_type == $sts->id ? 'selected' : '' }}>{{ $sts->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br />
                                                            <select class="mt-2 select2" name="filter_issue_type" id="filter_issue_type_select">
                                                                <option value="" selected>Issue Type</option>
                                                                @foreach($issue_type as $it)
                                                                    <option value="{{ $it->id }}" {{ $filter_issue_type == $it->id ? 'selected' : '' }}>{{ $it->issue_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select class="mt-2 select2" name="filter_status_type" id="filter_status_type_select">
                                                                <option value="" selected>Status</option>
                                                                @foreach($service_status as $ss)
                                                                    <option value="{{ $ss->Status_Id }}" {{ $filter_status_type == $ss->Status_Id ? 'selected' : '' }}>{{ $ss->Status_Name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                            <button type="button" class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix mb-3"></div>

                            {{-- TABLE VIEW (Desktop & Tablets) --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#Code</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="table-width-20">Customer Name</th>
                                            <th>Issue Type</th>
                                            <th>Last Updated</th>
                                            <th>Assigned To</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($services) == 0)
                                            <tr>
                                                <td colspan="9" class="text-center">No services to show</td>
                                            </tr>
                                        @endif
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>
                                                    @if ($service->wasRecentlyUpdated())
                                                        <i class="fa-spin fa fa-circle" aria-hidden="true"></i>
                                                    @endif
                                                    {{ $service['service_no'] }}
                                                </td>
                                                <td>{{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}</td>
                                                <td>{{ $service['service_date'] != '' ? date('d-M-Y', strtotime($service['service_date'])) : 'NA' }}</td>
                                                <td>{{ $service['CST_Name'] }}</td>
                                                <td>{{ $service['issue_name'] }}</td>
                                                <td>{{ $service['last_updated'] != null ? date('d-M-Y h:i', strtotime($service['last_updated'])) : 'NA' }}</td>
                                                <td>{{ $service['name'] }}</td>
                                                <td>
                                                    <span class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                        {{ $service['Status_Name'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="flex-d">
                                                        <a href="{{ route('services.view', $service['service_id']) }}" class="action-btn btn btn-sm btn-info"><i class="far fa-eye"></i></a>
                                                        @if (auth()->user()->role == 1)
                                                            <a href="{{ route('services.edit', $service['service_id']) }}" class="action-btn btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- MOBILE CARD VIEW (Only on small devices) --}}
                            <div class="d-block d-md-none">
                                @if(count($services) == 0)
                                    <p class="text-center">No services to show</p>
                                @endif
                                @foreach ($services as $service)
                                    <div class="card mb-3 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-1">
                                                #{{ $service['service_no'] }} 
                                                @if ($service->wasRecentlyUpdated())
                                                    <i class="fa-spin fa fa-circle" aria-hidden="true"></i>
                                                @endif
                                            </h5>
                                            <p class="mb-1"><strong>Type:</strong> {{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}</p>
                                            <p class="mb-1"><strong>Date:</strong> {{ $service['service_date'] != '' ? date('d-M-Y', strtotime($service['service_date'])) : 'NA' }}</p>
                                            <p class="mb-1"><strong>Customer:</strong> {{ $service['CST_Name'] }}</p>
                                            <p class="mb-1"><strong>Issue Type:</strong> {{ $service['issue_name'] }}</p>
                                            <p class="mb-1"><strong>Last Updated:</strong> {{ $service['last_updated'] != null ? date('d-M-Y h:i', strtotime($service['last_updated'])) : 'NA' }}</p>
                                            <p class="mb-1"><strong>Assigned To:</strong> {{ $service['name'] }}</p>
                                            <p>
                                                <span class="badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                    {{ $service['Status_Name'] }}
                                                </span>
                                            </p>
                                            <div class="flex-d">
                                                <a href="{{ route('services.view', $service['service_id']) }}" class="action-btn btn btn-sm btn-info"><i class="far fa-eye"></i> View</a>
                                                @if (auth()->user()->role == 1)
                                                    <a href="{{ route('services.edit', $service['service_id']) }}" class="action-btn btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Pagination (same for both views) --}}
                            <div class="float-right mt-2">
                                {{ $services->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .flex-d {
            display: flex;
            gap: 0.4rem;
        }
        .action-btn i {
            margin-right: 0.3rem;
        }
        .edit-filter-modal {
            min-width: 220px;
            padding: 10px;
        }
    </style>
    @section('script')
        <script>
        $(document).ready(function() {
            $('.btn-status-filter').on('click', function() {
                var key = $(this).data('key');
                $('#filter_status').val(key);
                $('#search_form_all').submit();
            });

            $('.filter-remove').on('click', function (e) {
                e.preventDefault(); // Prevent default behavior if it's a link or button
                window.location.href = "{{ route('services') }}";
            });

            $('.filter-dropdown').on('click', function() {
                $(this).siblings('.edit-filter-modal').toggleClass('hidden');
            });
        });
    </script>
    
    @endsection
</x-app-layout>
