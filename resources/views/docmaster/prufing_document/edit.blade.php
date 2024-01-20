<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="qTFAXIJBjShlaE5mrnl9y9KbU6MxBsNUNyyleBpe">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel='shortcut icon' type='image/x-icon' href="../../assets/img/favicon.ico" />
    <title>PMS</title>

    <!-- Fonts -->
    <link rel=" preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- <link rel="preload" as="style" href="../../assets/build/../../assets/app-6d1fe8ee.css" /><link rel="modulepreload" href="../../assets/build/../../assets/app-7c0572f8.js" /><link rel="stylesheet" href="../../assets/build/../../assets/app-6d1fe8ee.css" /><script type="module" src="../../assets/build/../../assets/app-7c0572f8.js"></script>; -->
    <!-- Scripts -->

    <link rel="stylesheet" href="../../assets/css/app.min.css">

    <link rel="stylesheet" href="../../assets/bundles/summernote/summernote-bs4.css">
    <!-- Template CSS -->

    <link rel="stylesheet" href="../../assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="../../assets/css/custom.css">
    <link rel="stylesheet" href="../../assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="../../assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/bundles/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/bundles/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="../../assets/css/jquery-editable-select.min.css">
    <!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css"> -->
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



    <script type="text/javascript"
        class="flasher-js">(function () { var rootScript = 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js'; var FLASHER_FLASH_BAG_PLACE_HOLDER = {}; var options = mergeOptions([], FLASHER_FLASH_BAG_PLACE_HOLDER); function mergeOptions(first, second) { return { context: merge(first.context || {}, second.context || {}), envelopes: merge(first.envelopes || [], second.envelopes || []), options: merge(first.options || {}, second.options || {}), scripts: merge(first.scripts || [], second.scripts || []), styles: merge(first.styles || [], second.styles || []), }; } function merge(first, second) { if (Array.isArray(first) && Array.isArray(second)) { return first.concat(second).filter(function (item, index, array) { return array.indexOf(item) === index; }); } return Object.assign({}, first, second); } function renderOptions(options) { if (!window.hasOwnProperty('flasher')) { console.error('Flasher is not loaded'); return; } requestAnimationFrame(function () { window.flasher.render(options); }); } function render(options) { if ('loading' !== document.readyState) { renderOptions(options); return; } document.addEventListener('DOMContentLoaded', function () { renderOptions(options); }); } if (1 === document.querySelectorAll('script.flasher-js').length) { document.addEventListener('flasher:render', function (event) { render(event.detail); }); } if (window.hasOwnProperty('flasher') || !rootScript || document.querySelector('script[src="' + rootScript + '"]')) { render(options); } else { var tag = document.createElement('script'); tag.setAttribute('src', rootScript); tag.setAttribute('type', 'text/javascript'); tag.onload = function () { render(options); }; document.head.appendChild(tag); } })();</script>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        <li>
                            <!-- <form class="form-inline mr-auto">
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            data-width="200">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form> -->
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                            <span class="badge headerBadge1">
                                0 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <!-- <a href="#">Mark All As Read</a> -->
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">

                            </div>
                            <div class="dropdown-footer text-center">
                                <!-- <a href="#">View All <i class="fas fa-chevron-right"></i></a> -->
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <!-- <a href="#">Mark All As Read</a> -->
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">

                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="../../assets/img/user.png" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">Hello tomy</div>
                            <a href="https://pmss.mdsstechno.com/profile" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
                            </a>
                            <!-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                    Activities
                </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                    Settings
                </a> -->
                            <div class="dropdown-divider"></div>
                            <a href="https://pmss.mdsstechno.com/logout" method="post"
                                class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html"> <img alt="image" src="../../assets/img/logo.png" class="header-logo" />
                            <span class="logo-name">PMS</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="dropdown ">
                            <a href="https://pmss.mdsstechno.com/dashboard" class="nav-link"><i
                                    data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="menu-toggle nav-link has-dropdown "><i
                                    data-feather="briefcase"></i><span>Clients
                                    Management</span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a class="nav-link" href="https://pmss.mdsstechno.com/clients">Clients</a>
                                </li>
                                <li class=""><a class="nav-link"
                                        href="https://pmss.mdsstechno.com/clients/persons">Persons</a></li>
                                <li class=""><a class="nav-link"
                                        href="https://pmss.mdsstechno.com/clients/sites">Sites</a></li>
                            </ul>
                        </li>
                        <li class="dropdown ">
                            <a href="https://pmss.mdsstechno.com/projects" class="nav-link"><i
                                    data-feather="figma"></i><span>Projects</span></a>
                        </li>
                        <li class="dropdown ">
                            <a href="https://pmss.mdsstechno.com/documents" class="nav-link"><i
                                    data-feather="file"></i><span>Documents</span></a>
                        </li>
                        <li class="dropdown ">
                            <a href="https://pmss.mdsstechno.com/employees" class="nav-link"><i
                                    data-feather="users"></i><span>Employees</span></a>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="menu-toggle nav-link has-dropdown "><i
                                    data-feather="settings"></i><span>Settings</span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a class="nav-link"
                                        href="https://pmss.mdsstechno.com/settings/document">Document Settings</a></li>
                            </ul>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="menu-toggle nav-link has-dropdown "><i
                                    data-feather="settings"></i><span>Invoice Management</span></a>
                            <ul class="dropdown-menu">
                                <li class="">
                                    <a class="nav-link" href="https://pmss.mdsstechno.com/invoices">Invoices</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="menu-toggle nav-link has-dropdown "><i
                                    data-feather="settings"></i><span>Master Settings</span></a>
                            <ul class="dropdown-menu">
                                <li class="">
                                    <a class="nav-link" href="https://pmss.mdsstechno.com/masters/invoice-items">Invoice
                                        Item Master</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>
            <!-- Page Heading -->

            <!-- Page Content -->
            <main>
                <div class="main-content">
                    <section class="section">
                        <div class="section-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Update Invoice Item</h4>
                                        </div>
                                        <div class="card-body">
                                            <form id="frmcreateemployee" method="post" enctype="multipart/form-data"
                                                action="https://pmss.mdsstechno.com/masters/invoice-item/update/13">
                                                <input type="hidden" name="_token"
                                                    value="qTFAXIJBjShlaE5mrnl9y9KbU6MxBsNUNyyleBpe" autocomplete="off">
                                                <input type="hidden" id="updated_by" name="updated_by" value="1" />
                                                <input type="hidden" id="account_id" name="account_id" value="1" />
                                                <div class="form-horizontal">

                                                    <h3 style="color:orangered"></h3>


                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <h4><i class="fa fa-user"></i> Invoice Item Information
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <span
                                                                    style="color:blue; font-weight:bold; text-decoration:underline">Description
                                                                </span>
                                                                <br />
                                                                <span style="font-weight:bold">Description</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <textarea class="form-control text-box single-line "
                                                                    data-val="true" id="description" name="description"
                                                                    rows="4" placeholder="Description *"
                                                                    required="required"
                                                                    type="text">Objektüberwachungsbericht</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="card-footer text-right">
                                                            <input type="button" id="btnAddEmployee" value="Update"
                                                                class="btn btn-primary">
                                                            <a type="button" class="btn btn-primary"
                                                                href="https://pmss.mdsstechno.com/clients">Back</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

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

    <script src="../../assets/js/app.min.js"></script>
    <script src="../../assets/bundles/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../assets/bundles/jquery-ui/bootstrap.bundle.min.js"></script>
    <!-- JS Libraies -->
    <script src="../../assets/bundles/apexcharts/apexcharts.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="../../assets/js/page/index.js"></script>
    <!-- Template JS File -->

    <!-- Custom JS File -->
    <script src="../../assets/js/custom.js"></script>
    <script src="../../assets/bundles/datatables/datatables.min.js"></script>
    <script src="../../assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>


    <!-- Page Specific JS File -->
    <script src="../../assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script src="../../assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>

    <script src="../../assets/js/page/datatables.js"></script>
    <script src="../../assets/bundles/summernote/summernote-bs4.js"></script>
    <script src="../../assets/js/mark.js_8.11.1_mark.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/jquery-editable-select.min.js"></script>
    <!-- <script src="../../assets/js/bootstrap.min.js"></script> -->
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
    <script>
        $("input[type = 'text']").each(function () {
            $(this).change(function () {
                $(this).removeClass('is-invalid');
                $(this).siblings('span').text('');
            });
        });
        $('#btnAddEmployee').on('click', function () {
            $("#frmcreateemployee")[0].submit();
        });
    </script>

</body>

</html>