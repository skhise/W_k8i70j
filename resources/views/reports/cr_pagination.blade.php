@if (count($contracts) == 0)
    <tr>
        <td colspan="11" class="text-center">
            <h5>Report not generated yte.</h5>
        </td>
    </tr>
@else
    @foreach ($contracts as $contract)
        <tr>
            <td>{{ $contract->CNRT_Number }}</td>
            <td>{{ $contract->contract_type_name }}</td>
            <td>{{ $contract->CST_Name }}</td>
            <td>{{ $contract->SiteAreaName }}</td>
            <td>{{ $contract->CNRT_Charges }}</td>
            <td>{{ $contract->CNRT_Charges_Paid }}</td>
            <td>{{ $contract->CNRT_Charges_Pending }}</td>
            <td>{{ date('d-M-Y', strtotime($contract->CNRT_StartDate)) }}</td>
            <td>{{ date('d-M-Y', strtotime($contract->CNRT_EndDate)) }}</td>
            <td>{!! $status[$contract->CNRT_Status] !!}</td>
            <td><a href="{{ route('contracts.view', $contract['CNRT_ID']) }}" class="btn btn-primary"><i
                        class="far fa-eye"></i></a></td>
        </tr>
    @endforeach
    <tr>
        <td colspan="11">
            {{ $contracts->links() }}
        </td>
    </tr>

@endif
