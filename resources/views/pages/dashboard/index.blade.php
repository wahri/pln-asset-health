@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush


@section('content')
    <div class="page-content" x-data="alphineData">
        {{-- <div class="row row-cols-1 row-cols-lg-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Goal Completions</p>
                                <h4 class="font-weight-bold">1,94,2335</h4>
                                <p class="mb-0 text-secondary font-13">Analytics for last month</p>
                            </div>
                            <div class="text-white widgets-icons bg-gradient-kyoto"><i class='bx bxs-cube'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Bounce Rate</p>
                                <h4 class="font-weight-bold">58% <small class="text-danger font-13">(-16%)</small></h4>
                                <p class="mb-0 text-secondary font-13">Analytics for last week</p>
                            </div>
                            <div class="text-white widgets-icons bg-gradient-blues"><i class='bx bx-line-chart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">New Sessions</p>
                                <h4 class="font-weight-bold">96% <small class="text-danger font-13">(+54%)</small></h4>
                                <p class="mb-0 text-secondary font-13">Analytics for last week</p>
                            </div>
                            <div class="text-white widgets-icons bg-gradient-moonlit"><i class='bx bx-bar-chart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="p-4 card-body">
                        <form id="form" @submit.prevent>
                            <div class="form-group">
                                <label class="form-label" for="locationSelect">Select Location</label>
                                <select class="form-select select2" id="exampleFormControlSelect1"
                                    @change="setSelectedLocation($event.target.value)">
                                    <option selected>Pilih Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <button class="mt-3 btn btn-primary" @click="getDataChart(selectedLocation)">Submit</button> --}}
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <div class="row" id="chartContainer" x-init="getDataChart()">
            {{-- <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart3"></div>
                    </div>
                </div>
            </div> --}}
        </div>

        <template x-for="(d,index) in dataTables" :key="index">
            <div class="row">
                <div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
                    <div class="card radius-10 w-100">
                        <div class="mb-2 bg-transparent card-header font-weight-bold mb-lg-0" x-text="d.unit"></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th class="text-success">Normal</th>
                                            <th class="text-warning">Abnormal</th>
                                            <th class="text-danger">Fault</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <template x-for="(data,index) in d.data" :key="index">

                                            <tr>
                                                <td x-text = "data.month"></td>
                                                <td x-text="data.normal"></td>
                                                <td x-text="data.abnormal"></td>
                                                <td x-text="data.fault"></td>
                                            </tr>

                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="bg-transparent card-header border-bottom-0">
                            <div class="d-lg-flex align-items-center">
                                <div>
                                    <h6 class="mb-2 font-weight-bold mb-lg-0">Historical Analytics</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <div class="cursor-pointer text-dark font-24 dropdown-toggle dropdown-toggle-nocaret"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded text-option"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javaScript:;">Action</a>
                                        <a class="dropdown-item" href="javaScript:;">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javaScript:;">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" >
                            <div class="gap-2 d-flex align-items-center ms-auto font-13">
                                <span class="px-1 border rounded cursor-pointer"><i
                                        class="bx bxs-circle text-success me-1"></i>Normal</span>
                                <span class="px-1 border rounded cursor-pointer"><i
                                        class="bx bxs-circle text-warning me-1"></i>Abnormal</span>
                                <span class="px-1 border rounded cursor-pointer"><i
                                        class="bx bxs-circle text-danger me-1"></i>Fault</span>
                            </div>
                            <div :id="'charts' + (index + 1)"></div> <!-- Dynamic chart ID -->
                        </div>
                    </div>
                </div>
            </div>
        </template>


    </div>
@endsection

