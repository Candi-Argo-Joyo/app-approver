@extends('index')
@section('title', 'Division | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Division</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Division</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary add" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add Division</a>
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
                        <h4 class="card-title">List Data Division</h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap division">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Division Name</th>
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
                <form action="" id="form-divisi">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Form Division</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Division Name</label>
                            <input class="form-control" type="text" name="name" id="name" required=""
                                placeholder="Division Name">
                            <div id="invalid-name" class="invalid-feedback">
                            </div>
                            <input type="text" name="param" hidden>
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
    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    <script>
        $(function() {
            var i = 1;
            var table = $('.division').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('division.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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

            $('.add').on('click', function() {
                $('#name').val('')
                $('input[name="param"]').val('')
            })

            $('#form-divisi').on('submit', function(e) {
                e.preventDefault();
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('division.save') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.error) {
                            if (response.error.name) {
                                $('#name').addClass('is-invalid')
                                $('#invalid-name').html(response.error.name)
                            } else {
                                $('#name').removeClass('is-invalid')
                                $('#invalid-name').html('')
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
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('division.edit') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            $('#myModal').modal('show')
                            $('#name').val(response.success.name)
                            $('input[name="param"]').val(response.success.id)
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
                            url: "{{ route('division.delete') }}",
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
        });
    </script>
@endsection
