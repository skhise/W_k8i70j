<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Quotation Report</h4>
                            </div>
                            <div class="card-body">

                                <form action="quotation-report" id="quotation_filter">
                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label>Select Client</label>
                                                <select
                                                    class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                    data-val="true"
                                                    data-val-required="The Customer Name field is required."
                                                    id="customer_id" name="customer_id" placeholder=""
                                                    required="required" type="text">
                                                    <option value="">All</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->CST_ID }}"
                                                            {{ $customer_id == $client->CST_ID ? 'selected' : '' }}>
                                                            {{ $client->CST_Name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-3">
                                                <label>Select Type</label>
                                                <select
                                                    class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                    data-val="true" id="type" name="type" placeholder=""
                                                    required="required">
                                                    <option value="">All
                                                    </option>
                                                    @foreach ($type as $tp)
                                                        <option value="{{ $tp->id }}"
                                                            {{ $quot_type == $tp->id ? 'selected' : '' }}>
                                                            {{ $tp->quot_type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Select Status</label>
                                                <select
                                                    class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                    data-val="true" id="status" name="status" placeholder=""
                                                    required="required">
                                                    <option value="">All
                                                    </option>
                                                    @foreach ($status as $st)
                                                        <option value="{{ $st->id }}"
                                                            {{ $quot_status == $st->id ? 'selected' : '' }}>
                                                            {{ $st->status_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="col-md-3">
                                                    <div class="d-flex mt-4">
                                                        <button class="action-btn onchange btn btn-info"
                                                            type="button">Generate</button>
                                                        <button class="action-btn export-to-excel btn btn-primary"
                                                            type="button">Export</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">

                                    <table class="table table-striped" id="tbRefClient">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Client Name</th>
                                                <th>QTY</th>
                                                <th>Total Amount</th>
                                                <th>Issue Date</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($service_quots->count() == 0)
                                                <tr>
                                                    <td colspan="6" class="text-center">No
                                                        products
                                                        added yet.</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_quots as $index => $dcp)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $dcp['CST_Name'] }}</td>
                                                    <td>{{ $dcp->totalProduct($dcp['dcp_id']) }}</td>
                                                    <td>{{ $dcp->totalAmount($dcp['dcp_id']) }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($dcp['issue_date'])) }}</td>
                                                    <td>{{ $dcp['quot_type_name'] }}</td>
                                                    <td>{{ $dcp['status_name'] }}</td>
                                                    <td>
                                                        <div class="">
                                                            <a class="btn btn-sm btn-primary"
                                                                href="{{ route('quotmanagements.view', $dcp['dcp_id']) }}?flag=1"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </div>
                                                    </td>
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
        </section>
    </div>
    @section('script')
        <script>
            $(".onchange").on("click", function() {
                $("#quotation_filter")[0].submit();
            });
        </script>
    @stop
</x-app-layout>
