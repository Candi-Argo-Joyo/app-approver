@extends('index')
@section('title', 'Build Form | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Form</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Form</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    {{-- <a href="javasctipt:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">Create Form</a> --}}

                    <a href="{{ route('formBuilder.add') }}" class="btn btn-primary">Create Form</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Top Leader Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Data Form</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Form Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Form IT</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-info">Preview</a>
                                            <a href="javascript:void(0)" class="badge bg-warning">Edit</a>
                                            <a href="javascript:void(0)" class="badge bg-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Form Keuangan</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-info">Preview</a>
                                            <a href="javascript:void(0)" class="badge bg-warning">Edit</a>
                                            <a href="javascript:void(0)" class="badge bg-danger">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
@endsection