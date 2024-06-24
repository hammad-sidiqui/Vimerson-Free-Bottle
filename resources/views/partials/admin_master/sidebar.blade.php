<div class="vh-sidebar  sidebar-default  ">
    <div class="vh-sidebar-logo d-flex align-items-end justify-content-lg-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('images/vimerson-logo.png') }}" class="img-fluid rounded-normal light-logo" alt="logo">
            <img src="{{ asset('images/vimerson-logo_white.png') }}" class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
        </a>
        <div class="side-menu-bt-sidebar-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="vh-sidebar-menu">
            <ul id="vh-sidebar-toggle" class="side-menu">
                <li class="sidebar-layout sidebar-dashboard">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <i class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </i>
                        <span class="ml-1">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-layout sidebar-bottle">
                    <a href="{{ route('bottle_list') }}" class="svg-icon">
                        <i class="">
                            <svg viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m15.5 24h-7c-1.378 0-2.5-1.122-2.5-2.5v-11.343c0-1.202.468-2.332 1.318-3.182l1.243-1.243c.283-.283.439-.66.439-1.06v-.922c0-.276.224-.5.5-.5.276 0 .5.224.5.5v.922c0 .667-.26 1.294-.732 1.767l-1.243 1.243c-.661.661-1.025 1.54-1.025 2.475v11.343c0 .827.673 1.5 1.5 1.5h7c.827 0 1.5-.673 1.5-1.5v-11.343c0-.935-.364-1.813-1.025-2.475l-1.243-1.243c-.472-.471-.732-1.099-.732-1.768v-.921c0-.276.224-.5.5-.5s.5.224.5.5v.921c0 .401.156.778.439 1.061l1.243 1.243c.85.85 1.318 1.98 1.318 3.182v11.343c0 1.378-1.122 2.5-2.5 2.5z" />
                                <path d="m14.5 4h-5c-.827 0-1.5-.673-1.5-1.5v-1c0-.827.673-1.5 1.5-1.5h5c.827 0 1.5.673 1.5 1.5v1c0 .827-.673 1.5-1.5 1.5zm-5-3c-.276 0-.5.224-.5.5v1c0 .276.224.5.5.5h5c.276 0 .5-.224.5-.5v-1c0-.276-.224-.5-.5-.5z" />
                            </svg>
                        </i>
                        <span class="ml-1">Bottle Management</span>
                    </a>
                </li>

                <li class="sidebar-layout sidebar-product">
                    <a href="{{ route('product_list') }}" class="svg-icon">
                        <i class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </i>
                        <span class="ml-1">ASIN Management</span>
                    </a>
                </li>

                <li class="sidebar-layout sidebar-timetracker">
                    <a href="{{route('timetracker_list')}}" class="svg-icon">
                        <i class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </i>
                        <span class="ml-1">Time Tracker Management</span>
                    </a>
                </li>

                <li class="sidebar-layout sidebar-questionnaire">
                    <a href="{{ route('questionnaire_list') }}" class="svg-icon">
                        <i class="">

                            <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </i>
                        <span class="ml-1">Questionnaire Management</span>
                    </a>
                </li>

                <li class="sidebar-layout sidebar-users">
                    <a href="{{route('user_list')}}" class="svg-icon">
                        <i class="">

                            <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </i>
                        <span class="ml-1">Users Management</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="pt-5 pb-5"></div>
    </div>
</div>
<div class="vh-top-navbar">
    <div class="vh-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="side-menu-bt-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <div class="d-flex align-items-center">
                <div class="change-mode">
                    <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                        <div class="custom-switch-inner">
                            <p class="mb-0"> </p>
                            <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                            <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                <span class="switch-icon-right">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="h-moon" height="20" width="20" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                </span>
                                <span class="switch-icon-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="h-sun" height="20" width="20" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon align-items-center d-flex">
                            <a href="{{ route('logout') }}" class="nav-item nav-icon pr-0">
                                <svg class="svg-icon mr-0 text-secondary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <a href="{{ route('logout') }}">Logout</a>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>