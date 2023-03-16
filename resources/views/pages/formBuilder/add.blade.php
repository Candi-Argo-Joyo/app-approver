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
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Form</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Form</li>
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
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white">Preview</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light">Setting</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <input class="form-name" type="text" name="form_name" placeholder="Form Name">
                        </div>

                        <div data-inner-layout>
                            <div class="d-flex mt-4" id="layout-1">
                                <div class="w-100 mb-3" id="section-1">
                                    <div
                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <input type="text" value="Text Field" class="no-border"
                                                    id="label-text-field" readonly='true'>
                                                <div class="d-flex justify-content-between align-items-center gap-2">
                                                    <a href="javascript:void(0)" class="text-black" x-edit
                                                        data-name="label-text-field" data-layout="layout-1"
                                                        data-section="section-1">
                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="text-danger">
                                                        <i data-feather="trash" style="width: 20px"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <input class="form-control" placeholder="Input Text Here..." type="text"
                                                name="text-field" id="text-field">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#fields"
                                            class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                            + Add Field
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div id="iner">
                                    <div class="">
                                        <div class="d-flex gap-3">
                                            <div class="w-100">
                                                <div class="mb-3" data-iner="">
                                                    <div
                                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                                        <div class="form-group mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>Text Field</div>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center gap-2">
                                                                    <a href="javascript:void(0)" class="text-black">
                                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="text-danger">
                                                                        <i data-feather="trash" style="width: 20px"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Input Text Here..."
                                                                type="text" name="text-field" id="text-field">
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                                        <div class="form-group mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>Text Field</div>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center gap-2">
                                                                    <a href="javascript:void(0)" class="text-black">
                                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="text-danger">
                                                                        <i data-feather="trash" style="width: 20px"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Input Text Here..."
                                                                type="text" name="text-field" id="text-field">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#fields"
                                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <div class="mb-3" data-iner="">
                                                    <div
                                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                                        <div class="form-group mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>Text Field</div>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center gap-2">
                                                                    <a href="javascript:void(0)" class="text-black">
                                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="text-danger">
                                                                        <i data-feather="trash" style="width: 20px"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Input Text Here..."
                                                                type="text" name="text-field" id="text-field">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#fields"
                                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div id="iner">
                                    <div class="">
                                        <div class="d-flex gap-3">
                                            <div class="w-100">
                                                <div class="mb-3" data-iner="">
                                                    <div
                                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                                        <div class="form-group mb-2">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>Text Field</div>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center gap-2">
                                                                    <a href="javascript:void(0)" class="text-black">
                                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="text-danger">
                                                                        <i data-feather="trash" style="width: 20px"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Input Text Here..."
                                                                type="text" name="text-field" id="text-field">
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3">
                                                        <div class="form-group mb-2">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>Text Field</div>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center gap-2">
                                                                    <a href="javascript:void(0)" class="text-black">
                                                                        <i data-feather="edit-2" style="width: 20px"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="text-danger">
                                                                        <i data-feather="trash" style="width: 20px"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Input Text Here..."
                                                                type="text" name="text-field" id="text-field">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#fields"
                                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="w-100">

                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#fields"
                                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="w-100">

                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#fields"
                                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal"
                                        class="col-md-12 btn bg-light text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                        + Add Layout
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
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
                            <a href="javascript:void(0)" data-col='1' class="d-block bg-light py-4 text-center">Column
                                I</a>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0)" data-col='2' class="d-block bg-light py-4 text-center">Column
                                II</a>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0)" data-col='3' class="d-block bg-light py-4 text-center">Column
                                III</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Apply</button>
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
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='1' class="d-block bg-light py-3 text-center">Text
                                Field</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='1'
                                class="d-block bg-light py-3 text-center">Date</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3' class="d-block bg-light py-3 text-center">File
                                Upload</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='2'
                                class="d-block bg-light py-3 text-center">Textarea</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3' class="d-block bg-light py-3 text-center">Select
                                Option</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3' class="d-block bg-light py-3 text-center">Radio
                                Button</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3' class="d-block bg-light py-3 text-center">Check
                                Box</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3'
                                class="d-block bg-light py-3 text-center">Submit</a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="javascript:void(0)" data-col='3'
                                class="d-block bg-light py-3 text-center">Button</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Apply</button>
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
        function htmlCol(col) {
            let htmlcol = ""
            if (col == '1') {
                htmlCol = ''
            }
        }
        $(document).ready(function() {
            $(document).on('click', 'a[x-edit]', function() {
                let nameField = $(this).attr('data-name')
                let layout = $(this).attr('data-layout')
                let nameSection = $(this).attr('data-section')
                $(`#${nameField}`).prop('readonly', false)
            })
        })
    </script>
@endsection
