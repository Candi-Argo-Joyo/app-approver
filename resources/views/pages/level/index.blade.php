@extends('index')
@section('title', 'Level | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/select2.min.css') }}" />
@endsection
@section('content')
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: unset;
            padding: 6px 12px;
        }

        /* .select2-container .select2-selection--single {
                        height: unset;
                    } */

        .select2-container--default .select2-selection--multiple .select2-selection__arrow {
            height: 37px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            line-height: unset;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e9ecef;
        }

        .is-invalid .select2-selection,
        .needs-validation~span>.select2-dropdown {
            border-color: var(--bs-danger) !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #e9ecef;
        }

        .select2-container .select2-search--inline .select2-search__field {
            vertical-align: unset;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-left: unset;
            margin-top: unset;
        }
    </style>
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Level</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item text-muted active" aria-current="page">Level</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add Level</a>
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
                        <h4 class="card-title">List Data Level</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Level</th>
                                        <th>Access Control Menu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            Administrator
                                        </td>
                                        <td>Full Access</td>
                                        <td>
                                            <a href="#" class="badge bg-warning">Edit</a>
                                            <a href="#" class="badge bg-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            User
                                        </td>
                                        <td>Dashboard, Dealer</td>
                                        <td>
                                            <a href="#" class="badge bg-warning">Edit</a>
                                            <a href="#" class="badge bg-danger">Delete</a>
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
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Level</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Level Name</label>
                                <input class="form-control" type="text" id="name" required=""
                                    placeholder="Michael Zenaty">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="address">Access Control Menu</label>
                                <select name="" id="control" class="form-control" multiple>
                                    <option value="Dashboard">Digital Asign</option>
                                    <option value="Dealer">Data Items</option>
                                    <option value="Dealer">Form Builder</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="{{ asset('dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#control').select2({
                placeholder: "--Plih Control Menu--",
                dropdownParent: $("#myModal"),
                width: '100%'
            });
        });
    </script>
@endsection
