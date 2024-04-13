<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Details</h4>
                                <div class="card-header-action">
                                    <a class="btn btn-danger" href="{{ route('products') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('product_activeTab') === 'product_details' || session('product_activeTab') == '' ? ' active' : '' }}"
                                            id="product_details" data-toggle="tab" href="#product_details_div"
                                            role="tab" aria-controls="product_details" aria-selected="true">Product
                                            Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  {{ session('product_activeTab') === 'product_srno' ? ' active' : '' }}"
                                            id="product_srno" data-toggle="tab" href="#product_srno_div" role="tab"
                                            aria-selected="false" aria-controls="product_srno">Serial Numbers <span
                                                class="badge bg-danger text-white">{{ $serialnumbers->count() }}</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade {{ session('product_activeTab') === 'details' || session('product_activeTab') == '' ? ' show active' : '' }} "
                                        id="product_details_div" role="tabpanel" aria-labelledby="product_details">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">{{ $product->Product_Name }}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ">
                                                            <li class="list-group-item">
                                                                <div class="box-body">
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Product
                                                                        Type
                                                                    </strong>
                                                                    <p class="text-muted">
                                                                        {{ $product->type_name }}
                                                                    </p>
                                                                    <strong>
                                                                        <i
                                                                            class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Status
                                                                    </strong>
                                                                    <p>{!! $status[$product['Status']] !!}</p>
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
                                                                <span style="float:right ;font-weight:bold">Product
                                                                    Name</span>
                                                            </div>
                                                            <div class="col-md-9">{{ $product->Product_Name }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold">Product
                                                                    Price</span>
                                                            </div>
                                                            <div class="col-md-9">{{ $product->Product_Price }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <span
                                                                    style="float:right ;font-weight:bold">Description</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $product->Product_Description }}
                                                            </div>
                                                        </div>
                                                        <div class="row hide">
                                                            <div class="col-md-3">
                                                                <span style="float:right ;font-weight:bold;">
                                                                    Product Image
                                                                </span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <image src="{{ $img_url }}" alt=""
                                                                    width="200" height="200" />
                                                                <form method="post"
                                                                    action="{{ route('products.upload', $product->Product_ID) }}"
                                                                    enctype="multipart/form-data" id="image_upload">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label>Change Image</label>
                                                                        <input
                                                                            class="form-control text-box single-line @error('Image_Path') is-invalid @enderror"
                                                                            data-val="true" id="Image_Path"
                                                                            name="Image_Path" placeholder=""
                                                                            required="required" type="file"
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
                                    <div class="tab-pane fade {{ session('product_activeTab') === 'product_srno' ? ' show active' : '' }} "
                                        id="product_srno_div" role="tabpanel" aria-labelledby="product_srno">
                                        @include('products.serial_number')
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('products.product_add')
    </div>
    @section('script')
        <script>
            $(document).on('change', '#Image_Path', function() {
                var value = $(this).val();
                if (value != "") {
                    $('#image_upload')[0].submit();
                }
            });
            $(document).ready(function() {
                var max_fields = 100;
                var wrapper = $("#multipeInput");
                var add_button = $(".add_form_field");
                var x = 1;
                $(add_button).click(function(e) {
                    e.preventDefault();
                    if (x < max_fields) {
                        x++;
                        $("#add_sr_no").text(x);
                        $(wrapper).prepend(
                            '<div class="input-group mt-2"><input type="text" class="form-control nrnumber" id="nrnumber_' +
                            x +
                            '" name="nrnumber[]"/><span class="btn btn-danger input-group-addon add_form_field delete"><i class="fa fa-trash" aria-hidden="true"></i></span></div > '
                        ); //add input box
                    } else {
                        alert('You Reached the limits')
                    }
                });
                $(wrapper).on("click", ".delete", function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                    $("#add_sr_no").text(x);

                })
            });

            function SaveProduct() {
                $('.text-danger-error').html('');
                $(".nrnumber").removeClass("error_border");
                var product_id = $("#product_id").val();
                var url = "{{ route('products.add-sn', $product->Product_ID) }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $("#form_cp").serialize(),
                    success: function(response) {
                        //  var obj = JSON.parse(response);
                        if (response.success) {
                            CancelModelBox();
                            window.location.reload();
                        } else {
                            $('.errorMsgntainer').html("");
                            if (typeof response.validation_error != 'undefined') {
                                $.each(response.validation_error, function(index, value) {
                                    var id = index.replace(".", "_");
                                    $("#" + id).addClass('error_border');
                                    $('.srnumber-field-validation-valid').html(
                                        "required valid serial number.");
                                    // $("#" + index).('<div id="cmprivacy">' + value + '</div>');
                                });
                            } else {
                                $('.srnumber-field-validation-valid').html(response.message);
                            }


                        }

                    },
                    error: function(error) {
                        alert("something went wrong, try again.");
                    }
                })
            }

            function CancelModelBox() {
                $("#product_id").val("");
                $('.text-danger-error').html('');
                $("#add_sr_no").html(1);
                $(".nrnumber").removeClass("error_border");
                $("#form_cp")[0].reset();
                $("#multipeInput").html("");
                $("#btn_close").trigger('click');
            }
        </script>
    @stop
</x-app-layout>
