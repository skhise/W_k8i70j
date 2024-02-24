<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4>Contract Type</h4>
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
                                            @if(count($contractTypes) == 0)
                                            <tr class="text-center">
                                                <td colspan="6">No type added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($contractTypes as $index=>$contractType)
                                            <tr key="{{$contractType['id']}}">
                                                <td>{{$index+1}}</td>
                                                <td>{{$contractType['contract_type_name']}}</td>
                                                <td>
                                                    <button data-action="delete" data-id="{{$contractType['id']}}"
                                                        class="btn-delete btn btn-danger btn-sm btn-icon"><i
                                                            class="fa fa-trash"></i></button>
                                                    <button data-name="{{$contractType['contract_type_name']}}"
                                                        data-id="{{$contractType['id']}}"
                                                        class="btn-edit btn btn-primary btn-sm btn-icon mr-2"><i
                                                            class="far fa-edit"></i></button>


                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($contractTypes->count())
                                        <p>Found {{ $contractTypes->count()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $contractTypes->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Contract Type</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 floating-label">
                                            <input type="text" id="type_id" value="0" name="type_id"
                                                style="display:none;" />
                                            <input type="text" id="flag" value="0" name="flag" style="display:none;" />
                                            <input class="form-control" type="text" name="contract_type_name"
                                                id="contract_type_name" />
                                            <label>Type Name</label>
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
            $("#contract_type_name").val('');
            $("#flag").val('0');
        });
        $(document).on('click', "#btnAddCt", function () {
            var id = $("#type_id").val();
            var name = $("#contract_type_name").val();
            var flag = $("#flag").val();
            if (name != "" && typeof name != 'undefined') {
                $.ajax({
                    url: '/masters/contract-type',
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
                alert("Type name required");
            }
        });
        $(document).on('click', ".btn-edit", function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $("#flag").val(1);
            $("#contract_type_name").val(name);
            $("#type_id").val(id);

        });
        $(document).on('click', ".btn-delete", function () {
            var con = confirm("Are you sure to delete?");
            if (con) {
                var id = $(this).data('id');
                var currentRow = $(this).closest("tr");

                if (id != "" && typeof id != 'undefined') {
                    $.ajax({
                        url: '/masters/contract-type',
                        method: 'delete',
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.code == 200) {
                                // currentRow.remove();
                                alert("Deleted!");
                                window.location.reload();
                            } else {
                                alert("action failed, try again");
                            }
                        },
                        error: function (error) {
                            sweet("Something went wrong, try again.");
                        }
                    })
                } else {
                    alert("Something went wrong, try again");
                }
            }


        });

    </script>

    @stop
</x-app-layout>