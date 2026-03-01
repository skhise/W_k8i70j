@php
    $report_data = $report_data ?? collect();
    $hasRecords = $report_data->count() > 0;
@endphp

@unless ($hasRecords)
    <tr>
        <td colspan="6" class="text-center">No spare utilization found.</td>
    </tr>
@endunless

@if ($hasRecords)
    @php
        $startIndex = $report_data->firstItem() ?? 1;
    @endphp
    @foreach ($report_data as $index => $row)
    <tr>
        <td>{{ $startIndex + $index }}</td>
        <td>{{ $row->issue_date ? \Carbon\Carbon::parse($row->issue_date)->format('d-M-Y') : '—' }}</td>
        <td>{{ $row->service_no ?? '—' }}</td>
        <td>{{ $row->product_name ?? '—' }}</td>
        <td>{{ (int) ($row->quantity ?? 0) }}</td>
        <td>{{ $row->dc_type_name ?? '—' }}</td>
    </tr>
    @endforeach

    @if (method_exists($report_data, 'links'))
    <tr>
        <td colspan="6" class="text-center">
            {{ $report_data->links() }}
        </td>
    </tr>
    @endif
@endif
