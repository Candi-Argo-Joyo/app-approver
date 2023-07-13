@extends('index')
@section('title', 'Digital Assign | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Digital Assign</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Digital Assign</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add Signature</a>
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
                        <h4 class="card-title">List Digital Assign</h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap asign">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sign [Image]</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div style="height: 100px">
                                                <img class="h-100"
                                                    src="{{ asset('images/signature/Oprah-Winfrey-Signature-1.png') }}"
                                                    alt="">
                                            </div>
                                        </td>
                                        <td>Manager 1</td>
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
                <form action="" id="form-asign">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Form Dealer</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="file">Sign [image]</label>
                            <input class="form-control" type="file" name="file" id="file">
                            <div id="invalid-file" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="address">User</label>
                            <select name="user" id="user" class="form-control">
                                <option value="">--Pilih User--</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} [role: {{ $u->role }}]
                                    </option>
                                @endforeach
                            </select>
                            <div id="invalid-user" class="invalid-feedback">
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
    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    <script>
        var table = $('.asign').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('asign.datatables') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'img',
                    name: 'img'
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

        $('#form-asign').on('submit', function(e) {
            e.preventDefault();
            $(".preloader").fadeIn()
            $.ajax({
                url: "{{ route('digitalAsign.save') }}",
                type: "post",
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    if (response.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.success,
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        })
                        table.ajax.reload();
                        $('#myModal').modal('hide')
                    } else {
                        if (response.error.file) {
                            $('#file').addClass('is-invalid')
                            $('#invalid-file').html(response.error.file)
                        } else {
                            $('#file').removeClass('is-invalid')
                            $('#invalid-file').html('')
                        }

                        if (response.error.user) {
                            $('#user').addClass('is-invalid')
                            $('#invalid-user').html(response.error.user)
                        } else {
                            $('#user').removeClass('is-invalid')
                            $('#invalid-user').html('')
                        }
                    }
                }
            })
        })

        $(document).on('click', '.del', function() {
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
                        url: "{{ route('digitalAsign.del') }}",
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
                                    title: response.success,
                                    showConfirmButton: false,
                                    toast: true,
                                    timer: 1500
                                })
                                table.ajax.reload();
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
    </script>
@endsection
