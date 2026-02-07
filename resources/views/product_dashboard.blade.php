<x-app-layout>
    <style>
        .banner-img { top: 20%; position: relative; float: right; }
    </style>
    <div class="main-content">
        <section class="section m-2">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover" href="{{ route('services') }}">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-14">Utilize Spares (Today)</h5>
                                            <h2 class="mb-3 font-18" style="color:#586fcb">{{ $dashboard->spares_today ?? 0 }}</h2>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-box fa-3x" style="color:#586fcb"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover" href="{{ route('services') }}">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-14">Utilize Spares (This week)</h5>
                                            <h2 class="mb-3 font-18" style="color:#586fcb">{{ $dashboard->spares_week ?? 0 }}</h2>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-cubes fa-3x" style="color:#586fcb"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a class="card card-hover" href="{{ route('services') }}">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-14">Utilize Spares (Last 30 days)</h5>
                                            <h2 class="mb-3 font-18" style="color:#586fcb">{{ $dashboard->spares_30 ?? 0 }}</h2>
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-tasks fa-3x" style="color:#586fcb"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Contract Status</h4>
                        </div>
                        <div class="card-body">
                            <div id="echart_pie_product" class="chartsh" style="min-height: 280px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product Type Utilized</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Count of product used under contract by product type</p>
                            @foreach ($productTypeUtilized as $item)
                                <div class="mb-4">
                                    <div class="text-small float-right font-weight-bold text-muted">
                                        {{ $item['value'] }} Used</div>
                                    <div class="font-weight-bold mb-1">{{ $item['name'] }}</div>
                                    <div class="progress" data-height="4" data-toggle="tooltip" title="{{ $item['value'] }}">
                                        <div class="progress-bar {{ $item['color'] ?? 'bg-primary' }}" data-width="{{ count($productTypeUtilized) > 0 ? min(100, round(($item['value'] / max(1, collect($productTypeUtilized)->max('value'))) * 100)) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                            @if (count($productTypeUtilized) == 0)
                                <p class="text-muted mb-0">No product utilized under contract yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Last 10 Product</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Product/Spare Type</th>
                                            <th>Description</th>
                                            <th>Last Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                        @if (count($lastUpdates) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">No products added yet.</td>
                                            </tr>
                                        @endif
                                        @foreach ($lastUpdates as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->Product_Name ?? '—' }}</td>
                                                <td>{{ $product->type_name ?? '—' }}</td>
                                                <td title="{{ $product->Product_Description ?? '' }}">{{ Str::limit($product->Product_Description ?? '', 50, ' ...') }}</td>
                                                <td>{{ $product->updated_at ? date('d-M-Y', strtotime($product->updated_at)) : '—' }}</td>
                                                <td>
                                                    <a href="{{ route('products.view', $product->Product_ID) }}" class="action-btn btn btn-icon btn-sm btn-primary"><i class="far fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
        $(document).ready(function() {
            var rawData = {!! json_encode($contractdonut) !!};
            var data = Array.isArray(rawData) ? rawData : [];
            var chartEl = document.getElementById('echart_pie_product');
            if (chartEl && typeof echarts !== 'undefined') {
                var pieChart = echarts.init(chartEl);
                var option = {
                    tooltip: {
                        trigger: "item",
                        formatter: "{b}: {c} ({d}%)"
                    },
                    legend: {
                        orient: "horizontal",
                        x: "center",
                        y: "bottom",
                        textStyle: { color: '#9aa0ac' },
                        data: data.map(function(item) { return item.name; })
                    },
                    color: ['#54ca68', '#ff9800', '#fe1515', '#DE725C', '#6c757d'],
                    series: [{
                        name: "Contract Status",
                        type: "pie",
                        radius: ["40%", "70%"],
                        center: ["50%", "45%"],
                        avoidLabelOverlap: true,
                        itemStyle: { borderRadius: 4 },
                        label: { show: data.length > 0 },
                        emphasis: { label: { show: true, fontSize: 14, fontWeight: "bold" } },
                        data: data
                    }]
                };
                if (data.length === 0) {
                    option.graphic = {
                        type: "text",
                        left: "center",
                        top: "middle",
                        style: { text: "No contract data", fontSize: 14, fill: "#999" }
                    };
                }
                pieChart.setOption(option);
                window.addEventListener("resize", function() { pieChart.resize(); });
            }
        });
    </script>
    @stop
</x-app-layout>
