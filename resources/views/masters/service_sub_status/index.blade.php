<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4>Service Sub Status</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>Sub Status</th>
                                                <th>Status</th>
                                                <th style="text-align:end;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($serviceSubStatus) == 0)
                                            <tr class="text-center">
                                                <td colspan="4">No added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($serviceSubStatus as $index=>$subStatus)
                                            <tr key="{{$subStatus['Sub_Status_Id']}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{$subStatus['Sub_Status_Name']}}</td>
                                                <td>{{$subStatus['Status_Name']}}</td>
                                                <td>
                                                    <div class="d-flex float-right">
                                                    <button data-statusid="{{$subStatus['status_id']}}" data-name="{{$subStatus['Sub_Status_Name']}}"
                                                        data-id="{{$subStatus['Sub_Status_Id']}}"
                                                        class="btn-edit btn btn-primary btn-sm btn-icon mr-2"><i
                                                            class="far fa-edit"></i></button>
                                                    <button data-name="{{$subStatus['Sub_Status_Name']}}"
                                                        data-id="{{$subStatus['Sub_Status_Id']}}"
                                                        class="btn-delete btn btn-danger btn-sm btn-icon mr-2"><i
                                                            class="fa fa-trash"></i></button>
                                                    </div>
                                                    


                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($serviceSubStatus->count())
                                        <p>Found {{ $serviceSubStatus->count()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $serviceSubStatus->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Sub Status</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 floating-label">
                                        
                                            <select class="form-control" id="status_id" name="status_id">
                                                <option value="">Select Status</option>
                                                @foreach($status as $st)
                                                        <option value="{{$st->Status_Id}}">{{$st->Status_Name}}</option>
                                                @endforeach
                                                <label>Status</label>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 floating-label">
                                            <input type="text" id="sub_status_id" value="0" name="sub_status_id"
                                                style="display:none;" />
                                            <input type="text" id="flag" value="0" name="flag" style="display:none;" />
                                            <input class="form-control" type="text" name="sub_status_name"
                                                id="sub_status_name" />
                                            <label>Sub Status Name</label>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                            <div class="form-group">
                                <div class="card-footer text-right">
                                    <button type="button" id="btnResetCt" class="btn btn-danger">Reset</button>

                                    <button type="button" id="btnAddCt" class="mr-2 btn btn-primary">Save</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @section('script')

    <script>
        $(document).on('click', "#btnResetCt", function () {
            $("#sub_status_id").val('');
            $("#sub_status_name").val('');
            $("#status_id").val('');
            $("#flag").val('0');
        });
        $(document).on('click', "#btnAddCt", function () {
            var id = $("#sub_status_id").val();
            var name = $("#sub_status_name").val();
            var status_id = $("#status_id").val();
            var flag = $("#flag").val();
            if (name != "" && typeof name != 'undefined') {
                $.ajax({
                    url: '/masters/service-sub-status',
                    method: 'post',
                    data: {
                        id: id,
                        flag: flag,
                        name: name,
                        status_id:status_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        // response = JSON.parse(response);
                        if (response.success) {
                            alert("Saved!");
                            window.location.reload();
                        } else {
                            alert("action failed, try again");
                        }
                    },
                    error: function (error) {
                        alert("Something went wrong, try again.");
                    }
                })
            } else {
                alert("Status name required");
            }
        });
        $(document).on('click', ".btn-edit", function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var statusid = $(this).data('statusid');
            $("#flag").val(1);
            $("#sub_status_name").val(name);
            $("#sub_status_id").val(id);
            $("#status_id").val(statusid);

        });
        $(document).on('click', ".btn-delete", function () {
            var con = confirm("Are you sure to delete?");
            if (con) {
                var id = $(this).data('id');
                var currentRow = $(this).closest("tr");

                if (id != "" && typeof id != 'undefined') {
                    $.ajax({
                        url: '/masters/service-sub-status',
                        method: 'delete',
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.code == 200) {
                                showalert("Deleted","Success",false);
                                window.location.reload();
                            } else {
                                showalert("Something went wrong, try again","Error",true);
                            }
                        },
                        error: function (error) {
                            showalert("Something went wrong, try again","Error",true);
                        }
                    })
                } else {
                    showalert("Something went wrong, try again","Error",true);
                }
            }


        });
        function showalert(message,flag,flag1){
 Swal.fire({
                                title: flag+'!',
                                text: message,
                                dangerMode: flag1,
                                icon: flag1 ? 'error' :'success',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            });
                        }
    </script>

    @stop
</x-app-layout>