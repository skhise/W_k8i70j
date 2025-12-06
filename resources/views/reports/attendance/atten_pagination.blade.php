@if (count($attendance) == 0)
    <tr>
        <td colspan="5" class="text-center">
            nothing to show.
        </td>
    </tr>
@else
    @foreach ($attendance as $atten)
        <tr>
            <td>{{ $atten->name }}</td>
            <td>{{ $atten->Att_Date != null ? date('d-M-Y', strtotime($atten->Att_Date)) : 'NA' }}</td>
            <td>{{ $atten->Att_In != null ? date('h:i:s a', strtotime($atten->Att_In)) : 'NA' }}</td>
            <td>{{ $atten->Att_In_Location != null ? $atten->Att_In_Location : 'NA' }}</td>
            <td>{{ $atten->Att_Out != null ? date('h:i:s a', strtotime($atten->Att_Out)) : 'NA' }}</td>
            <td>{{ $atten->Att_Out_Location != null ? $atten->Att_Out_Location : 'NA' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="11">
            {{ $attendance->links() }}
        </td>
    </tr>

@endif
