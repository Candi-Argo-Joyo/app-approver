@extends('index')
@section('title', 'Dinamis Page | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    @if ($menu->status == 'non-active')
        @include('pages/dinamispage/page/notset')
    @else
        @if ($menu->page == 'Entry Page')
            @include('pages/dinamispage/page/entry')
        @elseif ($menu->page == 'Approver')
            @include('pages/dinamispage/page/approval')
        @else
            @include('pages/dinamispage/page/data')
        @endif
    @endif
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
@endsection
