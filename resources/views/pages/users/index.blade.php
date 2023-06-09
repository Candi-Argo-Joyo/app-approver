@extends('index')
@section('title', 'Users | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <style>
        .buton-eye {
            display: block;
            padding: 6px 12px;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #4f5467;
            background-color: transparent;
            background-clip: padding-box;
            border: var(--bs-border-width) solid #e9ecef;
            appearance: none;
            border-radius: 2px;
            box-shadow: inset 0 1px 2px rgba(var(--bs-body-color-rgb), 0.075);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .border-radius-left {
            border-top-left-radius: 2px !important;
            border-bottom-left-radius: 2px !important;
        }

        .border-radius-right {
            border-top-right-radius: 2px !important;
            border-bottom-right-radius: 2px !important;
        }
    </style>
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data User</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item text-muted active" aria-current="page">User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add User</a>
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
                        <h4 class="card-title">List Data Users</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th>Full Name</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Anton Wowo</td>
                                        <td>anton_wowo</td>
                                        <td>anton@mail.com</td>
                                        <td>Manager</td>
                                        <td>User</td>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Dealer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-control" type="text" id="name" required=""
                            placeholder="Michael Zenaty">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Username</label>
                        <input class="form-control" type="text" id="name" required=""
                            placeholder="michael_zenaty">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="d-flex">
                            <input style="border-radius: unset" class="form-control border-radius-left" type="password"
                                id="password" value="kddi123" required>
                            <div role="button" class="buton-eye border-radius-right show">
                                <div style="padding-top: 1.1px;"><i class="fas fa-eye "></i></div>
                            </div>
                            <div role="button" class="buton-eye border-radius-right hidden" style="display:none;">
                                <div style="padding-top: 1.1px;"><i class="fas fa-eye-slash"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Email</label>
                        <input class="form-control" type="email" id="name" required=""
                            placeholder="michael@mail.com">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Jabatan</label>
                        <select name="" id="" class="form-control">
                            <option value="">--Select Jabatan--</option>
                        </select>
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
    <script>
        $('.show').mousedown(function() {
            $(this).hide()
            $('#password').attr('type', 'text')
            $('.hidden').show()
        })

        $('.hidden').mousedown(function() {
            $(this).hide()
            $('#password').attr('type', 'password')
            $('.show').show()
        })
    </script>
@endsection
