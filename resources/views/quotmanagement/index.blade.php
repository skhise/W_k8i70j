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
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn-quot-export btn btn-info ml-2 p-2">Export</button>
                                        <form action="{{ route('quotmanagements') }}" id="quotation_filter">
                                            <input type="hidden" name="search_field" value="{{ $search_field }}"
                                                id="search_field" />
                                            <input type="hidden" value="{{ $filter_status }}" name="filter_status"
                                                id="filter_status" />
                                            <div class="d-flex float-right justify-space-between" style="width:30%;">
                                                <div class="input-group">
                                                    <input type="text" class="filter_values form-control"
                                                        value="{{ $search }}" id="search" name="search"
                                                        placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary mr-2" type="submit"><i
                                                                class="fas fa-search fa-lg"></i></button>
                                                        <button class="btn btn-primary filter-dropdown"
                                                            data-toggle="dropdown"><i
                                                                class="fas fa-filter fa-lg"></i></button>
                                                        <button class="filter-remove_btn btn btn-danger ml-2">
                                                            <i class="fa fa-times"></i></button>        
                                                        <div class="edit-filter-modal dropdown-menu-right hidden">
                                                            <li class="dropdown-title">Filter By</li>
                                                            <select
                                                                class="select2 form-control text-box single-line @error('customer_id') is-invalid @enderror"
                                                                data-val="true"
                                                                data-val-required="The Customer Name field is required."
                                                                id="customer_id" name="customer_id" placeholder=""
                                                                required="required" type="text"
                                                                value="{{ $service->customer_id ?? old('customer_id') }}">
                                                                <option value="">Select client</option>
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->CST_ID }}"
                                                                        {{ $customer_id == $client->CST_ID ? 'selected' : '' }}>
                                                                        {{ $client->CST_Name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br />
                                                            <select class="mt-2 select2 filter_values"
                                                                name="quot_type" id="quot_type">
                                                                <option value="">Quotation Type</option>
                                                                @foreach ($quotationType as $qtype)
                                                                    <option value="{{ $qtype->CST_ID }}"
                                                                        {{ $quot_type == $qtype->id ? 'selected' : '' }}>
                                                                        {{ $qtype->quot_type_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <br />
                                                            <select class="mt-2 select2 filter_values"
                                                                name="quot_status" id="quot_status">
                                                                <option value="">Quotation status
                                                                </option>
                                                                @foreach ($quotationStatus as $qstatus)
                                                                    <option value="{{ $qstatus->id }}"
                                                                        {{ $quot_status == $qstatus->id ? 'selected' : '' }}>
                                                                        {{ $qstatus->status_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <button type="submit"
                                                                class="filter_values mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                            <button type="button"
                                                                class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">

                                    <table class="table table-striped" id="tbRefClient">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Date</th>
                                                <th>Client Name</th>
                                                <th>Total QTY</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($service_quots->count() == 0)
                                                <tr>
                                                    <td colspan="7" class="text-center">No
                                                        products
                                                        added yet.</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_quots as $index => $dcp)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($dcp['issue_date'])) }}</td>
                                                    <td>{{ $dcp['CST_Name'] }}</td>
                                                    <td>{{ $dcp->totalProduct($dcp['dcp_id']) }}</td>
                                                    <td>{{ $dcp->totalAmount($dcp['dcp_id']) }}</td>
                                                    <td>{{ $dcp['status_name'] }}</td>
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
            $(document).on("click", ".btn-quot-export", function() {
                var cust_id = $("#customer_id option:selected").val();
                var cust_Name = $("#customer_id option:selected").text();
                var status = $("#quot_status option:selected").val();
                var quot_type = $("#quot_type option:selected").val();
                $.ajax({
                        type: "GET",
                        url: "reports/quot-report-export",
                        data: {
                            status: status,
                            customer: cust_id,
                            quot_type:quot_type
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        success: function(result, status, xhr) {
                            console.log(result);
                            $(".loader").hide();
                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var timestamp = new Date().toISOString().replace(/[:\-T]/g, '').slice(0, 15);

                            var filename = (matches != null && matches[1] ? matches[1] : `quot_report_${timestamp}.csv`);

                            // The actual download
                            var blob = new Blob([result], {
                                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;

                            document.body.appendChild(link);

                            link.click();
                            document.body.removeChild(link);
                        },
                        error: function(error) {
                            $(".loader").hide();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong, try again',
                                dangerMode: true,
                                icon: 'warning',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            });
                        }
                    });
            });
            $(".filter_values").on("change", function() {
                $("#quotation_filter")[0].submit();
            });
            $(document).ready(function() {
                $(".filter-dropdown, .text-button").click(function() {
                    $(".edit-filter-modal").toggleClass("hidden");

                });
                $(".apply-button").click(function() {
                    $(".edit-filter-modal").toggleClass("hidden");
                    $(".filter, .fa-plus, .fa-filter").toggleClass("filter-hidden");
                    $(".filter-dropdown-text").text("Add filter");
                });

                $(".filter-remove").click(function() {
                    $("#search_field").val("");
                    $("#customer_id").val("");
                    $("#c").val("");
                    $("#search").val("");
                    $("#filter_status").val("");
                    //$("#quotation_filter")[0].submit();
                    window.location.replace("/quotmanagements");
                    $(".edit-filter-modal").toggleClass("hidden");
                });
                $(".filter-remove_btn").click(function(e) {
                    e.preventDefault();
                    $("#search_field").val("");
                    $("#customer_id").val("");
                    $("#c").val("");
                    $("#search").val("");
                    $("#filter_status").val("");
                    window.location.replace("/quotmanagements");
                });




            });
        </script>
    @stop
</x-app-layout>
