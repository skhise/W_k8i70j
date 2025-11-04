<style>
.password-container {
    position: relative;
}
.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
}
.toggle-password:hover {
    color: #495057;
}
</style>

<div class="modal fade bd-RefPasswordReset-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                <button type="button" id="btn_close_password" data-toggle="modal"
                    data-target=".bd-RefPasswordReset-modal-lg" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Password must be at least 6 characters long.
                </div>
                <div class="errorMsgntainer"></div>
                <form id="form_password_reset" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>New Password <span class="text-danger">*</span></label>
                                <div class="password-container">
                                    <input
                                        class="required form-control text-box single-line @error('password') is-invalid @enderror"
                                        data-val="true" id="password" name="password" placeholder="Enter new password"
                                        required="required" type="password" value="{{ old('password') }}" />
                                    <span id="togglePassword" class="toggle-password"><i class="fas fa-eye"></i></span>
                                </div>
                                <small class="form-text text-muted">Minimum 6 characters required</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right d-flex">
                    <button type="button" class="btn btn-primary mr-2" id="btn_password_save">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button class="btn btn-danger" onclick="CancelModelBoxPassword()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
