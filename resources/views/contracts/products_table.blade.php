<tbody>
    @if (count($products) == 0)
        <tr>
            <td colspan="9" class="text-center">No products found</td>
        </tr>
    @endif
    @foreach ($products as $key => $product)
        <tr>
            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}</td>
            <td>
                <a href="{{ route('contracts.view', $product->CNRT_ID) }}">
                    {{ $product->CNRT_Number }}
                </a>
            </td>
            <td>
                {{ $product->CST_Name ?? 'N/A' }}
                @if($product->CNRT_Phone1)
                    <br><small class="text-muted">{{ $product->CNRT_Phone1 }}</small>
                @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->type_name ?? 'N/A' }}</td>
            <td>{{ $product->nrnumber ?? 'N/A' }}</td>
            <td>{{ $product->branch ?? 'N/A' }}</td>
            <td>
                <span class="text-white badge badge-shadow {{ $product->status_color ?? 'bg-light' }}">
                    {{ $product->contract_status_name ?? 'N/A' }}
                </span>
            </td>
            <td>
                <a href="{{ route('contracts.view', $product->CNRT_ID) }}"
                    class="btn btn-primary btn-sm"><i class="far fa-eye"></i></a>
            </td>
        </tr>
    @endforeach
</tbody>
