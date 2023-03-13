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
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Kredit</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">Master Data</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Kredit</li>
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
                            <h4 class="card-title">Detail Data Kredit</h4>
                        </div>
                        <div style="font-size: 12px">
                            <div class="row mt-3">
                                <div class="col-7 align-self-center">
                                    PT. KDDI Indonesia
                                </div>
                                <div class="col-5 align-self-center">
                                    <div class="float-end">
                                        <div class="py-1 px-4 border">
                                            FORM A1
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Form Persetujuan Aplikasi Kredit Khusus / Special Credit Application
                                    Approval Form</div>
                                <div class="col-md-12">APLIKASI KREDIT DILUAR TARGET DEALER LIST / CREDIT APPLICATION
                                    OUTSIDE
                                    TARGET DEALER LIST</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-7 align-self-center">
                                    CABANG / BRANCH : JAKARTA PUSAT
                                </div>
                                <div class="col-5 align-self-center">
                                    <div class="float-end">
                                        Tanggal / Date : 14 / 02/ 2022
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="border w-100">
                                        <tr class="border" style="background: #f6f6f6">
                                            <td colspan="9" style="border-right: 1px solid #ddd" class="p-2 text-center">
                                                THE
                                                DEALERS
                                            </td>
                                            <td colspan="3" class="p-2 text-center">PIC SALES</td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">NAME DEALERS</td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td colspan="3" style="border-right: 1px solid #ddd" class="p-2">PT ANGIN
                                                RIBUT
                                                SEKALI</td>
                                            <td colspan="4" style="border-right: 1px solid #ddd; width:80px"
                                                class="p-2">TDL
                                                CABANG : JAKARTA
                                            </td>

                                            <td style="border-right: 1px solid #ddd" class="p-2">NAMA SALES</td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td class="p-2">JOKO TINGKIR</td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">DEALER ADDRESS</td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td colspan="7" style="border-right: 1px solid #ddd" class="p-2">JALAN
                                                RAYA
                                                MERUYA ILIR NO 35 LAPANGAN BOLA KEBON JERUK JAKARTA BARAT JAKARTA INDONESIA
                                            </td>

                                            <td style="border-right: 1px solid #ddd" class="p-2">NO HP</td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td class="p-2">01234567890</td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">DEALER CODE </td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td colspan="7" style="border-right: 1px solid #ddd" class="p-2">010000001
                                            </td>

                                            <td style="border-right: 1px solid #ddd" class="p-2">TOTAL GO LIVE </td>
                                            <td rowspan="2" style="border-right: 1px solid #ddd;width: 10px;"
                                                class="p-2">:</td>
                                            <td rowspan="2" class="p-2">25 UNIT</td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">DEALER CONTRIBUTION</td>
                                            <td style="border-right: 1px solid #ddd;width: 10px;" class="p-2">:</td>
                                            <td colspan="7" style="border-right: 1px solid #ddd" class="p-2">12
                                                UNIT
                                                (LAST 1 YEAR)
                                            </td>

                                            <td style="border-right: 1px solid #ddd" class="p-2">( LAST 1 YEAR )</td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" style="padding: 2px"></td>
                                        </tr>
                                        <tr class="border" style="background: #f6f6f6">
                                            <td colspan="2" style="border-right: 1px solid #ddd"
                                                class="p-2 text-center">NAME
                                                CUSTOMER</td>
                                            <td colspan="4" style="border-right: 1px solid #ddd"
                                                class="p-2 text-center">THE
                                                ADDRESS OF THE CUSTOMER</td>
                                            <td colspan="6" class="p-2 text-center">THE CUSTOMER'S TYPE OF BUSINESS
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="2" style="border-right: 1px solid #ddd" class="p-2">KI
                                                MANTEP SUDARSONO</td>
                                            <td colspan="4" style="border-right: 1px solid #ddd" class="p-2">JALAN
                                                KENANGAN MANIS NO 165 B SAMBILEGI KIDUL RT 001/002 MAGUWOHARJO DEPOK SLEMAN
                                                YOGYAKARTA</td>
                                            <td colspan="6" class="p-2">PEMOHON MEMILIKI USAHA DISTRIBUTOR MAKANAN
                                                TERNAK, LAMA USAHA 10 TAHUN, TEMPAT USAHA MILIK SENDIRI, LOKASI STRATEGIS
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" style="padding: 2px"></td>
                                        </tr>
                                        <tr class="border" style="background: #f6f6f6">
                                            <td colspan="6" style="border-right: 1px solid #ddd"
                                                class="p-2 text-center">REASON
                                                FOR FILING</td>
                                            <td colspan="6" class="p-2 text-center">HOW TO GET APPLICATIONS
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">
                                                DISTANCE TO BRANCH PIC TDL
                                            </td>
                                            <td style="border-right: 1px solid #ddd; width:10px" class="p-2">
                                                :
                                            </td>
                                            <td colspan="2" style="border-right: 1px solid #ddd" class="p-2">
                                                50 KM
                                            </td>
                                            <td colspan="2" style="border-right: 1px solid #ddd" class="p-2">
                                                SLIK PEMOHON : C1
                                            </td>
                                            <td colspan="6" rowspan="3" class="p-2">
                                                APLIKASI DIPEROLEH DARI BPK "A" HEAD CREDIT CABANG JAKARTA, SEHUBUNGAN
                                                NASABAH AO CABANG JAKARTA PUSAT APLIKASI TERSEBUT DIBERIKAN KE HEAD CREDIT
                                                JAKARTA PUSAT BPK "B" UNTUK DIPROSES LEBIH LANJUT
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">
                                                DISTANCE TO BRANCH NON TDL
                                            </td>
                                            <td style="border-right: 1px solid #ddd; width:10px" class="p-2">
                                                :
                                            </td>
                                            <td colspan="2" style="border-right: 1px solid #ddd" class="p-2">
                                                25 KM
                                            </td>
                                            <td colspan="2" style="border-right: 1px solid #ddd" class="p-2">
                                                PASANGAN : C1
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td style="border-right: 1px solid #ddd" class="p-2">
                                                RO / AO NOPIN
                                            </td>
                                            <td style="border-right: 1px solid #ddd; width:10px" class="p-2">
                                                :
                                            </td>
                                            <td colspan="4" style="border-right: 1px solid #ddd" class="p-2">
                                                123556789101, 123456789102, 123456789103
                                            </td>
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
