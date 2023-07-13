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

$('.prev').on('click', function () {
    $(this).removeClass('bg-light').addClass('bg-white')
    $('.set').removeClass('bg-white').addClass('bg-light')

    $('#prev').show()
    $('#set').hide()
})

$('.set').on('click', function () {

    if ($('#html_form').val() == undefined) {
        alert('Please create a form first before opening this page')
        return false
    }

    $(this).removeClass('bg-light').addClass('bg-white')
    $('.prev').removeClass('bg-white').addClass('bg-light')

    $('#prev').hide()
    $('#set').show()
})

$(document).on('click', '.next-form', function () {
    $('.set').trigger('click')
})

$(document).on('click', '.del-form', function () {
    $.ajax({
        url: "{{ route('formBuilder.delform') }}?param= " + $('#html_form').val(),
        type: "get",
        async: false
    })
    window.location.href = "{{ route('formBuilder') }}";
})

$(document).on('click', 'a[x-field]', function () {
    let idlayout = $(this).attr('id-layout')
    let layout = $(this).attr('data-layout')
    let section = $(this).attr('data-section')
    $('input[name="id_layout"]').val(idlayout)
    $('input[name="on_layout"]').val(layout)
    $('input[name="on_section"]').val(section)
})

$(document).on('click', 'label[data-select-radio]', function () {
    $('label[data-select-radio]').removeClass('checked').addClass('bg-gray')
    $(this).removeClass('bg-gray').addClass('checked')
})

// membuat formbuilder baru dengan name sapace
$('.submit-form-name').on('click', function () {
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
        success: function (response) {
            $(".preloader").fadeOut()
            $('#formName').modal('hide')
            $(`div[data-dom]`).html(response.success.data)
            $('#param-form').val(response.success.param)
            formBuild()
        }
    })
})

// menambahkan layout baru
$('.submit-layout').on('click', function () {
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
        success: function (response) {
            $(".preloader").fadeOut()
            $('#myModal').modal('hide')
            $(`div[data-inner-layout]`).append(response)
            formBuild()
        }
    })
})

