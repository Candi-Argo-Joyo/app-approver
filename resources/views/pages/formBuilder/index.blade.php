@extends('index')
@section('title', 'Build Form | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
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
                                                <a href="{{ route('formBuilder.add') }}?form={{ $f->id }}"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-danger">
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
    <!--End Container fluid  -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="conditional-form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add Condition Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Select Field to Condition</label>
                            <select name="field" id="field" class="form-control">
                                <option value="">--Select Field--</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Condition</label>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="logic" name="logic"
                                        placeholder="Division Name" value="if" readonly>
                                </div>
                                <div class="col-md-6 p-0">
                                    <input class="form-control" type="text" id="amount" name="amount"
                                        placeholder="Amount">
                                </div>
                                <div class="col-md-3">
                                    <select name="comparison" id="comparison" class="form-control text-center">
                                        <option value="">--Comparison--</option>
                                        <option value=">"> > </option>
                                        <option value="<">
                                            < </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="name" name="condition"
                                        value="must pass" readonly>
                                </div>
                                <div class="col-md-9">
                                    <select name="approval" id="approval" class="form-control">
                                        <option value="">--Select Approval--</option>
                                    </select>
                                </div>
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

                        $('#approval').html('<option value="">--Select Approval--</option>')
                        for (let index = 0; index < response.success.approval.length; index++) {
                            var option = $('<option>', {
                                text: response.success.approval[index].name,
                                value: response.success.approval[index].id
                            })

                            $('#approval').append(option)
                            if (response.success.selected_field != null) {
                                if (response.success.approval[index].id == response.success
                                    .selected_field.id) {
                                    $(option).prop('selected', true)
                                }
                            }
                        }

                        if (response.success.selected_field != null) {
                            $('#amount').val(response.success.selected_field.amount)

                            $('select[name="comparison"] option').each(function(e) {
                                if ($(this).val() == response.success.selected_field
                                    .comparison) {
                                    $(this).prop('selected', true)
                                }
                            })
                        }
                    }
                }
            })
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

                    if (response.error) {
                        $('#field').removeClass('is-invalid')
                        $('#amount').removeClass('is-invalid')
                        $('#comparison').removeClass('is-invalid')
                        $('#approval').removeClass('is-invalid')

                        if (response.error.field) {
                            $('#field').addClass('is-invalid')
                            $('#field').parent().append(
                                '<span err class="invalid-feedback">' + response.error.field +
                                '</span>'
                            )
                        }

                        if (response.error.amount) {
                            $('#amount').addClass('is-invalid')
                            $('#amount').parent().append(
                                '<span err class="invalid-feedback">' + response.error.amount +
                                '</span>')
                        }

                        if (response.error.comparison) {
                            $('#comparison').addClass('is-invalid')
                            $('#comparison').parent().append(
                                '<span err class="invalid-feedback">' + response.error.comparison +
                                '</span>'
                            )
                        }

                        if (response.error.approval) {
                            $('#approval').addClass('is-invalid')
                            $('#approval').parent().append(
                                '<span err class="invalid-feedback">' + response.error.approval +
                                '</span>'
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
                        $('#myModal').modal('hide')
                    }
                }
            })
        })
    </script>
@endsection
