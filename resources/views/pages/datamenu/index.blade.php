@extends('index')
@section('title', 'Setting SSO/WEB | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.css') }}">
@endsection
@section('content')
    <style>
        .border-blue {
            border: 1px solid #5f76e8;
            box-shadow: 0 8px 8px -4px #5f76e8;
        }

        .lb:hover {
            border: 1px solid #5f76e8;
            box-shadow: 0 8px 8px -4px #5f76e8;
        }

        .select2-container--default .select2-selection--single {
            background-color: unset;
            padding: 6px 12px;
        }

        .select2-container .select2-selection--single {
            height: unset;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: unset;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #e9ecef;
        }

        .is-invalid .select2-selection,
        .needs-validation~span>.select2-dropdown {
            border-color: var(--bs-danger) !important;
        }
    </style>
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Menu</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Data Menu</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javasctipt:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">Add Sales</a>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Top Leader Table -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex">
                    {{-- <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white group">Add Group
                        Menu</a> --}}
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white menu">Add
                        Menu</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light page"
                        style="border-left: 1px solid #c8c8c8">Setting
                        Page Menu</a>
                </div>
                {{-- <div class="card" id="group">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Data Group</h4>
                                <small>data group mandatory</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary create-group" data-bs-toggle="modal"
                                data-bs-target="#menuGroup">Create Group</a>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group" id="html-group">
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <div class="card" id="menu">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Data Menu</h4>
                                <small>data menu primary</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary add-menu" data-bs-toggle="modal"
                                data-bs-target="#menuModal">Create Menu</a>
                        </div>
                        <div class="col-md-12" id="show-menu">
                        </div>
                    </div>
                </div>
                <div class="card" id="page" style="display: none">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Setting page menu</h4>
                                <small>data page menu mandatory</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary create-page" data-bs-toggle="modal"
                                data-bs-target="#pageMenu">Setting Page Menu</a>
                        </div>
                        <div class="col-md-12">
                            <table class="table border table-striped table-bordered text-nowrap tb-page"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu (Parent Menu)</th>
                                        <th>Menu (Child Menu)</th>
                                        <th>Menu Type</th>
                                        <th>Status</th>
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
    <div id="menuModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="menuModalLabel">Form Create Menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="param-menu" id="param-menu" hidden>
                    {{-- <div class="form-group mb-3">
                        <label class="form-label" for="menu-group">Select Group <small class="text-danger">*</small></label>
                        <select name="menu-group" id="menu-group" class="form-control">
                        </select>
                        <div id="invalid-menu-group" class="invalid-feedback">
                        </div>
                    </div> --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="name-menu">Name Menu <small class="text-danger">*</small></label>
                        <input class="form-control" type="text" id="name-menu" name="name-menu" required=""
                            placeholder="My Menu">
                        <div id="invalid-name-menu" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="type-menu">Type Menu <small class="text-danger">*</small></label>
                        <select name="type-menu" id="type-menu" class="form-control">
                            <option value="">--Select Type Menu--</option>
                            <option value="dropdown">Parent Menu</option>
                            <option value="singgle">Child Menu</option>
                        </select>
                        <div id="invalid-type-menu" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group mb-3" id="parent" style="display: none">
                        <label class="form-label" for="parent-menu">Parent Menu</label>
                        <select name="parent-menu" id="parent-menu" class="form-control">
                            <option value="">--Select Menu--</option>
                        </select>
                        <div id="invalid-parent-menu" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-menu">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    {{-- <div id="menuGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="menuGroupLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="menuGroupLabel">Form Create Group</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name_group">Name Group <small
                                class="text-danger">(mandatory)</small></label>
                        <input class="form-control" name="name_group" type="text" id="name_group"
                            placeholder="My Group">
                        <div id="invalid-group" class="invalid-feedback">
                        </div>

                        <input type="text" name="param_group" hidden>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="divisi">Division <small
                                class="text-danger">(mandatory)</small></label>
                        <select name="divisi" id="divisi" class="form-control">
                            <option value="">--Select Division--</option>
                            @foreach ($divsi as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        <div id="invalid-divisi" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-group">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div> --}}
    <div id="pageMenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pageMenuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="pageMenuLabel">Form Create Page Menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="page-form">
                        <div class="form-group mb-3">
                            <label class="form-label" for="parent_menu">Select Parent Menu <small
                                    class="text-danger">*</small></label>
                            <select name="parent_menu" id="parent_menu" class="form-control">
                                <option value="">--Select Menu--</option>
                            </select>
                            <div id="invalid-parent-menu" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="child_menu">Select Child Menu <small
                                    class="text-danger">*</small></label>
                            <select name="child_menu" id="child_menu" disabled class="form-control">
                                <option value="">--Select Menu--</option>
                            </select>
                            <div id="invalid-child-menu" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Select menu type <small class="text-danger">*</small></label>
                            <div class="p-3">
                                <div class="row">
                                    <label class="col-sm-6 col-md-3 p-2 form-label lb" click role="button">
                                        Entry Page <br>
                                        <small>used for entry forms</small>
                                        <div style="border: 1px solid #ddd">
                                            <img src="{{ asset('images/page/entry.png') }}" alt="entry page"
                                                style="width: 100%">
                                            <input type="radio" name="page" hidden value="Entry Page">
                                        </div>
                                    </label>
                                    <label class="col-sm-6 col-md-3 p-2 form-label lb" click role="button">
                                        Approver Page <br>
                                        <small>used for form approval</small>
                                        <div style="border: 1px solid #ddd">
                                            <img src="{{ asset('images/page/approver.png') }}" alt="Approver page"
                                                style="width: 100%">
                                            <input type="radio" name="page" hidden value="Approver">
                                        </div>
                                    </label>
                                    <label class="col-sm-6 col-md-3 p-2 form-label lb" click role="button">
                                        Validator Page <br>
                                        <small>used for form validator</small>
                                        <div style="border: 1px solid #ddd">
                                            <img src="{{ asset('images/page/approver.png') }}" alt="Approver page"
                                                style="width: 100%">
                                            <input type="radio" name="page" hidden value="Validator">
                                        </div>
                                    </label>
                                    <label class="col-sm-6 col-md-3 p-2 form-label lb" click role="button">
                                        Report Page <br>
                                        <small>used for data reports</small>
                                        <div style="border: 1px solid #ddd">
                                            <img src="{{ asset('images/page/report.png') }}" alt="Report page"
                                                style="width: 100%">
                                            <input type="radio" name="page" hidden value="Report">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div id="invalid-select-menu" class="invalid-feedback">
                            </div>
                        </div>
                        {{-- <div class="form-group mb-3" id="approval" style="display: none">
                            <label class="form-label">Select User Approval <small class="text-danger">*</small></label>
                            <select name="user_approval" id="user_approval" class="form-control">
                                <option value="">--Select User--</option>
                                @foreach ($users as $us)
                                    <option value="{{ $us->id }}">{{ $us->name }} [Role: {{ $us->role }}]
                                    </option>
                                @endforeach
                            </select>
                            <div id="invalid-user-approval" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group mb-3" id="validator" style="display: none">
                            <label class="form-label">Select User Validator <small class="text-danger">*</small></label>
                            <select name="user_validator" id="user_validator" class="form-control">
                                <option value="">--Select User--</option>
                                @foreach ($users_v as $usv)
                                    <option value="{{ $usv->id }}">{{ $usv->name }} [Role: {{ $usv->role }}]
                                    </option>
                                @endforeach
                            </select>
                            <div id="invalid-user-validator" class="invalid-feedback">
                            </div>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-page-menu">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="viewImage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pageMenuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="pageMenuLabel">View Image</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="row">
                    <img src="" id="preview-image" style="width: 100%">
                </div>
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
            $('#divisi').select2({
                width: '100%',
                dropdownParent: $("#menuGroup"),
            })

            $('#menu-group').select2({
                width: '100%',
                dropdownParent: $("#menuModal"),
            })

            var i = 1;
            var table = $('.tb-page').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: "{{ route('pagemenu.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                    {
                        data: 'name_parent',
                        name: 'name_parent',
                        width: "30%"
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: "30%"
                    },
                    {
                        data: 'type',
                        name: 'type',
                        width: "25%"
                    },
                    {
                        data: 'status',
                        name: 'status',
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

            url()
            getAllMenu()
            getSinggleMenu()

            function url() {
                var url_string = window.location.href;
                var url = new URL(url_string);
                var c = url.searchParams.get("data");

                switch (c) {
                    case 'add-menu':
                        menu()
                        break;
                    case 'setting-page-menu':
                        page()
                        break;
                }
            }

            $('.menu').on('click', function() {
                menu()
            })

            $('.page').on('click', function() {
                page()
                table.ajax.reload();
            })

            function menu() {
                $('.menu').removeClass('bg-light').addClass('bg-white')
                $('.group').removeClass('bg-white').addClass('bg-light')
                $('.page').removeClass('bg-white').addClass('bg-light')

                $('#menu').show()
                $('#page').hide()
                $('#group').hide()
                window.history.pushState(
                    'page add menu',
                    'add menu', '{{ route('dataMenu') }}?data=add-menu');
            }

            function page() {
                $('.page').removeClass('bg-light').addClass('bg-white')
                $('.menu').removeClass('bg-white').addClass('bg-light')
                $('.group').removeClass('bg-white').addClass('bg-light')

                $('#menu').hide()
                $('#group').hide()
                $('#page').show()
                window.history.pushState(
                    'page setting page menu',
                    'setting page menu', '{{ route('dataMenu') }}?data=setting-page-menu');
            }

            // fungsi untuk menu
            $('#menu-group').on('change', function() {
                $.ajax({
                    url: "{{ route('dataMenu.getParentMenu') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_group: $('select[name=menu-group] option').filter(':selected').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#parent-menu').html('<option value="">--Select Menu--</option>')
                        for (let index = 0; index < response.data.length; index++) {
                            $('#parent-menu').append('<option value="' + response.data[index]
                                .id + '">' +
                                response
                                .data[index].name + '</option>')
                        }
                    }
                })
            })

            $('#type-menu').on('change', function() {
                if ($('select[name=type-menu] option').filter(':selected').val() == 'singgle') {
                    $('#parent').show()
                } else if ($('select[name=type-menu] option').filter(':selected').val() == 'dropdown') {
                    $('#parent').hide()
                    $('#parent-menu').prop('selectedIndex', 0);
                } else {
                    $('#parent').hide()
                    $('#parent-menu').prop('selectedIndex', 0);
                }
            })

            $('.add-menu').click(function() {
                $('#type-menu').val('').trigger('change').prop('disabled', false)
                $('#name-menu').val('')
                $('#param-menu').val('')
                $('#parent-menu').prop('disabled', false)
            })

            $('.save-menu').on('click', function() {

                if ($('input[name=name-menu]').val() == '') {
                    Swal.fire(
                        'Ups!',
                        'menu name cannot be empty',
                        'warning'
                    )
                    return false
                }

                if ($('select[name=type-menu] option').filter(':selected').val() == '') {
                    Swal.fire(
                        'Ups!',
                        'menu type cannot be empty',
                        'warning'
                    )
                    return false
                }

                if ($('select[name=type-menu] option').filter(':selected').val() == 'singgle') {
                    if ($('select[name=parent-menu] option').filter(':selected').val() == '') {
                        Swal.fire(
                            'Ups!',
                            'parent menu cannot be empty',
                            'warning'
                        )
                        return false
                    }
                }

                $.ajax({
                    url: "{{ route('dataMenu.saveMenu') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('input[name="name-menu"]').val(),
                        type: $('select[name=type-menu] option').filter(':selected').val(),
                        parent: $('select[name=parent-menu] option').filter(':selected').val(),
                        param_menu: $('input[name="param-menu"]').val()
                    },
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

                            $('#menuModal').modal('hide')
                            getAllMenu()
                            getSinggleMenu()
                            sidebarShow()
                        } else {
                            if (response.error.name) {
                                $('#name-menu').addClass('is-invalid')
                                $('#invalid-name-menu').html(response.error.name)
                            } else {
                                $('#name-menu').removeClass('is-invalid')
                                $('#invalid-name-menu').html('')
                            }

                            if (response.error.type) {
                                $('#type-menu').addClass('is-invalid')
                                $('#invalid-type-menu').html(response.error.type)
                            } else {
                                $('#type-menu').removeClass('is-invalid')
                                $('#invalid-type-menu').html('')
                            }

                            if (response.error.parent) {
                                $('#parent-menu').addClass('is-invalid')
                                $('#invalid-parent-menu').html(response.error.parent)
                            } else {
                                $('#parent-menu').removeClass('is-invalid')
                                $('#invalid-parent-menu').html('')
                            }

                            if (response.error.msg) {
                                Swal.fire(
                                    'Ups?',
                                    response.error.msg,
                                    'question'
                                )
                            }
                        }
                    }
                })
            })

            $(document).on('click', '.edit', function() {
                $.ajax({
                    url: "{{ route('dataMenu.editMenu') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param')
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#menuModal').modal('show')
                            if (response.success.type != 'dropdown') {
                                $('#parent').show()
                            } else {
                                $('#parent').hide()
                                $('#parent-menu').prop('selectedIndex', 0);
                            }

                            $('#type-menu').prop('disabled', true)
                            $('#param-menu').val(response.success.id)
                            $('#name-menu').val(response.success.name)
                            $('#type-menu').val(response.success.type).trigger('change')

                            if (response.success.parent != '0') {
                                $('#parent-menu').val(response.success.parent).trigger(
                                    'change').prop('disabled', true)
                            }
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
                            url: "{{ route('dataMenu.deleteMenu') }}",
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

                                    getAllMenu()
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

            // fungsi untuk page
            $('#parent_menu').change(function() {
                $.ajax({
                    url: "{{ route('dataMenu.pageParentMenu') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            if (response.success.data.length < 1) {
                                $('#child_menu').prop('disabled', true)
                                $('#child_menu').html(
                                    '<option value="">--Select Child Menu--</option>')
                                Swal.fire(
                                    'Ups?',
                                    'Child menu not yet created',
                                    'warning'
                                )
                            } else {
                                $('#child_menu').prop('disabled', false)
                                $('#child_menu').html(
                                    '<option value="">--Select Child Menu--</option>')
                                for (let index = 0; index < response.success.data
                                    .length; index++) {
                                    $('#child_menu').append('<option value="' + response.success
                                        .data[index]
                                        .id + '">' + response.success.data[index]
                                        .name + '</option>')
                                }
                            }
                        } else {
                            $('#child_menu').prop('disabled', true)
                            $('#child_menu').html(
                                '<option value="">--Select Child Menu--</option>')
                            Swal.fire(
                                'Ups?',
                                'Child menu not found',
                                'warning'
                            )
                        }
                    }
                })
            })

            $('.create-page').on('click', function() {
                $('#page-form').trigger("reset");
                $('#child_menu').prop('disabled', true)
                $('#child_menu').html('<option value="">--Select Child Menu--</option>')
                $('input[name="page"]').each(function(params) {
                    $(this).prop('checked', false)
                })

                $('label[click]').removeClass('border-blue')
                $('#approval').hide()
            })

            $('.save-page-menu').on('click', function() {
                $.ajax({
                    url: "{{ route('dataMenu.savePageMenu') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        parent: $('select[name=parent_menu] option').filter(':selected').val(),
                        child: $('select[name=child_menu] option').filter(':selected').val(),
                        page: $('input[name="page"]:checked').val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            if (response.error.parent) {
                                $('select[name="parent_menu"]').addClass('is-invalid')
                                $('#invalid-parent-menu').html(response.error.parent[0])
                            } else {
                                $('select[name="parent_menu"]').removeClass('is-invalid')
                                $('#invalid-parent-menu').html('')
                            }

                            if (response.error.child) {
                                $('select[name="child_menu"]').addClass('is-invalid')
                                $('#invalid-child-menu').html(response.error.child[0])
                            } else {
                                $('select[name="child_menu"]').removeClass('is-invalid')
                                $('#invalid-child-menu').html('')
                            }

                            if (response.error.page) {
                                Swal.fire(
                                    'Ups!',
                                    'please select menu type',
                                    'warning'
                                )
                            }

                            if (response.error.msg) {
                                Swal.fire(
                                    'Ups!',
                                    response.error.msg,
                                    'warning'
                                )
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

                            $('#pageMenu').modal('hide')
                            sidebarShow()
                            getAllMenu()
                            table.ajax.reload();
                        }
                    }
                })
            })

            $(document).on('click', 'a[preview]', function() {
                let image = $(this).attr('asset')
                $('#preview-image').attr('src', image)
            })

            $(document).on('click', '.change-status', function() {
                let status = $(this).attr('status')
                let text = ''
                if (status == 'true') {
                    text = 'You will change this status to non active'
                } else {
                    text = 'You will change this status to active'
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, confirm!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dataMenu.changeStatus') }}",
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
                                    sidebarShow()
                                    getAllMenu()
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

            $(document).on('click', '.delete-page', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, confirm!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dataMenu.deletePageMenu') }}",
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
                                    sidebarShow()
                                    getAllMenu()
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

            $('label[click]').on('click', function() {
                $('label[click]').removeClass('border-blue')
                $(this).addClass('border-blue')

                val = $('input[name="page"]:checked').val()
                if (val == 'Approver') {
                    $('#approval').show()
                } else {
                    $('#approval').hide()
                }

                if (val == 'Validator') {
                    $('#validator').show()
                } else {
                    $('#validator').hide()
                }
            })

            function getAllMenu() {
                $.ajax({
                    url: "{{ route('dataMenu.getAllMenu') }}",
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        if (response.count_group < 1) {
                            $('#show-menu').html(
                                '<div class="h3 text-center p-4" style="background:#f1f1f1">No data available in menu</div>'
                            )
                        } else {
                            if (response.count_menu < 0) {
                                $('#show-menu').html(
                                    '<div class="h3 text-center p-4" style="background:#f1f1f1">No data available in menu</div>'
                                )
                            } else {
                                $('#show-menu').html(response.html)
                            }
                        }
                    }
                })
            }

            function getSinggleMenu() {
                $.ajax({
                    url: "{{ route('dataMenu.getSinggleMenu') }}",
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        $('#parent-menu').html('<option value="">--Select Menu--</option>')
                        $('#parent_menu').html('<option value="">--Select Menu--</option>')
                        for (let index = 0; index < response.data.length; index++) {
                            $('#parent-menu').append('<option value="' + response.data[index].id +
                                '">' + response
                                .data[index].name + '</option>')
                            $('#parent_menu').append('<option value="' + response.data[index].id +
                                '">' + response
                                .data[index].name + '</option>')
                        }
                    }
                })
            }

            function sidebarShow() {
                $.ajax({
                    url: "{{ route('dataMenu.sidebar') }}",
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        $('ul[id="sidebarnav"]').html(response.data)
                        $('div[data-sidebar]').html(response.script)
                    }
                })
            }
        })
    </script>
@endsection
