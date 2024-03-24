<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">DC Details</h4>
                                <div class="card-header-action">
                                    <a class="btn btn-danger"
                                            href="{{route('dcmanagements')}}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h4 class="text-uppercase">{{$service_dc->Product_Name}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <ul class="list-group ">
                                                                <li class="list-group-item">
                                                                    <div class="box-body">
                                                                    <strong>
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;DC
                                                                            No.
                                                                        </strong>
                                                                        <p class="text-muted">
                                                                            {{$service_dc->id}}
                                                                        </p>  
                                                                    <strong>
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;DC
                                                                            Type
                                                                        </strong>
                                                                        <p class="text-muted">
                                                                            {{$service_dc->dc_type_name}}
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <br />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card card-success">
                                                        <div class="card-body">
                                                            <div>
                                                                <h class="">DC DETAILS</h5>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Client Name</span>
                                                                </div>
                                                                <div class="col-md-9">{{$service_dc->CST_Name}}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Service No.</span>
                                                                </div>
                                                                <div class="col-md-9">{{$service_dc->service_no}}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Description</span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {{$service_dc->Product_Description}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                </div>
                                            </div>
                                            @include('services.dc_product')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    @section('script')
    <script>
        $(document).on('change', '#Image_Path', function () {
            var value = $(this).val();
            if (value != "") {
                $('#image_upload')[0].submit();
            }
        });
    </script>
    @stop
</x-app-layout>