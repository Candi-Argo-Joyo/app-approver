@extends('index')
@section('title', 'Add Kredit | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <script src="https://cdn.tiny.cloud/1/bx37734n27j3z8dfd0nytnxe3jmv18nlkh47fvwbbchlow82/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
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
    </script>
@endsection
