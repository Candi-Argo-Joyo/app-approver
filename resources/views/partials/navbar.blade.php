<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="index.html">
                    <img src="{{ asset('images/KDDI_Logo.svg.png') }}" alt="" class="img-fluid"
                        style="width: 130px;">
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent"
            style="background: #fff; box-shadow: 0 3px 9px 0 rgba(169,184,200,.15);
    -webkit-box-shadow: 0 3px 9px 0 rgba(169,184,200,.15)">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge text-bg-danger notify-no rounded-circle">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            <li>
                                <div class="message-center notifications position-relative">
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-warning rounded-circle btn-circle"><i
                                                data-feather="alert-circle" class="text-white"></i></div>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                            <span class="font-12 text-nowrap d-block text-muted">Just see
                                                the my new
                                                admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-warning rounded-circle btn-circle"><i
                                                data-feather="alert-circle" class="text-white"></i></div>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                            <span class="font-12 text-nowrap d-block text-muted">Just see
                                                the my new
                                                admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);"
                                    data-bs-toggle="modal" data-bs-target="#notifModal">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->
                @if (Auth::user()->role == 'administrator')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="settings" class="svg-icon"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users') }}">Users</a>
                            {{-- <a class="dropdown-item" href="{{ route('level') }}">Level</a> --}}
                            <a class="dropdown-item" href="{{ route('settingweb') }}">Setting SSO/WEB</a>
                            <a class="dropdown-item" href="{{ route('settingmail') }}">Setting Mail</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('dataMenu') }}">Data Menu</a>
                            <a class="dropdown-item" href="{{ route('log') }}">Logs</a>
                        </div>
                    </li>
                @endif

                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <div class="customize-input">
                            <select
                                class="lang nav-link custom-select form-control bg-white custom-radius custom-shadow border-0">
                                <option href="javascript:void(0)" data-lang="en"> English</option>
                                <option href="javascript:void(0)" data-lang="id"> Indonesia</option>
                                <option href="javascript:void(0)" data-lang="ja"> Jepang</option>
                            </select>
                        </div>
                    </a>
                </li>
                <li>
                    <div id='google_translate_element'></div>
                </li>
            </ul>

            @if (Auth::user()->role != 'administrator')
                <ul class="navbar-nav">
                    <span class="divisi">Divisi IT</span>
                </ul>
            @endif
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{-- <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user"
                            class="rounded-circle" width="40"> --}}
                        <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                class="text-dark">{{ Auth::user()['name'] }}</span> <i data-feather="chevron-down"
                                class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        {{-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="user"
                                class="svg-icon me-2 ms-1"></i>
                            My Profile</a> --}}
                        {{-- <div class="dropdown-divider"></div> --}}
                        {{-- <div class="dropdown-divider"></div> --}}
                        <a class="dropdown-item" href="javascript:void(0)"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                data-feather="power" class="svg-icon me-2 ms-1"></i>
                            Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        {{-- <div class="dropdown-divider"></div> --}}
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
