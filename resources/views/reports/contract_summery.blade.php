<x-app-layout>
    <style>
        @media print {
            @page { size: A4; margin: 12mm; }
            .no-print, .card-header, .card-header-action, .main-sidebar, .navbar, .main-footer { display: none !important; }
            .summary-screen { display: none !important; }
            .summary-print { display: block !important; }
            body { background: #fff !important; }
            /* Font: Arial only, 14pt base */
            .contract-print-wrap {
                font-family: Arial, sans-serif !important;
                font-size: 14pt !important;
                color: #000;
                line-height: 1.25;
                text-align: left;
            }
            .contract-print-wrap * { font-family: Arial, sans-serif !important; box-sizing: border-box; }
            .summary-print.contract-print-wrap { width: 100%; max-width: none; }
            /* Tables: left-aligned */
            .contract-print-wrap table { width: 100%; border-collapse: collapse; margin-bottom: 10pt; page-break-inside: auto; font-family: Arial, sans-serif !important; font-size: 14pt !important; text-align: left; }
            .contract-print-wrap thead { display: table-header-group; text-align: left; }
            .contract-print-wrap tr { page-break-inside: avoid; page-break-after: auto; }
            .contract-print-wrap th, .contract-print-wrap td { border: 1px solid #000; padding: 5px 8px; text-align: left !important; font-family: Arial, sans-serif !important; font-size: 14pt !important; line-height: 1.25; }
            .contract-print-wrap th { background: #f5f5f5; font-weight: bold; }
            /* Company block: left-aligned */
            .contract-print-wrap .company-block { text-align: left !important; margin-bottom: 0; font-family: Arial, sans-serif !important; font-size: 14pt !important; }
            .contract-print-wrap .company-name { font-family: Arial, sans-serif !important; font-size: 15pt !important; font-weight: bold; margin-bottom: 3pt; line-height: 1.2; text-align: left !important; }
            .contract-print-wrap .company-address { font-family: Arial, sans-serif !important; font-size: 14pt !important; margin-bottom: 2pt; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .company-gstin-line { font-family: Arial, sans-serif !important; font-size: 14pt !important; margin-bottom: 2pt; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .company-gstin-label { font-family: Arial, sans-serif !important; font-size: 14pt !important; margin-bottom: 14pt; line-height: 1.25; text-align: left !important; }
            /* Title: full-page center, bold, underlined */
            .contract-print-wrap .doc-title { display: block; width: 100%; text-align: center !important; font-family: Arial, sans-serif !important; font-size: 16pt !important; font-weight: bold; text-decoration: underline; margin: 0 0 6pt 0; line-height: 1.2; page-break-after: avoid; }
            .contract-print-wrap .doc-contract-type { display: block; width: 100%; text-align: center !important; font-family: Arial, sans-serif !important; font-size: 14pt !important; margin: 0 0 12pt 0; line-height: 1.2; page-break-after: avoid; }
            /* Two columns */
            .contract-print-wrap .print-two-col { display: flex; justify-content: space-between; align-items: flex-start; gap: 24pt; margin-bottom: 12pt; width: 100%; }
            .contract-print-wrap .print-col-left { flex: 1; min-width: 0; text-align: left !important; }
            .contract-print-wrap .print-col-right { flex: 1; min-width: 0; text-align: right !important; }
            .contract-print-wrap .customer-title { font-family: Arial, sans-serif !important; font-size: 15pt !important; font-weight: bold; margin-bottom: 4pt; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .customer-details-inner { padding-left: 12pt; font-family: Arial, sans-serif !important; font-size: 14pt !important; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .customer-name { font-family: Arial, sans-serif !important; font-size: 14pt !important; font-weight: bold; margin: 0 0 2pt 0; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .customer-addr { font-family: Arial, sans-serif !important; font-size: 14pt !important; margin: 0 0 6pt 0; line-height: 1.25; text-align: left !important; }
            /* Customer detail rows: label right (colons align), value left */
            .contract-print-wrap .detail-row { display: table; width: 100%; max-width: 260px; margin: 1pt 0; font-family: Arial, sans-serif !important; font-size: 14pt !important; line-height: 1.25; }
            .contract-print-wrap .detail-label { display: table-cell; width: 1%; white-space: nowrap; text-align: right !important; padding-right: 4px; vertical-align: top; font-family: Arial, sans-serif !important; font-size: 14pt !important; }
            .contract-print-wrap .detail-value { display: table-cell; text-align: left !important; font-family: Arial, sans-serif !important; font-size: 14pt !important; }
            /* Contract block: right-aligned (each line right-aligned) */
            .contract-print-wrap .contract-row { display: block; margin: 1pt 0; font-family: Arial, sans-serif !important; font-size: 14pt !important; line-height: 1.25; text-align: right !important; }
            .contract-print-wrap .contract-label { display: inline; font-family: Arial, sans-serif !important; font-size: 14pt !important; }
            .contract-print-wrap .contract-value { display: inline; font-family: Arial, sans-serif !important; font-size: 14pt !important; }
            /* Section titles: left-aligned */
            .contract-print-wrap .section-title { font-family: Arial, sans-serif !important; font-size: 15pt !important; font-weight: bold; margin: 12pt 0 6pt 0; padding-bottom: 2pt; page-break-after: avoid; border-bottom: 1px solid #000; line-height: 1.25; text-align: left !important; }
            .contract-print-wrap .print-section { page-break-inside: avoid; margin-bottom: 0; }
            .contract-print-wrap .terms-block { margin-top: 8pt; white-space: pre-line; font-family: Arial, sans-serif !important; font-size: 14pt !important; line-height: 1.3; text-align: left !important; page-break-inside: avoid; }
            .contract-print-wrap .signature-block { margin-top: 20pt; padding-top: 6pt; text-align: right !important; font-family: Arial, sans-serif !important; font-size: 14pt !important; page-break-inside: avoid; }
            .contract-print-wrap tr.validity-row td { border-top: none; padding-top: 0; padding-bottom: 4px; font-family: Arial, sans-serif !important; font-size: 12pt !important; text-align: left !important; }
        }
        @media screen {
            .summary-print { display: none !important; }
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
                                {{-- Print layout: identical to reference (Warranty Contract style) --}}
                                <div class="summary-print contract-print-wrap">
                                    {{-- 1. Company block (left-aligned) --}}
                                    <div class="company-block">
                                        <div class="company-name">{{ config('app.name', 'AMC') }}</div>
                                        <div class="company-address">{{ config('app.company_address', '') }}{{ config('app.company_phone', '') ? ' Phone ' . config('app.company_phone') : '' }}</div>
                                        <div class="company-gstin-line">{{ config('app.company_gstin', '') ? 'GSTIN ' . config('app.company_gstin') : '' }}</div>
                                        <div class="company-gstin-label">GSTIN :</div>
                                    </div>
                                    {{-- 2. Document title: centered, bold, underlined --}}
                                    <div class="doc-title">Contract Summary</div>
                                    
                                    {{-- 3. Two columns: LEFT = Customer Details (indented, colons aligned), RIGHT = Contract info (colons aligned) --}}
                                    <div class="print-two-col">
                                        <div class="print-col-left">
                                            <div class="customer-title">Customer Details :</div>
                                            <div class="customer-details-inner">
                                                <div class="customer-name">{{ $contract->CST_Name ?? '' }}</div>
                                                <div class="customer-addr">, {{ $contract->SiteAreaName ?? '' }}, {{ $contract->CNRT_OfficeAddress ?? '' }}</div>
                                                <div class="detail-row"><span class="detail-label">Mobile No</span><span class="detail-value"> : {{ $contract->CCP_Mobile ?? $contract->CNRT_Phone1 ?? '' }}</span></div>
                                                <div class="detail-row"><span class="detail-label">Email</span><span class="detail-value"> : {{ $contract->CCP_Email ?? $contract->CNRT_CustomerEmail ?? '' }}</span></div>
                                                <div class="detail-row"><span class="detail-label">GSTIN</span><span class="detail-value"> : {{ $contract->CST_GSTIN ?? '' }}</span></div>
                                            </div>
                                        </div>
                                        <div class="print-col-right">
                                            <div class="contract-row"><span class="contract-label">Contract No.</span><span class="contract-value"> : {{ $contract->CNRT_Number ?? '' }}</span></div>
                                            <div class="contract-row"><span class="contract-label">Contract Type</span><span class="contract-value"> : {{ $contract->contract_type_name ?? 'N/A' }}</span></div>
                                            <div class="contract-row"><span class="contract-label">Ref. No./Po No.</span><span class="contract-value"> : {{ $contract->CNRT_RefNumber ?? '' }}</span></div>
                                            <div class="contract-row"><span class="contract-label">Created Date</span><span class="contract-value"> : {{ $contract->CNRT_Date ? date('d M Y', strtotime($contract->CNRT_Date)) : '' }}</span></div>
                                        </div>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">Product Details</div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Particulars</th>
                                                <th>Serial No</th>
                                                <th>No of Service</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->no_of_service ?? '0' }} Service / Year {{ $product->product_price ?? '0.00' }}</td>
                                                <td>{{ $product->product_name ?? '' }} - {{ $product->nrnumber ?? '' }}</td>
                                                <td>{{ $product->no_of_service ?? '0' }}</td>
                                                <td>{{ $product->product_price ?? '0.00' }}</td>
                                            </tr>
                                            <!-- <tr class="validity-row">
                                                <td colspan="5">Validity : {{ $contract->CNRT_StartDate ? date('d M Y', strtotime($contract->CNRT_StartDate)) : '' }} to {{ $contract->CNRT_EndDate ? date('d M Y', strtotime($contract->CNRT_EndDate)) : '' }}</td>
                                            </tr> -->
                                            @endforeach
                                            @if ($products->count() == 0)
                                            <tr><td colspan="5" class="text-center">No products added yet.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">Service Calendar</div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Particulars</th>
                                                <th>Serial No</th>
                                                <th>Service Count</th>
                                                <th>Service Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($services as $index => $service)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $index + 1 }} Service</td>
                                                <td>{{ $service->product_name ?? '' }} - {{ $service->nrnumber ?? '' }}</td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $service->Schedule_Date ? date('d M Y', strtotime($service->Schedule_Date)) : '' }}</td>
                                            </tr>
                                            <tr class="validity-row">
                                                <td colspan="5">Validity : {{ $contract->CNRT_StartDate ? date('d M Y', strtotime($contract->CNRT_StartDate)) : '' }} to {{ $contract->CNRT_EndDate ? date('d M Y', strtotime($contract->CNRT_EndDate)) : '' }}</td>
                                            </tr>
                                            @endforeach
                                            @if ($services->count() == 0)
                                            <tr><td colspan="5" class="text-center">No schedule service added yet.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">Ongoing Services</div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Schedule Date</th>
                                                <th>Issue Type</th>
                                                <th>Service Type</th>
                                                <th>Product</th>
                                                <th>Issue Description</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ongoing_services as $index => $ongoing_service)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $ongoing_service->service_date ? date('d M Y', strtotime($ongoing_service->service_date)) : '' }}</td>
                                                <td>{{ $ongoing_service->issue_name ?? '' }}</td>
                                                <td>{{ $ongoing_service->type_name ?? '' }}</td>
                                                <td>{{ ($ongoing_service->nrnumber ?? '') . ' / ' . ($ongoing_service->product_name ?? '') }}</td>
                                                <td>{{ $ongoing_service->service_note ?? '' }}</td>
                                                <td>{{ $ongoing_service->Status_Name ?? '' }}</td>
                                            </tr>
                                            @endforeach
                                            @if ($ongoing_services->count() == 0)
                                            <tr><td colspan="7" class="text-center">No ongoing service added yet.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">Checklist Note</div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checklists as $index => $checklist)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $checklist->description ?? $checklist['description'] ?? '' }}</td>
                                            </tr>
                                            @endforeach
                                            @if ($checklists->count() == 0)
                                            <tr><td colspan="2" class="text-center">No checklist added yet.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">Renewal History</div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
                                                <th>Cost</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($renewals as $index => $renewal)
                                            @php $r = is_array($renewal) ? (object) $renewal : $renewal; @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ !empty($r->new_start_date) ? date('d M Y', strtotime($r->new_start_date)) : 'NA' }}</td>
                                                <td>{{ !empty($r->new_expiry_date) ? date('d M Y', strtotime($r->new_expiry_date)) : 'NA' }}</td>
                                                <td>{{ $r->amount ?? '' }}</td>
                                                <td>{{ $r->renewal_note ?? '' }}</td>
                                            </tr>
                                            @endforeach
                                            @if ($renewals->count() == 0)
                                            <tr><td colspan="5" class="text-center">No renewal history yet.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="print-section">
                                    <div class="section-title">TERMS & CONDITIONS</div>
                                    <div class="terms-block">{{ $contract->CNRT_TNC ?? 'Contract – Terms & Conditions
1. Contract period as mentioned in agreement.
2. Services limited to scope defined in contract only.
3. Breakdown due to misuse, voltage fluctuation or external damage not covered.
4. Payment to be made as per agreed schedule.
5. Jurisdiction subject to local court only' }}</div>
                                    <div class="signature-block">
                                        <div>For {{ config('app.name', 'AMC') }}</div>
                                        <div style="margin-top: 24px;">Authorized Signatory</div>
                                    </div>
                                    </div>
                                </div>
                                {{-- Screen layout (existing) --}}
                                <div class="summary-screen">
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
                                </div>{{-- end summary-screen --}}
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
            // Use print media: only summary-print is visible when printing
            window.print();
        }
    </script>
    @stop
</x-app-layout>