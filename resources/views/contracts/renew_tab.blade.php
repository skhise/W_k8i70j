<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Renewal History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Created On</th>
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
                                    <td>{{ $renewal['created_at'] != '' ? date('d-M-Y', strtotime($renewal['created_at'])) : 'NA' }}
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
        </div>
    </div>
</div>
