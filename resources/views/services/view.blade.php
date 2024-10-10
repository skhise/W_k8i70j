<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Service Details</h4>
                                <div class="card-header-action d-flex">

                                    @if ($service->Status_Id == 6 && $service->assigned_to == auth()->user()->id)
                                        <button class="btn btn-info  ml-2" id="btn-accept-call">Accept</button>
                                        <button class="btn btn-danger  mr-2 ml-2" id="btn-reject-call">Reject</button>
                                    @endif
                                    @if(($service->Status_Id != 6 && $service->assigned_to == auth()->user()->id) || auth()->user()->role == 1)
                                        <input type="button" id="btn_service_add ml-2" value="Action"
                                            class="btn btn-primary" data-toggle="modal"
                                            data-target=".bd-RefServiceStatus-modal-lg" />
                                    @endif
                                    @if (auth()->user()->role == 1)
                                        <button type="button" class="btn btn-info ml-2" data-toggle="modal"
                                            data-target=".bd-RefServiceAssign-modal-lg">Assign</button>
                                    @endif

                                    <a class="btn ml-2 btn-info" target="_blank"
                                        href="{{ route('services.print', $service_id) }}">Print</a>
                                    <a class="btn btn-danger ml-2" href="{{ route('services') }}">Back</a>
                                    @if (auth()->user()->role == 1)

                                        <div class="dropdown d-inline  ml-2">

                                            <button class="btn btn-light dropleft  dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="true">
                                                More
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="top-start"
                                                style="position: absolute; transform: translate3d(0px, -133px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                @if (auth()->user()->role == 1)
                                                    <a class="dropdown-item has-icon"
                                                        href="{{ route('services.edit', $service_id) }}"><i
                                                            class="far fa-edit"></i> Edit</a>
                                                @endif
                                                <a class="delete-btn action-btn  dropdown-item has-icon" href="{{route('services.delete',$service_id)}}"><i
                                                        class="far fa-file"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ClientDetails" role="tab" aria-controls="home-tab2"
                                            aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Servicetimeline-tab5" data-toggle="tab"
                                            href="#servicetimeline" role="tab" aria-controls="Servicetimeline-tab5"
                                            aria-selected="true">Timeline</a>
                                    </li>
                                    @if (auth()->user()->role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link" id="ServiceProductDC-tab5" data-toggle="tab"
                                                href="#serviceproductdc" role="tab"
                                                aria-controls="ServiceProductDC-tab5" aria-selected="true">Product
                                                DC</a>
                                        </li>
                                    @endif


                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ClientDetails" role="tabpanel"
                                        aria-labelledby="home-tab2">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{ $service->service_no }}</h4>

                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                    <strong><i
                                                                            class="fa fa-map-marker margin-r-5"></i>&nbsp;&nbsp;Status</strong>
                                                                    <p class="text-white mb-0"><span
                                                                            class="badge badge-shadow {{ $service->status_color ?? 'bg-primary' }}">
                                                                            {{ $service->Status_Name }}</span></p>
                                                                            <p style="font-size:12px;">{{$service->lastactiondetails()}}</p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Last
                                                                        Update
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $service->lastaction() }}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Assigned
                                                                        To.
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $service->EMP_Name ?? '' }}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Date
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $service->service_date != '' ? date('d-M-Y', strtotime($service->service_date)) : 'NA' }}
                                                                    </p>
                                                                    <hr>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Type
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $service['contract_id'] == 0 || empty($service['contract_id']) ? 'Non-Contracted' : 'Contracted' }}

                                                                    </p>
                                                                    <hr>
                                                                    
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Priority
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $service->priority_name }}
                                                                    </p>

                                                                    <hr>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <br />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card card-success">
                                                    <div class="card-body">

                                                        @if ($service->contract_id != 0)
                                                            <div>
                                                                <div>
                                                                    <h5 class="">Contract Information
                                                                    </h5>
                                                                </div>
                                                                <hr />
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Client Name</span>
                                                                    </div>
                                                                    <div class="col-md-9">{{ $service->CST_Name }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Contract Number</span>
                                                                    </div>
                                                                    <div class="col-md-9">{{ $contract->CNRT_Number ?? "" }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span
                                                                            style="float:right ;font-weight:bold">Contrcat
                                                                            Type</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ $contract->contract_type_name }}</div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Site Type
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ $contract->site_type_name }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Service Category
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ $service->service_category == 1 ? 'Under AMC' : ($service->service_category == 2 ? 'Chargeable' : 'NA') }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Start Date
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ date('d-M-Y', strtotime($contract->CNRT_StartDate)) ?? 'NA' }}
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <span style="float:right ;font-weight:bold">
                                                                            Expriy Date
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) ?? 'NA' }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <span
                                                                            style="float:right ;font-weight:bold">Contract
                                                                            Cost</span>
                                                                    </div>
                                                                    <div class="col-md-2 "
                                                                        style="float:left ;font-weight:bold">
                                                                        {{ $contract->CNRT_Charges }}</div>
                                                                    <div class="col-md-1">
                                                                        <span
                                                                            style="float:right ;font-weight:bold">Paid</span>
                                                                    </div>
                                                                    <div class="col-md-2"
                                                                        style="float:left ;font-weight:bold">
                                                                        {{ $contract->CNRT_Charges_Paid }}</div>
                                                                    <div class="col-md-2">
                                                                        <span
                                                                            style="float:right ;font-weight:bold">Pending</span>
                                                                    </div>
                                                                    <div class="col-md-2"
                                                                        style="float:left ;font-weight:bold">
                                                                        {{ $contract->CNRT_Charges_Paid }}</div>
                                                                </div>

                                                                <hr />
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h5 class="">Contact Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contact Person</span>
                                                            </div>
                                                            <div class="col-md-9">{{ $service->contact_person }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Email</span>
                                                            </div>
                                                            <div class="col-md-9">{{ $service->contact_email }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Phone Numbers</span>
                                                            </div>
                                                            <div class="col-md-3">{{ $service->contact_number1 }}
                                                                &nbsp;&nbsp;
                                                                {{ $service->contact_number2 }}</div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5 class="">Product Information
                                                            </h5>
                                                        </div>
                                                        <hr />
                                                        @if ($service->product_id == 0)
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Serial Number</span>
                                                                </div>
                                                                <div class="col-md-9">{{ $service->nrnumber ?? $service->product_sn  }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Name</span>
                                                                </div>
                                                                <div class="col-md-9">{{ $service->product_name }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Type</span>
                                                                </div>
                                                                <div class="col-md-3">{{ $service->product_type }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Description</span>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    {{ $service->product_description }}
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        @endif
                                                        @if ($service->product_id != 0)
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Name</span>
                                                                </div>
                                                                <div class="col-md-9">{{ $product->product_name }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Type</span>
                                                                </div>
                                                                <div class="col-md-3">{{ $product->type_name }}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Description</span>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    {{ $product->product_description }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <hr />
                                                         <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Service Type</span>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    {{ $service->type_name }}
                                                                </div>
                                                            </div>
                                                         <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Issue Type</span>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    {{ $service->issue_name }}
                                                                </div>
                                                            </div>
                                                               <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Issue
                                                                    Description</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $service->service_note != null ? $service->service_note : 'NA' }}
                                                            </div>
                                                        </div>    
                                                                    <hr>
                                                        <div>
                                                            <h5 class="">Other Information</h5>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Google
                                                                    Location Link
                                                                </span>
                                                            </div>
                                                            <div class="col-md-1">
                                                                @if ($service->site_google_link != '')
                                                                    <a href="{{ $service->site_google_link ?? '#' }}"
                                                                        target="_blank"><i class="fa fa-map-marker"
                                                                            aria-hidden="true"></i>

                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Area</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ $service->SiteAreaName ?? 'NA' }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $service->site_address ?? 'NA' }}
                                                            </div>

                                                        </div>
                                                        
                                                        <hr />
                                                        @if ($service->service_status == 5)
                                                            <div>
                                                                <h5 class="">Close Note</h5>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">
                                                                        Charges
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    {{ $service->charges ?? '0' }}
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <span
                                                                        style="float:right ;font-weight:bold">Expenses</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    {{ $service->expenses ?? '0' }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Note
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {{ $service->close_note }}
                                                                </div>

                                                            </div>
                                                        @endif

                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="servicetimeline">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="activities">
                                                    @foreach ($timeline as $time_line)
                                                        <div class="activity">
                                                            <div class="activity-icon bg-primary text-white">
                                                                <i class="fas fa-clock" style="font-size: 16px;"></i>
                                                            </div>
                                                            <div class="activity-detail" style="width:50%;">
                                                                <div class="mb-2">
                                                                    <a class="text-white" href="#"><span
                                                                            class="badge badge-shadow {{ $time_line['status_color'] ?? 'bg-primary' }}">
                                                                            {{ $time_line['Status_Name'] }}</span></a>
                                                                            <span><strong>{{$service['assigned_to']!=0 && $time_line['Status_Id']== 6 ? " To : ".$service['EMP_Name'] : "" }}</strong></span>
                                                                    <span class="float-right"
                                                                        style="font-size: 14px;">{{ date(
                                                                            "d-m-Y
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    h:i:s",
                                                                            strtotime(
                                                                                $time_line['created_at'] .
                                                                                    "
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    " .
                                                                                    config('app.timezone'),
                                                                            ),
                                                                        ) }}</span>

                                                                </div>
                                                                <p style="font-size: 14px;">
                                                                    {{ $time_line['Sub_Status_Name'] }}</p>
                                                                <p style="font-size: 14px;">
                                                                    {{ $time_line['action_description'] }}.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="serviceproductdc">
                                        @include('services.service_dcproduct_tab');
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('services.service_action')
    @include('services.service_action_assign')
    @section('script')
        <script>
            $(document).on("click", "#btn-accept-call", function() {
                Swal.fire({
                        title: 'Are you sure?',
                        text: 'Are you sure to accept the call?',
                        buttons: true,
                        icon: 'warning',
                        buttons: true,
                        showCancelButton: true,
                        confirmButtonText: "Yes",
                        cancelButtonText: `No`,
                        dangerMode: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'accept-reject-call',
                                type: "POST",
                                data: {
                                    flag: 2,
                                    note: "",
                                    service_id: "{{ $service_id }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        window.location.reload();
                                    } else {
                                        Swal.fire({
                                            title: 'Action failed!',
                                            icon: 'warning',
                                            text: 'Something went wrong, try again',
                                            dangerMode: true
                                        });
                                    }

                                },
                                error: function(error) {
                                    Swal.fire({
                                        title: 'Action failed!',
                                        icon: 'warning',
                                        text: 'Something went wrong, try again',
                                        dangerMode: true
                                    });
                                }
                            });
                        }
                    });

            });
            $(document).on("click", "#btn-reject-call", function() {
                Swal.fire({
                        icon: 'warning',
                        title: 'Rejection note',
                        input: "text",
                        inputAttributes: {
                            autocapitalize: "off"
                        },
                        buttons: true,
                        showCancelButton: true,
                        confirmButtonText: "Yes",
                        cancelButtonText: `No`,
                    })
                    .then((ok) => {
                        console.log(ok);
                        var note = ok.value;
                        if (ok.isConfirmed) {
                            $.ajax({
                                url: 'accept-reject-call',
                                type: "POST",
                                data: {
                                    flag: 1,
                                    note: note,
                                    service_id: "{{ $service_id }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        window.location.replace("/services");
                                    } else {
                                        Swal.fire({
                                            title: 'Action failed!',
                                            icon: 'warning',
                                            text: 'Something went wrong, try again',
                                            dangerMode: true
                                        });
                                    }

                                },
                                error: function(error) {
                                    Swal.fire({
                                        title: 'Action failed!',
                                        icon: 'warning',
                                        text: 'Something went wrong, try again',
                                        dangerMode: true
                                    });
                                }
                            });
                        }
                    });
            });
            $(document).on("change", "#status_id", function() {
                $("#sub_status_id").empty();
                var status_id = $("#status_id option:selected").val();
                var sub_status = $("#status_id option:selected").data('sub_status');
                var option = "<option value='0'>None</option>";
                $.each(sub_status, function(index, value) {
                    option += "<option value=" + value.Sub_Status_Id + ">" + value.Sub_Status_Name +
                        "</option>";
                });
                if (status_id == 5) {
                    $("#close_call_div").removeClass("hide");
                    $("#action_description_lbl").text("Close Note / Remark *");
                } else {
                    $("#close_call_div").addClass("hide");
                    $("#action_description_lbl").text("Description *");
                }
                $("#sub_status_id").append(option);
            });
            $(document).ready(function() {
                var max_fields = 100;
                var wrapper = $("#multipeInput");
                var add_button = $(".add_form_field");
                var x = 0;
                $(add_button).click(function(e) {
                    e.preventDefault();
                    if (x < max_fields) {
                        x++;
                        $("#add_sr_no").text(x);
                        $(wrapper).prepend(
                            '<div class="input-group mt-2"><input type="text" class="form-control nrnumber" id="nrnumber.' +
                            x +
                            '" name="nrnumber[]"/><span class="btn btn-danger input-group-addon add_form_field delete"><i class="fa fa-trash" aria-hidden="true"></i></span></div > '
                        ); //add input box
                    } else {
                        alert('You Reached the limits')
                    }
                });
                $(wrapper).on("click", ".delete", function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                    $("#add_sr_no").text(x);

                })
            });
            $(document).on("click", "#showEditModal", function() {
                $("#btn_cp_add").trigger('click');
                $("#CNT_Name").val($(this).data('name'));
                $("#CNT_Department").val($(this).data('department'));
                $("#CNT_Email").val($(this).data('email'));
                $("#CNT_Mobile").val($(this).data('mobile'));
                $("#CNT_Phone1").val($(this).data('phone'));
                var cpid = $(this).data('cpid');
                $("#CNT_ID").val(cpid);
            });

            function SaveContractProduct() {
                $.ajax({
                    url: 'add_product',
                    type: "POST",
                    data: $("#form_cp").serialize(),
                    success: function(response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBox();
                            window.location.reload();
                        } else {
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function(index, value) {
                                    $("#" + index).addClass('required');
                                    $('.errorMsgntainer').append('<span class="text-danger">' +
                                        value +
                                        '<span>' + '<br>');
                                });
                            } else {
                                alert(response.message);
                            }


                        }

                    },
                    error: function(error) {
                        alert("something went wrong, try again.");
                    }
                })
            }

            function CancelModelBox() {

                $("#form_cp")[0].reset();
                $("#btn_close").trigger('click');
            }
            $(document).on("click", "#btn_service_status_save", function() {

                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                $(".nrnumber").removeClass("error_border");
                var service_id = $("#service_id").val();
                var url = '{{ route('service_status.store', $service_id) }}';
                var isValid = true;

                // Loop through each input field and validate
                $('#form_service_status .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_service_status_save").attr("disabled", false);
                        $("#btn_service_status_save").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_service_status").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            $("#btn_service_status_save").attr("disabled", false);
                            $("#btn_service_status_save").html("Save");
                            $('.errorMsgntainer').html("");
                            if (response.success) {
                                CancelModelBoxServiceAction();
                                window.location.reload();
                            } else {

                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_service_save").attr("disabled", false);
                            $("#btn_service_save").html("Save");

                            alert("something went wrong, try again.");
                        }
                    })
                } else {
                    alert("else");
                }

            });
            $(document).on("click", "#btn_service_assign_save", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                $(".nrnumber").removeClass("error_border");
                var service_id = $("#service_id_assign").val();
                var url = '{{ route('service_status.assign', $service_id) }}';
                var isValid = true;

                // Loop through each input field and validate
                $('#form_service_assign .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_service_assign_save").attr("disabled", false);
                        $("#btn_service_assign_save").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_service_assign").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            if (response.success) {
                                CancelModelBoxServiceAssign();
                                window.location.reload();
                            } else {
                                $("#btn_service_status_save").attr("disabled", false);
                                $("#btn_service_status_save").html("Save");
                                $('.errorMsgntainer').html("");
                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_service_assign_save").attr("disabled", false);
                            $("#btn_service_assign_save").html("Save");
                            alert("something went wrong, try again.");
                        }
                    })
                }

            });


            function CancelModelBoxServiceAction() {
                $("#btn_service_status_save").attr("disabled", false);
                $("#btn_service_status_save").html("Save");
                $('.text-danger-error').html('');
                $("#close_call_div").addClass("hide");
                $("#action_description_lbl").text("Description *");
                $("#form_service_status")[0].reset();
                $(".required").removeClass('error_border')
                $("#btn_close_service_status").trigger('click');
            }

            function CancelModelBoxServiceAssign() {
                $("#btn_service_assign_save").attr("disabled", false);
                $("#btn_service_assign_save").html("Save");
                $('.text-danger-error').html('');
                $("#form_service_assign")[0].reset();
                $(".required").removeClass('error_border')
                $("#btn_close_service_assign").trigger('click');
            }
        </script>
    @stop
</x-app-layout>
