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
                    <a href="javasctipt:void(0)" class="btn btn-primary add" data-bs-toggle="modal"
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
                            <table class="table border table-striped table-bordered text-nowrap tb-users">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th>Full Name</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Source</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                <form action="" id="form-user">
                    @csrf
                    <input type="text" name="param" id="param" hidden>
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Form Dealer</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                placeholder="Michael Zenaty">
                            <div id="invalid-name" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" type="text" id="username" name="username"
                                placeholder="michael_zenaty">
                            <div id="invalid-username" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="d-flex" id="err-pswd">
                                <input style="border-radius: unset" id="password" class="form-control border-radius-left"
                                    type="password" value="kddi123" name="password">
                                <div role="button" class="buton-eye border-radius-right show">
                                    <div style="padding-top: 1.1px;"><i class="fas fa-eye "></i></div>
                                </div>
                                <div role="button" class="buton-eye border-radius-right hidden" style="display:none;">
                                    <div style="padding-top: 1.1px;"><i class="fas fa-eye-slash"></i></div>
                                </div>
                            </div>
                            <div id="invalid-password" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email"
                                placeholder="michael@mail.com">
                            <div id="invalid-email" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script>
        $(function() {
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

            $('.add').click(function() {
                $('#name').val('')
                $('#username').val('')
                $('#email').val('')
                $('#password').val('kddi123')
                $('#param').val('')
            })

            var table = $('.tb-users').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: "{{ route('users.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: "30%"
                    },
                    {
                        data: 'username',
                        name: 'username',
                        width: "30%"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        width: "5%"
                    },
                    {
                        data: 'source',
                        name: 'source',
                        width: "5%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                ]
            });

            $('#form-user').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('users.save') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            if (response.error.name) {
                                $('#name').addClass('is-invalid')
                                $('#invalid-name').html(response.error.name)
                            } else {
                                $('#name').removeClass('is-invalid')
                                $('#invalid-name').html('')
                            }

                            if (response.error.username) {
                                $('#username').addClass('is-invalid')
                                $('#invalid-username').html(response.error.username)
                            } else {
                                $('#username').removeClass('is-invalid')
                                $('#invalid-username').html('')
                            }

                            if (response.error.password) {
                                $('#err-pswd').addClass('is-invalid')
                                $('#err-pswd').attr('style', 'border: 1px solid #ff4f70;')
                                $('#invalid-password').html(response.error.password)
                            } else {
                                $('#err-pswd').removeClass('is-invalid')
                                $('#err-pswd').removeAttr('style')
                                $('#invalid-password').html('')
                            }

                            if (response.error.email) {
                                $('#email').addClass('is-invalid')
                                $('#invalid-email').html(response.error.email)
                            } else {
                                $('#email').removeClass('is-invalid')
                                $('#invalid-email').html('')
                            }
                        } else {
                            table.ajax.reload();
                            $('#myModal').modal('hide')

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                        }
                    }
                })
            })

            $(document).on('click', '.edit', function() {
                $.ajax({
                    url: "{{ route('users.edit') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('show')
                            $('#name').val(response.success.name)
                            $('#username').val(response.success.username)
                            $('#password').val('')
                            $('#email').val(response.success.email)
                            $('#param').val(response.success.id)
                        } else {
                            Swal.fire(
                                'Ups?',
                                response.error,
                                'warning'
                            )
                        }
                    }
                })
            })

            $(document).on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('users.delete') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                param: $(this).attr('data-param')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.success,
                                        showConfirmButton: false,
                                        toast: true,
                                        timer: 1500
                                    })
                                } else {
                                    Swal.fire(
                                        'Ups?',
                                        response.error,
                                        'warning'
                                    )
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
