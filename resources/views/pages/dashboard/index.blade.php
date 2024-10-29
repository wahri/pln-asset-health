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
                                        <select class="form-select">
                                            <option value="0">Semua Lokasi</option>
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
                <div class="row">
                    <template x-for="(report, index) in reports" :key="report.location_id">
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div :id="'chart-' + report.location_id"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div id="chartExample"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end page wrapper -->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
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
    {{-- <script src="{{ asset('assets-horizontal/js/index2.js') }}"></script> --}}


    <!-- highcharts js -->
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/cylinder.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/funnel3d.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets-horizontal/plugins/highcharts/js/accessibility.js') }}"></script>
    {{-- <script src="{{asset('assets-horizontal/plugins/highcharts/js/highcharts-custom.script.js')}}"></script> --}}

    <script>
        Highcharts.chart("chartExample", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                styledMode: true,
                plotShadow: false,
            },
            credits: {
                enabled: false,
            },
            title: {
                text: "Duri",
                align: "center",
                verticalAlign: "top",
                y: 60,
            },
            colors: ["#198754", "#ffc107", "#dc3545"],
            tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
            },
            accessibility: {
                point: {
                    valueSuffix: "%",
                },
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: "bold",
                            color: "white",
                        },
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ["50%", "75%"],
                    size: "110%",
                },
            },
            series: [{
                type: "pie",
                name: "Percentage",
                innerSize: "50%",
                data: [
                    ["Normal", 50],
                    ["Abnormal", 30],
                    ["Fault", 20],
                ],
            }, ],
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('assets-horizontal/js/app.js') }}"></script>

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                isLoading: true,
                reports: [],

                init() {
                    this.getData();
                },

                async getData() {
                    this.isLoading = true;
                    try {
                        const response = await axios.get('{{ route('getReportData') }}');
                        this.reports = response.data;
                        this.isLoading = false;
                        this.$nextTick(() => this.loadCharts());
                    } catch (error) {
                        console.error("Error fetching data:", error);
                        this.isLoading = false;
                    }
                },

                loadCharts() {
                    this.reports.forEach(report => {
                        // Hitung total asset
                        const totalAssets = (report.asset_counts.normal || 0) +
                            (report.asset_counts.abnormal || 0) +
                            (report.asset_counts.fault || 0);

                        // Konversi ke persentase
                        const data = [
                            ["Normal", totalAssets ? (report.asset_counts.normal /
                                totalAssets) * 100 : 0],
                            ["Abnormal", totalAssets ? (report.asset_counts.abnormal /
                                totalAssets) * 100 : 0],
                            ["Fault", totalAssets ? (report.asset_counts.fault /
                                totalAssets) * 100 : 0]
                        ];

                        console.log(data);


                        Highcharts.chart(`chart-${report.location_id}`, {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: 0,
                                styledMode: true,
                                plotShadow: false,
                            },
                            credits: {
                                enabled: false,
                            },
                            title: {
                                text: report.location_name,
                                align: "center",
                                verticalAlign: "top",
                                y: 60,
                            },
                            tooltip: {
                                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
                            },
                            accessibility: {
                                point: {
                                    valueSuffix: "%",
                                },
                            },
                            plotOptions: {
                                pie: {
                                    dataLabels: {
                                        enabled: true,
                                        distance: -50,
                                        style: {
                                            fontWeight: "bold",
                                            color: "white",
                                        },
                                    },
                                    startAngle: -90,
                                    endAngle: 90,
                                    center: ["50%", "75%"],
                                    size: "110%",
                                },
                            },
                            series: [{
                                type: "pie",
                                name: "Percentage",
                                innerSize: "50%",
                                data: data,
                            }],
                        });
                    });

                    Highcharts.chart("col-chart", {
                        chart: {
                            type: "column",
                            styledMode: true,
                        },
                        credits: {
                            enabled: false,
                        },
                        title: {
                            text: "Stacked column chart",
                        },
                        xAxis: {
                            categories: ["Apples", "Oranges", "Pears", "Grapes", "Bananas"],
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: "Total fruit consumption",
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
                        series: [{
                                name: "Normal",
                                data: [5, 3, 4, 7, 2],
                            },
                            {
                                name: "Abnormal",
                                data: [2, 2, 3, 2, 1],
                            },
                            {
                                name: "Fault",
                                data: [3, 4, 4, 2, 5],
                            },
                        ],
                    });
                },
            }));
        });
    </script>
</body>

</html>
