<div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>Serial Numbers</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefClient">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Serial Number</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($serialnumbers->count() == 0)
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No
                                                                            serial number added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($serialnumbers as $index => $serialnumber)
                                                                    <tr>
                                                                        <td>
                                                                            {{$index + 1}}
                                                                        </td>
                                                                        <td>
                                                                            {{$serialnumber->sr_number}}
                                                                        </td>
                                                                        <td>
                                                                        <a href="{{route('product_srno.delete', $serialnumber['id'])}}" class="delete-btn btn btn-sm btn-danger"><i
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