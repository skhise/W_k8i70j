<div class="modal fade bd-RefServiceStatus-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Status</h5>
                    <button type="button" id="btn_close_service_status" data-toggle="modal" data-target=".bd-RefServiceStatus-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_service_status" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="service_id" name="service_id" value="{{$service_id}}" style="display:none;" />
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
                                        {!! $sub_status_options !!}
                                    </select>
                                        <label for="first">Sub Status *</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                                <div class="col-md-12 floating-label">
                                    <textarea class="required form-control text-box single-line" id="action_description"
                                        name="action_description" placeholder=""></textarea>
                                        <label for="first">Description  *</label>
                                </div>
                            </div>
                        </div>
                        <p>Note: All * marked are required.</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" id="btn_service_status_save">Save</button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBoxServiceAction()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>