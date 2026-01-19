@if (count($renewals) == 0)
    <tr>
        <td colspan="8" class="text-center">
            No renewals found for the selected criteria.
        </td>
    </tr>
@else
    @foreach ($renewals as $renewal)
        <tr>
            <td>{{ $renewal->CNRT_Number }}</td>
            <td>{{ $renewal->contract_type_name }}</td>
            <td>{{ $renewal->CST_Name }}</td>
            <td>{{ $renewal->new_start_date ? date('d-M-Y', strtotime($renewal->new_start_date)) : 'N/A' }}</td>
            <td>{{ $renewal->new_expiry_date ? date('d-M-Y', strtotime($renewal->new_expiry_date)) : 'N/A' }}</td>
            <td>{{ $renewal->amount }}</td>
            <td>{{ $renewal->renewal_note ?? 'N/A' }}</td>
            <td>{{ $renewal->renewal_date ? date('d-M-Y', strtotime($renewal->renewal_date)) : 'N/A' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8">
            {{ $renewals->links() }}
        </td>
    </tr>
@endif
