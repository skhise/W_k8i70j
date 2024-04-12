<div class="modal fade bd-RefPSR-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Products</h5>
                <button type="button" id="btn_close" data-toggle="modal" data-target=".bd-RefPSR-modal-lg"
                    class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errorMsgntainer"></div>
                <form id="form_cp" onsubmit="return false;">
                    @csrf
                    <input type="text" id="product_id" name="product_id" style="display:none;" />
                    <div class="form-group">
                        <label class="control-label">Sr. Number (Total: <span id="add_sr_no">1</span>) <span
                                class="text-danger-error text-danger srnumber-field-validation-valid"
                                data-valmsg-replace="true"></span></label>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="input-group">
                                    <input class="form-control text-box single-line" id="nrnumber_0" name="nrnumber[]"
                                        placeholder="" type="text" value="" />
                                    <span class="btn btn-primary input-group-addon add_form_field"><i class="fa fa-plus"
                                            aria-hidden="true"></i></span>

                                </div>


                            </div>
                            <div class="col-md-12 mb-2" id="multipeInput">

                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right d-flex">
                    <button type="button" class="action-btn btn btn-primary  mr-2"
                        onclick="SaveProduct()">Save</button>
                    <button class="ction-btn btn btn-danger" onclick="CancelModelBox()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
