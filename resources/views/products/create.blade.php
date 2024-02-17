<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Product' : 'Add Product'}}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateemployee" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('products.update',$product->Product_ID) : route('products.store')}}">
                                    @csrf
                                    @if(!$update)
                                    <input type="hidden" id="created_by" name="created_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="client_id" name="client_id" value="{{Auth::user()->id}}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="account_id" name="account_id"
                                        value="{{Auth::user()->account_id}}" />
                                    <div class="form-horizontal">

                                        <h3 style="color:orangered"></h3>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Product Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Name</span>
                                                </div>

                                                <div class="col-md-4 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('Product_Name') is-invalid @enderror"
                                                        data-val="true" id="Product_Name" name="Product_Name"
                                                        placeholder="" required="required" type="text"
                                                        value="{{old('Product_Name') ?? $product->Product_Name}}" />
                                                    <label for="Product_Name">Name *</label>
                                                    @if($errors->has('Product_Name'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="Product_Name" data-valmsg-replace="true">{{
                                                        $errors->first('Product_Name') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-lg-3 floating-label">
                                                    <select
                                                        class="form-control text-box single-line @error('Product_Type') is-invalid @enderror"
                                                        name="Product_Type" id="Product_Type">
                                                        <option "">Select Type</option>
                                                        @foreach($product_types as $product_type)
                                                        <option value="{{$product_type->id}}" {{$product_type->id ==
                                                            old('Product_Type') ? 'selected' :
                                                            ''}} {{$product_type->id ==
                                                            $product->Product_Type ? 'selected' :
                                                            ''}}>
                                                            {{$product_type->type_name}}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                    @if($errors->has('Product_Type'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="Product_Type" data-valmsg-replace="true">{{
                                                        $errors->first('Product_Type ') }}</span>

                                                    @endif
                                                </div>
                                                <div class="col-md-3 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('Product_Price') is-invalid @enderror"
                                                        data-val="true" id="Product_Price" name="Product_Price"
                                                        placeholder="" required="required" type="number"
                                                        value="{{old('Product_Price') ?? $product->Product_Price}}" />
                                                    <label for="Product_Price">Price</label>
                                                    @if($errors->has('Product_Price'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="Product_Price" data-valmsg-replace="true">{{
                                                        $errors->first('Product_Price') }}</span>

                                                    @endif
                                                </div>

                                            </div>
                                        </div>

                                        @if(!$update)
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Product Image</span>
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <input
                                                        class="form-control text-box single-line @error('Image_Path') is-invalid @enderror"
                                                        data-val="true" id="Image_Path" name="Image_Path" placeholder=""
                                                        required="required" type="file"
                                                        accept="image/png, image/jpeg,, image/jpg"
                                                        value="{{old('Image_Path') ?? $product->Image_Path}}" />
                                                    @if($errors->has('Image_Path'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="Image_Path" data-valmsg-replace="true">{{
                                                        $errors->first('Image_Path') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span style="float:right ;font-weight:bold">Description</span>
                                                </div>
                                                <div class="col-md-4 floating-label">
                                                    <textarea
                                                        class="form-control text-box single-line @error('Product_Description') is-invalid @enderror"
                                                        data-val="true" id="Product_Description"
                                                        name="Product_Description" placeholder="" required="required"
                                                        type="text">{{old('Product_Description') ?? $product->Product_Description}}</textarea>
                                                    @if($errors->has('Product_Description'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="Product_Description"
                                                        data-valmsg-replace="true">{{
                                                        $errors->first('Product_Description') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                <input type="button" id="btnAddEmployee"
                                                    value="{{$update ? 'Update' :'Save'}}" class="btn btn-primary">
                                                <a type="button" class="btn btn-danger"
                                                    href="{{route('clients')}}">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @section('script')
    <script>
        $("input[type = 'text']").each(function () {
            $(this).change(function () {
                $(this).removeClass('is-invalid');
                $(this).siblings('span').text('');
            });
        });
        $('#btnAddEmployee').on('click', function () {
            $("#frmcreateemployee")[0].submit();
        });
    </script>

    @stop
</x-app-layout>