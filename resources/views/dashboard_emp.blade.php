<x-app-layout>
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
                                            <h5 class="font-15">Service Calls</h5>
                                            <h2 class="mb-3 font-18">{{ $dashboard->services ?? 0 }}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">18%</span>
                                                Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('img/banner/3.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-9">
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
                                                        class="action-btn btn btn-info"><i class="far fa-eye"></i></a>

                                                </div>


                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Service Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">558</div>
                                <div class="font-weight-bold mb-1">Google</div>
                                <div class="progress" data-height="4" data-toggle="tooltip" title="58%">
                                    <div class="progress-bar bg-success" data-width="58%"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">338</div>
                                <div class="font-weight-bold mb-1">Facebook</div>
                                <div class="progress" data-height="4" data-toggle="tooltip" title="44%">
                                    <div class="progress-bar bg-purple" data-width="44%"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">238</div>
                                <div class="font-weight-bold mb-1">Bing</div>
                                <div class="progress" data-height="4" data-toggle="tooltip" title="32%">
                                    <div class="progress-bar bg-orange" data-width="32%"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">190</div>
                                <div class="font-weight-bold mb-1">Yahoo</div>
                                <div class="progress" data-height="4" data-toggle="tooltip" title="22%">
                                    <div class="progress-bar bg-cyan" data-width="22%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">

                </div>
            </div>
        </section>

    </div>
</x-app-layout>
