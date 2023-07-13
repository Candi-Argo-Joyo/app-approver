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
        @elseif ($menu->page == 'Validator')
            @include('pages/dinamispage/page/validator')
        @else
            @include('pages/dinamispage/page/data')
        @endif
    @endif
@endsection
@section('script')
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
    @if ($menu->page == 'Entry Page')
        <script>
            $(function() {
                var table = $('.tb-entry').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('entrypage.datatables') }}",
                        data: {
                            id_html_form: '{{ $menu->id_html_form }}',
                            menu: '{{ $menu->slug }}',
                        },
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                        {
                            data: 'form_name',
                            name: 'form_name',
                            width: "30%"
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            width: "30%"
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            width: "25%"
                        },
                        {
                            data: 'status',
                            name: 'status',
                            width: "5%"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                    ]
                });

                $(document).on('click', '.preview', function() {
                    let param = $(this).attr('data-param')
                })

                $(document).on('click', '.delete', function() {
                    let param = $(this).attr('data-param')
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('pages.delete') }}",
                                type: "post",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    param: param
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: response.success,
                                            showConfirmButton: false,
                                            toast: true,
                                            timer: 1500
                                        })
                                        table.ajax.reload()
                                    } else {
                                        Swal.fire(
                                            'Ups!',
                                            response.error.msg,
                                            'warning'
                                        )
                                    }
                                }
                            })
                        }
                    })
                })
            });
        </script>
    @endif
    @if ($menu->page == 'Validator')
        <script>
            var table = $('.tb-validator').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('validatorpage.datatables') }}",
                    data: {
                        id_html_form: '{{ $menu->id_html_form }}',
                        id_menu: '{{ $menu->id }}',
                        menu: '{{ $menu->slug }}',
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                    {
                        data: 'form_name',
                        name: 'form_name',
                        width: "30%"
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        width: "30%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        width: "25%"
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: "5%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                ]
            });

            $(document).on('click', '.accept', function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('pages.validate') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param'),
                        validator: $(this).attr('data-validator'),
                        form: $(this).attr('data-from')
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                        } else {
                            Swal.fire(
                                'Ups?',
                                response.error,
                                'warning'
                            )
                        }
                    }
                })
            })
        </script>
    @endif
    @if ($menu->page == 'Approver')
        <script>
            var table = $('.tb-approval').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('approvalpage.datatables') }}",
                    data: {
                        id_html_form: '{{ $menu->id_html_form }}',
                        menu: '{{ $menu->slug }}',
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                    {
                        data: 'form_name',
                        name: 'form_name',
                        width: "30%"
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        width: "30%"
                    },
                    {
                        data: 'validate_by',
                        name: 'validate_by',
                        width: "5%"
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: "5%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        width: "25%"
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        width: "25%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: "5%"
                    },
                ]
            });

            $(document).on('click', '.approve', function() {
                $(".preloader").fadeIn()
                $.ajax({
                    url: "{{ route('pages.approve') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        param: $(this).attr('data-param'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".preloader").fadeOut()
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                        } else {
                            Swal.fire(
                                'Ups?',
                                response.error.msg,
                                'warning'
                            )
                        }
                    }
                })
            })
        </script>
    @endif
    @if ($menu->page == 'Report')
        <script>
            $(function() {
                var table = $('.tb-data').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('datapage.datatables') }}",
                        data: {
                            id_html_form: '{{ $menu->id_html_form }}',
                            menu: '{{ $menu->slug }}',
                        },
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                        {
                            data: 'form_name',
                            name: 'form_name',
                            width: "30%"
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            width: "30%"
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            width: "25%"
                        },
                        {
                            data: 'status',
                            name: 'status',
                            width: "5%"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                    ]
                });
            })
        </script>
    @endif
@endsection
