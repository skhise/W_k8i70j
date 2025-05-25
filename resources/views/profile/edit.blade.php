<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card author-box">
                            <div class="card-body">
                                <div class="author-box-center">
                                    <img alt="image" src="{{asset('img/logo.png')}}"
                                        class="rounded-circle author-box-picture">
                                        
                                    <div class="clearfix"></div>
                                    <div class="author-box-name mt-3">
                                        <a href="#">{{$profile->comapny_name}}</a>  
                                    </div>
                                </div>
                                <!-- <div class="text-center">
                                    <div class="author-box-description">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur
                                            voluptatum alias molestias
                                            minus quod dignissimos.
                                        </p>
                                    </div>
                                    <div class="mb-2 mt-3">
                                        <div class="text-small font-weight-bold">Follow Hasan On</div>
                                    </div>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-github">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="w-100 d-sm-none"></div>
                                </div> -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Personal Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="py-4">

                                    <p class="clearfix">
                                        <span class="float-left">
                                            Name
                                        </span>
                                        <span class="float-right text-muted">
                                        {{Auth::user()->name}}
                                        </span>
                                    </p>
                                    <p class="clearfix">
                                        <span class="float-left">
                                            Users
                                        </span>
                                        <span class="float-right text-muted">
                                            {{ $users}}
                                        </span>
                                    </p>
                                    <p class="clearfix">
                                        <span class="float-left">
                                            Mail
                                        </span>
                                        <span class="float-right text-muted">
                                            {{Auth::user()->email}}
                                        </span>
                                    </p>
                                    
                                    <p class="clearfix">
                                        <span class="float-right text-muted">
                                        <button data-target=".bd-RefPasswordReset-modal-lg"
                                                            data-toggle="modal" type="button"
                                                            class="float-left btn btn-primary">Change
                                                            Password</button>
                                        </span>
                                    </p>
                                    <!-- <p class="clearfix">
                                        <span class="float-left">
                                            Facebook
                                        </span>
                                        <span class="float-right text-muted">
                                            <a href="#">John Deo</a>
                                        </span>
                                    </p> -->
                                    <!-- <p class="clearfix">
                                        <span class="float-left">
                                            Twitter
                                        </span>
                                        <span class="float-right text-muted">
                                            <a href="#">@johndeo</a>
                                        </span>
                                    </p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="card">
                            <div class="padding-20">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab2" data-toggle="tab" href="#settings"
                                            role="tab" aria-selected="true">Profile</a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="settings" role="tabpanel"
                                        aria-labelledby="profile-tab2">
                                        <form id="profile_form" method="post" action="{{ route('profile.update') }}"
                                            class="needs-validation">
                                            @csrf
                                            @method('patch')
                                            <div class="card-header">
                                                <h4>Profile</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-7 col-12">
                                                        <label>Address</label>
                                                        <textarea type="address" class="form-control"
                                                            rows="2" required
                                                            autocomplete="address" name="address" id="address">{{old('address', $profile->address)}}</textarea>
                                                        <div class="invalid-feedback">
                                                            Please fill in the address
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-5 col-12">
                                                        <label for="contact_number">Contact number</label>
                                                        <input type="tel"  onkeypress="return isNumberKey(event)"  class="form-control" name="contact_number" id="contact_number" value="{{old('contact_number', $profile->contact_number)}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                    <hr/>
                                                    </div>
                                                </div>
                                              @if ($user->role != 3)
                                                <div class="row">
                                                    <div class="form-group col-md-4 col-12">
                                                        <label for="wp_user_name">WhatsApp Username</label>
                                                        <input class="form-control" name="wp_user_name" id="wp_user_name" value="{{ old('wp_user_name', $profile->wp_user_name) }}">
                                                    </div>
                                                    <div class="form-group col-md-8 col-12">
                                                        <label for="wp_api_key">WhatsApp Api Key</label>
                                                        <input class="form-control" name="wp_api_key" id="wp_api_key" value="{{ old('wp_api_key', $profile->wp_api_key) }}">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <hr/>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-4 col-12">
                                                        <button class="btn-save btn btn-primary float-left">Save</button>
                                                    </div>
                                                </div>
                                            @endif

                                                

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="settingSidebar">
            <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
            </a>
            <div class="settingSidebar-body ps-container ps-theme-default">
                <div class=" fade show active">
                    <div class="setting-panel-header">Setting Panel
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Select Layout</h6>
                        <div class="selectgroup layout-color w-50">
                            <label class="selectgroup-item">
                                <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout"
                                    checked>
                                <span class="selectgroup-button">Light</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="value" value="2"
                                    class="selectgroup-input-radio select-layout">
                                <span class="selectgroup-button">Dark</span>
                            </label>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Sidebar Color</h6>
                        <div class="selectgroup selectgroup-pills sidebar-color">
                            <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="1"
                                    class="selectgroup-input select-sidebar">
                                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                    data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar"
                                    checked>
                                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                    data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Color Theme</h6>
                        <div class="theme-setting-options">
                            <ul class="choose-theme list-unstyled mb-0">
                                <li title="white" class="active">
                                    <div class="white"></div>
                                </li>
                                <li title="cyan">
                                    <div class="cyan"></div>
                                </li>
                                <li title="black">
                                    <div class="black"></div>
                                </li>
                                <li title="purple">
                                    <div class="purple"></div>
                                </li>
                                <li title="orange">
                                    <div class="orange"></div>
                                </li>
                                <li title="green">
                                    <div class="green"></div>
                                </li>
                                <li title="red">
                                    <div class="red"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <div class="theme-setting-options">
                            <label class="m-b-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                    id="mini_sidebar_setting">
                                <span class="custom-switch-indicator"></span>
                                <span class="control-label p-l-10">Mini Sidebar</span>
                            </label>
                        </div>
                    </div>
                    <div class="p-15 border-bottom">
                        <div class="theme-setting-options">
                            <label class="m-b-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                    id="sticky_header_setting">
                                <span class="custom-switch-indicator"></span>
                                <span class="control-label p-l-10">Sticky Header</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                        <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                            <i class="fas fa-undo"></i> Restore Default
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @include('profile.change_password');
    </div>
   

    @section('script')
    <script>
          $(document).on("click", ".btn-save", function() {
            $(this).attr("disabled", true);
            $(this).html("Saving...");
            $("#profile_form").submit();
            return true;
          });
        $(document).on("click", "#btn_password_save", function() {
                $('.text-danger-error').html('');
                $(this).attr("disabled", true);
                $(this).html("Saving...");
                var url = '{{ route('profile.change-password') }}';
                var isValid = true;

                // Loop through each input field and validate
                $('#form_password_reset .required').each(function() {
                    if (!validateInput($(this))) {
                        isValid = false;
                        $("#btn_password_save").attr("disabled", false);
                        $("#btn_password_save").html("Save");
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#form_password_reset").serialize(),
                        success: function(response) {
                            //  var obj = JSON.parse(response);
                            if (response.success) {
                                showSuccessSwal("Password Changed");
                                CancelModelBoxPassword();
                          
                            } else {

                                $("#btn_password_save").attr("disabled", false);
                                $("#btn_password_save").html("Save");
                                $('.errorMsgntainer').html("");
                                if (typeof response.validation_error != 'undefined') {
                                    $.each(response.validation_error, function(index, value) {
                                        $('.' + index + "-field-validation-valid").html(value);
                                    });
                                } else {
                                    $('.errorMsgntainer').html(response.message);
                                }
                            }

                        },
                        error: function(error) {
                            $("#btn_password_save").attr("disabled", false);
                            $("#btn_password_save").html("Save");
                            showErrorSwal("Something went wrong, try again");
                        }
                    })
                }

            });
         function CancelModelBoxPassword() {
            
                $("#btn_password_save").attr("disabled", false);
                $("#btn_password_save").html("Save");
                $('.text-danger-error').html('');
                $("#form_password_reset")[0].reset();
                $(".required").removeClass('error_border')
                $("#btn_close_password").trigger('click');
            }
    </script>
    @endsection
    
</x-app-layout>