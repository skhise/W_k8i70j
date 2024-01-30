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
                    <!-- <a href="#" class="dropdown-item dropdown-item-unread"> <span
                            class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                        </span> <span class="dropdown-item-desc"> Template update is
                            available now! <span class="time">2 Min
                                Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i
                                class="far
												fa-user"></i>
                        </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                                Sugiharto</b> are now friends <span class="time">10 Hours
                                Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-success text-white">
                            <i class="fas
												fa-check"></i>
                        </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                            moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                                Hours
                                Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span> <span class="dropdown-item-desc"> Low disk space. Let's
                            clean it! <span class="time">17 Hours Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i
                                class="fas
												fa-bell"></i>
                        </span> <span class="dropdown-item-desc"> Welcome to Otika
                            template! <span class="time">Yesterday</span>
                        </span>
                    </a> -->
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                    src="{{asset('img/user.png')}}" class="user-img-radious-style"> <span
                    class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello {{Auth::user()->name ?? ''}}</div>
                <a href="{{route('profile.edit')}}" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
                </a>
                <!-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                    Activities
                </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                    Settingsas
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="{{route('logout')}}" method="post" class="dropdown-item has-icon text-danger"> <i
                        class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="{{asset('img/logo.png')}}" class="header-logo" />
                <span class="logo-name">{{ config('app.name', 'PMS') }}</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="nav-link"><i
                        data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li
                class="dropdown {{(Request::is('clients/*') || Request::is('clients') || Request::is('persons') || Request::is('sites')) ? 'active' : '' }}">
                <a href="#"
                    class="menu-toggle nav-link has-dropdown {{(Request::is('clients') || Request::is('persons') || Request::is('sites')) ? 'toggled' : '' }}"><i
                        data-feather="briefcase"></i><span>Clients
                        Management</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('clients') ? 'active' : '' }}"><a class="nav-link"
                            href="{{route('clients')}}">Clients</a></li>
                    <!-- <li class="{{Request::is('clients/persons') ? 'active' : '' }}"><a class="nav-link"
                            href="{{route('persons')}}">Persons</a></li> -->
                    <!-- <li class="{{Request::is('clients/sites') ? 'active' : '' }}"><a class="nav-link"
                            href="{{route('sites')}}">Sites</a></li> -->
                </ul>
            </li>
            <li class="dropdown {{Request::is('projects') ? 'active' : '' }}">
                <a href="{{route('projects')}}" class="nav-link"><i data-feather="figma"></i><span>Projects</span></a>
            </li>
            <li class="dropdown {{Request::is('documents') ? 'active' : '' }}">
                <a href="{{route('documents')}}" class="nav-link"><i data-feather="file"></i><span>Documents</span></a>
            </li>
            <li class="dropdown {{Request::is('employees') ? 'active' : '' }}">
                <a href="{{route('employees')}}" class="nav-link"><i data-feather="users"></i><span>Employees</span></a>
            </li>
            <li class="dropdown {{Request::is('settings/document') ? 'active' : '' }}">
                <a href="#"
                    class="menu-toggle nav-link has-dropdown {{Request::is('settings/document') ? 'toggled' : '' }}"><i
                        data-feather="settings"></i><span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('settings/document') ? 'active' : '' }}"><a class="nav-link"
                            href="{{route('document-settings')}}">Document Settings</a></li>
                </ul>
            </li>
            <li class="dropdown {{Request::is('invoices') || Request::is('invoices/create') ? 'active' : '' }}">
                <a href="#"
                    class="menu-toggle nav-link has-dropdown {{Request::is('invoices') || Request::is('invoices/create') ? 'toggled' : '' }}"><i
                        data-feather="settings"></i><span>Invoice Management</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('invoices') || Request::is('invoices/create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('invoices')}}">Invoices</a>
                    </li>
                </ul>
            </li>
            <li
                class="dropdown {{Request::is('doc-master') || Request::is('doc-master/prufing_document') ? 'active' : '' }}">
                <a href="#"
                    class="menu-toggle nav-link has-dropdown {{Request::is('doc-master') || Request::is('doc-master/prufing_document') ? 'toggled' : '' }}"><i
                        data-feather="settings"></i><span>Document Master</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('doc-master/prufing_document') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('doc-master.prufing_document')}}">Prufing Documents</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{Request::is('reports') || Request::is('reports/invoice') ? 'active' : '' }}">
                <a href="#"
                    class="menu-toggle nav-link has-dropdown {{Request::is('reports') || Request::is('reports/invoice') ? 'toggled' : '' }}"><i
                        data-feather="settings"></i><span>Reports</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('reports/invoice') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('reports.invoice')}}">Invoice Report</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>