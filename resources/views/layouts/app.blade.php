<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('img/favicon.ico')}}" />
    <title>{{ config('app.name', 'PMS') }}</title>

    <!-- Fonts -->
    <!-- <link rel=" preconnect" href="https://fonts.bunny.net"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->
    <!-- @vite([ 'resources/js/app.js','resources/css/app.css']); -->
    <!-- Scripts -->

    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">

    <link rel="stylesheet" href="{{asset('bundles/summernote/summernote-bs4.css')}}">
    <!-- Template CSS -->

    <link rel="stylesheet" href="{{asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/components.css')}}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/jquery-selectric/selectric.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-editable-select.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> -->
    <style>
        .action-2 {
            width: 10% !important;
        }

        .action-1 {
            width: 10% !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .myselect2.select2-container {
            width: 25% !important;
        }

        .manualtext_common {
            width: 90% !important;
            height: auto !important;
            resize: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 42px !important;
        }

        .disable {
            pointer-events: none;
            background: #c9c9c9;
        }
    </style>


</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}

            </main>
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
                                    <input type="radio" name="value" value="1"
                                        class="selectgroup-input-radio select-layout" checked>
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
                                    <input type="radio" name="icon-input" value="2"
                                        class="selectgroup-input select-sidebar" checked>
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
        </div>
        <footer class=" main-footer">
            <div class="footer-left">
                <a href="templateshub.net">Templateshub</a></a>
            </div>
            <div class="footer-right">
            </div>
        </footer>
    </div>

    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('bundles/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('bundles/jquery-ui/bootstrap.bundle.min.js')}}"></script>
    <!-- JS Libraies -->
    <script src="{{asset('bundles/apexcharts/apexcharts.min.js')}}"></script>
    <!-- Page Specific JS File -->
    <script src="{{asset('js/page/index.js')}}"></script>
    <!-- Template JS File -->

    <!-- Custom JS File -->
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('bundles/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>


    <!-- Page Specific JS File -->
    <script src="{{asset('bundles/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>

    <script src="{{asset('js/page/datatables.js')}}"></script>
    <script src="{{asset('bundles/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('js/mark.js_8.11.1_mark.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/jquery-editable-select.min.js')}}"></script>
    <script src="{{asset('bundles/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Page Specific JS File -->
    <script src="{{asset('js/page/sweetalert.js')}}"></script>
    <!-- <script src="{{asset('js/bootstrap.min.js')}}"></script> -->
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
    @yield('script')
</body>

</html>