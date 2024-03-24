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
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ session('dc_product_activeTab') === 'dc_details' || session('dc_product_activeTab') == "" ? ' active' : '' }}"
                                            id="dc_details" data-toggle="tab"
                                                href="#dc_details_div" role="tab" aria-controls="dc_details"
                                                aria-selected="true">DC Details</a>
                                        </li>
                                        <li class="nav-item">   
                                            <a class="nav-link  {{ session('dc_product_activeTab') === 'dc_product' ? ' active' : '' }}"
                                            id="dc_product" data-toggle="tab" href="#dc_product_div"
                                                role="tab" aria-selected="false" aria-controls="dc_product">Dc Products</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered">
                                        <div class="tab-pane fade {{ session('dc_product_activeTab') === 'dc_details' || session('dc_product_activeTab') == "" ? ' show active' : '' }} "
                                         id="dc_details_div" role="tabpanel"
                                            aria-labelledby="dc_details">
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
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Issue
                                                                            Type
                                                                        </strong>
                                                                        <p class="text-muted">
                                                                            {{$service_dc->dc_type_name}}
                                                                        </p>
                                                                        <strong>
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Status
                                                                        </strong>
                                                                        <p>{{$service_dc['dc_status_name']}}</p>
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
                                                                <div class="col-md-9">{{$service_dc->service_dc}}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Issue Type</span>
                                                                </div>
                                                                <div class="col-md-9">{{$service_dc->dc_type_name}}</div>
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
                                        </div>
                                        <div class="tab-pane fade {{ session('dc_product_activeTab') === 'dc_product' || session('dc_product_activeTab') == "" ? ' show active' : '' }} "
                                         id="dc_product_div" role="tabpanel"
                                            aria-labelledby="dc_product">
                                            @include('services.dc_product')
                                        </div>
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
        $(document).on('change', '#Image_Path', function () {
            var value = $(this).val();
            if (value != "") {
                $('#image_upload')[0].submit();
            }
        });
    </script>
    @stop
</x-app-layout>