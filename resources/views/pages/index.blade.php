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
            <div class="page-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="">
                                    <div class="form-group">
                                        <label for="" class="form-label">Pilih Lokasi</label>
                                        <select class="form-select" x-model="location_id" @change="getData">
                                            <option value="">Semua Lokasi</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="col-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <template x-for="(report, index) in reports" :key="report.location_id">
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div :id="'chart-' + report.location_id"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div> --}}

                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="mb-0 text-uppercase">Data Asset Fault and Warning</h6>
                        <hr />
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableAssets" class="table table-striped table-bordered"
                                        style="color: #ffffff; table-layout: fixed">
                                        <colgroup>
                                            <col style="width: 150px;"> <!-- Lokasi -->
                                            <col style="width: 120px;"> <!-- Unit -->
                                            <col style="width: 100px;"> <!-- No Asset -->
                                            <col style="width: 200px;"> <!-- Nama Asset -->
                                            <col style="width: 150px;"> <!-- Group Asset -->
                                            <col style="width: 100px;"> <!-- Status -->
                                            <col style="width: 120px;"> <!-- No SR -->
                                            <col style="width: 120px;"> <!-- No WO -->
                                            <col style="width: 130px;"> <!-- Tgl Identifikasi -->
                                            <col style="width: 100px;"> <!-- Status SR -->
                                            <col style="width: 300px;"> <!-- Kondisi Asset -->
                                            <col style="width: 300px;"> <!-- Action Plan -->
                                            <col style="width: 130px;"> <!-- Target Selesai -->
                                            <col style="width: 130px;"> <!-- Progress Saat Ini -->
                                            <col style="width: 150px;"> <!-- Realisasi Selesai -->
                                            <col style="width: 180px;"> <!-- Main Issue -->
                                            <col style="width: 200px;"> <!-- Keterangan -->
                                        </colgroup>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end page wrapper -->

        {{-- <footer class="page-footer">
            <p class="mb-0">Copyright © 2021. All right reserved.</p>
        </footer> --}}
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets-horizontal/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets-horizontal/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <!-- highcharts js -->
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/cylinder.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/funnel3d.js') }}"></script>
    {{-- datatable --}}
    <script src="{{ asset('assets-horizontal/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <!--app JS-->
    <script src="{{ asset('assets-horizontal/js/app.js') }}"></script>

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                isLoading: true,
                reports: [],
                location_id: '',
                dataAssets: [],

                init() {
                    this.getData();
                },

                async getData() {
                    this.isLoading = true;
                    try {
                        const response = await axios.get('{{ route('getReportData') }}', {
                            params: {
                                location_id: this.location_id
                            }
                        });
                        this.reports = response.data.charts;
                        this.dataAssets = response.data.table;
                        this.isLoading = false;
                        // this.loadCharts()

                        this.$nextTick(() => this.loadCharts());
                        this.$nextTick(() => {
                            this.initializeDataTable();
                        });
                    } catch (error) {
                        console.error("Error fetching data:", error);
                        this.isLoading = false;
                    }
                },

                loadCharts() {
                    // this.reports.forEach(report => {
                    //     // Hitung total asset
                    //     const totalAssets = (report.asset_counts.normal || 0) +
                    //         (report.asset_counts.abnormal || 0) +
                    //         (report.asset_counts.fault || 0);

                    //     // Konversi ke persentase
                    //     const data = [
                    //         ["Normal", totalAssets ? (report.asset_counts.normal /
                    //             totalAssets) * 100 : 0],
                    //         ["Abnormal", totalAssets ? (report.asset_counts.abnormal /
                    //             totalAssets) * 100 : 0],
                    //         ["Fault", totalAssets ? (report.asset_counts.fault /
                    //             totalAssets) * 100 : 0]
                    //     ];

                    //     console.log(data);


                    //     Highcharts.chart(`chart-${report.location_id}`, {
                    //         chart: {
                    //             plotBackgroundColor: null,
                    //             plotBorderWidth: 0,
                    //             styledMode: true,
                    //             plotShadow: false,
                    //         },
                    //         credits: {
                    //             enabled: false,
                    //         },
                    //         title: {
                    //             text: report.location_name,
                    //             align: "center",
                    //             verticalAlign: "top",
                    //             y: 60,
                    //         },
                    //         tooltip: {
                    //             pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
                    //         },
                    //         accessibility: {
                    //             point: {
                    //                 valueSuffix: "%",
                    //             },
                    //         },
                    //         plotOptions: {
                    //             pie: {
                    //                 dataLabels: {
                    //                     enabled: true,
                    //                     distance: -50,
                    //                     style: {
                    //                         fontWeight: "bold",
                    //                         color: "white",
                    //                     },
                    //                 },
                    //                 startAngle: -90,
                    //                 endAngle: 90,
                    //                 center: ["50%", "75%"],
                    //                 size: "110%",
                    //             },
                    //         },
                    //         series: [{
                    //             type: "pie",
                    //             name: "Percentage",
                    //             innerSize: "50%",
                    //             data: data,
                    //         }],
                    //     });
                    // });

                    Highcharts.chart("col-chart", {
                        chart: {
                            type: "column",
                            styledMode: true,
                        },
                        credits: {
                            enabled: false,
                        },
                        title: {
                            text: "Status Assets",
                        },
                        xAxis: {
                            categories: this.reports.categories,
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: "Overview Asset Wellness",
                            },
                            stackLabels: {
                                enabled: true,
                                style: {
                                    fontWeight: "bold",
                                    color:
                                        // theme
                                        (Highcharts.defaultOptions.title.style &&
                                            Highcharts.defaultOptions.title.style.color) ||
                                        "gray",
                                },
                            },
                        },
                        legend: {
                            align: "right",
                            x: -30,
                            verticalAlign: "top",
                            y: 25,
                            floating: true,
                            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor ||
                                "white",
                            borderColor: "#CCC",
                            borderWidth: 1,
                            shadow: false,
                        },
                        tooltip: {
                            headerFormat: "<b>{point.x}</b><br/>",
                            pointFormat: "{series.name}: {point.y}<br/>Total: {point.stackTotal}",
                        },
                        plotOptions: {
                            column: {
                                stacking: "normal",
                                dataLabels: {
                                    enabled: true,
                                },
                            },
                        },
                        series: this.reports.series,
                    });
                    // if ($.fn.DataTable.isDataTable('#tableAssets')) {
                    //     $('#tableAssets').DataTable().clear().destroy();
                    // }
                    // var table = $('#tableAssets').DataTable({
                    //     lengthChange: false,
                    //     buttons: ['colvis', 'excel']
                    // });

                    // table.buttons().container()
                    //     .appendTo('#tableAssets_wrapper .col-md-6:eq(0)');
                },

                initializeDataTable() {
                    // Check if DataTable is already initialized and destroy it if necessary
                    if ($.fn.DataTable.isDataTable('#tableAssets')) {
                        $('#tableAssets').DataTable().clear().destroy();
                    }

                    // Initialize the DataTable with the new data
                    $('#tableAssets').DataTable({
                        data: this.dataAssets,
                        columns: [{
                                data: 'unit.location.name',
                                title: 'Lokasi'
                            },
                            {
                                data: 'unit.name',
                                title: 'Unit'
                            },
                            {
                                data: 'asset.no_asset',
                                title: 'No Asset'
                            },
                            {
                                data: 'asset.name',
                                title: 'Nama Asset'
                            },
                            {
                                data: 'asset.asset_group.name',
                                title: 'Group Asset'
                            },
                            {
                                data: 'status',
                                title: 'Status'
                            },
                            {
                                data: 'detail_reports',
                                title: 'No SR',
                                render: function(data, type, row) {
                                    return data.map(report => report.no_sr).join(
                                        '<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'No WO',
                                render: function(data, type, row) {
                                    return data.map(report => report.no_wo).join(
                                        '<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Tgl Identifikasi',
                                render: function(data, type, row) {
                                    return data.map(report => report
                                        .tanggal_identifikasi).join('<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Status SR',
                                render: function(data, type, row) {
                                    return data.map(report => report.status_sr).join(
                                        '<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Kondisi Asset',
                                render: function(data, type, row) {
                                    return data.map(report => report.kondisi_asset)
                                        .join('<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Action Plan',
                                render: function(data, type, row) {
                                    return data.map(report => report.action_plan).join(
                                        '<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Target Selesai',
                                render: function(data, type, row) {
                                    return data.map(report => report.target_selesai)
                                        .join('<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Progress Saat Ini',
                                render: function(data, type, row) {
                                    return data.map(report => report.progress_saat_ini)
                                        .join('<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Realisasi Selesai',
                                render: function(data, type, row) {
                                    return data.map(report => report.realisasi_selesai)
                                        .join('<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Main Issue',
                                render: function(data, type, row) {
                                    return data.map(report => report.issue).join(
                                        '<hr>');
                                }
                            },
                            {
                                data: 'detail_reports',
                                title: 'Keterangan',
                                render: function(data, type, row) {
                                    return data.map(report => report.keterangan).join(
                                        '<hr>');
                                }
                            }
                        ],
                        lengthChange: false,
                        buttons: ['colvis', 'excel'],
                    });

                    // Append buttons to the desired location
                    $('#tableAssets').DataTable().buttons().container()
                        .appendTo('#tableAssets_wrapper .col-md-6:eq(0)');
                },
            }));
        });
    </script>


    {{-- <script>
        $(document).ready(function() {
            var table = $('#tableAssets').DataTable({
                lengthChange: false,
                buttons: ['colvis','excel']
            });

            table.buttons().container()
                .appendTo('#tableAssets_wrapper .col-md-6:eq(0)');
        });
    </script> --}}
</body>

</html>
