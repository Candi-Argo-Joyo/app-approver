@extends('index')
@section('title', 'Preview form | Aprover KDDI')
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
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Preview Form</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Form Builder</li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Preview Form</li>
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
                    <div class="card-body h6">
                        <h4 class="card-title">{{ $html->form_name }}</h4>
                        <hr>
                        <?= $html->html_final ?>
                        <a href="{{ route('formBuilder') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
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
    </script>
@endsection
