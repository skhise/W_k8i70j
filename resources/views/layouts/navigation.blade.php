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
        <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                <span class="badge headerBadge1">
                    0 </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                <div class="dropdown-header">
                    Messages
                    <div class="float-right">
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">

                </div>
                <div class="dropdown-footer text-center">
                </div>
            </div>
        </li> -->
        <li class="dropdown mt-1">
            <span class="flex">{{ Auth::user()->name }}</span>
        </li>
        <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                <div class="dropdown-header">
                    Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread"> <span
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
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> -->
        <li class="dropdown dropdown-custom"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                    src="{{ asset('img/user.png') }}" class="user-img-radious-style"> <span
                    class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello {{ Auth::user()->name ?? '' }}</div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
                </a>
                <!-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                    Activities
                </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                    Settingsas
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" method="post" class="dropdown-item has-icon text-danger"> <i
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
            <a href="index.html"> <img alt="image" src="{{ asset('img/logo.png') }}" class="header-logo" />
                <span class="logo-name">{{ config('app.name', 'AMC') }}</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            
            @php
                $userRole = Auth::user()->role ?? null;
            @endphp
            
            @if($userRole === 0 || $userRole === '0')
                {{-- Super Admin (role 0) - Only show Customers menu --}}
                <li class="dropdown {{ Request::is('customers') || Request::is('customers/*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}" class="nav-link"><i
                            data-feather="user-check"></i><span>Customers</span></a>
                </li>
                <li class="dropdown {{ Request::is('generate') || Request::is('generate/*') ? 'active' : '' }}">
                    <a href="{{ route('generate') }}" class="nav-link"><i
                            data-feather="user-check"></i><span>Generate</span></a>
                </li>
                
            @else
                {{-- Other roles - Show all menus --}}
                <li class="dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link"><i
                            data-feather="grid"></i><span>Dashboard</span></a>
                </li>
                <li class="dropdown {{ Request::is('employees') || Request::is('employees/*') ? 'active' : '' }}">
                    <a href="{{ route('employees') }}" class="nav-link"><i
                            data-feather="users"></i><span>Employees</span></a>
                </li>

                <li class="{{ Request::is('clients') || Request::is('clients/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('clients') }}"><i data-feather="user-plus"></i> Clients</a>
                </li>
                <li class="dropdown {{ Request::is('contracts/*') || Request::is('contracts') ? 'active' : '' }}">
                    <a href="{{ route('contracts') }}" class="nav-link"><i data-feather="edit"></i><span>Contract</span></a>
                </li>
                <li class="dropdown {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}">
                    <a href="{{ route('services') }}" class="nav-link"><i
                            data-feather="bar-chart"></i><span>Services</span></a>
                </li>
                <li class="dropdown {{ Request::is('schedules') || Request::is('schedules/*') ? 'active' : '' }}">
                    <a href="{{ route('schedules') }}" class="nav-link"><i data-feather="clock"></i><span>Schedules
                            Services</span></a>
                </li>
                <li class="dropdown {{ Request::is('dcmanagements') || Request::is('dcmanagements/*') ? 'active' : '' }}">
                    <a href="{{ route('dcmanagements') }}" class="nav-link"><i data-feather="file"></i><span>DC
                            Management</span></a>
                </li>
                <li class="dropdown {{ Request::is('repairinwards') || Request::is('repairinwards/*') ? 'active' : '' }}">
                    <a href="{{ route('repairinwards.index') }}" class="nav-link"><i data-feather="file"></i><span>Repair Inward
                            </span></a>
                </li>
                <!-- <li
                    class="dropdown {{ Request::is('quotmanagements') || Request::is('quotmanagements/*') ? 'active' : '' }}">
                    <a href="{{ route('quotmanagements') }}" class="nav-link"><i
                            data-feather="file-text"></i><span>Quotation
                            Management</span></a>
                </li> -->

                <li class="dropdown {{ Request::is('products/*') || Request::is('products') ? 'active' : '' }}">
                    <a href="{{ route('products') }}" class="nav-link"><i data-feather="box"></i><span>Products / Spares</span></a>
                </li>
                <li class="dropdown {{ Request::is('location-report') || Request::is('attendance') || Request::is('location') ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ Request::is('location-report') || Request::is('attendance') || Request::is('location') ? 'toggled' : '' }}"><i
                            data-feather="map"></i><span>Tracking</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown {{ Request::is('location') || Request::is('location') ? 'active' : '' }}">
                            <a href="{{ route('location') }}" class="nav-link"><span>Track Location</span></a>
                        </li>

                        <li class="{{ Request::is('location-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('location-report') }}">Location History</a></li>

                        <li class="{{ Request::is('attendance') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('attendance') }}">Attendance</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ Request::is('reports/*') || Request::is('reports') ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ Request::is('reports/*') || Request::is('reports') ? 'toggled' : '' }}"><i
                            data-feather="pie-chart"></i><span>System Reports</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('reports/contract-report') ? 'active' : '' }}"><a class="nav-link active"
                                href="{{ route('contract-report') }}">Contract Reports</a></li>
                        <li class="{{ Request::is(patterns: 'reports/contract-due-report') ? 'active' : '' }}"><a
                                class="nav-link active" href="{{ route('contract-due-report') }}">Contract Due Reports</a>
                        </li>
                        <li class="{{ Request::is('reports/service-status-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('service-status-report') }}">Service Status Reports</a></li>

                        <li class="{{ Request::is('reports/service-ticket-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('service-ticket-report') }}">Service Summary Report</a></li>
                        <li class="{{ Request::is('reports/engineer-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('engineer-report') }}">Engineer Reports</a></li>

                        <li class="{{ Request::is('reports/dc-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('dc-report') }}">Dc Report</a></li>
                        <li class="{{ Request::is('reports/inward-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('inward-report') }}">Repair Inward Report</a></li>
                        <!-- <li class="{{ Request::is('reports/quotation-report') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('quotation-report') }}">Quotation Report</a></li> -->
                        <li class="{{ Request::is('reports/logs') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('logs') }}">Logs</a></li>

                    </ul>
                </li>
                <li class="dropdown {{ Request::is('analysis/*') || Request::is('analysis') ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ Request::is('reports/*') || Request::is('analysis') ? 'toggled' : '' }}"><i
                            data-feather="bar-chart-2"></i><span>Analysis Reports</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('analysis/engineer-service-analysis') ? 'active' : '' }}"><a
                                class="nav-link" href="{{ route('engineer-service-analysis') }}">Engineer Analysis
                                Report</a></li>
                        <li class="{{ Request::is('analysis/contract-service-report') ? 'active' : '' }}"><a
                                class="nav-link" href="{{ route('contract-service-report') }}">Service Analysis
                                Report</a></li>
                    </ul>
                </li>

                <li class="dropdown {{ Request::is('masters/*') || Request::is('masters') ? 'active' : '' }}">
                    <a href="{{ route('masters') }}" class="nav-link"><i data-feather="settings"></i><span>Master
                            Settings</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>