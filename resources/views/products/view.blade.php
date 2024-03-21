<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contract Details</h4>
                                <div class="card-header-action">
                                    <a class="btn btn-danger"
                                            href="{{route('products')}}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ session('product_activeTab') === 'product_details' || session('product_activeTab') == "" ? ' active' : '' }}"
                                            id="product_details" data-toggle="tab"
                                                href="#product_details_div" role="tab" aria-controls="product_details"
                                                aria-selected="true">Product Details</a>
                                        </li>
                                        <li class="nav-item">   
                                            <a class="nav-link  {{ session('product_activeTab') === 'product_srno' ? ' active' : '' }}"
                                            id="product_srno" data-toggle="tab" href="#product_srno_div"
                                                role="tab" aria-selected="false" aria-controls="product_srno">Contract
                                                Product</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered">
                                        <div class="tab-pane fade {{ session('product_activeTab') === 'details' || session('product_activeTab') == "" ? ' show active' : '' }} "
                                         id="product_details_div" role="tabpanel"
                                            aria-labelledby="product_details">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h4 class="text-uppercase">{{$product->Product_Name}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <ul class="list-group ">
                                                                <li class="list-group-item">
                                                                    <div class="box-body">
                                                                        <strong>
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Product
                                                                            Type
                                                                        </strong>
                                                                        <p class="text-muted">
                                                                            {{$product->type_name}}
                                                                        </p>
                                                                        <strong>
                                                                            <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Status
                                                                        </strong>
                                                                        <p>{!!$status[$product['Status']]!!}</p>
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
                                                                <h class="">PRODUCT DETAILS</h5>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Product Name</span>
                                                                </div>
                                                                <div class="col-md-9">{{$product->Product_Name}}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Product Price</span>
                                                                </div>
                                                                <div class="col-md-9">{{$product->Product_Price}}</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold">Description</span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {{$product->Product_Description}}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <span style="float:right ;font-weight:bold;">
                                                                        Product Image
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <image src="{{$img_url}}" alt="" width="200" height="200" />
                                                                    <form method="post"
                                                                        action="{{route('products.upload', $product->Product_ID)}}"
                                                                        enctype="multipart/form-data" id="image_upload">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label>Change Image</label>
                                                                            <input
                                                                                class="form-control text-box single-line @error('Image_Path') is-invalid @enderror"
                                                                                data-val="true" id="Image_Path" name="Image_Path"
                                                                                placeholder="" required="required" type="file"
                                                                                accept="image/png, image/jpeg,, image/jpg" />
                                                                        </div>
                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade {{ session('product_activeTab') === 'details' || session('product_activeTab') == "" ? ' show active' : '' }} "
                                         id="product_srno_div" role="tabpanel"
                                            aria-labelledby="product_srno">
                                            @include('products.serial_number')
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