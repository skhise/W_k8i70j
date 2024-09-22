@if (count($services) == 0)
    <tr>
        <td colspan="19" class="text-center">
            <p>Report not generated yte.</p>
        </td>
    </tr>
@else
    @foreach ($services as $service)
         <tr>
            <td>{{ $service->service_no }}</td>
            <td>{{ $service->contract_id == 0 ? 'Non-Contracted' : 'Contracted' }}</td>
            <td>{{ $service->CNRT_Number }}</td>
            <td>{{ $service->CST_Name }}</td>
              <td>{{ $service->nrnumber ??  $service->product_sn }} / {{$service->product_name }}</td>
            <td>{{ $service->type_name }}</td>
            <td>{{ $service->issue_name }}</td>
            <td>{{ $service->service_note }}</td>
            <td>{{ $service->contact_person }}</td>
            <td>{{ $service->created_at != null ? date('d-M-Y H:i', strtotime($service->created_at)) : 'NA' }}</td>
            <td>{{ $service->accepted_datetime != null ? date('d-M-Y H:i', strtotime($service->accepted_datetime)) : 'NA' }}</td>
            <td>{!! $service->timeline() !!}</td>
            <td> <span class="text-white badge badge-shadow {{ $service['status_color'] ?? 'bg-primary' }}">
                    {{ $service['Status_Name'] }}</span></td>
            <td>{{ $service->EMP_Name }}</td>
            <td>{{ $service->resolved_datetime != null ? date('d-M-Y H:i', strtotime($service->resolved_datetime)) : 'NA' }}
            </td>
            <td>{{ $service->resolved_datetime != null ? date('d-M-Y H:i', strtotime($service->closed_at)) : 'NA' }}
            </td>
            <td>{{ now()->diffInHours($service->created_at) }}</td>
            <td>{{$service->expenses}}</td>
            <td>{{$service->charges}}</td>
            <td>{{$service->close_note}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="20">
            {{ $services->links() }}
        </td>
    </tr>

@endif
