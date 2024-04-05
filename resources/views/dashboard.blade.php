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
                                            <h5 class="font-15">Customers</h5>
                                            <h2 class="mb-3 font-18">{{$dashboard->customers ?? 0}}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{asset('img/banner/1.png') }}" alt="">
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
                                            <h2 class="mb-3 font-18">{{$dashboard->contracts ?? 0}}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">09%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{asset('img/banner/2.png') }}" alt="">
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
                                            <h2 class="mb-3 font-18">{{$dashboard->contracts ?? 0}}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">18%</span>
                                                Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{asset('img/banner/3.png') }}" alt="">
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
                                            <h2 class="mb-3 font-18">{{$dashboard->employees ?? 0}}</h2>
                                            <!-- <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{asset('img/banner/4.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card mt-sm-5 mt-md-0">
                  <div class="card-header">
                    <h4>Visitors</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="donutChart"></canvas>
                      </div>
                </div>
              </div>
              <div class="col-lg-6 mt-lg-0 mt-sm-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Service Status</h4>
                  </div>
                  <div class="card-body">
                    <div class="mb-4 mt-4">
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
                                        @if(count($services) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">No services to show</td>
                                            </tr>
                                            @endif
                                            @foreach($services as $key => $service)
                                            <tr>
                                                <td>
                                                    {{$service['service_no']}}
                                                </td>
                                                <td>
                                                    {{$service['contract_id'] == 0 || empty($service['contract_id']) ?
        'Non-Contracted' : 'Contracted'}}
                                                </td>
                                                <td>
                                                    {{$service['service_date'] != "" ?
        date('d-M-Y', strtotime($service['service_date'])) : 'NA'}}
                                                </td>

                                                <td>
                                                    {{$service['CST_Name']}}
                                                </td>
                                                <td>{{$service['issue_name']}}</td>
                                                <td>
                                                    <span
                                                        class="text-white badge badge-shadow {{$service['status_color'] ?? 'bg-primary'}}">
                                                        {{$service['Status_Name']}}</span>
                                                </td>
                                                <td>
                                                    <div class="flex-d">
                                                    <a href="{{route('services.view', $service['service_id'])}}"
                                                        class="action-btn btn btn-info"><i class="far fa-eye"></i></a>
                                                    <a href="{{route('services.edit', $service['service_id'])}}"
                                                        class="action-btn btn btn-primary"><i class="far fa-edit"></i></a>
                                                    </div>
                                                    

                                            </tr>
                                            @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <!-- Support tickets -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Support Ticket</h4>
                                <form class="card-header-form">
                                    <input type="text" name="search" class="form-control" placeholder="Search">
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="support-ticket media pb-1 mb-3">
                                    <img src="{{asset('img/users/user-1.png') }}" class="user-img mr-2" alt="">
                                    <div class="media-body ml-3">
                                        <div class="badge badge-pill badge-success mb-1 float-right">Feature</div>
                                        <span class="font-weight-bold">#89754</span>
                                        <a href="javascript:void(0)">Please add advance table</a>
                                        <p class="my-1">Hi, can you please add new table for advan...</p>
                                        <small class="text-muted">Created by <span class="font-weight-bold font-13">John
                                                Deo</span>
                                            &nbsp;&nbsp; - 1 day ago</small>
                                    </div>
                                </div>
                                <div class="support-ticket media pb-1 mb-3">
                                    <img src="{{asset('img/users/user-2.png') }}" class="user-img mr-2" alt="">
                                    <div class="media-body ml-3">
                                        <div class="badge badge-pill badge-warning mb-1 float-right">Bug</div>
                                        <span class="font-weight-bold">#57854</span>
                                        <a href="javascript:void(0)">Select item not working</a>
                                        <p class="my-1">please check select item in advance form not work...</p>
                                        <small class="text-muted">Created by <span
                                                class="font-weight-bold font-13">Sarah
                                                Smith</span>
                                            &nbsp;&nbsp; - 2 day ago</small>
                                    </div>
                                </div>
                                <div class="support-ticket media pb-1 mb-3">
                                    <img src="{{asset('img/users/user-3.png') }}" class="user-img mr-2" alt="">
                                    <div class="media-body ml-3">
                                        <div class="badge badge-pill badge-primary mb-1 float-right">Query</div>
                                        <span class="font-weight-bold">#85784</span>
                                        <a href="javascript:void(0)">Are you provide template in Angular?</a>
                                        <p class="my-1">can you provide template in latest angular 8.</p>
                                        <small class="text-muted">Created by <span
                                                class="font-weight-bold font-13">Ashton
                                                Cox</span>
                                            &nbsp;&nbsp; -2 day ago</small>
                                    </div>
                                </div>
                                <div class="support-ticket media pb-1 mb-3">
                                    <img src="{{asset('img/users/user-6.png') }}" class="user-img mr-2" alt="">
                                    <div class="media-body ml-3">
                                        <div class="badge badge-pill badge-info mb-1 float-right">Enhancement</div>
                                        <span class="font-weight-bold">#25874</span>
                                        <a href="javascript:void(0)">About template page load speed</a>
                                        <p class="my-1">Hi, John, can you work on increase page speed of template...
                                        </p>
                                        <small class="text-muted">Created by <span
                                                class="font-weight-bold font-13">Hasan
                                                Basri</span>
                                            &nbsp;&nbsp; -3 day ago</small>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="card-footer card-link text-center small ">View
                                All</a>
                        </div>
                        <!-- Support tickets -->
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Projects Payments</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Date</th>
                                                <th>Payment Method</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>John Doe </td>
                                                <td>11-08-2018</td>
                                                <td>NEFT</td>
                                                <td>$258</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Cara Stevens
                                                </td>
                                                <td>15-07-2018</td>
                                                <td>PayPal</td>
                                                <td>$125</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>
                                                    Airi Satou
                                                </td>
                                                <td>25-08-2018</td>
                                                <td>RTGS</td>
                                                <td>$287</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>
                                                    Angelica Ramos
                                                </td>
                                                <td>01-05-2018</td>
                                                <td>CASH</td>
                                                <td>$170</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>
                                                    Ashton Cox
                                                </td>
                                                <td>18-04-2018</td>
                                                <td>NEFT</td>
                                                <td>$970</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>
                                                    John Deo
                                                </td>
                                                <td>22-11-2018</td>
                                                <td>PayPal</td>
                                                <td>$854</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>
                                                    Hasan Basri
                                                </td>
                                                <td>07-09-2018</td>
                                                <td>Cash</td>
                                                <td>$128</td>
                                            </tr>
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
</x-app-layout>