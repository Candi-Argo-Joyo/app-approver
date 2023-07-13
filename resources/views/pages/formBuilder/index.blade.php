@extends('index')
@section('title', 'Build Form | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Builder</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Form Builder</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="{{ route('formBuilder.add') }}" class="btn btn-primary">Create Form</a>
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
                        <h4 class="card-title">List Data Form</h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap tb-form">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 20%">Form Name</th>
                                        <th>Status</th>
                                        <th style="width: 12px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($forms as $f)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $f->form_name }}</td>
                                            <td>{{ $f->status }}</td>
                                            <td style="width: 12px">
                                                <a href="javascript:void(0)" class="btn btn-info setting-form"
                                                    data-bs-toggle="modal" data-bs-target="#myModal"
                                                    data-form-id="{{ $f->id }}">
                                                    <i class="fas fa-cog"></i>
                                                </a>
                                                <a href="{{ route('formBuilder.preview') }}?form={{ $f->id }}"
                                                    class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                {{-- @if ($f->status == 'draft') --}}
                                                <a href="{{ route('formBuilder.add') }}?form={{ $f->id }}"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                {{-- @endif --}}
                                                <a href="javascript:void(0)" class="btn btn-danger" id="del-form"
                                                    data-html="{{ $f->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <style>
        .th {
            padding: 3px;
            border-top: hidden;
            border-left: hidden;
            border-right: hidden;
        }

        .td1 {
            padding: 5px;
            border-left: hidden;
            border-bottom: hidden;
        }

        .td2 {
            padding: 5px;
            border-right: hidden;
            border-bottom: hidden;
        }
    </style>
    <!--End Container fluid  -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="" id="conditional-form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add Condition Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="form_id" hidden>
                        <div class="form-group mb-3 col-md-6">
                            <label class="form-label"> Simultan</label>
                            <select name="simultan" id="simultan" class="form-control">
                                <option value="">--Select--</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label class="form-label" for="name">Select Field to Condition</label>
                            <select name="field" id="field" class="form-control">
                                <option value="">--Select Field--</option>
                            </select>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-secondary w-100 mb-3 add-validation">Add Condition
                            (+)</a>
                        <div id="v-append" class="table-responsive"></div>
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
        $('.tb-form').DataTable({
            serverSide: false,
            scrollX: true,
            autoWidth: true,
            columns: [{
                    width: "1%"
                },
                {
                    width: "30%"
                },
                {
                    width: "15%"
                },
                {
                    width: "5%"
                },
            ],
        });

        $(document).on('click', '.setting-form', function() {
            let id = $(this).attr('data-form-id')
            $('input[name="form_id"]').val(id)
            $.ajax({
                url: "{{ route('formBuilder.settinggetfield') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    param: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#field').html('<option value="">--Select Field--</option>')
                        for (let index = 0; index < response.success.field.length; index++) {
                            var option = $('<option>', {
                                text: response.success.field[index].field_name,
                                value: response.success.field[index].id
                            })

                            $('#field').append(option)
                            if (response.success.selected_field != null) {
                                if (response.success.field[index].id == response.success.selected_field
                                    .id_form_field) {
                                    $(option).prop('selected', true)
                                }
                            }
                        }

                        if (response.success.exist_validation) {
                            $('.add-validation').hide()
                            if (response.success.exist_validation.html) {
                                $('#v-append').html(response.success.exist_validation.html)
                            }

                            if (response.success.exist_validation.selected_field) {
                                $('#field').val(response.success.exist_validation.selected_field)
                                    .trigger('change')
                            }
                        }
                    }
                }
            })
        })

        $('.add-validation').on('click', function() {
            $.ajax({
                url: "{{ route('formBuilder.addValidation') }}",
                type: "get",
                data: {
                    validation_length: ($('table[validation]').length + 1)
                },
                dataType: "json",
                success: function(response) {
                    $('#v-append').append(response.html)
                    $('.add-validation').hide()
                }
            })
        })

        $(document).on('click', '.add-more', function() {
            let inTable = $(this).attr('data-table')
            var rowCount = $(`#${inTable} > tbody`).children().length + 1;

            $.ajax({
                url: "{{ route('users.get') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function(response) {
                    let select = ''
                    for (let index = 0; index < response.data.length; index++) {
                        select += '<option value="' + response.data[index].id + '">' + response.data[
                                index].name + ' [' + response.data[index]
                            .jabatan_name + ']</option>'
                    }

                    let row = `<tr>
                                    <td><span id="${inTable}-row">${rowCount}</span></td>
                                    <td><input td-count-${inTable} type="number" name="step_${inTable}[]" class="form-control bg-white" value="${rowCount}" placeholder="${rowCount}"></td>
                                    <td><input td-count-${inTable} type="text" name="name_${inTable}[]" class="form-control bg-white"></td>
                                    <td>
                                        <select name="select_${inTable}[]" id="" class="form-control bg-white">
                                            <option value="">--Select User--</option>
                                            ${select}
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control bg-white" value="0" name="more_than_${inTable}[]"></td>
                                    <td><input type="text" class="form-control bg-white" value="0" name="less_than_${inTable}[]"></td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-danger dell-more" data-table="${inTable}">-</a>
                                    </td>
                                </tr>`
                    $(`#${inTable}`).append(row)
                }
            })
        })

        $(document).on('click', '.dell-more', function() {
            $(this).closest("tr").remove();

            let inTable = $(this).attr('data-table')
            $(`span[id="${inTable}-row"]`).each(function(i, obj) {
                i++
                $(this).html(i)
            })

            $(`input[td-count-${inTable}]`).each(function(j) {
                j++
                $(this).attr('placeholder', j).val(j)
            })

        })

        $(document).on('click', '.delete-validation', function() {
            let validation = $(this).attr('data-table')
            $(`#${validation}`).remove()
            $('.add-validation').show()
        })

        $('#conditional-form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('formBuilder.settingsaveapprover') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    $('span[err]').remove()
                    console.log(response);

                    if (response.error) {
                        let message = ''
                        if (response.error[0].condition) {
                            message = response.error[0].condition
                        }

                        if (response.error[0].condition_validation) {
                            message = response.error[0].condition_validation
                        }

                        if (response.error[0].step) {
                            message = response.error[0].step
                        }

                        if (response.error[0].required) {
                            message = response.error[0].required
                        }

                        if (response.error[0].user) {
                            message = response.error[0].user
                        }

                        if (response.error[0].name) {
                            message = response.error[0].name
                        }

                        Swal.fire(
                            'Ups?',
                            message,
                            'warning'
                        )
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
                    }
                }
            })
        })

        $(document).on('click', '#del-form', function() {
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
                        url: "{{ route('formBuilder.delform') }}?param= " + $(this).attr(
                            'data-html'),
                        type: "get",
                        async: false
                    })
                    window.location.href = "{{ route('formBuilder') }}";
                }
            })
        })
    </script>
@endsection
