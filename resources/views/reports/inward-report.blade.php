<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Repair Inward Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-horizontal">
                                    <form action="{{ route('inward-report') }}" id="inward-report-filter" method="GET">
                                        <div class="form-group">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label>Select Customer</label>
                                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                                        <option value="">Select Customer</option>
                                                        <option value="">All</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->CST_ID }}" {{ request('customer_id') == $customer->CST_ID ? 'selected' : '' }}>
                                                                {{ $customer->CST_Name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Date Range</label>
                                                    <select class="form-control select2" id="date_range" name="date_range">
                                                        <option value="">Select Date Range</option>
                                                        <option value="-1" {{ request('date_range') == '-1' ? 'selected' : '' }}>Any</option>
                                                        <option value="0" {{ request('date_range') == '0' ? 'selected' : '' }}>Today</option>
                                                        <option value="1" {{ request('date_range') == '1' ? 'selected' : '' }}>Yesterday</option>
                                                        <option value="7" {{ request('date_range') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                                                        <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                                                        <option value="60" {{ request('date_range') == '60' ? 'selected' : '' }}>Last 60 Days</option>
                                                        <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>Last 90 Days</option>
                                                        <option value="180" {{ request('date_range') == '180' ? 'selected' : '' }}>Last 180 Days</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Status</label>
                                                    <select class="form-control select2" id="status_id" name="status_id">
                                                        <option value="">All Status</option>
                                                        @foreach($repairStatuses as $status)
                                                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                                                {{ $status->status_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button type="button" class="btn btn-primary mr-2" id="btn-fetch-report">Generate</button>
                                                    <button type="button" class="btn btn-info mr-2" id="btn-export-report">Export</button>
                                                    <button type="button" class="btn btn-secondary" id="btn-reset">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="inward-report-table">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Inward No.</th>
                                                    <th>Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Ticket No.</th>
                                                    <th>Status</th>
                                                    <th>Spare Type</th>
                                                    <th>Part/Model Name</th>
                                                    <th>Description</th>
                                                    <th>Location</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody id="inward-report-tbody">
                                                @if(isset($repairInwards) && $repairInwards->count() > 0)
                                                    @foreach($repairInwards as $index => $inward)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $inward->defective_no }}</td>
                                                            <td>{{ $inward->defective_date ? date('d M Y', strtotime($inward->defective_date)) : 'N/A' }}</td>
                                                            <td>{{ $inward->CST_Name ?? 'N/A' }}</td>
                                                            <td>{{ $inward->ticket_no ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $inward->repairStatus && $inward->repairStatus->id == 1 ? 'primary' : 'success' }}">
                                                                    {{ $inward->repairStatus->status_name ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $inward->spareType->type_name ?? 'N/A' }}</td>
                                                            <td>{{ $inward->part_model_name ?? 'N/A' }}</td>
                                                            <td>{{ $inward->spare_description ?? 'N/A' }}</td>
                                                            <td>{{ $inward->current_product_location ?? 'N/A' }}</td>
                                                            <td>{{ $inward->remark ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="12" class="text-center">No records found. Please select filters and click Generate.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if(isset($repairInwards) && method_exists($repairInwards, 'hasPages') && $repairInwards->hasPages())
                                        <div class="float-right mt-3">
                                            {{ $repairInwards->links() }}
                                        </div>
                                    @endif
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
        $(document).ready(function() {
            $('.select2').select2();

            // Generate Report
            $('#btn-fetch-report').on('click', function() {
                const customerId = $('#customer_id').val();
                const dateRange = $('#date_range').val();
                const statusId = $('#status_id').val();
                
                const url = new URL('{{ route("inward-report") }}', window.location.origin);
                if (customerId) url.searchParams.set('customer_id', customerId);
                if (dateRange) url.searchParams.set('date_range', dateRange);
                if (statusId) url.searchParams.set('status_id', statusId);
                
                window.location.href = url.toString();
            });

            // Export Report
            $('#btn-export-report').on('click', function() {
                const customerId = $('#customer_id').val();
                const dateRange = $('#date_range').val();
                const statusId = $('#status_id').val();
                
                const url = new URL('{{ route("inward-report-export") }}', window.location.origin);
                if (customerId) url.searchParams.set('customer_id', customerId);
                if (dateRange) url.searchParams.set('date_range', dateRange);
                if (statusId) url.searchParams.set('status_id', statusId);
                
                // Show loader
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Exporting...');
                
                // Trigger download
                window.location.href = url.toString();
                
                // Re-enable button after a delay
                setTimeout(() => {
                    $(this).prop('disabled', false).html('Export');
                }, 2000);
            });

            // Reset
            $('#btn-reset').on('click', function() {
                window.location.href = '{{ route("inward-report") }}';
            });
        });
    </script>
    @stop
</x-app-layout>

