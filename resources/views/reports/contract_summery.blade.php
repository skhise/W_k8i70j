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
                                                    <h5 class="">Contract Information
                                                    </h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Contract
                                                                    Type</span></div>
                                                            <div class="col-md-9">
                                                                <h6 class="text-uppercase">
                                                                    {{ $contract->contract_type_name }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Total
                                                                    Service</span></div>
                                                            <div class="col-md-9">
                                                                <h6 class="text-uppercase">
                                                                    {{ $contract->Total_Services ?? 0 }}
                                                                </h6>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span
                                                                    style="float:right ;font-weight:bold">Website</span>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <h6 class="text-uppercase"> {{ $contract->CST_Website }}
                                                                </h6>

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
                                                                    style="float:right ;font-weight:bold">Client
                                                                    Name</span></div>
                                                            <div class="col-md-9">
                                                                <h6 class="text-uppercase">{{ $contract->CST_Name }}
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
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h5 class="">Contact Information</h5>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h5 class="">Other Information</h5>
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
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span style="float:right ;font-weight:bold">Note</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $contract->CNRT_Note != null ? $contract->CNRT_Note : 'NA' }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span style="float:right ;font-weight:bold">Term &
                                                                    Condition
                                                                </span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $contract->CNRT_TNC != null ? $contract->CNRT_TNC : 'NA' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                        <hr />
                                                        <div>
                                                            <h5>Contract Services</h5>
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
                                                                            <th>Actions</th>
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
                                                                                <td>{{ $service['product_Id'] != 0 ? $service['nrnumber'] . '/' . $service['product_name'] : 'NA' }}
                                                                                </td>
                                                                                <td>{{ $service['description'] }}</td>
                                                                                <td><span
                                                                                        class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                                                                                        {{ $service['Status_Name'] }}</span>
                                                                                </td>
                                                                                <td>

                                                                                    @if ($service['Service_Call_Id'] == 0)
                                                                                        <div class="flex-d">
                                                                                            <a href="#"
                                                                                                data-toggle="modal"
                                                                                                id="showServiceEditModal"
                                                                                                data-Schedule_Date="{{ $service['Schedule_Date'] }}"
                                                                                                data-product_id="{{ $service['product_Id'] }}"
                                                                                                data-issueType="{{ $service['issueType'] }}"
                                                                                                data-description="{{ $service['description'] }}"
                                                                                                data-serviceType="{{ $service['serviceType'] }}"
                                                                                                data-service_id="{{ $service['cupId'] }}"
                                                                                                data-target=".bd-RefServiceEdit-modal-lg"
                                                                                                class="action-btn btn btn-icon btn-sm btn-primary"><i
                                                                                                    class="far fa-edit"></i></a>

                                                                                            <a href="{{ route('contract_service.delete', $service['cupId']) }}"
                                                                                                class="action-btn delete-btn btn-icon btn btn-sm btn-danger"><i
                                                                                                    class="fa fa-trash"></i></a>

                                                                                            <a title="lock ticket"
                                                                                                href="{{ route('services.schedulecreate', $service['cupId']) }}?flag=1"
                                                                                                class="action-btn btn btn-icon btn-sm btn-primary"><i
                                                                                                    class="fa fa-lock"></i></a>
                                                                                        </div>
                                                                                    @else
                                                                                        <a title="view ticket"
                                                                                            href="{{ route('services.view', $service['Service_Call_Id']) }}?flag=1"
                                                                                            class="action-btn btn btn-icon btn-sm btn-primary"><i
                                                                                                class="fa fa-eye"></i></a>
                                                                                    @endif

                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5>Checklist Note</h5>
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
                                                                            <th>Actions</th>
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
                                                                                <td><a href="#"
                                                                                        data-toggle="modal"
                                                                                        id="showChkEditModal"
                                                                                        data-description="{{ $checklist['description'] }}"
                                                                                        data-cid="{{ $checklist['contactId'] }}"
                                                                                        data-id="{{ $checklist['id'] }}"
                                                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                                                            class="far fa-edit"></i></a>
                                                                                    <a type="submit"
                                                                                        href="{{ route('checklist.delete', $checklist['id']) }}"
                                                                                        class="btn btn-sm btn-danger"><i
                                                                                            class="fa fa-trash"></i>
                                                                                        </a< /td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                        <hr />
                                                        <div>
                                                            <h5>Renewal History</h5>
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
                                                        <div>
                                                            <h5>Contract Product</h5>
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
                                                                            <th>Actions</th>
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
                                                                                <th>{{ $product['product_price'] }}
                                                                                </th>
                                                                                <th>{{ $product['branch'] }}</th>
                                                                                <th>{{ $product['remark'] }}</th>
                                                                                <th>{{ $product['service_period'] }}
                                                                                </th>
                                                                                <td><a href="#"
                                                                                        data-toggle="modal"
                                                                                        id="showEditModal"
                                                                                        data-product_name="{{ $product['product_name'] }}"
                                                                                        data-product_type="{{ $product['product_type'] }}"
                                                                                        data-nrnumber="{{ $product['nrnumber'] }}"
                                                                                        data-product_description="{{ $product['product_description'] }}"
                                                                                        data-product_price="{{ $product['product_price'] }}"
                                                                                        data-branch="{{ $product['branch'] }}"
                                                                                        data-remark="{{ $product['remark'] }}"
                                                                                        data-service_period="{{ $product['service_period'] }}"
                                                                                        data-cid="{{ $product['contactId'] }}"
                                                                                        data-product_id="{{ $product['id'] }}"
                                                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                                                            class="far fa-edit"></i></a>
                                                                                    <a type="submit"
                                                                                        href="{{ route('contract_product.delete', $product['id']) }}"
                                                                                        class="delete-btn btn btn-sm btn-danger"><i
                                                                                            class="fa fa-trash"></i>
                                                                                        </a< /td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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