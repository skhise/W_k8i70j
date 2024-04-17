<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>DC Management</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Service. No.</th>
                                                                        <th>Client Name</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Type</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if($dc_products->count() == 0)
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">No
                                                                            products
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                   @foreach($dc_products as $index => $dcp) 
                                                                    <tr>
                                                                        <td>{{$index + 1}}</td>
                                                                        <td>{{$dcp['service_no']}}</td>
                                                                        <td>{{$dcp['CST_Name']}}</td>
                                                                        <td>{{date("d-M-Y", strtotime($dcp['issue_date']))}}</td>
                                                                        <td>{{$dcp['dc_type_name']}}</td>
                                                                        <td>
                                                                            <div class="d-flex">
                                                                                <a class="delete-btn action-btn btn btn-sm btn-danger" href="{{route('services.dc_delete', $dcp['dcp_id'])}}"><i class="fa fa-trash"></i></a>
                                                                                <a class="action-btn btn btn-sm btn-primary" href="{{route('services.dc_view', $dcp['dcp_id'])}}"><i class="fa fa-eye"></i></a>
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

            </div>
        </section>
    </div>
 
</x-app-layout>