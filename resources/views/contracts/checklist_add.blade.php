<div class="modal fade bd-RefChecklist-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Note</h5>
                    <button type="button" id="btn_close_checklist" data-toggle="modal" data-target=".bd-RefChecklist-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_checklist" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="contractId" name="contractId" value="{{$contract['CNRT_ID']}}" style="display:none;" />
                        <input type="text" id="checklist_id" name="checklist_id" value="0"
                            style="display:none;" />
                        <div class="form-group">
                        <label for="first">Description</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea class="form-control text-box single-line" id="description"
                                        name="description" placeholder="" type="text" value="" required></textarea>
                                        <span
                                    class="text-danger-error text-danger description-field-validation-valid"
                                    data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" id="btn_checklist_save">Save</button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBoxChecklist()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
