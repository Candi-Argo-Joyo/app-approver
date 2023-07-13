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
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Items</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Items</li>
                        </ol>
                    </nav>
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
                <div class="d-flex">
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white group">Add Group
                        Items</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light items"
                        style="border-left: 1px solid #c8c8c8">Add
                        Items</a>
                </div>
                <div class="card" id="group">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Data Group Items</h4>
                                <small>data group mandatory</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary create-group" data-bs-toggle="modal"
                                data-bs-target="#menuGroup">Create Group</a>
                        </div>
                        <div class="col-12">
                            <table class="table border table-striped table-bordered text-nowrap tb-group-items">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Group Name</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card" id="item" style="display: none">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Data Items</h4>
                                <small>list item</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary add-item" data-bs-toggle="modal"
                                data-bs-target="#modalItems">Add Item</a>
                        </div>
                        <div class="col-12">
                            <table class="table border table-striped table-bordered text-nowrap tb-items"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Group</td>
                                        <td>Item</td>
                                        <td>Unit</td>
                                        <td>Action</td>
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
    <div id="menuGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="menuGroupLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="form-group">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="menuGroupLabel">Form Group</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Group Name</label>
                            <input class="form-control" type="text" name="name" id="name"
                                placeholder="Group Name">
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
    <div id="modalItems" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalItemsLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="form-item">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalItemsLabel">Form Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="param_item" hidden>
                        <div class="form-group mb-3">
                            <label class="form-label" for="group_item">Group Item</label>
                            <select name="group_item" id="group_item" class="form-control">
                                <option value="">--Select Group--</option>
                            </select>
                            <div id="invalid-group_item" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Item Name</label>
                            <input class="form-control" type="text" name="name_item" id="name_item"
                                placeholder="Item Name">
                            <div id="invalid-name_item" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="unit">Unit</label>
                            <input class="form-control" type="text" name="unit" id="unit" placeholder="Pcs">
                            <div id="invalid-unit" class="invalid-feedback">
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
        $(function() {
            getAllGroup()

            var table_group = $('.tb-group-items').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('groupitem.datatables') }}",
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

            var table_items = $('.tb-items').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('items.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name_group',
                        name: 'name_group'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.group').on('click', function() {
                $('#group').show()
                $('#item').hide()
                $(this).removeClass('bg-light').addClass('bg-white')
                $('.items').addClass('bg-light').removeClass('bg-white')
            })

            $('.items').on('click', function() {
                $('#item').show()
                $('#group').hide()
                $(this).removeClass('bg-light').addClass('bg-white')
                $('.group').addClass('bg-light').removeClass('bg-white')
                table_items.ajax.reload();
            })

            // group area
            $('#form-group').on('submit', function(e) {
                e.preventDefault();
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('items.save_group') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            table_group.ajax.reload();
                            $('#menuGroup').modal('hide')
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                            getAllGroup()
                        } else {
                            if (response.error.name) {
                                $('#name').addClass('is-invalid')
                                $('#invalid-name').html(response.error.name)
                            } else {
                                $('#name').removeClass('is-invalid')
                                $('#invalid-name').html('')
                            }
                        }
                    }
                })
            })

            $(document).on('click', '.edit', function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('items.edit') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            $('#menuGroup').modal('show')
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
                            url: "{{ route('items.delete') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                param: $(this).attr('data-param')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    table_group.ajax.reload();
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

            // Item area
            $('#form-item').on('submit', function(e) {
                e.preventDefault();
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('items.save_item') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            table_items.ajax.reload();
                            $('#modalItems').modal('hide')
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                            getAllGroup()
                        } else {
                            if (response.error.group_item) {
                                $('#group_item').addClass('is-invalid')
                                $('#invalid-group_item').html(response.error.group_item)
                            } else {
                                $('#group_item').removeClass('is-invalid')
                                $('#invalid-group_item').html('')
                            }

                            if (response.error.name_item) {
                                $('#name_item').addClass('is-invalid')
                                $('#invalid-name_item').html(response.error.name_item)
                            } else {
                                $('#name_item').removeClass('is-invalid')
                                $('#invalid-name_item').html('')
                            }

                            if (response.error.unit) {
                                $('#unit').addClass('is-invalid')
                                $('#invalid-unit').html(response.error.unit)
                            } else {
                                $('#unit').removeClass('is-invalid')
                                $('#invalid-unit').html('')
                            }
                        }
                    }
                })
            })

            $(document).on('click', '.edit-item', function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('items.edititem') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            $('#modalItems').modal('show')
                            $('#name_item').val(response.success.name)
                            $('#unit').val(response.success.unit)
                            $('input[name="param_item"]').val(response.success.id)
                            $('#group_item').val(response.success.id_group_item).trigger(
                                'change')
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


            $(document).on('click', '.del-item', function() {
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
                            url: "{{ route('items.deleteitem') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                param: $(this).attr('data-param')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    table_items.ajax.reload();
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

            function getAllGroup() {
                $.ajax({
                    url: "{{ route('items.getgroup') }}",
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        $('#group_item').html('<option value="">--Select Group--</option>')
                        for (let index = 0; index < response.data.length; index++) {
                            $('#group_item').append('<option value="' + response.data[index].id + '">' +
                                response.data[index].name + '</option>')
                        }
                    }
                })
            }
        })
    </script>
@endsection
