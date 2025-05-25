<x-app-layout>
    <style>
        .banner-img {
            top: 20%;
            position: relative;
            float: right;
        }

        @media (max-width: 767px) {
            .banner-img {
                float: none;
                text-align: center;
                margin-top: 10px;
            }

            .card-content {
                text-align: center;
            }
        }
        @media (max-width: 767px) {
        .hide-on-mobile {
            display: none !important;
        }
    }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="row">
                {{-- Ticket Summary Cards --}}
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                    <a href="{{ route('services') }}?search_field=Assigned" style="text-decoration: none;">

                    <div class="card text-white bg-primary">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="card-content">
                                <h5 class="font-15">New Assigned Tickets</h5>
                                <h2 class="mb-0 font-18">{{ $new_ticket ?? 0 }}</h2>
                            </div>
                            <div class="banner-img">
                                <i class="fa fa-ticket-alt fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                <a href="{{ route('services') }}?search_field=Open" style="text-decoration: none;">

                    <div class="card text-white bg-info">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="card-content">
                                <h5 class="font-15">Open Tickets</h5>
                                <h2 class="mb-0 font-18">{{ $open_ticket ?? 0 }}</h2>
                            </div>
                            <div class="banner-img">
                                <i class="fa fa-spinner fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                <a href="{{ route('services') }}?search_field=Pending" style="text-decoration: none;">

                    <div class="card text-white bg-info">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="card-content">
                                <h5 class="font-15">Pending Tickets</h5>
                                <h2 class="mb-0 font-18">{{ $pending_ticket ?? 0 }}</h2>
                            </div>
                            <div class="banner-img">
                                <i class="fa fa-spinner fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                    <a href="{{ route('services') }}?search_field=Pending" style="text-decoration: none;">
                    <div class="card text-white bg-success">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="card-content">
                                <h5 class="font-15">Resolved Tickets</h5>
                                <h2 class="mb-0 font-18">{{ $resolved_ticket ?? 0 }}</h2>
                            </div>
                            <div class="banner-img">
                                <i class="fa fa-check-circle fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="card-content">
                                <h5 class="font-15">Closed Tickets</h5>
                                <h2 class="mb-0 font-18">{{ $closed_ticket ?? 0 }}</h2>
                            </div>
                            <div class="banner-img">
                                <i class="fa fa-times-circle fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔻 Your existing service list table starts here - Unchanged --}}
            <div class="row  hide-on-mobile">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Last Updates</h4>
                            <!-- <div class="card-header-form">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>#Code</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th class="table-width-20">Customer Name</th>
                                        <th>Issue Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @if (count($services) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">No services to show</td>
                                        </tr>
                                    @endif
                                    @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $service['service_no'] }}</td>
                                            <td>{{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}</td>
                                            <td>{{ $service['service_date'] != '' ? date('d-M-Y', strtotime($service['service_date'])) : 'NA' }}</td>
                                            <td>{{ $service['CST_Name'] }}</td>
                                            <td>{{ $service['issue_name'] }}</td>
                                            <td>
                                                <span class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                    {{ $service['Status_Name'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="flex-d">
                                                    <a href="{{ route('services.view', $service['service_id']) }}"
                                                       class="action-btn btn btn-info">
                                                       <i class="far fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 🔺 End of service list --}}
        </section>
    </div>
</x-app-layout>
