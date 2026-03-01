<x-app-layout>
    <style>
        .banner-img { top: 20%; position: relative; float: right; }
        .card-statistic-4 {
            border: 1px solid #e3e6f0;
            border-radius: 6px;
        }
        .card-statistic-4 .card-content,
        .product-dashboard-card .row {
            padding: 1rem 1.25rem;
        }
        .product-dashboard-card .card-content h5 { margin-bottom: 0.35rem; }
        .product-dashboard-card .card-content h2 { margin-bottom: 0; }
        .section.section-product-dashboard { padding: 1.5rem 0; }
        .section.section-product-dashboard .row + .row { margin-top: 1.25rem; }
        .product-dashboard-card .banner-img { padding-right: 1.25rem !important; }
        #product-dashboard .card .card-body { padding: 1.25rem 1.5rem; }
        #product-dashboard .card .card-header { padding: 1rem 1.5rem; }
        #product-dashboard .table td, #product-dashboard .table th { padding: 0.75rem 1rem; }
    </style>
    <div class="main-content" id="product-dashboard">
        <section class="section section-product-dashboard m-2">
            {{-- Row 1: Total Spares, Low Stock, Pending Purchases, Technician Stock --}}
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card card-statistic-4 product-dashboard-card">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Total Spares</h5>
                                        <h2 class="font-18 font-weight-bold">{{ number_format($dashboard->total_spares ?? 0) }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-cubes fa-3x text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card card-statistic-4 product-dashboard-card">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Low Stock Items</h5>
                                        <h2 class="font-18 font-weight-bold text-danger">{{ number_format($dashboard->low_stock_items ?? 0) }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card card-statistic-4 product-dashboard-card">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Pending Purchases</h5>
                                        <h2 class="font-18 font-weight-bold text-warning">{{ number_format($dashboard->pending_purchases ?? 0) }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-shopping-cart fa-3x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card card-statistic-4 product-dashboard-card">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Technician Stock</h5>
                                        <h2 class="font-18 font-weight-bold">{{ number_format($dashboard->technician_stock ?? 0) }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-user-cog fa-3x text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Row 2: Utilize Spares (Today, This week, Last 30 days) --}}
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover card-statistic-4 product-dashboard-card" href="{{ route('services') }}">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Utilize Spares (Today)</h5>
                                        <h2 class="font-18" style="color:#586fcb">{{ $dashboard->spares_today ?? 0 }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-box fa-3x" style="color:#586fcb"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover card-statistic-4 product-dashboard-card" href="{{ route('services') }}">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Utilize Spares (This week)</h5>
                                        <h2 class="font-18" style="color:#586fcb">{{ $dashboard->spares_week ?? 0 }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-cubes fa-3x" style="color:#586fcb"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover card-statistic-4 product-dashboard-card" href="{{ route('services') }}">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                    <div class="card-content">
                                        <h5 class="font-14">Utilize Spares (Last 30 days)</h5>
                                        <h2 class="font-18" style="color:#586fcb">{{ $dashboard->spares_30 ?? 0 }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="banner-img">
                                        <i class="fa fa-tasks fa-3x" style="color:#586fcb"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product Type Utilized</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Count of product used under contract by product type</p>
                            @foreach ($productTypeUtilized as $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-weight-bold">{{ $item['name'] }}</span>
                                    <span class="text-muted">{{ $item['value'] }} Used</span>
                                </div>
                            @endforeach
                            @if (count($productTypeUtilized) == 0)
                                <p class="text-muted mb-0">No product utilized under contract yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Spare Utilization</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Technician</th>
                                            <th>Spare Name</th>
                                            <th>Quantity</th>
                                            <th>Job Card</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($recentSpareUtilization ?? []) == 0)
                                            <tr>
                                                <td colspan="5" class="text-center">No recent spare utilization.</td>
                                            </tr>
                                        @else
                                            @foreach ($recentSpareUtilization as $row)
                                                <tr>
                                                    <td>{{ $row->issue_date ? \Carbon\Carbon::parse($row->issue_date)->format('d M Y') : '—' }}</td>
                                                    <td>{{ $row->technician_name ?? '—' }}</td>
                                                    <td>{{ $row->spare_name ?? '—' }}</td>
                                                    <td>{{ (int) ($row->quantity ?? 0) }}</td>
                                                    <td>{{ $row->job_card ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
