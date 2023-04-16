@extends('index')
@section('title', 'Sales | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Mapping Users</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Mapping Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary mapping-now" data-bs-toggle="modal"
                        data-bs-target="#myModal">Mapping Now</a>
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
                        <h4 class="card-title">List Mapping Users</h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap hast-maping">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Position</th>
                                        <th>Division</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="" id="save-mapping">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Form Mapping Users</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table border table-striped table-bordered text-nowrap un-mapping">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Position</th>
                                    <th>Division</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save">Save changes</button>
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
    <script src="{{ asset('assets/select2/js/select2.js') }}"></script>
    <script>
        $(function() {
            // $('.position').select2({
            //     placeholder: '--Chose Position--',
            //     tags: true
            // });

            var table = $('.hast-maping').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: "{{ route('hastmapping.datatables') }}",
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
                        data: 'email',
                        name: 'email',
                        width: "30%"
                    },
                    {
                        data: 'role',
                        name: 'role',
                    },
                    {
                        data: 'jabatan_name',
                        name: 'jabatan_name',
                        width: "25%"
                    },
                    {
                        data: 'divisi_name',
                        name: 'divisi_name',
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

            var table2 = $('.un-mapping').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: "{{ route('untmapping.datatables') }}",
                columns: [{
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'divisi',
                        name: 'divisi',
                        orderable: false,
                        searchable: false,
                    }
                ],
                drawCallback: function() {
                    $('.position').select2({
                        placeholder: '--Chose Position--',
                        dropdownParent: $("#myModal"),
                        tags: true,
                    });

                    $('.division').select2({
                        placeholder: '--Chose Division--',
                        dropdownParent: $("#myModal"),
                        tags: true,
                    });

                    $('.role').select2({
                        placeholder: '--Chose Role--',
                        dropdownParent: $("#myModal"),
                        tags: true,
                    });
                },
            });

            $('.mapping-now').click(function() {
                table2.ajax.reload();
            })

            $('#save-mapping').on('submit', function(e) {
                e.preventDefault();
                let selected = []
                $('input[name="select[]"]:checked').each(function(params) {
                    selected.push($(this).val())
                })

                if (selected.length == 0) {
                    Swal.fire(
                        'Ups?',
                        'Please select the user first',
                        'warning'
                    )

                    return false
                }

                $.ajax({
                    url: "{{ route('mappingusers.savemapping') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success',
                                response.success,
                                'success'
                            )
                            table.ajax.reload()
                            table2.ajax.reload()
                        } else {
                            Swal.fire(
                                'Ups?',
                                'please check your form again',
                                'warning'
                            )
                        }
                    }
                })
            })

            $(document).on('click', '.rolback', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "you will rollback this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('mappingusers.rollback') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                param: $(this).attr('data-param')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Success',
                                        response.success,
                                        'success'
                                    )
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
        })
    </script>
@endsection
