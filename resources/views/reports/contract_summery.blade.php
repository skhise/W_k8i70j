<x-app-layout>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 5mm;
                /* Set custom margin */
            }
            .row{
                display: block;
                flex-wrap: wrap;
                background-color: red !important;    
                width: 100%;
            }
            #summary_div_print {
                margin: 0;
                /* Ensure no extra margins from the body */
            }
        }
    </style>
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
                                    <a href="{{route('contract-report')}}" class="btn btn-danger">Back</a>
                                </div>
                            </div>

                            <div class="card-body" id="summary_div_print">
                                <h4 class="card-title" id="#summary_title" style="display: none;">Contract Summary</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div>
                                                    <h6 class="">Contract Information
                                                    </h6>
                                                </div>
                                                <hr />
                                                <table class="table table-bordered">
    <tbody>
        <tr>
            <th>Client Name</th>
            <td colspan="3" class="text-end">{{ $contract->CST_Name }}</td>
        </tr>
        <tr>
            <th>Contract No.</th>
            <td class="text-end">{{ $contract->CNRT_Number }}</td>
            <th>Site Type</th>
            <td class="text-end">{{ $contract->site_type_name }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td class="text-end">{{ date('d-M-Y', strtotime($contract->CNRT_StartDate)) ?? 'NA' }}</td>
            <th>End Date</th>
            <td class="text-end">{{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) ?? 'NA' }}</td>
        </tr>
        <tr>
            <th>Contract Cost</th>
            <td class="text-end">{{ $contract->CNRT_Charges }}</td>
            <th>Paid</th>
            <td class="text-end">{{ $contract->CNRT_Charges_Paid }}</td>
        </tr>
        <tr>
            <th>Pending</th>
            <td class="text-end">{{ $contract->CNRT_Charges - $contract->CNRT_Charges_Paid }}</td>
            <th>Status</th>
            <td class="text-end">
                <span class="text-white badge badge-shadow {{ $contract['status_color'] ?? 'bg-light' }}">
                    {{ $contract['contract_status_name'] }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Contract Type</th>
            <td class="text-end">{{ $contract->contract_type_name }}</td>
            <th>Total Service</th>
            <td class="text-end">{{ $contract->Total_Services ?? 0 }}</td>
        </tr>
        <tr>
            <th>Website</th>
            <td colspan="3" class="text-end">{{ $contract->CST_Website }}</td>
        </tr>
    </tbody>
</table>

                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h6 class="">Contact Information</h6>
                                                    </div>
                                                </div>
                                                <hr />
                                                <table class="table table-bordered">
    <tbody>
        <tr>
            <th>Contact Person</th>
            <td class="text-end">{{ $contract->CCP_Name ?? '' }}</td>
            <th>Site Location</th>
            <td class="text-end">{{ $contract->SiteAreaName ?? 'NA' }}</td>
        </tr>
        <tr>
            <th>Mobile Number</th>
            <td class="text-end">{{ $contract->CCP_Mobile ?? '' }}</td>
            <th>Address</th>
            <td class="text-end">{{ $contract->CNRT_OfficeAddress ?? 'NA' }}</td>
        </tr>
        <tr>
            <th>Alternate Number</th>
            <td class="text-end">{{ $contract->CCP_Phone1 ?? '' }}</td>
            <th>Contact Email</th>
            <td class="text-end">{{ $contract->CCP_Email ?? '' }}</td>
        </tr>
    </tbody>
</table>

                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h6 class="">Note</h6>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <span style="float: right;">
                                                            {{ $contract->CNRT_Note != null ? $contract->CNRT_Note : 'NA' }}
                                                        </span>
                                                    </div>


                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h6 class="">Term &
                                                            Condition</h6>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <span style="float: right;">
                                                            {{ $contract->CNRT_TNC != null ? $contract->CNRT_TNC : 'NA' }}
                                                        </span>
                                                    </div>

                                                </div>
                                                <hr />
                                                <div style="page-break-before: auto;">
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
                                                                        <td colspan="10" class="text-center">No
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
                                                    <h6>Schedules Services</h6>
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
                                                                        <td colspan="8" class="text-center">No
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
                                                                        <td colspan="8" class="text-center">No
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
                                                        <table class="table table-striped" id="tbRefChecklist">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr. No.</th>
                                                                    <th style="width:80%;">Description</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($checklists->count() == 0)
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">No
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
                                                        <table class="table table-striped" style="width:100%;">
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
                                                                        <td colspan="5" class="text-center">No
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
        function printDiv() {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById("summary_div_print").innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
    @stop
</x-app-layout>