<div class="modal fade bd-RefServiceAssign-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Status</h5>
                <button type="button" id="btn_close_service_assign" data-toggle="modal"
                    data-target=".bd-RefServiceAssign-modal-lg" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errorMsgntainer"></div>
                <form id="form_service_assign" onsubmit="return false;">
                    @csrf
                    <input type="hidden" id="service_id_assign" name="service_id_assign" value="{{ $service_id }}"
                        style="display:none;" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">

                                <label for="first">Select Employee *</label>
                                <select class="required form-control text-box single-line select2" id="employee_id"
                                    name="employee_id" placeholder="">
                                    {!! $employee_options !!}
                                </select>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" id="btn_service_assign_save">Save</button>
                    <button class="btn btn-danger mr-2" onclick="CancelModelBoxServiceAssign()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
