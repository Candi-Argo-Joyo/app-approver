@extends('index')
@section('title', 'Template Memo | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <style>
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Add Template Memo</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Template Memo</li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Add Template</li>
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
                        <h4 class="card-title">Form Template Memo</h4>
                        <div class="form-group mb-3">
                            <label for="">Template Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <table class="table border table-bordered" id="tb-template">
                            <thead>
                                <tr>
                                    <th style="width: 15px">#</th>
                                    {{-- <th>Content Name</th> --}}
                                    <th>Template</th>
                                    <th style="width: 25px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div id="urutan">1</div>
                                    </td>
                                    {{-- <td>
                                    </td> --}}
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="">Content Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Content</label>
                                            <textarea name="content" id="content" style="min-height: 500px" class="form-control editor"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="badge bg-primary" id="more">
                                            +
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="{{ asset('dist/js/ckeditor/ckeditor.js') }}"></script>
    <div param="true">
        <script>
            ClassicEditor.create(document.querySelector('.editor'))
        </script>
    </div>
    <script>
        let no = 0;
        $('#more').on('click', function() {
            $(".preloader").fadeIn()
            $('#tb-template > tbody > tr').each(function(index) {
                no = index;
            });

            $.ajax({
                url: "{{ route('memoTemplate.add.more') }}",
                type: "get",
                data: {
                    no: no
                },
                dataType: 'json',
                success: function(response) {
                    $(".preloader").fadeOut()
                    $('#tb-template > tbody:last-child').append(response.html);
                    $('div[param]').append(response.script)
                }
            })
        })

        $("#tb-template").on("click", "#DeleteButton", function() {
            $(this).closest("tr").remove();
            const jml = document.querySelectorAll("#urutan");
            for (var i = 0; i < jml.length; i++) {
                document.querySelectorAll("#urutan")[i].innerHTML = i + 1;
            }
        });
    </script>
@endsection
