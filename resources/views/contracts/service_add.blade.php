<div class="modal fade bd-RefService-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Services</h5>
                    <button type="button" id="btn_close_service" data-toggle="modal" data-target=".bd-RefService-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_service" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="contractId" name="contractId" value="{{$contract['CNRT_ID']}}" style="display:none;" />
                        <div class="form-group">
                        
                            <div class="row">
                                <div class="col-md-3 floating-label">
                                    <input type="number" class="form-control text-box single-line" id="number_of_services"
                                        name="number_of_services" placeholder="" type="text" value="" required/>
                                        <label for="first">Total Services</label>
                                </div>
                                <div class="col-md-3 floating-label">
                                    <input class="disabled form-control text-box single-line" id="service_start_date"
                                        name="service_start_date" placeholder="" type="text" value="{{date("d-M-Y", strtotime($contract['CNRT_StartDate']))}}" readonly/>
                                        <label for="first">Start Date</label>
                                </div>
                                <div class="col-md-3 floating-label">
                                    <input class="disabled form-control text-box single-line" id="service_end_date"
                                        name="service_end_date" placeholder="" type="text" value="{{date("d-M-Y", strtotime($contract['CNRT_EndDate']))}}" readonly/>
                                        <label for="first">End Date</label>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="add_servies_rows" class="btn btn-icon btn-primary"><i class="fa fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="service_div">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" id="btn_service_save">Save</button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBoxService()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
