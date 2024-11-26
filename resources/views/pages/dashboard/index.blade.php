@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets-horizontal/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
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
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div id="col-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div id="chart10"></div>
                    </div>
                </div>
            </div>
              <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart11"></div>
                            </div>
                        </div>
                    </div>

        </div>



        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-hover table-sm"
                                style="width:100%">
                                <thead>
                                    <tr id="tableHeader1">
                                        {{-- <th rowspan="2" width="15%">Bulan</th>
                                    <th colspan="3" class="text-center">Koto Panjang</th>
                                    <th colspan="3" class="text-center">Duri</th>
                                    <th colspan="3" class="text-center">Location 3</th> --}}
                                    </tr>
                                    <tr id="tableHeader2">
                                        {{-- <th>Normal</th>
                                    <th>Abnormal</th>
                                    <th>Fault</th>
                                    <th>Normal</th>
                                    <th>Abnormal</th>
                                    <th>Fault</th>
                                    <th>Normal</th>
                                    <th>Abnormal</th>
                                    <th>Fault</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    {{-- <tr>
                                    <td>Januari</td>
                                    <td>12</td>
                                    <td>21</td>
                                    <td>21</td>
                                    <td>12</td>
                                    <td>21</td>
                                    <td>12</td>
                                    <td>12</td>
                                    <td>21</td>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <td>Februari</td>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>1</td>
                                    <td>3</td>
                                    <td>3</td>
                                    <td>1</td>
                                    <td>12</td>
                                    <td>21</td>
                                    <td>12</td>
                                </tr> --}}
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <h6 class="mb-0 text-uppercase">Data Asset Fault and Warning</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4 row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="status" class="col-form-label">Filter Status</label>
                            </div>
                            <div class="col-auto">
                                <select name="status" id="status" class="form-select" x-model="status"
                                    @change="getData">
                                    <option value="">Semua Status</option>
                                    <option value="abnormal">Abnormal</option>
                                    <option value="fault">Fault</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tableAssets" class="table table-striped table-bordered"
                                style="color: #ffffff; table-layout: fixed">
                                <colgroup>
                                    <col style="width: 300px;"> <!-- Lokasi -->
                                    <col style="width: 300px;"> <!-- Unit -->
                                    <col style="width: 300px;"> <!-- No Asset -->
                                    <col style="width: 300px;"> <!-- Nama Asset -->
                                    <col style="width: 300px;"> <!-- Group Asset -->
                                    <col style="width: 300px;"> <!-- Status -->
                                    <col style="width: 300px;"> <!-- No SR -->
                                    <col style="width: 300px;"> <!-- No WO -->
                                    <col style="width: 300px;"> <!-- Tgl Identifikasi -->
                                    <col style="width: 300px;"> <!-- Status WO -->
                                    <col style="width: 300px;"> <!-- Kondisi Asset -->
                                    <col style="width: 300px;"> <!-- Action Plan -->
                                    <col style="width: 300px;"> <!-- Target Selesai -->
                                    <col style="width: 300px;"> <!-- Progress Saat Ini -->
                                    <col style="width: 300px;"> <!-- Realisasi Selesai -->
                                    <col style="width: 300px;"> <!-- Main Issue -->
                                    <col style="width: 300px;"> <!-- Keterangan -->
                                    {{-- <col style="width: 300px;"> <!-- Keterangan --> --}}
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
                status: '',
                location_id: '',
                dataAssets: [],
                headers: [],
                data: [],
                trendLineChartData: [],

                init() {
                    this.getData();

                },
                renderChart() {
                    Highcharts.chart('chart10', {
                        chart: {
                            type: 'line',
                            styledMode: true
                        },
                        title: {
                            text: 'Status Asset Health'
                        },
                        credits: {
                            enabled: false
                        },
                        exporting: {
                            buttons: {
                                contextButton: {
                                    enabled: false,
                                }
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Jumlah Asset'
                            }
                        },
                        xAxis: {
                            categories: this.trendLineChartData.categories
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        plotOptions: {
                            series: {
                                label: {
                                    connectorAllowed: false
                                },
                                pointStart: 0
                            }
                        },
                        series: this.trendLineChartData.series, // Data untuk setiap status
                        colors: ['green', 'yellow', 'red'], // Warna garis
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }
                    });
                },
                  renderPieChart() {
                    // Hitung total data untuk setiap status
                    const totalNormal = this.trendLineChartData.series[0].data.reduce((sum, value) => sum +
                        value, 0);
                    const totalAbnormal = this.trendLineChartData.series[1].data.reduce((sum, value) => sum +
                        value, 0);
                    const totalFault = this.trendLineChartData.series[2].data.reduce((sum, value) => sum +
                        value, 0);

                    // Hitung total keseluruhan
                    const grandTotal = totalNormal + totalAbnormal + totalFault;

                    // Hitung persentase untuk setiap status
                    const dataForPieChart = [{
                            name: 'Normal',
                            y: (totalNormal / grandTotal) * 100
                        },
                        {
                            name: 'Abnormal',
                            y: (totalAbnormal / grandTotal) * 100
                        },
                        {
                            name: 'Fault',
                            y: (totalFault / grandTotal) * 100
                        }
                    ];

                    // Render pie chart menggunakan Highcharts
                    Highcharts.chart('chart11', {
                        chart: {
                            height: 400,
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            styledMode: true
                        },
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: 'Status Asset Distribution'
                        },
                        subtitle: {
                            text: 'Percentage of asset status'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                innerSize: 20,
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Status',
                            colorByPoint: true,
                            data: dataForPieChart
                        }],
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    plotOptions: {
                                        pie: {
                                            innerSize: 140,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    }
                                }
                            }]
                        }
                    });

                },


                async getData() {
                    this.isLoading = true;
                    try {
                        const response = await axios.get('{{ route('getReportData') }}', {
                            params: {
                                location_id: this.location_id,
                                status: this.status
                            }
                        });
                        this.reports = response.data.charts;
                        this.dataAssets = response.data.table;
                        this.headers = response.data.monthlyReport.headers;
                        this.data = response.data.monthlyReport.data;
                        this.trendLineChartData = response.data.trendLineChart;
                        console.log(this.trendLineChartData);
                        this.isLoading = false;
                        // this.loadCharts()



                        if (this.location_id == '') {
                            this.$nextTick(() => {
                                this.loadCharts();
                                this.initializeDataTableMonthAll();
                                this.initializeDataTable();
                                this.renderChart();
                                   this.renderPieChart();
                            });
                        } else {
                            // this.loadCharts()
                            this.$nextTick(() => {
                                this.loadCharts();
                                this.initializeDataTableMonth();
                                this.initializeDataTable();
                                this.renderChart();
                                   this.renderPieChart();
                            });

                        }

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
                                title: 'Status',
                                render: function(data, type, row) {
                                    let className = '';

                                    if (data === 'normal') {
                                        className = 'text-success';
                                    } else if (data === 'abnormal') {
                                        className = 'text-warning';
                                    } else if (data === 'fault') {
                                        className = 'text-danger';
                                    }

                                    return `<span class="${className} text-uppercase fw-bold">${data}</span>`;
                                }
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
                            },
                            // {
                            //     title: 'Aksi',
                            //     orderable: false,
                            //     searchable: false,
                            //     render: function(data, type, row) {
                            //         return `
                            //             <button onclick="viewAssetDetails('${row.asset.id}')" class="btn btn-info btn-sm">
                            //                 Lihat Detail
                            //             </button>
                            //         `;
                            //     }
                            // }
                        ],
                        lengthChange: false,
                        buttons: ['colvis', 'excel'],
                    });



                    // Append buttons to the desired location
                    $('#tableAssets').DataTable().buttons().container()
                        .appendTo('#tableAssets_wrapper .col-md-6:eq(0)');
                },
                initializeDataTableMonthAll() {
                    const headers = this.headers; // Data untuk header lokasi dan kolom
                    const data = this.data; // Data bulan dengan data untuk setiap lokasi

                    // Function untuk generate table header
                    function generateTableHeader() {
                        let header1 = document.getElementById('tableHeader1');
                        let header2 = document.getElementById('tableHeader2');

                        // Clear konten sebelumnya
                        header1.innerHTML = '';
                        header2.innerHTML = '';

                        // Menambahkan baris pertama (judul lokasi)
                        header1.innerHTML = '<th rowspan="2" width="15%">Bulan</th>';
                        headers.forEach(header => {
                            header1.innerHTML +=
                                `<th colspan="3" class="text-center">${header.location}</th>`;
                        });

                        // Menambahkan baris kedua (kolom-kolom untuk setiap lokasi)
                        headers.forEach(header => {
                            header.columns.forEach(col => {
                                let className = '';

                                // Check the value of col and assign a class based on its status
                                if (col === 'Normal') {
                                    className = 'text-success';
                                } else if (col === 'Abnormal') {
                                    className = 'text-warning';
                                } else if (col === 'Fault') {
                                    className = 'text-danger';
                                }

                                // Add the <th> element with the appropriate class
                                header2.innerHTML +=
                                    `<th class="${className}">${col}</th>`;
                            });
                        });

                    }

                    // Function untuk generate table body
                    function generateTableBody() {
                        let tableBody = document.getElementById('tableBody');

                        // Clear baris sebelumnya
                        tableBody.innerHTML = '';

                        // Menampilkan data dari bawah ke atas
                        const reversedData = data.reverse(); // Membalikkan urutan data

                        // Menambahkan data untuk setiap bulan
                        reversedData.forEach(row => {
                            let tableRow = `<tr><td>${row.month}</td>`;

                            // Menambahkan data untuk setiap lokasi yang ada dalam headers
                            headers.forEach(header => {
                                header.columns.forEach((col, index) => {
                                    // Ambil data berdasarkan nama lokasi dan kolom
                                    const locationKey = header.location
                                        .toLowerCase().replace(' ',
                                            ''
                                        ); // Mengambil nama lokasi dan memodifikasinya untuk key
                                    const value = row[locationKey][
                                        index
                                    ]; // Mengakses data sesuai dengan lokasi dan kolom
                                    tableRow += `<td>${value}</td>`;
                                });
                            });

                            tableRow += '</tr>';
                            tableBody.innerHTML += tableRow;
                        });
                    }

                    // Generate table
                    generateTableHeader();
                    generateTableBody();

                },
                initializeDataTableMonth() {
                    const headers = this.headers; // Get headers (locations and columns)
                    const data = this.data; // Get data for each month (Normal, Abnormal, Fault)

                    // Function to generate the table header
                    function generateTableHeader() {
                        let header1 = document.getElementById('tableHeader1');
                        let header2 = document.getElementById('tableHeader2');

                        // Clear previous content
                        header1.innerHTML = '';
                        header2.innerHTML = '';

                        // Add first row (location headers)
                        header1.innerHTML = '<th rowspan="2" width="15%">Bulan</th>';
                        headers.forEach(header => {
                            header1.innerHTML +=
                                `<th colspan="3" class="text-center">${header.location}</th>`;
                        });

                        // Menambahkan baris kedua (kolom-kolom untuk setiap lokasi)
                        headers.forEach(header => {
                            header.columns.forEach(col => {
                                let className = '';

                                // Check the value of col and assign a class based on its status
                                if (col === 'Normal') {
                                    className = 'text-success';
                                } else if (col === 'Abnormal') {
                                    className = 'text-warning';
                                } else if (col === 'Fault') {
                                    className = 'text-danger';
                                }

                                // Add the <th> element with the appropriate class
                                header2.innerHTML +=
                                    `<th class="${className}">${col}</th>`;
                            });
                        });
                    }

                    // Function to generate the table body
                    function generateTableBody() {
                        let tableBody = document.getElementById('tableBody');

                        // Clear previous rows
                        tableBody.innerHTML = '';

                        // Reverse the data so the latest month comes first
                        const reversedData = Object.entries(data)
                            .reverse(); // Convert the object into an array of [month, data]

                        // Add data for each month
                        reversedData.forEach(([month, row]) => {
                            let tableRow = `<tr><td>${month}</td>`;

                            headers.forEach(header => {
                                header.columns.forEach((col) => {
                                    // For each location and each column (Normal, Abnormal, Fault), we get the value from the row
                                    let value =
                                        '0'; // Default value for missing data
                                    if (row[col] && row[col][header
                                            .location
                                        ]) {
                                        value = row[col][header
                                            .location
                                        ];
                                    }
                                    tableRow += `<td>${value}</td>`;
                                });
                            });

                            tableRow += '</tr>';
                            tableBody.innerHTML += tableRow;
                        });


                    }

                    // Generate table
                    generateTableHeader();
                    generateTableBody();

                }

            }));
        });

        // Fungsi untuk menangani klik tombol 'Lihat Detail'
        function viewAssetDetails(assetId) {
            // Arahkan ke halaman detail atau tampilkan modal berdasarkan assetId
            window.location.href = `/asset-management/assets/detail/${assetId}`; // Contoh mengarahkan ke halaman detail
        }
    </script>
@endpush
