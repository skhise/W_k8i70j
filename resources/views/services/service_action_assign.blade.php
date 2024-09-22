<div class="modal fade bd-RefServiceAssign-modal-lg" data-backdrop="static" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Assign</h5>
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
                <div class="pull-right d-flex">
                    <button type="button" class="btn btn-primary mr-2" id="btn_service_assign_save">Save</button>
                    <button class="btn btn-danger" onclick="CancelModelBoxServiceAssign()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
