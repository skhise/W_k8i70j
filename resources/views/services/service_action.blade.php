<div class="modal fade bd-RefServiceStatus-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Assign</h5>
                <button type="button" id="btn_close_service_status" data-toggle="modal"
                    data-target=".bd-RefServiceStatus-modal-lg" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errorMsgntainer"></div>
                <form id="form_service_status" onsubmit="return false;">
                    @csrf
                    <input type="hidden" id="service_id" name="service_id" value="{{ $service_id }}"
                        style="display:none;" />
                    <div class="form-group">

                        <div class="row">
                            <div class="col-md-12 floating-label">
                                <select class="required form-control text-box single-line" id="status_id"
                                    name="status_id" placeholder="">
                                    {!! $status_options !!}
                                </select>
                                <label for="first">Status *</label>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 floating-label">
                                <select class="required form-control text-box single-line" id="sub_status_id"
                                    name="sub_status_id" placeholder="">
                                    <option value="0">None</option>
                                </select>
                                <label for="first">Sub Status *</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 floating-label">
                                <textarea class="form-control text-box single-line" id="action_description" name="action_description"
                                    placeholder=""></textarea>
                                <label for="first" id="action_description_lbl">Description</label>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $service->service_status == 5 ? '' : 'hide' }}" id="close_call_div">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 floating-label">
                                    <select class="form-control text-box single-line" id="service_category"
                                        name="service_category">
                                        @if ($service->contract_id != 0)
                                            <option value="1">Under AMC</option>
                                        @endif
                                        <option value="2">Chargeable</option>
                                    </select>
                                    <label for="first">Service Category *</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <textarea type="text" class="form-control text-box single-line" id="expenses"
                                        name="expenses" placeholder=""></textarea>
                                    <label for="first">Your Expenses *</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <textarea type="text" class="form-control text-box single-line" id="charges"
                                        name="charges" placeholder=""></textarea>
                                    <label for="first">Call Charges *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right d-flex">
                    <button type="button" class="btn btn-primary  mr-2" id="btn_service_status_save">Save</button>
                    <button class="btn btn-danger" onclick="CancelModelBoxServiceAction()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
