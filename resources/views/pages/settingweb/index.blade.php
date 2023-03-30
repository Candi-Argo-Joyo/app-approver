@extends('index')
@section('title', 'Setting SSO/WEB | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data SSO / WEB</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Setting SSO/WEB</a>
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
                <div class="d-flex">
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-white sso">Setting SSO</a>
                    <a href="javascript:void(0)" class="col-sm-2 text-center px-4 py-2 bg-light web">Setting Web</a>
                </div>
                <div class="card" id="sso">
                    <form class="card-body">
                        <h4 class="card-title">Create the configuration</h4>
                        <h5>Mandatory Configuration Options</h5>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">Hosts</label>
                                    <input type="text" class="form-control" id="host"
                                        placeholder="['corp-dc1.corp.acme.org', 'corp-dc2.corp.acme.org']">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="base_dn" class="col-form-label">base_dn</label>
                                    <input type="text" class="form-control" id="base_dn"
                                        placeholder="dc=corp,dc=acme,dc=org">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">username</label>
                                    <input type="text" class="form-control" id="host" placeholder="admin">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">password</label>
                                    <input type="text" class="form-control" id="host" placeholder="password">
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-5">Optional Configuration Options</h5>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">schema</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host"
                                    placeholder="Adldap\Schemas\ActiveDirectory::class"
                                    value="Adldap\Schemas\ActiveDirectory::class" readonly>
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">account_prefix</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="ACME-">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">account_suffix</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="@acme.org">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">port</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="389">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">follow_referrals</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="false">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">use_ssl</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="false">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">use_tls</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="false">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">version</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="3">
                            </div>
                        </div>
                        <div class="row mt-4 justify-items-center">
                            <label for="" class="col-sm-2 col-form-label">timeout</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="host" placeholder="5">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-4">Save</button>
                    </form>
                </div>
                <div class="card" id="web" style="display: none">
                    <div class="card-body">
                        <h4 class="card-title">Create the configuration</h4>
                        <h5>Mandatory Configuration Options</h5>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">Company name</label>
                                    <input type="text" class="form-control" id="host"
                                        placeholder="PT KDDI Indonesia">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="base_dn" class="col-form-label">Slogan</label>
                                    <input type="text" class="form-control" id="base_dn"
                                        placeholder="Yor slogan here">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">Logo</label>
                                    <input type="file" class="form-control" id="host" placeholder="admin">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host" class="col-form-label">Preview Logo</label>
                                    {{-- <input type="text" class="form-control" id="host" placeholder="password"> --}}
                                    <div class="form-control">
                                        <img src="" alt="logo">
                                    </div>
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
    <script>
        $('.sso').on('click', function() {
            $(this).removeClass('bg-light').addClass('bg-white')
            $('.web').removeClass('bg-white').addClass('bg-light')

            $('#sso').show()
            $('#web').hide()
        })
        $('.web').on('click', function() {
            $(this).removeClass('bg-light').addClass('bg-white')
            $('.sso').removeClass('bg-white').addClass('bg-light')

            $('#sso').hide()
            $('#web').show()
        })
    </script>
@endsection
