<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Defective Inwards/Repairs</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('repairinwards.create') }}" class="btn btn-icon icon-left btn-primary">
                                        <i class="fas fa-plus-square"></i> New
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('repairinwards.index') }}" id="search_form" method="GET">
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $search }}" id="search" name="search" placeholder="Search">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">SEARCH</button>
                                                    <button class="btn btn-secondary btn-reset" type="button">RESET</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-control select2" id="status_filter" name="status" onchange="this.form.submit()">
                                                <option value="all" {{ $filter_status == 'all' ? 'selected' : '' }}>All</option>
                                                @foreach($repairStatuses as $status)
                                                    <option value="{{ $status->id }}" {{ $filter_status == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="repair-inward-table">
                                        <thead>
                                            <tr>
                                                <th>Defective No.</th>
                                                <th>Defective Date</th>
                                                <th>Customer Name</th>
                                                <th>Products</th>
                                                <th>Ticket No.</th>
                                                <th>Status/Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($repairInwards->count() == 0)
                                                <tr>
                                                    <td colspan="6" class="text-center">No defective items found</td>
                                                </tr>
                                            @else
                                                @foreach ($repairInwards as $repairInward)
                                                    <tr>
                                                        <td>{{ $repairInward->defective_no }}</td>
                                                        <td>
                                                            <i class="far fa-calendar-alt"></i>
                                                            {{ $repairInward->defective_date ? date('d M Y', strtotime($repairInward->defective_date)) : 'N/A' }}
                                                        </td>
                                                        <td>{{ $repairInward->CST_Name ?? 'N/A' }}</td>
                                                        <td>{{ $repairInward->part_model_name ?? 'N/A' }}</td>
                                                        <td>{{ $repairInward->ticket_no ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge badge-{{ $repairInward->repairStatus && $repairInward->repairStatus->id == 1 ? 'primary' : 'success' }} mr-2">
                                                                    {{ $repairInward->repairStatus->status_name ?? 'N/A' }}
                                                                </span>
                                                                <a href="{{ route('repairinwards.show', $repairInward->id) }}" class="btn btn-sm btn-info mr-1" title="View">
                                                                    <i class="far fa-file-alt"></i>
                                                                </a>
                                                                <a href="{{ route('repairinwards.edit', $repairInward->id) }}" class="btn btn-sm btn-warning mr-1" title="Edit">
                                                                    <i class="fas fa-sync-alt"></i>
                                                                </a>
                                                                <form action="{{ route('repairinwards.destroy', $repairInward->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this repair inward?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {{ $repairInwards->links() }}
                                </div>
                                @if ($repairInwards->total())
                                    <div class="float-left mt-3">
                                        <p>Showing {{ $repairInwards->firstItem() }} to {{ $repairInwards->lastItem() }} of {{ $repairInwards->total() }} entries</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @section('script')
    <script>
        $(document).on('click', '.btn-reset', function() {
            window.location.href = "{{ route('repairinwards.index') }}";
        });
    </script>
    @stop
</x-app-layout>