// menghapus layout berdasarkan button (x)
$(document).on('click', '.del-layout', function () {
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

    $('div[data-count-layout]').each(function (i) {
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
$('.submit-field').on('click', function () {
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
        success: function (response) {
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

            if (response.type == 'item') {

            } else {
                formBuild()
            }

        }
    })
})

// menghapus field berdasarkan button delete
$(document).on('click', '.del-fileld', function () {
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
                success: function (response) {
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
$(document).on('click', 'a[x-setting]', function () {
    $.ajax({
        url: "{{ route('formBuilder.getoption') }}",
        type: 'post',
        data: {
            _token: "{{ csrf_token() }}",
            target: $(this).attr('data-target-input'),
            param: $(this).attr('data-option-group')
        },
        dataType: 'json',
        success: function (response) {
            $('#option-show').html(response)
        }
    })
})

//menambahkan option pada select option 
$(document).on('click', '.more-opsi', function () {
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
        success: function (response) {
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
$('.submit-option').on('click', function (e) {
    $(".preloader").fadeIn()
    e.preventDefault()
    let valOption = []
    let valOptionId = []

    $('input[data-val-opt]').each(function (i, obj) {
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
        success: function (response) {
            $(`${targetOption}`).html(response.success.html)
            $(".preloader").fadeOut()
            $('#opsi-select-option').modal('hide')
            formBuild()
        }
    })
})

// membuat radio button
$(document).on('click', 'a[x-radio]', function () {
    $.ajax({
        url: "{{ route('formBuilder.getRadio') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            param: $(this).attr('data-radio-group')
        },
        dataType: "json",
        success: function (response) {
            $('#radio-show').html(response)
        }
    })
})

// menyimpan form render
$(document).on('click', '.save-form', function () {
    if ($('div[data-form-final]').html() == undefined) {
        alert('Layout and empty form, please create a layout and form first')
        $('.prev').trigger('click')
        return false
    }
    console.log($('input[name="approver-name[]"]').length)

    if ($('input[name="approver-name[]"]').length == 0) {
        Swal.fire(
            'Ups?',
            'Please add approver',
            'warning'
        )

        return false
    }
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

    formBuild()

    $(".preloader").fadeIn()
    $('div[data-action]').remove()
    $('.ck-editor').remove()
    $('input[data-checkbox]').remove()

    // $('div[data-css]').each(function(i) {
    //     $(this).removeClass(
    //         'border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray'
    //     )
    // });

    $('div[data-field-label]').each(function (i) {
        $(this).removeClass('mb-3')
    });

    let form = []
    $('div[data-form-final]').each(function (i, obj) {
        form.push($(this).html());
    });

    let id_approver = []
    let approver_name = []
    $('input[name="approver-name[]"]').each(function (i, obj) {
        approver_name.push($(this).val());
        id_approver.push($(this).attr('data-id'));
    });

    let page_approver = []
    $('select[name="page-approver[]"]').each(function (i, obj) {
        page_approver.push($(this).val());
    });

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
            is_edit: $('#is-edit').val(),
            id_approver: id_approver,
            delete_approver: $('#is-delet-approver').val(),
            approver_name: approver_name,
            page_approver: page_approver,
            id_validator: $('input[name="validator-name[]"]').attr('data-id'),
            validator_name: $('input[name="validator-name[]"]').val(),
            page_validator: $('input[name="page-validator[]"]').attr('data-id-validator')
        },
        dataType: "json",
        success: function (response) {
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
                    $('input[name="approver-name[]"]').each(function (i, obj) {
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
                    $('select[name="page-approver[]"]').each(function (i, obj) {
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

                if (response.error.name_validator) {
                    if (response.error.name_validator[0].value_empty) {
                        $('input[name="validator-name[]"]').addClass('is-invalid')
                        $('input[name="validator-name[]"]').next().html(
                            response.error.name_validator[0].value_empty)
                    } else {
                        $('input[name="validator-name[]"]').removeClass('is-invalid')
                        $('input[name="validator-name[]"]').next().html('')
                    }
                }

                if (response.error.page_validator) {
                    if (response.error.page_validator[0].value_empty) {
                        $('input[name="page-validator[]"]').addClass('is-invalid')
                        $('input[name="page-validator[]"]').next().html(
                            response.error.page_validator[0].value_empty)
                    } else {
                        $('input[name="page-validator[]"]').removeClass('is-invalid')
                        $('input[name="page-validator[]"]').next().html('')
                    }
                }
            } else {
                window.location.href = "{{ route('formBuilder') }}";
            }
        }
    })
})

// edit field formbuilder
$(document).on('click', 'a[x-edit]', function () {
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
$(document).on('blur', 'input[data-label-input]', function () {
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
$(document).on('change', 'input[data-label-input]', function () {
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
            name: val.replace(/\s+/g, '-').toLowerCase(),
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
                $(`input[data-name-radio="${nameField}"]`).each(function (i) {
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

$('#parent-page').on('change', function () {
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
            success: function (response) {
                if (response.success) {
                    $('select[name="page-approver[]"]').each(function (i) {
                        $(this).html(
                            '<option value="">--Select Page Approver--</option>')
                        for (let index = 0; index < response.success.data
                            .length; index++) {
                            $(this).append('<option value="' + response.success.data[
                                index].id +
                                '">' + response.success.data[index].name +
                                '</option>')
                        }
                    })

                    if (response.success.report) {
                        $('select[name="report-page"]').prop('disabled', false)
                        $('#report-page').html(
                            '<option value="">--Select Page Report--</option>')

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
    }
})

$('.more-approver').on('click', function () {

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
        success: function (response) {
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

$(document).on('click', '.dell-approver', function () {
    let data_id = $(this).attr('data-id')
    let val_now = $('#is-delet-approver').val()
    $('#is-delet-approver').attr('value', val_now == '' ? data_id : val_now + ',' + data_id)
    $(this).closest("tr").remove();
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
        success: function (response) {
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
        success: function (response) {
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
    $('div[data-field-label]').each(function (a) {
        a++
        $(this).attr('id', `title-${a}`)
    })

    $('a[data-edit-title]').each(function (c) {
        c++
        $(this).attr('data-name', `label-title-field-${c}`)
    })

    $('a[data-delete-title]').each(function (d) {
        d++
        $(this).attr('data-target-delete', `title-${d}`)
    })

    // merubah value label dan name input
    $('input[data-label-title]').each(function (b) {
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

    $('label[data-field-label]').each(function (l) {
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
    $('div[data-field-checkbox]').each(function (a) {
        a++
        $(this).attr('id', `checkbox-${a}`)
    })

    $('a[data-edit-checkbox]').each(function (b) {
        b++
        $(this).attr('data-name', 'label-checkbox-field-' + b)
    })

    $('a[data-delete-checkbox]').each(function (l) {
        l++
        $(this).attr('data-target-delete', `#checkbox-${l}`)
    })

    // merubah value label dan name input
    $('input[data-checkbox-indicator]').each(function (n) {
        n++
        let haschange = $(this).attr('has-change')

        if (haschange == 'false') {
            $(this).attr('value', 'i am unchecked Checkbox ' + n).attr('name', 'checkbox-' + n)
                .attr('data-id', 'label-checkbox-field-' + n)
        } else {
            $(this).attr('data-id', 'label-checkbox-field-' + n)
        }
    })

    $('span[data-label-checkbox]').each(function (o) {
        o++
        let haschange = $(this).attr('has-change')

        if (haschange == 'false') {
            $(this).attr('data-target', 'label-checkbox-field-' + o).text(`i am unchecked Checkbox ${o}`)
        } else {
            $(this).attr('data-target', 'label-checkbox-field-' + o)
        }
    })

    $('input[data-checkbox]').each(function (m) {
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
    $('div[data-field-text]').each(function (a) {
        a++
        $(this).attr('id', `text-${a}`)
    })

    $('a[data-edit-text]').each(function (b) {
        b++
        $(this).attr('data-name', 'label-text-field-' + b)
    })

    $('a[data-delete-text]').each(function (l) {
        l++
        $(this).attr('data-target-delete', `#text-${l}`)
    })

    // merubah value label dan name input
    $('input[data-label-text]').each(function (n) {
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

    $('input[data-text]').each(function (m) {
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
    $('div[data-field-date]').each(function (a) {
        a++
        $(this).attr('id', `date-${a}`)
    })

    $('a[data-edit-date]').each(function (b) {
        b++
        $(this).attr('data-name', 'label-date-field-' + b)
    })

    $('a[data-delete-date]').each(function (l) {
        l++
        $(this).attr('data-target-delete', `#date-${l}`)
    })

    // merubah value label dan name input
    $('input[data-label-date]').each(function (n) {
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

    $('input[data-date]').each(function (m) {
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
    $('div[data-field-file]').each(function (a) {
        a++
        $(this).attr('id', `file-${a}`)
    })

    $('a[data-edit-file]').each(function (b) {
        b++
        $(this).attr('data-name', 'label-file-field-' + b)
    })

    $('a[data-delete-file]').each(function (l) {
        l++
        $(this).attr('data-target-delete', `#file-${l}`)
    })

    // merubah value label dan name input
    $('input[data-label-file]').each(function (n) {
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

    $('input[data-file]').each(function (m) {
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
    $('div[data-field-textarea]').each(function (a) {
        a++
        $(this).attr('id', `textarea-${a}`)
    })

    $('a[data-edit-textarea]').each(function (k) {
        k++
        $(this).attr('data-name', 'label-textarea-field-' + k)
    })

    $('a[data-delete-textarea]').each(function (l) {
        l++
        $(this).attr('data-no', l).attr('data-target-delete', `#textarea-${l}`)
    })

    // merubah value label dan name input
    $('input[data-label-textarea]').each(function (n) {
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

    $('textarea[data-textarea]').each(function (m) {
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
    $('div[data-field-select]').each(function (a) {
        a++
        $(this).attr('id', `select-option-${a}`)
    })

    $('a[data-setting-select]').each(function (b) {
        b++
        $(this).attr('data-name', `label-select-field-${b}`).attr('data-target-input',
            `#select-option-field-${b}`)
    })

    $('a[data-edit-select]').each(function (c) {
        c++
        $(this).attr('data-name', `label-select-field-${c}`)
    })

    $('a[data-delete-select]').each(function (d) {
        d++
        $(this).attr('data-target-delete', `#select-option-${d}`).attr('data-target-label',
            `#label-select-field-${d}`)
    })

    // merubah value label dan name input
    $('input[data-label-select]').each(function (e) {
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

    $('select[select-option]').each(function (f) {
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
    $('div[data-radio]').each(function (a) {
        a++
        $(this).attr('id', `radio-${a}`)
    })

    $('a[data-setting-radio]').each(function (b) {
        b++
        $(this).attr('data-name', `label-radio-field-${b}`).attr('data-target-input', `#radio-append-${b}`)
    })

    $('a[data-edit-radio]').each(function (c) {
        c++
        $(this).attr('data-name', `label-radio-field-${c}`)
    })

    $('a[data-delete-radio]').each(function (d) {
        d++
        $(this).attr('data-target-delete', `#radio-${d}`)
    })

    $('h5[data-is-label-radio]').each(function (e) {
        e++
        let haschange = $(this).attr('has-change')
        if (haschange == 'false') {
            $(this).attr('data-label-radio', `label-radio-field-${e}`).text(`Default Radio Buttons ${e}`)
        } else {
            $(this).attr('data-label-radio', `label-radio-field-${e}`)
        }
    })

    $('input[data-label-radio]').each(function (f) {
        f++
        let haschangeName = $(this).attr('has-change')
        if (haschangeName == 'false') {
            $(this).attr('data-name', `label-radio-field-${f}`).attr('id', `label-radio-field-${f}`).attr(
                'value', `Default Radio Buttons ${f}`)
        } else {
            $(this).attr('data-name', `label-radio-field-${f}`).attr('id', `label-radio-field-${f}`)
        }

        let name = $(this).attr('value')

        $('input[data-name-radio]').each(function (ff) {
            let haschange = $(this).attr('has-change')
            if (haschange == 'false') {
                $(this).attr('name', name.replace(/\s+/g, '-').toLowerCase())
            }
        })
    })

    $('div[data-radio-append]').each(function (g) {
        g++
        $(this).attr('id', `radio-append-${g}`)
    })
}