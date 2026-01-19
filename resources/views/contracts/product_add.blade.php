<div class="modal fade bd-RefClient-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Contract Products</h5>
                    <button type="button" id="btn_close" data-toggle="modal" data-target=".bd-RefClient-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_cp" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="contractId" name="contractId" value="{{$contract['CNRT_ID']}}" style="display:none;" />
                        <input type="text" id="product_id" name="product_id"
                            style="display:none;" />
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <select class="form-control text-box single-line" id="product_type"
                                        name="product_type" placeholder="">

                                        <option value="">Select Type</option>
                                        @foreach($productType as $product_type)
                                        <option value="{{$product_type->id}}">{{$product_type->type_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="first">Product Type<span class="text-danger">*</span></label>
                                    <span class="text-danger-error text-danger product_type-field-validation-valid"
                                        data-valmsg-replace="true"></span>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="product_name"
                                        name="product_name" placeholder="" type="text" value="" />
                                    <label for="first">Name<span class="text-danger">*</span></label>
                                    <span class="text-danger-error text-danger product_name-field-validation-valid"
                                        data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 floating-label">
                                    <input class="form-control text-box single-line" id="product_description"
                                        name="product_description" placeholder="" type="text" value="" />
                                    <label for="first">Description</label>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Sr. Number (Total: <span id="add_sr_no">1</span>)(Unique serial number) <span
                                    class="text-danger-error text-danger srnumber-field-validation-valid"
                                    data-valmsg-replace="true"></span></label>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control text-box single-line" id="nrnumber_0"
                                            name="nrnumber[]" placeholder="" type="text" value="" />
                                        <span class="btn btn-primary input-group-addon add_form_field"><i
                                                class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2" id="multipeInput">

                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="branch" name="branch"
                                        placeholder="" type="text" value="" />
                                    <label for="first">Branch / Location</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="service_period"
                                        name="service_period" placeholder="" type="text" value="" />
                                    <label for="first">Support Period</label>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="remark" name="remark"
                                        placeholder="" type="text" value="" />
                                    <label for="first">Remark (Note)</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input class="form-control text-box single-line" id="product_price"
                                        name="product_price" placeholder="" type="number" value="" />
                                    <label for="first">Product Value</label>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" id="btn_save_product" class="btn btn-primary" onclick="SaveContractProduct()">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin" style="color: white;"></i>
                            </span>
                        </button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBox()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>