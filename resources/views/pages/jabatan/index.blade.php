@extends('index')
@section('title', 'Position | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Position</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Position</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary add" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add Position</a>
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
                        <h4 class="card-title">List Data Position</h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap position">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>Tiger Nixon</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="badge bg-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr> --}}
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
                    <h4 class="modal-title" id="myModalLabel">Form Position</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" type="text" id="name" name="name" required
                            placeholder="Manager">
                        <div id="invalid-name" class="invalid-feedback">
                        </div>
                        <input class="form-control" type="text" id="param" hidden name="param">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    <script>
        $(function() {
            var i = 1;
            var table = $('.position').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('poistion.datatables') }}",
                columns: [{
                        data: 'rownum',
                        name: 'rownum'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.add').click(function() {
                $('input[name="name"]').val('')
                $('input[name="param"]').val('')
            })

            $('.save').click(function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('poistion.save') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('input[name="name"]').val(),
                        param: $('input[name="param"]').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            if (response.error.name) {
                                $('input[name="name"]').addClass('is-invalid')
                                $('#invalid-name').html(response.error.name[0])
                            } else {
                                $('input[name="name"]').removeClass('is-invalid')
                                $('#invalid-name').html('')
                            }
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })

                            $('#myModal').modal('hide')
                            table.ajax.reload();
                        }
                    },
                    complete: function(data) {
                        $(".preloader").fadeOut()
                    },
                    error: function(jqXHR, exception) {
                        Swal.fire(
                            'The Internet?',
                            'An error occurred check your internet connection',
                            'warning'
                        )
                    },
                })
            })

            $(document).on('click', '.edit', function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('poistion.edit') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('show')
                            $('input[name="name"]').val(response.success.data.name)
                            $('input[name="param"]').val(response.success.data.id)
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: response.error.msg,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                        }
                    },
                    complete: function(data) {
                        $(".preloader").fadeOut()
                    },
                    error: function(jqXHR, exception) {
                        Swal.fire(
                            'The Internet?',
                            'An error occurred check your internet connection',
                            'warning'
                        )
                    },
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
                        $(".preloader").fadeIn()
                        $.ajax({
                            url: "{{ route('poistion.delete') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                param: $(this).attr('data-param')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.success.msg,
                                        showConfirmButton: false,
                                        toast: true,
                                        timer: 1500
                                    })
                                    table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: response.error.msg,
                                        showConfirmButton: false,
                                        toast: true,
                                        timer: 1500
                                    })
                                }
                            },
                            complete: function(data) {
                                $(".preloader").fadeOut()
                            },
                            error: function(jqXHR, exception) {
                                Swal.fire(
                                    'The Internet?',
                                    'An error occurred check your internet connection',
                                    'warning'
                                )
                            },
                        })
                    }
                })
            });
        });
    </script>
@endsection
