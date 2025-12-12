
                                            @if (count($service_dcs) == 0)
                                                <tr>
                                                    <td colspan="8" class="text-center">No
                                                        products
                                                        added yet.</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_dcs as $index => $dcp)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $dcp['CST_Name'] }}</td>
                                                    <td>{{ $dcp['CNRT_Number'] }}</td>
                                                    <td>{{ $dcp['service_no'] }}</td>
                                                    <td>{{ $dcp->totalProduct($dcp['dcp_id']) }}</td>
                                                    <td>{{ $dcp['dc_amount'] }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($dcp['issue_date'])) }}</td>
                                                    <td>{{ $dcp['dc_type_name'] }}</td>
                                                    <td>
                                                        <div class="">
                                                            <a class="action-btn btn btn-sm btn-primary"
                                                                href="{{ route('services.dc_view', $dcp['dcp_id']) }}?flag=1"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        
