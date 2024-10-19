<div class="modal fade bd-RefPasswordReset-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Set Password</h5>
                <button type="button" id="btn_close_password" data-toggle="modal"
                    data-target=".bd-RefPasswordReset-modal-lg" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errorMsgntainer"></div>
                <form id="form_password_reset" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 floating-label">
                                <div class="password-container">
                                    <input
                                        class="required form-control text-box single-line @error('password') is-invalid @enderror"
                                        data-val="true" id="password" name="password" placeholder=""
                                        required="required" type="password" value="{{ old('password') }}" />
                                    <label>Password <span class="text-danger">*</span></label>
                                    <span id="togglePassword" class="toggle-password"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right d-flex">
                    <button type="button" class="btn btn-primary  mr-2" id="btn_password_save">Save</button>
                    <button class="btn btn-danger" onclick="CancelModelBoxPassword()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
