@php
    $report_data = $report_data ?? collect();
    $hasRecords = $report_data->count() > 0;
@endphp

@unless ($hasRecords)
    <tr>
        <td colspan="7" class="text-center">No products found.</td>
    </tr>
@endunless

@if ($hasRecords)
    @php
        $startIndex = $report_data->firstItem() ?? 1;
    @endphp
    @foreach ($report_data as $index => $row)
    <tr>
        <td>{{ $startIndex + $index }}</td>
        <td>{{ $row->Product_Name ?? 'N/A' }}</td>
        <td>{{ $row->product_type_name ?? 'N/A' }}</td>
        <td>{{ (int) ($row->stock_quantity ?? 0) }}</td>
        <td>{{ (int) ($row->reserved_quantity ?? 0) }}</td>
        <td>{{ (int) ($row->utilized_quantity ?? 0) }}</td>
        <td>{{ $row->last_used_date ? \Carbon\Carbon::parse($row->last_used_date)->format('d-M-Y') : '—' }}</td>
    </tr>
    @endforeach

    @if (method_exists($report_data, 'links'))
    <tr>
        <td colspan="7" class="text-center">
            {{ $report_data->links() }}
        </td>
    </tr>
    @endif
@endif
