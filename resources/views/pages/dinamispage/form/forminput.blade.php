@extends('index')
@section('title', 'Add Kredit | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <script src="https://cdn.tiny.cloud/1/bx37734n27j3z8dfd0nytnxe3jmv18nlkh47fvwbbchlow82/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.css') }}">
    <style>
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
@endsection

@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Kredit</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"
                                    class="text-muted">{{ $parent->name }}</a>
                            </li>
                            <li class="breadcrumb-item text-muted active" aria-current="page"><?= $menu->name ?></li>
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $form->form_name }}</h5>
                        <div style="font-size: 12px">
                            <form action="" id="form-input" class="h6">
                                <input type="text" name="form" value="{{ Request::get('form') }}" hidden>
                                @csrf
                                {!! $form->html_final !!}
                                <button type="submit" class="btn btn-primary save">Confirm & Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
    <div id="items" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="itemsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="itemsLabel">Choose Items</h4>
                    <button type="button" class="btn-close close_item" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="">
                    <div class="form-group">
                        <label class="form-label" for="form-name">Select Item</label>
                        <select name="item" id="item" class="form-control">
                            <option value="">--Select Item--</option>
                        </select>
                        <div id="invalid-item" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light close_item" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-item">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/select2/js/select2.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'charmap codesample lists table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ]
        });

        $('#item').select2({
            width: '100%',
            dropdownParent: $("#items"),
        })


        $('#form-input').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('pages.save') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        var url_string = window.location.href;
                        var url = new URL(url_string);
                        var c = url.searchParams.get("menu");
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.success,
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        })

                        window.location.replace("{{ route('pages') }}?menu=" + c);
                    } else {
                        $('input[name]').removeClass('is-invalid')
                        $('select[name]').removeClass('is-invalid')
                        $('textarea[name]').removeClass('is-invalid')
                        $('span[data]').remove()

                        $.each(response.error, function(index, value) {
                            $(`input[name="${index}"]`).addClass('is-invalid')
                            $(`input[name="${index}"]`).after(
                                `<span data class="invalid-feedback">${value} </span>`)

                            $(`textarea[name="${index}"]`).addClass('is-invalid')
                            $(`textarea[name="${index}"]`).after(
                                `<span data class="invalid-feedback">${value} </span>`)
                        });
                    }
                }
            })
        })

        let table_item = ''
        $(document).on('click', '.add-item', function() {
            table_item = $(this).attr('data-id-table')
            $.ajax({
                url: "{{ route('pages.items') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    group: $(this).attr('data-group')
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#item').html(`<option value="">--Select Item--</option>`)
                        for (let index = 0; index < response.success.data.length; index++) {
                            $('#item').append(
                                `<option value="${response.success.data.id}">${response.success.data[index].name}</option>`
                            )
                        }
                        $('#items').modal('show')
                    } else {
                        Swal.fire(
                            'Ups?',
                            response.error.msg,
                            'question'
                        )
                    }
                }
            })
        })

        $('.submit-item').on('click', function() {
            let row = `<tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>`
            // $(`#${table_item} tbody`).html('')
            $(`#${table_item} tbody`).append(row)
            console.log(table_item)
        })
    </script>
@endsection
