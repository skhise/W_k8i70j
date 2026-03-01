@php
    $utilized_products = $utilized_products ?? [];
    $hasRecords = false;
    if (isset($utilized_products) && (is_array($utilized_products) || is_countable($utilized_products))) {
        $hasRecords = count($utilized_products) > 0;
    }
    // Check if it's a paginator instance
    if (is_object($utilized_products) && method_exists($utilized_products, 'count')) {
        $hasRecords = $utilized_products->count() > 0;
    }
@endphp

@unless ($hasRecords)
    <tr>
        <td colspan="8" class="text-center">No products found.</td>
    </tr>
@endunless

@if ($hasRecords)
    @php
        $startIndex = 1;
        if (method_exists($utilized_products, 'firstItem')) {
            $startIndex = $utilized_products->firstItem() ?? 1;
        }
    @endphp
    @foreach ($utilized_products as $index => $row)
    <tr>
        <td>{{ $startIndex + $index }}</td>
        <td>{{ $row->CST_Name ?? 'N/A' }}</td>
        <td>{{ $row->CNRT_Number ?? 'N/A' }}</td>
        <td>{{ $row->service_no ?? 'N/A' }}</td>
        <td>{{ $row->Product_Name ?? 'N/A' }}</td>
        <td>{{ (int) ($row->used_quantity ?? 0) }}</td>
        <td>{{ $row->dc_type_name ?? 'N/A' }}</td>
        <td>{{ $row->issue_date ? date('d-M-Y', strtotime($row->issue_date)) : 'N/A' }}</td>
    </tr>
    @endforeach
    
    @if (method_exists($utilized_products, 'links'))
    <tr>
        <td colspan="8" class="text-center">
            {{ $utilized_products->links() }}
        </td>
    </tr>
    @endif
@endif
