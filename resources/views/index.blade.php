<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>@yield('title')</title>
    <!-- Custom CSS -->
    @yield('css')
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<![endif]-->
</head>

<body>
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- End Preloader - style you can find in spinners.css -->

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <!-- Topbar header - style you can find in pages.scss -->
        @include('partials/navbar')
        <!-- End Topbar header -->

        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        @include('partials/sidebar')
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <div class="page-wrapper">

            @yield('content')

            <footer class="footer text-center text-muted">
                Designed and Developed by <a href="javascript:void(0)">KDDI Indonesia</a>.
            </footer>
        </div>
    </div>

    <!-- sample modal content -->
    <div id="notifModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="notifModalLabel">Notification</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-style-none">
                        <li>
                            <a href="javascript:void(0)"
                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                <div class="btn btn-warning rounded-circle btn-circle"><i data-feather="alert-circle"
                                        class="text-white"></i></div>
                                <div class="w-75 d-inline-block v-middle ps-2">
                                    <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                    <span class="font-12 text-nowrap d-block text-muted">Just see
                                        the my new
                                        admin!</span>
                                    <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                <div class="btn btn-warning rounded-circle btn-circle"><i data-feather="alert-circle"
                                        class="text-white"></i></div>
                                <div class="w-75 d-inline-block v-middle ps-2">
                                    <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                    <span class="font-12 text-nowrap d-block text-muted">Just see
                                        the my new
                                        admin!</span>
                                    <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div> --}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    @yield('script')
</body>

</html>
