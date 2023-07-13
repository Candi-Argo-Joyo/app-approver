@extends('index')
@section('title', 'Dashboard | Aprover KDDI')
@section('css')
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css" rel="stylesheet') }}">
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css" rel="stylesheet') }}">
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet') }}">
@endsection
@section('content')

    @if (Auth::user()->role == 'administrator')
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Hi, {{ Auth::user()['name'] }}!
                    </h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start First Cards -->
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-end">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium user">0</h2>
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data User
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-end ">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium form">0</h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Form
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-end ">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium division">0</h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Division
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-end ">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium position">0</h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Position
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End First Cards -->

            <!-- Start Sales Charts Section -->
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Sales</h4>
                            <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                            <ul class="list-style-none mb-0">
                                <li>
                                    <i class="fas fa-circle text-primary font-10 me-2"></i>
                                    <span class="text-muted">Direct Sales</span>
                                    <span class="text-dark float-end font-weight-medium">$2346</span>
                                </li>
                                <li class="mt-3">
                                    <i class="fas fa-circle text-danger font-10 me-2"></i>
                                    <span class="text-muted">Referral Sales</span>
                                    <span class="text-dark float-end font-weight-medium">$2108</span>
                                </li>
                                <li class="mt-3">
                                    <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                    <span class="text-muted">Affiliate Sales</span>
                                    <span class="text-dark float-end font-weight-medium">$1204</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Net Income</h4>
                            <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                            <ul class="list-inline text-center mt-5 mb-2">
                                <li class="list-inline-item text-muted fst-italic">Sales for this month</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Sales Charts Section -->

        </div>
        <!--End Container fluid  -->
    @else
        @if (Auth::user()->id_divisi != null)
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning Jason!</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start First Cards -->
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="d-inline-flex align-items-center">
                                            <h2 class="text-dark mb-1 font-weight-medium user">236</h2>
                                        </div>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data User
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">18,306</h2>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Memo
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">18,306</h2>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Dealer
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">18,306</h2>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Sales
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End First Cards -->

                <!-- Start Sales Charts Section -->
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Sales</h4>
                                <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                                <ul class="list-style-none mb-0">
                                    <li>
                                        <i class="fas fa-circle text-primary font-10 me-2"></i>
                                        <span class="text-muted">Direct Sales</span>
                                        <span class="text-dark float-end font-weight-medium">$2346</span>
                                    </li>
                                    <li class="mt-3">
                                        <i class="fas fa-circle text-danger font-10 me-2"></i>
                                        <span class="text-muted">Referral Sales</span>
                                        <span class="text-dark float-end font-weight-medium">$2108</span>
                                    </li>
                                    <li class="mt-3">
                                        <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                        <span class="text-muted">Affiliate Sales</span>
                                        <span class="text-dark float-end font-weight-medium">$1204</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Net Income</h4>
                                <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                                <ul class="list-inline text-center mt-5 mb-2">
                                    <li class="list-inline-item text-muted fst-italic">Sales for this month</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sales Charts Section -->

            </div>
            <!--End Container fluid  -->
        @endif
        @if (Auth::user()->id_divisi == null)
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <span class="h2">
                            Welcome {{ Auth::user()->name }},<br> Your account can be accessed but cannot access the
                            application
                            menu. Please contact the administrator to map your account</span>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
@section('script')
    <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.min.js') }}"></script>

    <script>
        $.ajax({
            url: "{{ route('dashboard.count') }}",
            type: "get",
            dataType: "json",
            success: function(response) {
                $('.user').html(response.total.user)
                $('.form').html(response.total.form)
                $('.division').html(response.total.division)
                $('.position').html(response.total.position)
            }
        })
    </script>
@endsection
