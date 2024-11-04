@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link href="{{ asset('assets-horizontal/plugins/datatable/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <style>
        /* Untuk membungkus teks di semua kolom tabel */
        #tableAssets th,
        #tableAssets td {
            white-space: normal;
            /* Membuat teks membungkus di dalam kolom */
            word-wrap: break-word;
            /* Menambah pembungkus kata */
        }

        div.dt-button-collection .active:after {
            position: absolute;
            right: 1em;
            display: inline-block;
            content: "✓";
            color: inherit;
        }
    </style>
@endpush


@section('content')
    <div class="page-content" x-data="alpineData">
        <div class="row">
            <div class="col-12">
                <h1 class="text-uppercase">Selamat Datang</h1>
                <hr>
            </div>
        </div>


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
                                    <col style="width: 100px;"> <!-- Status WO -->
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
@endsection

@push('script')
    <!--plugins-->
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <!-- highcharts js -->
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/cylinder.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/funnel3d.js') }}"></script>

    {{-- datatable --}}
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>


    <script src="{{ asset('assets/js/index4.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
                                title: 'Status WO',
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
@endpush
