@extends('index')
@section('title', 'Build Form | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <script src="https://cdn.tiny.cloud/1/bx37734n27j3z8dfd0nytnxe3jmv18nlkh47fvwbbchlow82/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection
@section('content')
    {{-- <style>
        .ck-editor__editable {
            min-height: 200px;
        }
    </style> --}}
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
                        {{-- <div class="row"> --}}
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="">Set Page <small class="text-danger">(mandatory)</small> <br><small
                                        class="text-info">form
                                        will be displayed on
                                        the selected
                                        page</small></label>
                                <select name="" id="" class="form-control">
                                    <option value="">--Choose Page--</option>
                                </select>
                            </div>
                        </div>
                        {{-- </div> --}}
                        <h5 class="m-0">Set Approver</h5>
                        <small class="text-info">select user as approver</small>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Approver Name</th>
                                    <th>Approver (user)</th>
                                    <th>Set Page Approver</th>
                                    <th>Step</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control"></td>
                                    <td>
                                        <select name="" id="" class="form-control">
                                            <option value="">--Select Approver--</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-control">
                                            <option value="">--Select Page Approver--</option>
                                        </select>
                                    </td>
                                    <td><input type="Number" min="1" class="form-control"></td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success">+</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0)"
                            class="mt-4 save-form btn btn-success text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                            Save Form
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
    <div id="formName" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formNameLabel" aria-hidden="true">
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
@endsection
@section('script')
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample lists table casechange formatpainter permanentpen powerpaste advtable advcode autocorrect typography inlinecss',
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

        window.onbeforeunload = function() {
            return alert("browser window closing...");
        };

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
                    length: totalField
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

            formBuild()

            $(".preloader").fadeIn()
            $('div[data-action]').remove()
            $('.ck-editor').remove()
            $('input[data-checkbox]').remove()

            $('div[data-css]').each(function(i) {
                $(this).removeClass(
                    'border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray'
                )
            });

            let form = []
            $('div[data-form-final]').each(function(i, obj) {
                form.push($(this).html());
            });

            $.ajax({
                url: "{{ route('formBuilder.updateformhtml') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    form_name: $('input[name="form_name"]').val(),
                    html_preview: form,
                    param_html: $('#html_form').val()
                },
                dataType: "json",
                success: function(response) {
                    $(".preloader").fadeOut()
                    window.location.href = "{{ route('formBuilder') }}";
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

            const data = {
                url: "{{ route('formBuilder.renamefield') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).attr('id-field'),
                    name: val.replace(/\s+/g, '-').toLowerCase()
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

        function typefield(field) {
            let countField

            switch (field) {
                case 'title':
                    countField = $('.input-title').length
                    break;
                case 'text':
                    countField = $('.input-text').length
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