@push('script')
    <!-- highcharts js -->
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/cylinder.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/funnel3d.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/index4.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                $('#exampleFormControlSelect1').select2({
                    theme: "bootstrap-5",
                    width: '100%', // Sesuaikan dengan lebar elemen
                    placeholder: 'Pilih opsi', // Placeholder dapat disesuaikan
                    closeOnSelect: false,
                });
            });


        });
    </script>



    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alphineData', () => ({
                open: false,
                data: [],
                dataTables: null,
                selectedLocation: null,

                init() {
                    // Inisialisasi Select2
                    $('#exampleFormControlSelect1').on('change', (e) => {
                        const selectedValue = $(e.target).val(); // Mengambil nilai yang dipilih
                        this.setSelectedLocation(
                            selectedValue); // Memanggil fungsi untuk set lokasi terpilih
                    });
                },

                setSelectedLocation(value) {
                    this.getDataChart(value);

                    this.selectedLocation = value; // Menyimpan ID lokasi yang dipilih
                },

                async getDataChart(id) {

                    try {
                        let response = await axios.post('{{ route('dashboard.getDataChart') }}', {
                            id: id
                        });



                        const data = response.data;
                        this.data = data;

                        /// Array untuk urutan bulan
                        const monthOrder = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];

                        // Menambahkan properti 'monthIndex' untuk sorting
                        data.forEach(item => {
                            item.monthIndex = monthOrder.indexOf(item.date);
                        });

                        // Mengurutkan data berdasarkan monthIndex
                        const sortedData = data.sort((a, b) => a.monthIndex - b.monthIndex);

                        // Mengambil bulan terkini
                        const latestMonthIndex = sortedData[sortedData.length - 1].monthIndex;
                        const latestMonthName = monthOrder[latestMonthIndex];

                        // Memfilter data untuk mendapatkan semua entri dengan bulan terkini
                        const latestMonthData = sortedData.filter(item => item.date ===
                            latestMonthName);


                        this.loadDataChart(latestMonthData);
                        this.getGroupedData(data);
                        // this.loadDataApexChart(data);

                    } catch (error) {
                        console.error("Error fetching chart data:", error);
                        return null;
                    }
                },
                loadDataChart(data) {


                    "use strict";

                    const chartContainer = document.getElementById('chartContainer');
                    chartContainer.innerHTML = '';

                    data.map((item, index) => {

                        const chartName = 'chart' + (index +
                            1);

                        const cardDiv = document.createElement('div');
                        cardDiv.className = "col-12 col-lg-4";

                        cardDiv.innerHTML = `
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div id="${chartName}" style="height: 350px;"></div>
                                </div>
                            </div>
                        `;
                        chartContainer.appendChild(cardDiv);

                        Highcharts.chart(chartName, {
                            chart: {
                                height: 350,
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: "pie",
                                styledMode: true,
                            },
                            credits: {
                                enabled: false,
                            },
                            title: {
                                text: item.unit,
                            },
                            subtitle: {
                                text: "Ratio of systems monitored",
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
                                    allowPointSelect: true,
                                    cursor: "pointer",
                                    innerSize: 120,
                                    dataLabels: {
                                        enabled: true,
                                        format: "<b>{point.name}</b>: {point.percentage:.1f} %",
                                    },
                                    showInLegend: true,
                                },
                            },
                            //colors: ['#ff9ad5', '#50b5ff', '#5a65dc'],
                            series: [{
                                name: "Unit",
                                colorByPoint: true,
                                data: [{
                                        name: "Normal",
                                        y: item.normal,
                                    },
                                    {
                                        name: "Abnormal",
                                        y: item.abnormal,
                                    },
                                    {
                                        name: "Fault",
                                        y: item.fault,
                                    },
                                ],
                            }, ],
                            responsive: {
                                rules: [{
                                    condition: {
                                        maxWidth: 500,
                                    },
                                    chartOptions: {
                                        plotOptions: {
                                            pie: {
                                                innerSize: 140,
                                                dataLabels: {
                                                    enabled: false,
                                                },
                                            },
                                        },
                                    },
                                }, ],
                            },
                        });

                    });

                },

             loadDataApexChart(data) {
    "use strict";

    // Memastikan panjang data
    if (!Array.isArray(data) || data.length === 0) {
        console.error("Data is empty or not an array");
        return;
    }

    // Menunggu semua elemen dirender sebelum memulai
    this.$nextTick(() => {
        // Loop melalui setiap unit data
        data.forEach((unitData, index) => {
            const chartElementId = 'charts' + (index + 1);
            const chartElement = document.getElementById(chartElementId);

            if (!chartElement) {
                console.error(`charts element not found for index: ${index + 1}`);
                return; // Lewatkan jika elemen tidak ditemukan
            }

            // Hancurkan instance chart jika ada
            const existingChart = chartElement.chartInstance;
            if (existingChart) {
                existingChart.destroy(); // Hancurkan chart yang sudah ada
            }

            // Ambil data untuk grafik dari unit
            const months = unitData.data.map(item => item.month || ''); // Menghindari undefined
            const normalData = unitData.data.map(item => item.normal || 0); // Ubah menjadi 0 jika undefined
            const abnormalData = unitData.data.map(item => item.abnormal || 0); // Ubah menjadi 0 jika undefined
            const faultData = unitData.data.map(item => item.fault || 0); // Ubah menjadi 0 jika undefined

            const options = {
                series: [
                    {
                        name: "Normal",
                        data: normalData,
                    },
                    {
                        name: "Abnormal",
                        data: abnormalData,
                    },
                    {
                        name: "Fault",
                        data: faultData,
                    }
                ],
                chart: {
                    foreColor: "#9a9797",
                    type: "bar",
                    height: 320,
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "18%",
                    },
                },
                legend: {
                    show: false,
                    position: "top",
                    horizontalAlign: "left",
                    offsetX: -20,
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                colors: ["#198754", "#ffc107", "#dc3545"],
                xaxis: {
                    categories: months, // Menggunakan bulan dari data
                },
                fill: {
                    opacity: 1,
                },
                grid: {
                    show: true,
                    borderColor: "rgba(0, 0, 0, 0.15)",
                    strokeDashArray: 4,
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 310,
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "30%",
                            },
                        },
                    },
                }],
            };

            // Membuat instance chart dan merender
            const chartInstance = new ApexCharts(chartElement, options);
            chartInstance.render().then(() => {
                // Simpan instance chart ke elemen untuk akses selanjutnya
                chartElement.chartInstance = chartInstance;
            }).catch(err => {
                console.error('Error rendering chart:', err);
            });
        });
    });
},



                getGroupedData(data) {


                    const groupedData = data.reduce((acc, item) => {
                        // Cek apakah unit sudah ada di accumulator
                        const existingUnit = acc.find(unit => unit.unit === item.unit);

                        if (existingUnit) {
                            // Cek apakah bulan sudah ada di dalam data unit
                            const monthData = existingUnit.data.find(month => month.month ===
                                item.date.toLowerCase());

                            if (monthData) {
                                // Jika bulan sudah ada, tambahkan nilai
                                monthData.normal += item.normal;
                                monthData.abnormal += item.abnormal;
                                monthData.fault += item.fault;
                            } else {
                                // Jika bulan belum ada, tambahkan data bulan baru
                                existingUnit.data.push({
                                    month: item.date.toLowerCase(),
                                    normal: item.normal,
                                    abnormal: item.abnormal,
                                    fault: item.fault
                                });
                            }
                        } else {
                            // Jika unit belum ada, tambahkan unit baru
                            acc.push({
                                unit: item.unit,
                                data: [{
                                    month: item.date.toLowerCase(),
                                    normal: item.normal,
                                    abnormal: item.abnormal,
                                    fault: item.fault
                                }]
                            });
                        }
                        return acc;
                    }, []);

                    this.dataTables = groupedData;


                    this.loadDataApexChart(this.dataTables);



                }







            }))

        })
    </script>
@endpush
