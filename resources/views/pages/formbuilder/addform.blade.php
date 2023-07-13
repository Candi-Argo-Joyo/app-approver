@extends('index')
@section('title', 'Build Form | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <script src="https://cdn.tiny.cloud/1/bx37734n27j3z8dfd0nytnxe3jmv18nlkh47fvwbbchlow82/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.css') }}">
@endsection
@section('content')
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
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Create Form</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Form Builder</li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Create Form</li>
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
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white prev">Preview</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light set">Setting</a>
                </div>
                <div class="card" id="prev">
                    <div class="card-body" data-dom>
                        <?php if($html){ ?>
                        <div>
                            <input class="form-name" type="text" value="{{ $html->form_name }}" name="form_name"
                                placeholder="Form Name">
                            <input type="text" hidden id="html_form"
                                value="<?= request()->get('form') ? request()->get('form') : $html->id ?>">
                        </div>
                        <div data-save-html class="h6">
                            <?= $html->html_builder ?>
                        </div>
                        <?php }else{ ?>
                        <button data-bs-toggle="modal" data-bs-target="#formName"
                            class="w-100 border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray bg-layout py-5 text-center create-form"
                            style="background-color: #f9f9f9">
                            CREATE FORM
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="card" id="set" style="display: none">
                    <div class="card-body">
                        <form action="" id="form-setting">
                            <input type="text" id="param-form" hidden
                                value="<?= request()->get('form') ? request()->get('form') : '' ?>">
                            <input type="text" id="is-edit" value="true" hidden>
                            <input type="text" id="is-delet-approver" hidden>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="parent-page">Set Entry Page <small class="text-danger">*</small>
                                        <br>
                                        <small class="text-info">form will be displayed on the selected page</small>
                                    </label>
                                    <select name="parent-page" id="parent-page" class="form-control">
                                        <option value="">--Choose Page--</option>
                                        @foreach ($page as $p)
                                            <option data-param="{{ $p->parent }}" value="{{ $p->id }}"
                                                data-divisi="{{ $p->id_divisi }}"
                                                {{ $selected_page ? ($p->id == $selected_page->id ? 'selected' : '') : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="invalid-parent-page" class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="report-page">Set Report Page <small class="text-danger">*</small>
                                        <br>
                                        <small class="text-info">form will be displayed on the selected page</small>
                                    </label>
                                    <select name="report-page" id="report-page" class="form-control">
                                        <option value="">--Select Page Report--</option>
                                        @if ($report)
                                            @foreach ($report as $r)
                                                <option value="{{ $r->id }}" selected>{{ $r->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div id="invalid-report-page" class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            {{-- setting halaman approver --}}
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="approval-page">Set Approval Page <small class="text-danger">*</small>
                                        <br>
                                        <small class="text-info">form will be displayed on the selected page</small>
                                    </label>
                                    <select name="approval-page" id="approval-page" class="form-control">
                                        <option value="">--Select Page Report--</option>
                                    </select>
                                    <div id="invalid-approval-page" class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            {{-- <h5 class="mt-4">Set Approval Page <small class="text-danger">*</small></h5>
                            <div class="d-flex justify-content-between">
                                <small class="text-info">select page approver</small>
                                <a href="javascript:void(0)" class="badge bg-primary more-approver">Add approval</a>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Approver Name</th>
                                        <th>Set Page Approver</th>
                                        <th style="width: 12px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="approver-append">
                                    @if ($selected_approver)
                                        @foreach ($selected_approver as $sp)
                                            <tr>
                                                <td>
                                                    <input name="approver-name[]" data-id="{{ $sp->id }}"
                                                        type="text" class="form-control" value="{{ $sp->name }}">
                                                    <div id="invalid-approver-name" class="invalid-feedback">
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="page-approver[]" id="page-approver" class="form-control">
                                                        <option value="">--Select Page Approver--</option>
                                                        @foreach ($approver as $a)
                                                            <option value="{{ $a->id }}"
                                                                {{ $sp->id_menu == $a->id ? 'selected' : '' }}>
                                                                {{ $a->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div id="invalid-page-approver" class="invalid-feedback">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" data-id="{{ $sp->id }}"
                                                        class="btn btn-danger dell-approver">-</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table> --}}
                            <a href="javascript:void(0)"
                                class="mt-4 save-form btn btn-success text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                Save Form
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
    <div id="formName" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formNameLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formNameLabel">Choose Layout</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="form-name">Form Name</label>
                        <input type="text" class="form-control" id="form-name" name="form_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-form-name">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Choose Layout</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label role="button" for="type_layout_1" data-select-radio
                                class="d-block py-3 text-center bg-gray">
                                Column I
                                <input type="radio" id="type_layout_1" hidden name="type_layout" value="column 1">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label role="button" for="type_layout_2" data-select-radio
                                class="d-block py-3 text-center bg-gray">
                                Column II
                                <input type="radio" id="type_layout_2" hidden name="type_layout" value="column 2">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label role="button" for="type_layout_3" data-select-radio
                                class="d-block py-3 text-center bg-gray">
                                Column III
                                <input type="radio" id="type_layout_3" hidden name="type_layout" value="column 3">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-layout">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="fields" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fieldsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fieldsLabel">Choose Field</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" hidden name="on_layout">
                        <input type="text" hidden name="on_section">
                        <input type="text" hidden name="id_layout">

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-title" data-select-radio
                                class="d-block py-3 text-center bg-gray">
                                Title
                                <input type="radio" id="pic-title" hidden name="type_field" value="title">
                            </label>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-text-field" data-select-radio
                                class="d-block py-3 text-center bg-gray">Text
                                Field
                                <input type="radio" id="pic-text-field" hidden name="type_field" value="text">
                            </label>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-number-field" data-select-radio
                                class="d-block py-3 text-center bg-gray">Number
                                Field
                                <input type="radio" id="pic-number-field" hidden name="type_field" value="number">
                            </label>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-date" data-select-radio
                                class="d-block py-3 text-center bg-gray">Date
                                <input type="radio" id="pic-date" hidden name="type_field" value="date">
                            </label>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-file" data-select-radio
                                class="d-block py-3 text-center bg-gray">File
                                Upload
                                <input type="radio" id="pic-file" hidden name="type_field" value="file upload">
                            </label>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-textarea" data-select-radio
                                class="d-block py-3 text-center bg-gray">Textarea
                                <input type="radio" id="pic-textarea" hidden name="type_field" value="textarea">
                            </label>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-select-option" data-select-radio
                                class="d-block py-3 text-center bg-gray">Select
                                Option
                                <input type="radio" id="pic-select-option" hidden name="type_field"
                                    value="select-option">
                            </label>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-radio-button" data-select-radio
                                class="d-block py-3 text-center bg-gray">Radio
                                Button
                                <input type="radio" id="pic-radio-button" hidden name="type_field"
                                    value="radio-button">
                            </label>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-check-box" data-select-radio
                                class="d-block py-3 text-center bg-gray">Check
                                Box
                                <input type="radio" id="pic-check-box" hidden name="type_field" value="check-box">
                            </label>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label role="button" for="pic-item" data-select-radio
                                class="d-block py-3 text-center bg-gray">Item
                                <input type="radio" id="pic-item" hidden name="type_field" value="item">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-field">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="opsi-select-option" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="opsi-select-optionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="opsi-select-optionLabel">Opsi Select Option</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div id="option-show"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-option">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="radio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="radioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="radioLabel">Add radio button</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div id="radio-show"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-radio">Apply</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="groupItems" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="groupItemsLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="groupItemsLabel">Choose Group Items</h4>
                    <button type="button" class="btn-close close_item" data-bs-dismiss="modal"
                        aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="form-name">Select Group Item</label>
                        <select name="group_item" id="group_item" class="form-control">
                            <option value="">--Select Group Items--</option>
                            @foreach ($group_item as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div id="invalid-group-item" class="invalid-feedback">
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
        getReportApprovalPage()

        $('#group_item').select2({
            width: '100%',
            dropdownParent: $("#groupItems"),
        })

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

        $('.prev').on('click', function() {
            $(this).removeClass('bg-light').addClass('bg-white')
            $('.set').removeClass('bg-white').addClass('bg-light')

            $('#prev').show()
            $('#set').hide()
        })

        $('.set').on('click', function() {

            if ($('#html_form').val() == undefined) {
                alert('Please create a form first before opening this page')
                return false
            }

            $(this).removeClass('bg-light').addClass('bg-white')
            $('.prev').removeClass('bg-white').addClass('bg-light')

            $('#prev').hide()
            $('#set').show()
        })

        $(document).on('click', '.next-form', function() {
            $('.set').trigger('click')
        })

        $(document).on('click', '.del-form', function() {
            $.ajax({
                url: "{{ route('formBuilder.delform') }}?param= " + $('#html_form').val(),
                type: "get",
                async: false
            })
            window.location.href = "{{ route('formBuilder') }}";
        })

        $(document).on('click', 'a[x-field]', function() {
            let idlayout = $(this).attr('id-layout')
            let layout = $(this).attr('data-layout')
            let section = $(this).attr('data-section')
            $('input[name="id_layout"]').val(idlayout)
            $('input[name="on_layout"]').val(layout)
            $('input[name="on_section"]').val(section)
        })

        $(document).on('click', 'label[data-select-radio]', function() {
            $('label[data-select-radio]').removeClass('checked').addClass('bg-gray')
            $(this).removeClass('bg-gray').addClass('checked')
        })

        // membuat formbuilder baru dengan name sapace
        $('.submit-form-name').on('click', function() {
            $(".preloader").fadeIn()
            $.ajax({
                url: "{{ route('formBuilder.createform') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    form_name: $('#form-name').val(),
                    html: $('div[data-dom]').html()
                },
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    $('#formName').modal('hide')
                    $(`div[data-dom]`).html(response.success.data)
                    $('#param-form').val(response.success.param)
                    formBuild()
                }
            })
        })

        // menambahkan layout baru
        $('.submit-layout').on('click', function() {
            let jenisLayout = $('input[name="type_layout"]:checked').val()
            let tot = $('div[data-count-layout]').length
            if (jenisLayout == 'column 2') {
                tot = $('div[data-count-layout]').length
            }

            if (jenisLayout == 'column 3') {
                tot = $('div[data-count-layout]').length
            }

            $(".preloader").fadeIn()
            $.ajax({
                url: "{{ route('formBuilder.getlayout') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    jenis: $('input[name="type_layout"]:checked').val(),
                    length: tot,
                    param_html: $('#html_form').val()
                },
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    $('#myModal').modal('hide')
                    $(`div[data-inner-layout]`).append(response)
                    formBuild()
                }
            })
        })

        // menghapus layout berdasarkan button (x)
        $(document).on('click', '.del-layout', function() {
            let nourutTextarea = ''

            const dataField = {
                url: "{{ route('formBuilder.dellayout') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).attr('id-layout'),
                }
            }

            let resp = requestAjax(dataField)

            if (resp == 'error') {
                alert('ups error')
                return false
            }

            $(this).parent().parent().remove()

            if ($('a[data-no-urut]').attr('data-iner-textarea')) {
                reOrderTextarea()
            }

            $('div[data-count-layout]').each(function(i) {
                i++
                $(this).children().next().children().attr('id', i)
                $(this).children().next().children().children().children().next().children()
                    .attr('data-layout', i)
            })

            reOrderLabel()
            reOrderText()
            reOrderDate()
            reOrderFileUpload()
            reOrderTextarea()
            reOrderSelect()
            reOrderCheckbox()
            reOrderRadio()

            formBuild()
        })

        // melakukan aksi simpan field bedasarkan lokasi dan section pada layout
        $('.submit-field').on('click', function() {
            let totalField = typefield($('input[name="type_field"]:checked').val())
            $(".preloader").fadeIn()
            if ($('input[name="type_field"]:checked').val() == 'item') {
                $('#groupItems').modal('show')
                $('#fields').modal('hide')
                $(".preloader").fadeOut()

                return false
            } else {
                submitfield(totalField)
            }
        })

        $(document).on('click', '.close_item', function() {
            $('#fields').modal('show')
            $('#groupItems').modal('hide')
        })

        $('.submit-item').on('click', function() {
            if ($('#group_item').find(":selected").val() == '') {
                $('#group_item + span').addClass('is-invalid')
                $('#invalid-group-item').html('Group items cannot be empty')
            } else {
                let totalField = typefield($('input[name="type_field"]:checked').val())
                submitfield(totalField)
                $('#fields').modal('hide')
            }
        })

        // menghapus field berdasarkan button delete
        $(document).on('click', '.del-fileld', function() {
            let type = $(this).attr('data-type')
            let target = $(this).attr('data-target-delete')

            const data = {
                url: "{{ route('formBuilder.delfield') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).attr('id-field'),
                }
            }

            let resp = requestAjax(data)

            if (resp == 'error') {
                alert('ups error')
                return false
            }

            $(`${target}`).remove()

            switch (type) {
                case 'title':
                    reOrderLabel()
                    break;
                case 'text':
                    reOrderText()
                    break;
                case 'date':
                    reOrderDate()
                    break;
                case 'file':
                    reOrderFileUpload()
                    break;
                case 'textarea':
                    reOrderTextarea()
                    break;
                case 'select':
                    $(".preloader").fadeIn()
                    $.ajax({
                        url: "{{ route('formBuilder.delOption') }}",
                        type: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            param: $(this).attr('data-option-group')
                        },
                        dataType: 'json',
                        success: function(response) {
                            $(".preloader").fadeOut()
                        }
                    })

                    reOrderSelect()
                    break;
                case 'checkbox':
                    reOrderCheckbox()
                    break;
                case 'radio':
                    reOrderRadio()
                    break;
                case 'item':
                    if ($('.item').length > 0) {
                        let id_item = []
                        $('input[name-item]').each(function name(i) {
                            id_item.push($(this).attr('id-field'))
                            $(this).attr('data-name', 'item-' + i)
                        })

                        $.ajax({
                            url: "{{ route('formBuilder.renamefielditems') }}",
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id_item
                            },
                            dataType: 'json',
                            success: function(response) {
                                $(".preloader").fadeOut()
                            }
                        })
                    }
                    break;
            }

            formBuild()
        })

        // melakukan setting pada select option
        $(document).on('click', 'a[x-setting]', function() {
            $.ajax({
                url: "{{ route('formBuilder.getoption') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    target: $(this).attr('data-target-input'),
                    param: $(this).attr('data-option-group')
                },
                dataType: 'json',
                success: function(response) {
                    $('#option-show').html(response)
                }
            })
        })

        //menambahkan option pada select option 
        $(document).on('click', '.more-opsi', function() {
            let targetOption = $(this).attr('data-target-input')
            console.log(targetOption);
            let option = `<option></option>`
            $.ajax({
                url: "{{ route('formBuilder.moreoption') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    param: $(this).attr('data-option-group')
                },
                dataType: 'json',
                success: function(response) {
                    $('#tb-opsi tr:last').after('<tr>' +
                        '<td>' +
                        '<input type="text" id="option-value" data-val-opt="' + response +
                        '" class="form-control">' +
                        '</td>' +
                        '<td>' +
                        '<a href="javascript:void(0)" class="btn btn-danger del-opsi" data-val-opt="' +
                        response + '">-</a>' +
                        '</td>' +
                        '</tr>')
                    $(`${targetOption}`).append(option)

                    formBuild()
                }
            })
        })

        // menyimpan dan update value pada select option
        $('.submit-option').on('click', function(e) {
            $(".preloader").fadeIn()
            e.preventDefault()
            let valOption = []
            let valOptionId = []

            $('input[data-val-opt]').each(function(i, obj) {
                valOption.push($(this).val());
                valOptionId.push($(this).attr('data-val-opt'));
            })

            let targetOption = $('#option-value').attr('data-target-input');

            $.ajax({
                url: "{{ route('formBuilder.submitOption') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    val: valOption,
                    id: valOptionId,
                    target: targetOption
                },
                dataType: 'json',
                success: function(response) {
                    $(`${targetOption}`).html(response.success.html)
                    $(".preloader").fadeOut()
                    $('#opsi-select-option').modal('hide')
                    formBuild()
                }
            })
        })

        // membuat radio button
        $(document).on('click', 'a[x-radio]', function() {
            $.ajax({
                url: "{{ route('formBuilder.getRadio') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    param: $(this).attr('data-radio-group')
                },
                dataType: "json",
                success: function(response) {
                    $('#radio-show').html(response)
                }
            })
        })

        // menyimpan form render
        $(document).on('click', '.save-form', function() {
            if ($('div[data-form-final]').html() == undefined) {
                alert('Layout and empty form, please create a layout and form first')
                $('.prev').trigger('click')
                return false
            }
            // console.log($('input[name="approver-name[]"]').length)

            // if ($('input[name="approver-name[]"]').length == 0) {
            //     Swal.fire(
            //         'Ups?',
            //         'Please add approver',
            //         'warning'
            //     )

            //     return false
            // }
            // $('select[name="page-approver[]"]').each(function(i, obj) {
            //     if ($(this).val() == '') {
            //         $(this).addClass('is-invalid')
            //         $(this).next().html('approvers cannot be the same')
            //     }

            //     if ($(this).val() != '') {
            //         $(this).removeClass('is-invalid')
            //         $(this).next().html('')
            //     }
            // });

            // formBuild()

            $(".preloader").fadeIn()
            $('div[data-action]').remove()
            $('.ck-editor').remove()
            $('input[data-checkbox]').remove()

            // $('div[data-css]').each(function(i) {
            //     $(this).removeClass(
            //         'border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray'
            //     )
            // });

            $('div[data-field-label]').each(function(i) {
                $(this).removeClass('mb-3')
            });

            $('textarea[data-filed]').each(function(i) {
                $(this).removeAttr('style').removeAttr('aria-hidden')
            });

            $('div[class="tox tox-tinymce"]').each(function(i) {
                $(this).remove()
            });

            let form = []
            $('div[data-form-final]').each(function(i, obj) {
                form.push($(this).html());
            });

            // let id_approver = []
            // let approver_name = []
            // $('input[name="approver-name[]"]').each(function(i, obj) {
            //     approver_name.push($(this).val());
            //     id_approver.push($(this).attr('data-id'));
            // });

            // let page_approver = []
            // $('select[name="page-approver[]"]').each(function(i, obj) {
            //     page_approver.push($(this).val());
            // });

            $.ajax({
                url: "{{ route('formBuilder.updateformhtml') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    form_name: $('input[name="form_name"]').val(),
                    html_preview: form,
                    param_html: $('#html_form').val(),
                    set_page: $('select[name=parent-page] option').filter(':selected').val(),
                    report_page: $('select[name=report-page] option').filter(':selected').val(),
                    approver_page: $('select[name=approval-page] option').filter(':selected').val(),
                    is_edit: $('#is-edit').val(),
                    // id_approver: id_approver,
                    // delete_approver: $('#is-delet-approver').val(),
                    // approver_name: approver_name,
                    // page_approver: page_approver,
                    // id_validator: $('input[name="validator-name[]"]').attr('data-id'),
                    // validator_name: $('input[name="validator-name[]"]').val(),
                    // page_validator: $('input[name="page-validator[]"]').attr('data-id-validator')
                },
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    if (response.error) {
                        if (response.error.page) {
                            $('#parent-page').addClass('is-invalid')
                            $('#invalid-parent-page').html(response.error.page)
                        } else {
                            $('#parent-page').removeClass('is-invalid')
                            $('#invalid-parent-page').html('')
                        }

                        if (response.error.report) {
                            $('#report-page').addClass('is-invalid')
                            $('#invalid-report-page').html(response.error.report)
                        } else {
                            $('#report-page').removeClass('is-invalid')
                            $('#invalid-report-page').html('')
                        }

                        if (response.error.name_approver) {
                            let val_approver_name = ''
                            $('input[name="approver-name[]"]').each(function(i, obj) {
                                if ($(this).val() == '') {
                                    $(this).addClass('is-invalid')
                                    $(this).next().html('name approvers cannot be empty')
                                } else {
                                    $(this).removeClass('is-invalid')
                                    $(this).next().html('')
                                }

                                if ($(this).val() != '') {
                                    if (val_approver_name == $(this).val()) {
                                        $(this).addClass('is-invalid')
                                        $(this).next().html('name approvers cannot be the same')
                                    } else {
                                        $(this).removeClass('is-invalid')
                                        $(this).next().html('')
                                    }
                                }

                                if ($(this).val() != '') {
                                    val_approver_name = $(this).val()
                                }
                            });
                        }

                        if (response.error.page_approver) {
                            let val_page_appover = ''
                            $('select[name="page-approver[]"]').each(function(i, obj) {
                                if ($(this).val() == '') {
                                    $(this).addClass('is-invalid')
                                    $(this).next().html('page approvers cannot be empty')
                                } else {
                                    $(this).removeClass('is-invalid')
                                    $(this).next().html('')
                                }

                                if ($(this).val() != '') {
                                    if (val_page_appover == $(this).val()) {
                                        $(this).addClass('is-invalid')
                                        $(this).next().html('page approvers cannot be the same')
                                    } else {
                                        $(this).removeClass('is-invalid')
                                        $(this).next().html('')
                                    }
                                }

                                if ($(this).val() != '') {
                                    val_page_appover = $(this).val()
                                }
                            });
                        }

                        // if (response.error.name_validator) {
                        //     if (response.error.name_validator[0].value_empty) {
                        //         $('input[name="validator-name[]"]').addClass('is-invalid')
                        //         $('input[name="validator-name[]"]').next().html(
                        //             response.error.name_validator[0].value_empty)
                        //     } else {
                        //         $('input[name="validator-name[]"]').removeClass('is-invalid')
                        //         $('input[name="validator-name[]"]').next().html('')
                        //     }
                        // }

                        // if (response.error.page_validator) {
                        //     if (response.error.page_validator[0].value_empty) {
                        //         $('input[name="page-validator[]"]').addClass('is-invalid')
                        //         $('input[name="page-validator[]"]').next().html(
                        //             response.error.page_validator[0].value_empty)
                        //     } else {
                        //         $('input[name="page-validator[]"]').removeClass('is-invalid')
                        //         $('input[name="page-validator[]"]').next().html('')
                        //     }
                        // }
                    } else {
                        window.location.href = "{{ route('formBuilder') }}";
                    }
                }
            })
        })

        // edit field formbuilder
        $(document).on('click', 'a[x-edit]', function() {
            let nameField = $(this).attr('data-name')
            let type = $(this).attr('data-type')
            // console.log(nameField)
            switch (type) {
                case 'title':
                    $(`#${nameField}`).prop('hidden', false).addClass('border-bottom').focus()
                    $(`label[data-target="${nameField}"]`).prop('hidden', true)
                    break;
                case 'checkbox':
                    $(`#${nameField}`).prop('hidden', false).addClass('border-bottom').focus()
                    $(`span[data-target="${nameField}"]`).prop('hidden', true)
                    break;
                case 'radio':
                    $(`#${nameField}`).prop('hidden', false).addClass('border-bottom').focus()
                    $(`h5[data-label-radio="${nameField}"]`).prop('hidden', true)
                    break;
                default:
                    $(`#${nameField}`).prop('readonly', false).addClass('border-bottom').focus()
                    break;
            }
        })

        // mengubah css pada label  
        $(document).on('blur', 'input[data-label-input]', function() {
            let type = $(this).attr('data-type')
            let nameField = $(this).attr('data-name')
            // console.log(nameField)

            switch (type) {
                case 'title':
                    $(`#${nameField}`).prop('hidden', true).removeClass('border-bottom')
                    $(`label[data-target="${nameField}"]`).prop('hidden', false)
                    break;
                case 'checkbox':
                    $(`#${nameField}`).prop('hidden', true).removeClass('border-bottom')
                    $(`span[data-target="${nameField}"]`).prop('hidden', false)
                    break;
                case 'radio':
                    $(`#${nameField}`).prop('hidden', true).removeClass('border-bottom')
                    $(`h5[data-label-radio="${nameField}"]`).prop('hidden', false)
                    break;
                default:
                    $(this).prop('readonly', true).removeClass('border-bottom')
                    break;
            }

            // if ($(this).attr('data-title') == 'true') {} else {}
        })

        // mengubah name pada field formbuilder
        $(document).on('change', 'input[data-label-input]', function() {
            let type = $(this).attr('data-type')
            let val = $(this).val()
            let nameField = $(this).attr('data-name')

            if (!val) {
                alert('Field name cannot be empty')
                return false
            }

            // if (type != 'item') {} else {}
            let data_name = $(this).attr('data-name')
            // const data = {
            //     url: "{{ route('formBuilder.renamefield') }}",
            //     data: {
            //         _token: "{{ csrf_token() }}",
            //         id: $(this).attr('id-field'),
            //         name: data_name.replace(/\s+/g, '-').toLowerCase(),
            //         original_name: val
            //     }
            // }

            const data = {
                url: "{{ route('formBuilder.renamefield') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).attr('id-field'),
                    name: type == 'item' ? data_name.replace(/\s+/g, '-').toLowerCase() : val.replace(/\s+/g,
                        '-').toLowerCase(),
                    original_name: val
                }
            }

            let resp = requestAjax(data)

            if (resp == 'error') {
                alert('ups error')
                return false
            }

            switch (type) {
                case 'title':
                    if (val != $(`label[data-target="${nameField}"]`).text()) {
                        $(this).attr('has-change', 'true').prop('hidden', true).removeClass(
                            'border-bottom').attr('value', val)
                        $(`label[data-target="${nameField}"]`).attr('has-change', 'true').prop('hidden', false)
                            .html(val)
                        formBuild()
                    }
                    break;
                case 'checkbox':
                    if (val != $(`span[data-target="${nameField}"]`).text()) {
                        $(this).attr('has-change', 'true').prop('hidden', true).removeClass(
                            'border-bottom')
                        $(`span[data-target="${nameField}"]`).attr('has-change', 'true').prop('hidden', false).text(
                            val)
                        $(`input[data-id="${nameField}"]`).attr('has-change', 'true').attr('value', val).attr(
                            'name', val.replace(/\s+/g, '-')
                            .toLowerCase())
                        formBuild()
                    }
                    break;
                case 'radio':
                    if (val != $(`h5[data-label-radio="${nameField}"]`).text()) {
                        $(this).attr('has-change', 'true').prop('hidden', true).removeClass(
                            'border-bottom')
                        $(`h5[data-label-radio="${nameField}"]`).attr('has-change', 'true').prop('hidden', false)
                            .text(val)
                        // $(`input[data-name-radio="label-radio-field-${nameField}"]`).attr('data-name-radio',)
                        $(`input[data-name-radio="${nameField}"]`).each(function(i) {
                            $(this).attr('has-change', 'true').attr('name', val.replace(/\s+/g, '-')
                                .toLowerCase())
                        })
                        formBuild()
                    }
                    break;
                case 'item':
                    if (val != $(this).attr('value')) {
                        $(this).attr('has-change', 'true').attr('value', val).prop('readonly', true).removeClass(
                            'border-bottom')
                        formBuild()
                    }
                    break;
                default:
                    let targetchange = $(this).attr('data-target-input')

                    if (val != $(this).attr('value')) {
                        $(this).attr('has-change', 'true').attr('value', val).prop('readonly', true).removeClass(
                            'border-bottom')
                        $(`${targetchange}`).attr('has-change', 'true').attr('name', val.replace(/\s+/g, '-')
                            .toLowerCase())
                        formBuild()
                    }
                    break;
            }
        })


        $('#report-page').html('<option value="">--Select Page Report--</option>').prop('disabled', true)
        $('#approval-page').html('<option value="">--Select Approval Page--</option>').prop('disabled', true)

        $('#parent-page').on('change', function() {
            if ($('select[name=parent-page] option').filter(':selected').val() != '') {
                var url_string = window.location.href;
                var url = new URL(url_string);
                var c = url.searchParams.get("form");
                var datas;

                if (c != null) {
                    datas = {
                        _token: "{{ csrf_token() }}",
                        parent: $('select[name=parent-page] option').filter(':selected').attr('data-param'),
                        is_edit: c
                    }
                } else {
                    datas = {
                        _token: "{{ csrf_token() }}",
                        parent: $('select[name=parent-page] option').filter(':selected').attr('data-param'),
                    }
                }

                $.ajax({
                    url: "{{ route('formBuilder.getpageapprover') }}",
                    type: "post",
                    data: datas,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // $('select[name="page-approver[]"]').each(function(i) {
                            //     $(this).html(
                            //         '<option value="">--Select Page Approver--</option>')
                            //     for (let index = 0; index < response.success.data
                            //         .length; index++) {
                            //         $(this).append('<option value="' + response.success.data[
                            //                 index].id +
                            //             '">' + response.success.data[index].name +
                            //             '</option>')
                            //     }
                            // })

                            if (response.success.data) {
                                $('#approval-page').html(
                                    '<option value="">--Select Approval Page--</option>').prop(
                                    'disabled', false)

                                for (let i = 0; i < response.success.data.length; i++) {
                                    $('#approval-page').append(
                                        '<option value="' + response.success.data[i].id +
                                        '">' + response.success.data[i].name +
                                        '</option>')
                                }
                            }

                            if (response.success.report) {
                                $('#report-page').html(
                                    '<option value="">--Select Page Report--</option>').prop(
                                    'disabled', false)

                                for (let i = 0; i < response.success.report.length; i++) {
                                    $('#report-page').append(
                                        '<option value="' + response.success.report[i].id +
                                        '">' + response.success.report[i].name +
                                        '</option>')
                                }
                            }

                            if (response.success.validator) {
                                $('#page-validator').val(response.success.validator.name).attr(
                                    'data-id-validator', response.success.validator.id)
                            }
                        } else {

                        }
                    }
                })
            } else {
                $('#report-page').html('<option value="">--Select Page Report--</option>').prop('disabled', true)
                $('#approval-page').html('<option value="">--Select Approval Page--</option>').prop('disabled',
                    true)
            }
        })

        $('.more-approver').on('click', function() {

            if ($('select[name=parent-page] option').filter(':selected').val() == '') {
                Swal.fire(
                    'Ups?',
                    'Please select an entry page first',
                    'warning'
                )

                return false
            }

            $.ajax({
                url: "{{ route('formBuilder.moreapprover') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    parent: $('select[name=parent-page] option').filter(':selected').attr('data-param'),
                    divisi: $('select[name=parent-page] option').filter(':selected').attr('data-divisi'),
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire(
                            'Ups?',
                            response.error,
                            'warning'
                        )
                    } else {
                        $('#approver-append').append(response.data)
                    }
                }
            })
        })

        $(document).on('click', '.dell-approver', function() {
            let data_id = $(this).attr('data-id')
            let val_now = $('#is-delet-approver').val()
            $('#is-delet-approver').attr('value', val_now == '' ? data_id : val_now + ',' + data_id)
            $(this).closest("tr").remove();
        })

        function submitfield(totalField) {
            $.ajax({
                url: "{{ route('formBuilder.getfield') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    layout: $('input[name="on_layout"]').val(),
                    section: $('input[name="on_section"]').val(),
                    type: $('input[name="type_field"]:checked').val(),
                    id_layout: $('input[name="id_layout"]').val(),
                    id_html: $('input[id="html_form"]').val(),
                    length: totalField,
                    groupItems: $('#group_item').find(":selected").val()
                },
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    $('#fields').modal('hide')

                    $(`#${response.layout} > #${response.section} > div[data-iner]`).append(response
                        .html)

                    if (response.script != 'null') {
                        $('#script').append(response.script)
                    }

                    if ($('input[name="type_field"]:checked').val() == 'textarea') {
                        let textareaCount = $(`a[data-no-urut="${response.layout}"]`).attr(
                            'data-iner-textarea')
                        $(`a[data-no-urut="${response.layout}"]`).attr('data-iner-textarea',
                            textareaCount > 0 ? (textareaCount + ',' + response.countTextArea) :
                            response.countTextArea)
                    }
                    formBuild()
                }
            })
        }

        function typefield(field) {
            let countField

            switch (field) {
                case 'title':
                    countField = $('.input-title').length
                    break;
                case 'text':
                    countField = $('.input-text').length
                    break;
                case 'number':
                    countField = $('.input-number').length
                    break;
                case 'date':
                    countField = $('.input-date').length
                    break;
                case 'file upload':
                    countField = $('.input-file').length
                    break;
                case 'textarea':
                    countField = $('.input-textarea').length
                    break;
                case 'select-option':
                    countField = $('.select-option').length
                    break;
                case 'radio-button':
                    countField = $('.radio-button').length
                    break;
                case 'check-box':
                    countField = $('.checkbox').length
                    break;
                case 'item':
                    countField = $('.item').length
                    break;
            }

            return countField;
        }

        function formBuild() {
            $('textarea[data-textarea]').removeAttr('aria-hidden').removeAttr('style')
            $('div[role="application"]').remove()

            $.ajax({
                url: "{{ route('formBuilder.updateformhtml') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    html: $('div[data-save-html]').html(),
                    param_html: $('#html_form').val()
                },
                dataType: "json",
                success: function(response) {
                    if ($('.input-textarea').length > 0) {
                        location.reload();
                    }
                }
            })
        }

        function getReportApprovalPage() {
            $.ajax({
                url: "{{ route('formBuilder.getReportApproval') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    parent: $('select[name=parent-page] option').filter(':selected').attr('data-param'),
                    param_html: $('#html_form').val()
                },
                dataType: "json",
                success: function(response) {
                    $('#report-page').html(
                        `<option value="">--Select Page Report--</option>
                        <option value="${response.data.report.id}" selected>${response.data.report.name}</option>`
                    ).prop('disabled', false)

                    $('#approval-page').html(
                        `<option value="">--Select Approval Page--</option>
                        <option value="${response.data.approver.id}" selected>${response.data.approver.name}</option>`
                    ).prop('disabled', false)
                }
            })
        }

        function requestAjax(params) {
            let calback
            $.ajax({
                url: params.url,
                type: "post",
                data: params.data,
                async: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        calback = 'success'
                    } else {
                        calback = 'error'
                    }
                }
            })

            return calback;
        }

        function reOrderLabel() {
            $('div[data-field-label]').each(function(a) {
                a++
                $(this).attr('id', `title-${a}`)
            })

            $('a[data-edit-title]').each(function(c) {
                c++
                $(this).attr('data-name', `label-title-field-${c}`)
            })

            $('a[data-delete-title]').each(function(d) {
                d++
                $(this).attr('data-target-delete', `title-${d}`)
            })

            // merubah value label dan name input
            $('input[data-label-title]').each(function(b) {
                b++
                let haschange = $(this).attr('has-change')
                if (haschange == 'false') {
                    $(this).attr('data-name', 'label-title-field-' + b).attr('value', `Your title here ${b}`).attr(
                        'id', `label-title-field-${b}`)
                } else {
                    $(this).attr('data-name', 'label-title-field-' + b).attr(
                        'id', `label-title-field-${b}`)
                }
            })

            $('label[data-field-label]').each(function(l) {
                l++
                let haschange = $(this).attr('has-change')
                if (haschange == 'false') {
                    $(this).attr('data-target', `label-title-field-${l}`).text(`Your title here ${l}`)
                } else {
                    $(this).attr('data-target', `label-title-field-${l}`)
                }
            })
        }

        function reOrderCheckbox() {
            $('div[data-field-checkbox]').each(function(a) {
                a++
                $(this).attr('id', `checkbox-${a}`)
            })

            $('a[data-edit-checkbox]').each(function(b) {
                b++
                $(this).attr('data-name', 'label-checkbox-field-' + b)
            })

            $('a[data-delete-checkbox]').each(function(l) {
                l++
                $(this).attr('data-target-delete', `#checkbox-${l}`)
            })

            // merubah value label dan name input
            $('input[data-checkbox-indicator]').each(function(n) {
                n++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', 'i am unchecked Checkbox ' + n).attr('name', 'checkbox-' + n)
                        .attr('data-id', 'label-checkbox-field-' + n)
                } else {
                    $(this).attr('data-id', 'label-checkbox-field-' + n)
                }
            })

            $('span[data-label-checkbox]').each(function(o) {
                o++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('data-target', 'label-checkbox-field-' + o).text(`i am unchecked Checkbox ${o}`)
                } else {
                    $(this).attr('data-target', 'label-checkbox-field-' + o)
                }
            })

            $('input[data-checkbox]').each(function(m) {
                m++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('id', 'label-checkbox-field-' + m).attr('data-name', 'label-checkbox-field-' + m)
                        .attr('value', `i am unchecked Checkbox ${m}`)
                } else {
                    $(this).attr('id', 'label-checkbox-field-' + m).attr('data-name', 'label-checkbox-field-' + m)
                }
            })
        }

        function reOrderText() {
            $('div[data-field-text]').each(function(a) {
                a++
                $(this).attr('id', `text-${a}`)
            })

            $('a[data-edit-text]').each(function(b) {
                b++
                $(this).attr('data-name', 'label-text-field-' + b)
            })

            $('a[data-delete-text]').each(function(l) {
                l++
                $(this).attr('data-target-delete', `#text-${l}`)
            })

            // merubah value label dan name input
            $('input[data-label-text]').each(function(n) {
                n++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', 'text Field ' + n).attr('data-target-input', '#text-field-' + n)
                        .attr('id', 'label-text-field-' + n)
                } else {
                    $(this).attr('data-target-input', '#text-field-' + n)
                        .attr('id', 'label-text-field-' + n)
                }
            })

            $('input[data-text]').each(function(m) {
                m++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('name', 'text-field-' + m).attr('id', 'text-field-' + m)
                } else {
                    $(this).attr('id', 'text-field-' + m)
                }
            })
        }

        function reOrderDate() {
            $('div[data-field-date]').each(function(a) {
                a++
                $(this).attr('id', `date-${a}`)
            })

            $('a[data-edit-date]').each(function(b) {
                b++
                $(this).attr('data-name', 'label-date-field-' + b)
            })

            $('a[data-delete-date]').each(function(l) {
                l++
                $(this).attr('data-target-delete', `#date-${l}`)
            })

            // merubah value label dan name input
            $('input[data-label-date]').each(function(n) {
                n++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', 'Date Field ' + n).attr('data-target-input', '#date-field-' + n)
                        .attr('id', 'label-date-field-' + n)
                } else {
                    $(this).attr('data-target-input', '#date-field-' + n)
                        .attr('id', 'label-date-field-' + n)
                }
            })

            $('input[data-date]').each(function(m) {
                m++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('name', 'date-field-' + m).attr('id', 'date-field-' + m)
                } else {
                    $(this).attr('id', 'date-field-' + m)
                }
            })
        }

        function reOrderFileUpload() {
            $('div[data-field-file]').each(function(a) {
                a++
                $(this).attr('id', `file-${a}`)
            })

            $('a[data-edit-file]').each(function(b) {
                b++
                $(this).attr('data-name', 'label-file-field-' + b)
            })

            $('a[data-delete-file]').each(function(l) {
                l++
                $(this).attr('data-target-delete', `#file-${l}`)
            })

            // merubah value label dan name input
            $('input[data-label-file]').each(function(n) {
                n++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', 'File Field ' + n).attr('data-target-input', '#file-field-' + n)
                        .attr('id', 'label-file-field-' + n)
                } else {
                    $(this).attr('data-target-input', '#file-field-' + n)
                        .attr('id', 'label-date-field-' + n)
                }
            })

            $('input[data-file]').each(function(m) {
                m++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('name', 'file-field-' + m).attr('id', 'file-field-' + m)
                } else {
                    $(this).attr('id', 'file-field-' + m)
                }
            })
        }

        function reOrderTextarea() {
            $('div[data-field-textarea]').each(function(a) {
                a++
                $(this).attr('id', `textarea-${a}`)
            })

            $('a[data-edit-textarea]').each(function(k) {
                k++
                $(this).attr('data-name', 'label-textarea-field-' + k)
            })

            $('a[data-delete-textarea]').each(function(l) {
                l++
                $(this).attr('data-no', l).attr('data-target-delete', `#textarea-${l}`)
            })

            // merubah value label dan name input
            $('input[data-label-textarea]').each(function(n) {
                n++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', 'Textarea Field ' + n).attr('data-target-input', '#textarea-field-' + n)
                        .attr('id', 'label-textarea-field-' + n)
                } else {
                    $(this).attr('data-target-input', '#textarea-field-' + n)
                        .attr('id', 'label-textarea-field-' + n)
                }
            })

            $('textarea[data-textarea]').each(function(m) {
                m++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('name', 'textarea-field-' + m).attr('id', 'textarea-field-' + m)
                } else {
                    $(this).attr('id', 'textarea-field-' + m)
                }
            })
        }

        function reOrderSelect() {
            $('div[data-field-select]').each(function(a) {
                a++
                $(this).attr('id', `select-option-${a}`)
            })

            $('a[data-setting-select]').each(function(b) {
                b++
                $(this).attr('data-name', `label-select-field-${b}`).attr('data-target-input',
                    `#select-option-field-${b}`)
            })

            $('a[data-edit-select]').each(function(c) {
                c++
                $(this).attr('data-name', `label-select-field-${c}`)
            })

            $('a[data-delete-select]').each(function(d) {
                d++
                $(this).attr('data-target-delete', `#select-option-${d}`).attr('data-target-label',
                    `#label-select-field-${d}`)
            })

            // merubah value label dan name input
            $('input[data-label-select]').each(function(e) {
                e++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('value', `Select Field ${e}`).attr('data-target-input',
                            `#select-option-field-${e}`)
                        .attr('id', `label-select-field-${e}`)
                } else {
                    $(this).attr('data-target-input', `#select-option-field-${e}`)
                        .attr('id', `label-select-field-${e}`)
                }
            })

            $('select[select-option]').each(function(f) {
                f++
                let haschange = $(this).attr('has-change')

                if (haschange == 'false') {
                    $(this).attr('name', `select-option-field-${f}`).attr('id',
                        `select-option-field-${f}`)
                } else {
                    $(this).attr('id', `select-option-field-${f}`)

                }
            })
        }

        function reOrderRadio() {
            $('div[data-radio]').each(function(a) {
                a++
                $(this).attr('id', `radio-${a}`)
            })

            $('a[data-setting-radio]').each(function(b) {
                b++
                $(this).attr('data-name', `label-radio-field-${b}`).attr('data-target-input', `#radio-append-${b}`)
            })

            $('a[data-edit-radio]').each(function(c) {
                c++
                $(this).attr('data-name', `label-radio-field-${c}`)
            })

            $('a[data-delete-radio]').each(function(d) {
                d++
                $(this).attr('data-target-delete', `#radio-${d}`)
            })

            $('h5[data-is-label-radio]').each(function(e) {
                e++
                let haschange = $(this).attr('has-change')
                if (haschange == 'false') {
                    $(this).attr('data-label-radio', `label-radio-field-${e}`).text(`Default Radio Buttons ${e}`)
                } else {
                    $(this).attr('data-label-radio', `label-radio-field-${e}`)
                }
            })

            $('input[data-label-radio]').each(function(f) {
                f++
                let haschangeName = $(this).attr('has-change')
                if (haschangeName == 'false') {
                    $(this).attr('data-name', `label-radio-field-${f}`).attr('id', `label-radio-field-${f}`).attr(
                        'value', `Default Radio Buttons ${f}`)
                } else {
                    $(this).attr('data-name', `label-radio-field-${f}`).attr('id', `label-radio-field-${f}`)
                }

                let name = $(this).attr('value')

                $('input[data-name-radio]').each(function(ff) {
                    let haschange = $(this).attr('has-change')
                    if (haschange == 'false') {
                        $(this).attr('name', name.replace(/\s+/g, '-').toLowerCase())
                    }
                })
            })

            $('div[data-radio-append]').each(function(g) {
                g++
                $(this).attr('id', `radio-append-${g}`)
            })
        }
    </script>
@endsection
