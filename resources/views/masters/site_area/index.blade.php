<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4>Site Location</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>Name</th>
                                                <th style="text-align:end;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($siteAreas) == 0)
                                            <tr class="text-center">
                                                <td colspan="6">No site location added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($siteAreas as $index=>$siteArea)
                                            <tr key="{{$siteArea['id']}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{$siteArea['SiteAreaName']}}</td>
                                                <td>
                                                    <button data-action="delete" data-id="{{$siteArea['id']}}"
                                                        class="btn-delete btn btn-danger btn-sm btn-icon"><i
                                                            class="fa fa-trash"></i></button>
                                                    <button data-name="{{$siteArea['SiteAreaName']}}"
                                                        data-id="{{$siteArea['id']}}"
                                                        class="btn-edit btn btn-primary btn-sm btn-icon mr-2"><i
                                                            class="far fa-edit"></i></button>


                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($siteAreas->count())
                                        <p>Found {{ $siteAreas->count()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $siteAreas->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Location</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 floating-label">
                                            <input type="text" id="type_id" value="0" name="type_id"
                                                style="display:none;" />
                                            <input type="text" id="flag" value="0" name="flag" style="display:none;" />
                                            <input class="form-control" type="text" name="SiteAreaName"
                                                id="SiteAreaName" />
                                            <label>Location Name</label>
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
            $("#type_id").val('');
            $("#SiteAreaName").val('');
            $("#flag").val('0');
        });
        $(document).on('click', "#btnAddCt", function () {
            var id = $("#type_id").val();
            var name = $("#SiteAreaName").val();
            var flag = $("#flag").val();
            if (name != "" && typeof name != 'undefined') {
                $.ajax({
                    url: '/masters/site-area',
                    method: 'post',
                    data: {
                        id: id,
                        flag: flag,
                        name: name,
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
                alert("Location name required");
            }
        });
        $(document).on('click', ".btn-edit", function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $("#flag").val(1);
            $("#SiteAreaName").val(name);
            $("#type_id").val(id);

        });
        $(document).on('click', ".btn-delete", function () {

            var con = confirm("Are you sure to delete?");
            if (con) {
                var id = $(this).data('id');
                var currentRow = $(this).closest("tr");

                if (id != "" && typeof id != 'undefined') {
                    $.ajax({
                        url: '/masters/site-area',
                        method: 'delete',
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.code == 200) {
                                // currentRow.remove();
                                showalert("Deleted","Success",false);
                                window.location.reload();
                            } else {
                                showalert("action failed, try again","Error",true);
                            }
                        },
                        error: function (error) {
                            showalert("Something went wrong, try again.","Error",true);
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