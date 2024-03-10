<div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Schedule Services</h4>
                                                        <div class="card-header-action">
                                                            <input type="button" id="btn_service_add" value="Add Service"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target=".bd-RefService-modal-lg" />
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Schedule Date</th>
                                                                        <th>Issue Type</th>
                                                                        <th>Service Type</th>
                                                                        <th>Product</th>
                                                                        <th>Issue Description</th>
                                                                        <th>Status</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($services->count() == 0)
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No
                                                                            schedule service
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($services as $index => $service)
                                                                    <tr>
                                                                        <td>
                                                                            {{$index + 1}}
                                                                        </td>
                                                                        <td>
                                                                            {{$service->Schedule_Date}}
                                                                        </td>
                                                                        <td>{{$service['issue_name']}}</td>
                                                                        <td>{{$service['type_name']}}</td>
                                                                        <td>{{$service['product_Id'] != 0 ? $service['nrnumber'] . "/" . $service['product_name'] : "NA"}}</td>
                                                                        <td>{{$service['description']}}</td>
                                                                        <td></td>
                                                                        <td>
                                                                            <div class="flex-d">
                                                                                @if($service['Service_Call_Id'] == 0)
                                                                                    <a href="#" data-toggle="modal"
                                                                                id="showServiceEditModal"
                                                                                data-Schedule_Date="{{$service['Schedule_Date']}}"
                                                                                data-product_id="{{$service['product_Id']}}"
                                                                                data-issueType="{{$service['issueType']}}"
                                                                                data-description="{{$service['description']}}"
                                                                                data-serviceType="{{$service['serviceType']}}"
                                                                                data-service_id="{{$service['cupId']}}"
                                                                                data-target=".bd-RefServiceEdit-modal-lg"
                                                                                class="action-btn btn btn-icon btn-sm btn-primary"><i
                                                                                    class="far fa-edit"></i></a>

                                                                                    <a href="{{route('contract_service.delete', $service['cupId'])}}" class="action-btn delete-btn btn btn-sm btn-danger"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                                    
                                                                                    <a title="lock ticket" href="{{route('services.schedulecreate', $service['cupId'])}}" class="action-btn btn btn-sm btn-primary"><i
                                                                                    class="fa fa-lock"></i></a>
                                                                                 @else 
                                                                                    <a title="view ticket" href="{{route('services.view', $service['Service_Call_Id'])}}" class="action-btn btn btn-sm btn-primary"><i
                                                                                    class="fa fa-eye"></i></a>
                                                                                
                                                                                @endif   
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