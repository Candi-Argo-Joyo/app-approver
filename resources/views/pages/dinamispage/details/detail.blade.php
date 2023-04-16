@extends('index')
@section('title', 'Detail Kredit | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1"><?= $menu->name ?> Detail</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"
                                    class="text-muted">{{ $parent->name }}</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page"><?= $menu->name ?></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-end">
                    <a href="javascript:void(0)" class="btn btn-primary">Download</a>
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
                        <div class="border-bottom">
                            <h4 class="card-title">Detail <?= $menu->name ?></h4>
                        </div>
                        <div>
                            <div class="row mt-4">
                                <style>
                                    table {
                                        width: 100%;
                                        border: 1px solid #ddd
                                    }

                                    table td {
                                        border-right: 1px solid #ddd;
                                        border-top: 1px solid #ddd;
                                        border-bottom: 1px solid #ddd;
                                        padding: 10px
                                    }
                                </style>
                                <div style="font-size: 12px">
                                    <table>
                                        @foreach ($layout as $l)
                                            <?php $field = DB::table('form_field')
                                                ->where('id_html_form', $menu->id_html_form)
                                                ->where('id_form_layout', $l->id)
                                                ->get(); ?>
                                            @if ($l->jenis == 'column-1')
                                                @foreach ($field as $f)
                                                    <?php $value = DB::table('insert_form')
                                                        ->where('id_html_form', $menu->id_html_form)
                                                        ->where('label', $f->field_name)
                                                        ->first(); ?>
                                                    <tr>
                                                        @if ($f->type == 'title')
                                                            <td colspan="4" style="border: unset; background:#ededed">
                                                                {{ $f->original_name }}</td>
                                                        @else
                                                            <td style="min-width: 100px">{{ $f->original_name }}
                                                            </td>
                                                            <td style="min-width: 215px">{{ $value->value }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                            @if ($l->jenis == 'column-2')
                                                <tr>
                                                    <td colspan="4" style="padding: 5px"></td>
                                                </tr>
                                                <?php $no = 0; ?>
                                                @foreach ($field as $f)
                                                    <?php $value = DB::table('insert_form')
                                                        ->where('id_html_form', $menu->id_html_form)
                                                        ->where('label', $f->field_name)
                                                        ->first(); ?>
                                                    @if ($f->type == 'title')
                                                        <td colspan="4">
                                                            {{ $f->original_name }}</td>
                                                    @else
                                                        <td style="min-width: 115px">{{ $f->original_name }}
                                                        </td>
                                                        <td style="min-width: 215px">{{ $value->value }}
                                                        </td>
                                                    @endif
                                                    @if ($no % 2 != 0)
                                                        </tr>
                                                    @endif
                                                    <?php $no++; ?>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="4" style="padding: 5px"></td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            @if (count($approver) < 3)
                                                @foreach ($approver as $app)
                                                    <td style="text-align: center; width:33%">
                                                        <div style="height: 150px;t;position: relative;">
                                                            <div style="position: absolute;top: 0;width: 100%;">
                                                                {{ $app->name }}
                                                            </div>
                                                            <img class="h-100"
                                                                src="{{ asset('images/signature/Oprah-Winfrey-Signature-1.png') }}">
                                                            <div style="position: absolute;bottom: 0;width: 100%;">
                                                                <br>Atas Nama
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                                <td style="text-align: center;width:33%">
                                                    <div style="height: 150px;t;position: relative;">
                                                    </div>
                                                </td>
                                                <td style="text-align: center;width:33%">
                                                    <div style="height: 150px;t;position: relative;">
                                                    </div>
                                                </td>
                                            @else
                                                @foreach ($approver as $app)
                                                    <td style="text-align: center;">
                                                        <div style="height: 150px;t;position: relative;">
                                                            <div style="position: absolute;top: 0;width: 100%;">
                                                                {{ $app->name }}
                                                            </div>
                                                            <div style="position: absolute;bottom: 0;width: 100%;">
                                                                <br>Atas Nama
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>
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
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
@endsection
