<!doctype html>
<html lang="en" class="dark-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo_pln.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets-horizontal/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets-horizontal/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets-horizontal/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets-horizontal/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets-horizontal/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets-horizontal/plugins/datatable/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets-horizontal/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets-horizontal/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets-horizontal/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-horizontal/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets-horizontal/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-horizontal/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets-horizontal/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-horizontal/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-horizontal/css/header-colors.css') }}" />

    <title>Asset Wellness Monitoring System</title>
      <style>
            /* Untuk membungkus teks di semua kolom tabel */
            #tableAssets th,
            #tableAssets td {
                white-space: normal;
                /* Membuat teks membungkus di dalam kolom */
                word-wrap: break-word;
                /* Menambah pembungkus kata */
            }
        </style>

    <style>
        html.dark-theme .highcharts-root text {
            fill: #000000;
        }

        .highcharts-color-0 {
            fill: #00ac00;
            stroke: #00ff00;
        }

        .highcharts-color-1 {
            fill: #acac00;
            stroke: #acac00;
        }

        .highcharts-color-2 {
            fill: #ac0000;
            stroke: #ac0000;
        }

        html.dark-theme .logo-icon {
            filter: none;
        }

        html.dark-theme .highcharts-root text {
            fill: #ffffff;
        }


        /* Untuk membungkus teks di semua kolom tabel */
        #tableAssets th,
        #tableAssets td {
            white-space: normal;
            /* Membuat teks membungkus di dalam kolom */
            word-wrap: break-word;
            /* Menambah pembungkus kata */
        }
    </style>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        <div class="header-wrapper">
            <!--start header -->
            <header>
                <div class="topbar d-flex align-items-center">
                    <nav class="gap-3 navbar navbar-expand">
                        <div class="topbar-logo-header">
                            <div class="">
                                <img src="{{ asset('assets/images/logo_pln2.png') }}" class="logo-icon"
                                    alt="logo icon" />
                            </div>
                            <div class="">
                                <h4 class="logo-text">PLN - Assets Wellness Monitoring System</h4>
                            </div>
                        </div>
                        <div class="top-menu ms-auto">
                            <ul class="gap-1 navbar-nav align-items-center">

                                <li class="nav-item dark-mode d-none d-sm-flex">
                                    <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-sun'></i>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link position-relative" href="{{ route('login') }}">
                                        <i class='bx bx-log-in-circle'></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>
            <!--end header -->
            <!--navigation-->
            <!--end navigation-->
        </div>
        <!--end header wrapper-->
        <!--start page wrapper -->
        <div class="page-wrapper" style="margin-top: 70px" x-data="alpineData">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="alert alert-success" role="alert" id="statusAlert" style="display: none">
                    </div>
                    <h6 class="mb-0 font-weight-bold">Detail Assets</h6>
                    <hr>
                    <div class="mt-4 table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 10px">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bxs-checkbox me-2 font-24" style="color: #9b59b6;"></i>
                                            <div><strong>System</strong></div>
                                        </div>
                                    </td>
                                    <td>
                                        : {{ $reportAsset->asset->assetGroup->name }}
                                    </td>

                                </tr>

                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bxs-checkbox me-2 font-24" style="color: #e74c3c;"></i>
                                            <div><strong>No Asset</strong></div>
                                        </div>
                                    </td>
                                    <td>
                                        : {{ $reportAsset->asset->no_asset }}
                                    </td>

                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bxs-checkbox me-2 font-24" style="color: #2ecc71;"></i>
                                            <div><strong>Nama</strong> </div>
                                        </div>
                                    </td>
                                    <td>
                                        : {{ $reportAsset->asset->name }}
                                    </td>

                                </tr>
                                <tr>


                                    <td class="px-0">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bxs-checkbox me-2 font-24" style="color: #f39c12;"></i>
                                            <div><strong>Status Asset :</strong></div>
                                        </div>
                                    </td>
                                    <td>

                                        : {{ ucfirst($reportAsset->status) }}


                                    </td>






                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

              <div class="card">
            <div class="card-body">

                <div class="gap-3 mb-4 d-lg-flex align-items-center">

                    <div class="position-relative">
                        {{-- <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span
                            class="position-absolute top-50 product-show translate-middle-y"><i
                                class="bx bx-search"></i></span> --}}
                    </div>
                   
                </div>
                <div class="table-responsive">
                    <table id="tableAssets" class="table mb-0">
                        <thead class="table">
                            <tr>
                                <th>No SR</th>
                                <th>No WO</th>
                                <th>Tanggal Identifikasi</th>
                                <th>Status WO</th>
                                <th>Kondisi Asset</th>
                                <th>Action Plan</th>
                                <th>Target Selesai</th>
                                <th>Progres Saat ini</th>
                                <th>Realisasi Selesai</th>
                                <th>Issue</th>
                                <th>Keterangan</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @if ($detailReportsAll->count() > 0)
                                @foreach ($detailReportsAll as $dr)
                                    <tr>
                                        <td>
                                            {{ $dr->no_sr }}
                                        </td>
                                        <td>{{ $dr->no_wo }}</td>

                                        <td>{{ $dr->tanggal_identifikasi }}</td>
                                        <td>{{ $dr->status_sr }}</td>
                                        <td>{{ $dr->kondisi_asset }}</td>

                                        <td>{{ $dr->action_plan }}</td>
                                        <td>{{ $dr->target_selesai }}</td>
                                        <td>{{ $dr->progress_saat_ini }}</td>
                                        <td>
                                            {{ $dr->realisasi_selesai }}
                                        </td>
                                        <td>{{ $dr->issue }}</td>
                                        <td>{{ $dr->keterangan }}</td>
                                      
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="text-center">No data available</td>
                                </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>

    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets-horizontal/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets-horizontal/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>


    {{-- datatable --}}
    <script src="{{ asset('assets-horizontal/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <!--app JS-->
    <script src="{{ asset('assets-horizontal/js/app.js') }}"></script>


    <script>
          $(document).ready(function() {
            $('#tableAssets').DataTable({
                buttons: ['pageLength', 'colvis', 'excel'],
                dom: 'Bfrtip' // untuk menampilkan tombol di atas tabel
            });
        });
    </script>

</body>

</html>
