<div class="modal fade bd-RefServiceEdit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Update Service</h5>
                    <button type="button" id="btn_close_service_edit" data-toggle="modal" data-target=".bd-RefServiceEdit-modal-lg"
                        class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errorMsgntainer"></div>
                    <form id="form_service_edit" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="contractId" name="contractId" value="{{$contract['CNRT_ID']}}" style="display:none;" />
                        <input type="text" id="service_id" name="service_id" value="0"
                            style="display:none;" />
                        <div class="form-group">
                        
                            <div class="row service_row">
                                <div class="col-md-6 floating-label">
                                    <input class="required form-control text-box single-line" id="Schedule_Date_edit"
                                        name="Schedule_Date" type="date" value="" required/>
                                        <label for="first">Schedule Date</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <select class="form-control text-box" id="product_Id_edit"
                                        name="product_Id">
                                        {!! $productOption !!}
                                    </select>
                                        <label for="first">Select Product</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group service_row">
                            <div class="row">
                                <div class="col-md-6 floating-label">
                                    <select class="required form-control text-box" id="issueType_edit"
                                        name="issueType">
                                        {!! $issueType !!}
                                    </select>
                                        <label for="first">Select Issue</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <select class="required form-control text-box" id="serviceType_edit"
                                        name="serviceType">
                                        {!! $serviceType !!}
                                    </select>
                                    <label for="first">Select Service Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 floating-label">
                                    <input class="form-control text-box single-line" id="description_edit"
                                        name="description" placeholder="" type="text" value=""/>
                                        <label for="first">Description</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" id="btn_service_update">Save</button>
                        <button class="btn btn-danger mr-2" onclick="CancelModelBoxServiceEdit()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
