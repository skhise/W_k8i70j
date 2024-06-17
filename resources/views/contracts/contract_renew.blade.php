<div class="modal fade bd-RefContractRenew-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Renew Contract</h5>
                <button type="button" id="btn_close_renew" data-toggle="modal"
                    data-target=".bd-RefContractRenew-modal-lg" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errorMsgntainer"></div>
                <form id="form_contract_renew" onsubmit="return false;">
                    @csrf
                    <input style="display:none;" id="contract_id" name="contract_id" style="display:none;" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 floating-label">
                                <input type="date" class="required form-control text-box single-line" data-val="true"
                                    id="new_start_date" name="new_start_date" placeholder="" required="required" />
                                <label>Start Date <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-6 floating-label">
                                <input type="date" class="required form-control text-box single-line" data-val="true"
                                    id="new_expiry_date" name="new_expiry_date" placeholder="" required="required" />
                                <label>Expriy Date <span class="text-danger">*</span></label>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 floating-label">
                                <input class="required form-control text-box single-line" data-val="true" id="amount"
                                    name="amount" placeholder="" required="required" />
                                <label>Renewal Amount <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 floating-label">
                                <textarea class="required form-control text-box" rows="2" id="renewal_note" name="renewal_note" placeholder=""
                                    required="required"></textarea>
                                <label>Note <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" id="btn_renew_save">Save</button>
                    <button class="btn btn-danger mr-2" onclick="CancelModelBoxRenew()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
