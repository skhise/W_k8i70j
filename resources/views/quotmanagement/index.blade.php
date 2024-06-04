<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Quotation Management</h4>
                                <div class="card-header-action">

                                    @if (auth()->user()->role == 1)
                                        <a href="{{ route('quotmanagements.create') }}"
                                            class="btn btn-icon icon-left btn-primary"><i
                                                class="
fas fa-plus-square"></i>
                                            Add New</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <form action="quotmanagements" id="quotation_filter">
                                            <label>Select Client<span class="error">*</span></label>
                                            <select
                                                class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                data-val="true" data-val-required="The Customer Name field is required."
                                                id="customer_id" name="customer_id" placeholder="" required="required"
                                                type="text"
                                                value="{{ $service->customer_id ?? old('customer_id') }}">
                                                <option value="">Select client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->CST_ID }}"
                                                        {{ $customer_id == $client->CST_ID ? 'selected' : '' }}>
                                                        {{ $client->CST_Name }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </div>
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
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="delete-btn action-btn btn btn-sm btn-danger"
                                                                href="{{ route('quotmanagements.delete', $dcp['dcp_id']) }}"><i
                                                                    class="fa fa-trash"></i></a>
                                                            <a class="action-btn btn btn-sm btn-primary"
                                                                href="{{ route('quotmanagements.view', $dcp['dcp_id']) }}"><i
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
            $("#customer_id").on("change", function() {
                $("#quotation_filter")[0].submit();
            });
        </script>
    @stop
</x-app-layout>
