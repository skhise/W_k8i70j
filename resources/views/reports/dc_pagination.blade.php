
                                            @php
                                                $service_dcs = $service_dcs ?? (isset($dc_products) ? $dc_products : []);
                                                $hasRecords = false;
                                                if (isset($service_dcs) && (is_array($service_dcs) || is_countable($service_dcs))) {
                                                    $hasRecords = count($service_dcs) > 0;
                                                }
                                            @endphp
                                            @unless ($hasRecords)
                                                <tr>
                                                    <td colspan="9" class="text-center">No
                                                        products
                                                        added yet.</td>
                                                </tr>
                                            @endunless
                                            @if ($hasRecords)
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
                                                @if (method_exists($service_dcs, 'links'))
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        {{ $service_dcs->links() }}
                                                    </td>
                                                </tr>
                                                @endif
                                            @endif
                                        
