@extends('index')
@section('title', 'Setting SSO/WEB | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
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
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white group">Add Group
                        Menu</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light menu"
                        style="border-left: 1px solid #c8c8c8">Add
                        Menu</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light page"
                        style="border-left: 1px solid #c8c8c8">Setting
                        Page Menu</a>
                </div>
                <div class="card" id="group">
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
                </div>
                <div class="card" id="menu" style="display: none">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Data Menu</h4>
                                <small>data menu primary</small>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
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
                            <ul class="list-group" id="html-group">
                            </ul>
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
                    <input type="text" name="param-menu" hidden>
                    <div class="form-group mb-3">
                        <label class="form-label" for="menu-group">Select Group <small class="text-danger">*</small></label>
                        <select name="menu-group" id="menu-group" class="form-control">
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name-menu">Name Menu <small class="text-danger">*</small></label>
                        <input class="form-control" type="text" id="name-menu" name="name-menu" required=""
                            placeholder="My Menu">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="type-menu">Type Menu <small class="text-danger">*</small></label>
                        <select name="type-menu" id="type-menu" class="form-control">
                            <option value="">--Select Type Menu--</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="singgle">Singgle Menu</option>
                        </select>
                    </div>
                    <div class="form-group mb-3" id="parent" style="display: none">
                        <label class="form-label" for="parent-menu">Parent Menu</label>
                        <select name="parent-menu" id="parent-menu" class="form-control">
                            <option value="">--Select Menu--</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-menu">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="menuGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="menuGroupLabel"
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-group">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="pageMenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pageMenuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="pageMenuLabel">Form Create Page Menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="param_group" hidden>
                    <div class="form-group mb-3">
                        <label class="form-label" for="select_menu">Select Menu <small
                                class="text-danger">(mandatory)</small></label>
                        <select name="select_menu" id="select_menu" class="form-control">
                            <option value="">--Select Menu--</option>
                        </select>
                        <div id="invalid-select-menu" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Select menu type <small class="text-danger">(mandatory)</small></label>
                        <div class="d-flex pe-3 gap-2">
                            <label class="col-sm-4 p-0 form-label lb" click role="button">
                                Entry Page <br>
                                <small>used for entry forms</small>
                                <div style="border: 1px solid #ddd">
                                    <img src="{{ asset('images/page/entry.png') }}" alt="entry page" style="width: 100%">
                                    <input type="radio" name="page" hidden value="">
                                </div>
                            </label>
                            <label class="col-sm-4 p-0 form-label lb" click role="button">
                                Approver Page <br>
                                <small>used for form approval</small>
                                <div style="border: 1px solid #ddd">
                                    <img src="{{ asset('images/page/approver.png') }}" alt="entry page"
                                        style="width: 100%">
                                    <input type="radio" name="page" hidden value="">
                                </div>
                            </label>
                            <label class="col-sm-4 p-0 form-label lb" click role="button">
                                Report Page <br>
                                <small>used for data reports</small>
                                <div style="border: 1px solid #ddd">
                                    <img src="{{ asset('images/page/report.png') }}" alt="entry page"
                                        style="width: 100%">
                                    <input type="radio" name="page" hidden value="">
                                </div>
                            </label>
                        </div>
                        <div id="invalid-select-menu" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-group">Save changes</button>
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
        getGroup()
        url()
        getAllMenu()
        getSinggleMenu()

        function url() {
            var url_string = window.location.href;
            var url = new URL(url_string);
            var c = url.searchParams.get("data");
            // console.log(url_string);

            switch (c) {
                case 'add-menu':
                    menu()
                    break;
                case 'add-group-menu':
                    group()
                    break;
                case 'setting-page-menu':
                    page()
                    break;
            }
        }

        $('.menu').on('click', function() {
            menu()
        })

        $('.group').on('click', function() {
            group()
        })
        $('.page').on('click', function() {
            page()
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

        function group() {
            $('.group').removeClass('bg-light').addClass('bg-white')
            $('.menu').removeClass('bg-white').addClass('bg-light')
            $('.page').removeClass('bg-white').addClass('bg-light')

            $('#menu').hide()
            $('#page').hide()
            $('#group').show()
            window.history.pushState(
                'page add group menu',
                'add group menu', '{{ route('dataMenu') }}?data=add-group-menu');
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

        $('label[click]').on('click', function() {
            $('label[click]').removeClass('border-blue')
            $(this).addClass('border-blue')
        })

        $('.create-group').on('click', function() {
            $('input[name="name_group"]').val('')
            $('input[name="param_group"]').val('')
        })

        $('.save-group').on('click', function() {
            $.ajax({
                url: "{{ route('dataMenu.savegroup') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    group: $('input[name="name_group"]').val(),
                    param: $('input[name="param_group"]').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.group) {
                            $('input[name="name_group"]').addClass('is-invalid')
                            $('#invalid-group').html(response.error.group[0])
                        } else {
                            $('input[name="name_group"]').removeClass('is-invalid')
                            $('#invalid-group').html('')
                        }
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        })

                        $('#menuGroup').modal('hide')
                        getGroup()
                        getAllMenu()
                        sidebarShow()
                    }
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

        $(document).on('click', '.edit-group', function() {
            $.ajax({
                url: "{{ route('dataMenu.delonegroup') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    param: $(this).attr('data-param')
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#menuGroup').modal('show')
                        $('input[name="name_group"]').val(response.success.name)
                        $('input[name="param_group"]').val(response.success.id)
                        return false
                    }
                    Swal.fire(
                        'The Internet?',
                        response.error,
                        'question'
                    )
                    return false
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

        $(document).on('click', '.del-group', function() {
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
                        url: "{{ route('dataMenu.delgroup') }}",
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

                                getGroup()
                                sidebarShow()
                                return false
                            }
                            Swal.fire(
                                'The Internet?',
                                response.error,
                                'question'
                            )
                            return false
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
        })

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
                        $('#parent-menu').append('<option value="' + response.data[index].id + '">' +
                            response
                            .data[index].name + '</option>')
                    }
                }
            })
        })

        $('#type-menu').on('change', function() {
            if ($('select[name=type-menu] option').filter(':selected').val() != 'dropdown') {
                $('#parent').show()
            } else {
                $('#parent').hide()
                $('#parent-menu').prop('selectedIndex', 0);
            }
        })

        $('.save-menu').on('click', function() {
            if ($('select[name=menu-group] option').filter(':selected').val() == '') {
                Swal.fire(
                    'Ups!',
                    'group menu cannot be empty',
                    'warning'
                )
                return false
            }

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
                    id_group: $('select[name=menu-group] option').filter(':selected').val(),
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

        function getGroup() {
            $.ajax({
                url: "{{ route('dataMenu.getGroupAll') }}",
                type: "get",
                dataType: "json",
                success: function(response) {
                    $('#html-group').html('')
                    $('#menu-group').html('<option value="">--Select Group--</option>')
                    for (let index = 0; index < response.data.length; index++) {
                        $('#html-group').append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           <strong>${response.data[index].name}</strong>
                            <span>
                                <a href="javascript:void(0)" data-param=${response.data[index].id} class="badge bg-warning badge-pill edit-group">edit</a>
                                <a href="javascript:void(0)" data-param=${response.data[index].id} class="badge bg-danger badge-pill del-group">delete</a>
                            </span>
                        </li>`)

                        $('#menu-group').append(
                            `<option value="${response.data[index].id}">${response.data[index].name}</option>`
                        )
                    }
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

        function getAllMenu() {
            $.ajax({
                url: "{{ route('dataMenu.getAllMenu') }}",
                type: "get",
                dataType: "json",
                success: function(response) {
                    $('#show-menu').html(response.html)
                }
            })
        }

        function getSinggleMenu() {
            $.ajax({
                url: "{{ route('dataMenu.getSinggleMenu') }}",
                type: "get",
                dataType: "json",
                success: function(response) {
                    $('#select_menu').html('<option value="">--Select Menu--</option>')
                    for (let index = 0; index < response.data.length; index++) {
                        $('#select_menu').append('<option value="' + response.data[index].id + '">' + response
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
    </script>
@endsection
