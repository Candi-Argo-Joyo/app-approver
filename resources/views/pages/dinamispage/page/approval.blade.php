    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1"><?= $menu->name ?></h4>
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
                        <h4 class="card-title">List Data <?= $menu->name ?></h4>
                        <div class="table-responsive">
                            <table class="table border table-striped table-bordered text-nowrap tb-approval">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Form Name</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>PT Batang Panjang</td>
                                        <td>Jl Seroa Jawa Tengah Kota Pekalongan</td>
                                        <td>DCA0191</td>
                                        <td>Sahroni</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-success">Preview</a>
                                            <a href="javascript:void(0)" class="badge bg-primary">Approve</a>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Leader Table -->
    </div>
    <!--End Container fluid  -->
