@extends('index')
@section('title', 'Add Kredit | Aprover KDDI')
@section('css')
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/select2.min.css') }}" />
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Kredit</li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Add Kredit</li>
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
                        <h5 class="card-title">Set Dealer</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dealer">Dealer Name</label>
                                    <select name="dealer" id="dealer" class="form-control">
                                        <option value="">--Pilih Dealer--</option>
                                        <option value="">PT Batang Panjang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Dealer Code</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Dealer Address</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">TDL Cabang</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">PIC Sales</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Sales Name</label>
                                    <select name="sales" id="sales" class="form-control">
                                        <option value="">--Pilih Sales--</option>
                                        <option value="">Risky Aditya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">No Hp</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Total Go Live</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Customer</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Customer Name</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Address</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Customer Type Busines</label>
                                    <textarea class="form-control" type="text" id="username" required=""></textarea>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Reason For Filing</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Distance To Branch PIC TDL</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Distance To Branch Non TDL</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Slik Pemohon</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Pasangan</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">RO / AO Nopin</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">How To Get Applications</label>
                                    <textarea class="form-control" type="text" id="username" required=""></textarea>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Merk / Jenis / Type</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Insert Merk / Jenis / Type</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">OTR Price</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Chasis</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Karoseri</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Total OTR</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Down Payment</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Amount</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">[%]</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Principal [Total OTR - DP]</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Total Unit</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Total Principal Amount (Include Insurance)</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Insert Total Principal Amount (Include
                                        Insurance)</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Tenor</label>
                                    <input class="form-control" type="text" id="username" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Interest Standard</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="username">FLAT [%]</label>
                                            <input class="form-control" type="text" id="username" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="username">EFF [%]</label>
                                            <input class="form-control" type="text" id="username" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">Interest Filings</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="username">FLAT [%]</label>
                                            <input class="form-control" type="text" id="username" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="username">EFF [%]</label>
                                            <input class="form-control" type="text" id="username" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="from-group">
                                    <label class="form-label" for="">Diteruskan Kepada</label>
                                    <select name="" id="sendMail" class="form-control" multiple>
                                        <option value="">User 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 15px">#</th>
                                                <th scope="col">Diteruskan Kepada</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span>1</span></td>
                                                <td>
                                                    <div class="from-group">
                                                        <select name="" id="sendMail" class="form-control"
                                                            multiple>
                                                            <option value="">User 1</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td><a href="javascript:(0)" class="badge bg-primary">+</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                        <button class="btn btn-primary">Confirm & Save</button>
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
    <script src="{{ asset('dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#sendMail').select2({
                placeholder: "--Plih Penerima Email--",
            });
        });
    </script>
@endsection
