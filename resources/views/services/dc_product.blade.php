<div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Prodcuts</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Name</th>
                                                                        <th>Serial No.</th>
                                                                        <th>Type</th>
                                                                        <th>Amount</th>
                                                                        <th>Description</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($dc_products->count() == 0)
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No
                                                                            serial number added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($dc_products as $index => $dc_product)
                                                                    <tr>
                                                                        <td>
                                                                            {{$index + 1}}
                                                                        </td>
                                                                        <td>
                                                                            {{$dc_product->Product_Name}}
                                                                        </td>
                                                                        <td>
                                                                            {{$dc_product->sr_number}}
                                                                        </td>
                                                                        <td>
                                                                            {{$dc_product->type_name}}
                                                                        </td>
                                                                        <td>
                                                                            {{$dc_product->amount}}
                                                                        </td>
                                                                        <td>
                                                                            {{$dc_product->description}}
                                                                        </td>
                                                                        <td>
                                                                        <a href="{{route('service_dcp.delete', $dc_product['sdp'])}}" class="delete-btn btn btn-sm btn-danger"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>