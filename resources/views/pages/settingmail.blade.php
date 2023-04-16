@extends('index')
@section('title', 'Setting Mail Sender | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Mail Sender</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Setting Mail
                                    Sender</a>
                            </li>
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
                    <form class="card-body" id="mail-form">
                        <h4 class="card-title">Create the configuration mail sender</h4>
                        <h5>Mandatory Configuration Options</h5>
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hosts" class="col-form-label">mail_host</label>
                                    <input type="text" class="form-control" id="hosts" placeholder="smtp.gmail.com"
                                        value="{{ $env['MAIL_HOST'] }}" name="hosts">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mailer" class="col-form-label">mail_driver</label>
                                    <input type="text" class="form-control" id="mailer" placeholder="smtp"
                                        value="{{ $env['MAIL_MAILER'] }}" name="mailer">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="col-form-label">username</label>
                                    <input type="text" class="form-control" id="username" placeholder="admin"
                                        value="{{ $env['MAIL_USERNAME'] }}" name="username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="col-form-label">password</label>
                                    <input type="text" class="form-control" id="password" placeholder="password"
                                        value="{{ $env['MAIL_PASSWORD'] }}" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="port" class="col-sm-2 col-form-label">port</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="port" placeholder="587"
                                    value="{{ $env['MAIL_PORT'] }}" name="port">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="encryption" class="col-sm-2 col-form-label">mail_encryption</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="encryption" placeholder="tls"
                                    value="{{ $env['MAIL_ENCRYPTION'] }}" name="encryption">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Save Mail</button>
                        <button type="button" class="btn btn-dark mt-4">Test Send Mail <i
                                class="fab fa-telegram-plane"></i></button>
                    </form>
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
    <script>
        $('#mail-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('settingmail.save') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "mail sender successfully saved",
                        showConfirmButton: false,
                        toast: true,
                        timer: 1500
                    })
                }
            })
        })
    </script>
@endsection
