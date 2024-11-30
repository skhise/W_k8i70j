<x-app-layout>
    <style>
        .banner-img {
            top: 20%;
            position: relative;
            float: right;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="row ">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Customers</h5>
                                            <h2 class="mb-3 font-18"  style="color:#586fcb">{{ $dashboard->customers ?? 0 }}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-user fa-3x" style="color:#586fcb"></i>
                                            <!--<img src="{{ asset('img/banner/1.png') }}" alt="">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15"> Contracts</h5>
                                            <h2 class="mb-3 font-18"  style="color:#586fcb">{{ $dashboard->contracts ?? 0 }}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">09%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-suitcase fa-3x"  style="color:#586fcb"></i>
                                            <!--<img src="{{ asset('img/banner/2.png') }}" alt="">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Service Calls</h5>
                                            <h2 class="mb-3 font-18"  style="color:#586fcb">{{ $dashboard->services ?? 0 }}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">18%</span>
                                                Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-tasks fa-3x"  style="color:#586fcb"></i>
                                            <!--<img src="{{ asset('img/banner/3.png') }}" alt="">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Employees</h5>
                                            <h2 class="mb-3 font-18"  style="color:#586fcb">{{ $dashboard->employees ?? 0 }}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <i class="fa fa-users fa-3x"  style="color:#586fcb"></i>
                                            <!-- <img src="{{ asset('img/banner/4.png') }}" alt=""> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Contract Status</h4>
                        </div>
                        <div class="card-body">
                            <div id="echart_pie" class="chartsh"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Service Status</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($servicesdata as $status)
                                <div class="mb-4">
                                    <div class="text-small float-right font-weight-bold text-muted">
                                        {{ $status['value'] }} Calls</div>
                                    <div class="font-weight-bold mb-1">{{ $status['name'] }}</div>
                                    <div class="progress" data-height="4" data-toggle="tooltip"
                                        title="{{ $status['value'] }}%">
                                        <div class="progress-bar {{ $status['color'] }}"
                                            data-width="{{ $status['value'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Last Updates</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                #Code
                                            </th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="table-width-20">Customer Name</th>
                                            <th>Issue Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @if (count($services) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">No services to show</td>
                                            </tr>
                                        @endif
                                        @foreach ($services as $key => $service)
                                            <tr>
                                                <td>
                                                    {{ $service['service_no'] }}
                                                </td>
                                                <td>
                                                    {{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}
                                                </td>
                                                <td>
                                                    {{ $service['service_date'] != '' ? date('d-M-Y', strtotime($service['service_date'])) : 'NA' }}
                                                </td>

                                                <td>
                                                    {{ $service['CST_Name'] }}
                                                </td>
                                                <td>{{ $service['issue_name'] }}</td>
                                                <td>
                                                    <span
                                                        class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                        {{ $service['Status_Name'] }}</span>
                                                </td>
                                                <td>
                                                    <div class="flex-d">
                                                        <a href="{{ route('services.view', $service['service_id']) }}"
                                                            class="action-btn btn btn-info"><i
                                                                class="far fa-eye"></i></a>
                                                        <a href="{{ route('services.edit', $service['service_id']) }}"
                                                            class="action-btn btn btn-primary"><i
                                                                class="far fa-edit"></i></a>
                                                    </div>


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
                var data = {!! json_encode($contractdonut) !!};
                console.log(data);
                var chart = document.getElementById('echart_pie');
                var barChart = echarts.init(chart);

                barChart.setOption({
                    tooltip: {
                        trigger: "item",
                        formatter: "{a} <br />{b} : {c} ({d}%)"
                    },
                    legend: {
                        x: "center",
                        y: "bottom",
                        textStyle: {
                            color: '#9aa0ac'
                        },
                        data: data
                    },

                    calculable: !0,
                    series: [{
                        name: "Chart Data",
                        type: "pie",
                        radius: "55%",
                        center: ["50%", "48%"],
                        data: data
                    }],
                    color: ['#54ca68', '#ff9800', '#fe1515', '#DE725C']
                });
            });
            /* Pie Chart */
        </script>

    @stop
</x-app-layout>
