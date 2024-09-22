<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contract Summary</h4>
                                <div class="card-header-action d-flex">
                                    <button onclick="printDiv()" class="btn btn-primary mr-2">Print</button>
                                    <a href="{{route('contract-report')}}"  class="btn btn-danger">Back</a>
                                </div>
                            </div>
                            <div class="card-body" id="summary_div_print">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div>
                                                    <h6 class="">Contract Information
                                                    </h6>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                <div class="col-lg-6">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Client
                                                                    Name</span></div>
                                                            <div class="col-md-9">
                                                                <h6>{{ $contract->CST_Name }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    Contract No.</span>
                                                            </div>
                                                            <div class="col-md-8">{{ $contract->CNRT_Number }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contrcat
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
                                                            <div class="col-md-3">{{ $contract->site_type_name }}
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
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">
                                                                    End Date
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) ?? 'NA' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contract
                                                                    Cost</span>
                                                            </div>
                                                            <div class="col-md-2 " style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges }}</div>
                                                            <div class="col-md-1">
                                                                <span style="float:right ;font-weight:bold">Paid</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges_Paid }}</div>
                                                            <div class="col-md-2">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Pending</span>
                                                            </div>
                                                            <div class="col-md-2" style="float:left ;font-weight:bold">
                                                                {{ $contract->CNRT_Charges_Paid }}</div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-6">
                                                    <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Status</span>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <p class="text-muted">{!! $contract->CST_Status != 0 ? $status[$contract->CNRT_Status] : 'NA' !!}</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Contract
                                                                    Type</span></div>
                                                            <div class="col-md-9">
                                                                <h6>
                                                                    {{ $contract->contract_type_name }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Total
                                                                    Service</span></div>
                                                            <div class="col-md-9">
                                                                <h6>
                                                                    {{ $contract->Total_Services ?? 0 }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Website</span>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <h6 > {{ $contract->CST_Website }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h6 class="">Contact Information</h6>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h6 class="">Other Information</h6>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact
                                                                    Person
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Name ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Mobile
                                                                    Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Mobile ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Alternate
                                                                    Number
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Phone1 ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Contact
                                                                    Email
                                                                </span>
                                                            </div>
                                                            <div class="col-md-9">{{ $contract->CCP_Email ?? '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span style="float:right ;font-weight:bold">Google
                                                                    Location Link
                                                                </span>
                                                            </div>
                                                            <div class="col-md-8"><a
                                                                    href="{{ $contract->CNRT_SiteLocation ?? '#' }}"
                                                                    target="_blank"><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i>
                                                                </a></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span style="float:right ;font-weight:bold">Site
                                                                    Location
                                                                </span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $contract->SiteAreaName ?? 'NA' }}
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span style="float:right ;font-weight:bold">Address
                                                                </span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $contract->CNRT_OfficeAddress ?? 'NA' }}
                                                            </div>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                        <hr />
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <h6 class="">Note</h6>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <h6 class="">Term &
                                                                        Condition</h6>
                                                        </div>
                                                       
                                                    </div>
                                                <hr />
                                                        <div class="row">
                                                        <div class="col-lg-6">
                                                                 {{ $contract->CNRT_Note != null ? $contract->CNRT_Note : 'NA' }}
                                                            </div>
                                                            <div class="col-lg-6">
                                                                {{ $contract->CNRT_TNC != null ? $contract->CNRT_TNC : 'NA' }}
                                                            </div>
                                                            
                                                        </div>
                                                        <hr/>
                                                        <div>
                                                            <h6>Contract Product</h6>
                                                        </div>
                                                        
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="table table-striped" id="tbRefClient">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th>Name</th>
                                                                            <th>Type</th>
                                                                            <th>Sr. Number</th>
                                                                            <th>Description</th>
                                                                            <th>Price</th>
                                                                            <th>Location</th>
                                                                            <th>Remark</th>
                                                                            <th>Service Period</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($products->count() == 0)
                                                                            <tr>
                                                                                <td colspan="10"
                                                                                    class="text-center">No
                                                                                    products
                                                                                    added yet.</td>
                                                                            </tr>
                                                                        @endif
                                                                        @foreach ($products as $index => $product)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $index + 1 }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $product->product_name }}
                                                                                </td>
                                                                                <td>{{ $product['product_type'] }}
                                                                                </td>
                                                                                <td>{{ $product['nrnumber'] }}</td>
                                                                                <td>{{ $product['product_description'] }}
                                                                                </td>
                                                                                <td>{{ $product['product_price'] }}
                                                                                </td>
                                                                                <td>{{ $product['branch'] }}</td>
                                                                                <td>{{ $product['remark'] }}</td>
                                                                                <td>{{ $product['service_period'] }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h6>Schedule Services</h6>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-striped" id="tbRefClient">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th>Schedule Date</th>
                                                                            <th>Issue Type</th>
                                                                            <th>Service Type</th>
                                                                            <th>Product</th>
                                                                            <th>Issue Description</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($services->count() == 0)
                                                                            <tr>
                                                                                <td colspan="8"
                                                                                    class="text-center">No
                                                                                    schedule service
                                                                                    added yet.</td>
                                                                            </tr>
                                                                        @endif
                                                                        @foreach ($services as $index => $service)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $index + 1 }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $service->Schedule_Date }}
                                                                                </td>
                                                                                <td>{{ $service['issue_name'] }}</td>
                                                                                <td>{{ $service['type_name'] }}</td>
                                                                                <td>{{ $service['product_Id'] != 0 ? $service['nrnumber'] . ' / ' . $service['product_name'] : 'NA' }}
                                                                                </td>
                                                                                <td>{{ $service['description'] }}</td>
                                                                                <td><span
                                                                                        class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                                                        {{ $service['Status_Name'] }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h6>Onging Services</h6>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-striped" id="tbRefClient">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th>Schedule Date</th>
                                                                            <th>Issue Type</th>
                                                                            <th>Service Type</th>
                                                                            <th>Product</th>
                                                                            <th>Issue Description</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($ongoing_services->count() == 0)
                                                                            <tr>
                                                                                <td colspan="8"
                                                                                    class="text-center">No
                                                                                    schedule service
                                                                                    added yet.</td>
                                                                            </tr>
                                                                        @endif
                                                                        @foreach ($ongoing_services as $index => $ongoing_service)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $index + 1 }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ date('d-M-Y', strtotime($ongoing_service->service_date)) }}
                                                                                </td>
                                                                                <td>{{ $ongoing_service['issue_name'] }}</td>
                                                                                <td>{{ $ongoing_service['type_name'] }}</td>
                                                                                <td>{{ $ongoing_service['nrnumber'] . ' / ' . $ongoing_service['product_name']}}
                                                                                </td>
                                                                                <td>{{ $ongoing_service['service_note'] }}</td>
                                                                                <td><span
                                                                                        class="text-white badge badge-shadow {{ $ongoing_service['status_color'] ?? 'bg-primary' }}">
                                                                                        {{ $ongoing_service['Status_Name'] }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h6>Checklist Note</h6>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-striped"
                                                                    id="tbRefChecklist">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th style="width:80%;">Description</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($checklists->count() == 0)
                                                                            <tr>
                                                                                <td colspan="3"
                                                                                    class="text-center">No
                                                                                    checklist
                                                                                    added yet.</td>
                                                                            </tr>
                                                                        @endif
                                                                        @foreach ($checklists as $index => $checklist)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $index + 1 }}
                                                                                </td>
                                                                                <td>{{ $checklist['description'] }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h6>Renewal History</h6>
                                                        </div>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-striped"
                                                                    style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th>Start Date</th>
                                                                            <th>Expiry Date</th>
                                                                            <th>Cost</th>
                                                                            <th>Note</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($renewals->count() == 0)
                                                                            <tr>
                                                                                <td colspan="5"
                                                                                    class="text-center">No
                                                                                    history yet.</td>
                                                                            </tr>
                                                                        @endif
                                                                        @foreach ($renewals as $index => $renewal)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $index + 1 }}
                                                                                </td>
                                                                                <td>{{ $renewal['new_start_date'] != '' ? date('d-M-Y', strtotime($renewal['new_start_date'])) : 'NA' }}
                                                                                </td>
                                                                                <td>{{ $renewal['new_expiry_date'] != '' ? date('d-M-Y', strtotime($renewal['new_expiry_date'])) : 'NA' }}
                                                                                </td>
                                                                                <td>{{ $renewal['amount'] }}</td>
                                                                                <td>{{ $renewal['renewal_note'] }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        </hr>
                                                        
                                                   </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                   
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
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
        function printDiv(){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById("summary_div_print").innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
        </script>
    @stop
</x-app-layout>