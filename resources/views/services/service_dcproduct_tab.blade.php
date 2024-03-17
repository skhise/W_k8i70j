<div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Product DC</h4>
                                                        <div class="card-header-action">
                                                            <a href="{{route('services.product_create', $service_id)}}" type="button" class="btn btn-primary">Add New</a>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Type</th>
                                                                        <th>Amount</th>
                                                                        <th>Product Type</th>
                                                                        <th>Product Name</th>
                                                                        <th>Product Sr. No.</th>
                                                                        <th>Issue Description</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if($dc_products->count() == 0)
                                                                    <tr>
                                                                        <td colspan="10" class="text-center">No
                                                                            products
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                   @foreach($dc_products as $index => $dcp) 
                                                                    <tr>
                                                                        <td>{{$index + 1}}</td>
                                                                        <td>{{date("d-M-Y", strtotime($dcp['issue_date']))}}</td>
                                                                        <td>{{$dcp['dc_type_name']}}</td>
                                                                        <td>{{$dcp['amount']}}</td>
                                                                        <td>{{$dcp['type_name']}}</td>
                                                                        <td>{{$dcp['Product_Name']}}</td>
                                                                        <td>{{$dcp['sr_number']}}</td>
                                                                        <td>{{$dcp['description']}}</td>
                                                                        <td>
                                                                            <div class="d-flex">
                                                                                <button class="action-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                                            </div>
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