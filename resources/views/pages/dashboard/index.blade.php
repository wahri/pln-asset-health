@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush


@section('content')
    <div class="page-content" x-data="alphineData">
        <div class="row">
            <div class="col-12">
                <h1 class="text-uppercase">Selamat Datang</h1>
                <hr>
            </div>
        </div>


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
                dataLocationAll: [],
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

                grupmontData(data) {
                    const monthOrder = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November",
                        "Desember"
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

                    return latestMonthData;

                },

                async getDataChart(id) {
                    try {
                        let responseLocation = await axios.post(
                            '{{ route('dashboard.getDataChart') }}', {
                                id: id
                            });

                        const data = responseLocation.data;
                        this.data = data;

                        if (id !== null) {
                            this.getGroupedDataLocation(data);
                        } else {
                            this.loadDataChart(data);
                        }

                        console.log(data);
                        // load data apexChart
                        this.getGroupedData(data);

                    } catch (error) {
                        console.error("Error fetching chart data:", error);
                        return null;
                    }
                },
                loadDataChart(data) {

                    let charts = null;
                    const hasUndefinedUnit = data.some(item => item.location === undefined);

                    if (hasUndefinedUnit) {
                        charts = this.grupmontData(this.data);
                    } else {
                        charts = data;
                    }

                    "use strict";
                    const chartContainer = document.getElementById('chartContainer');
                    chartContainer.innerHTML = '';
                    charts.map((item, index) => {
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
                                text: item.location ? item.location : item.unit,
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
                            const chartElement = document.getElementById(
                                chartElementId);

                            if (!chartElement) {
                                console.error(
                                    `charts element not found for index: ${index + 1}`
                                );
                                return; // Lewatkan jika elemen tidak ditemukan
                            }

                            // Hancurkan instance chart jika ada
                            const existingChart = chartElement.chartInstance;
                            if (existingChart) {
                                existingChart
                                    .destroy(); // Hancurkan chart yang sudah ada
                            }

                            // Ambil data untuk grafik dari unit
                            const months = unitData.data.map(item => item.month ||
                                ''); // Menghindari undefined
                            const normalData = unitData.data.map(item => item.normal ||
                                0); // Ubah menjadi 0 jika undefined
                            const abnormalData = unitData.data.map(item => item
                                .abnormal || 0); // Ubah menjadi 0 jika undefined
                            const faultData = unitData.data.map(item => item.fault ||
                                0); // Ubah menjadi 0 jika undefined

                            const options = {
                                series: [{
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
                                location: item.location,
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

                    console.log(this.dataTables);


                    this.loadDataApexChart(this.dataTables);



                },
                getGroupedDataLocation(data) {
                    const groupedData = data.reduce((acc, item) => {
                        // Cek apakah lokasi sudah ada di accumulator
                        let existingLocation = acc.find(location => location.location === item
                            .location);

                        if (existingLocation) {
                            // Jika lokasi sudah ada, tambahkan nilai status ke total
                            existingLocation.normal += item.normal;
                            existingLocation.abnormal += item.abnormal;
                            existingLocation.fault += item.fault;
                        } else {
                            // Jika lokasi belum ada, tambahkan lokasi baru dengan nilai status awal
                            acc.push({
                                location: item.location,
                                normal: item.normal,
                                abnormal: item.abnormal,
                                fault: item.fault
                            });
                        }
                        return acc;
                    }, []);

                    // Setelah data dikelompokkan, Anda bisa menggunakannya
                    this.loadDataChart(groupedData);
                }







            }))

        })
    </script>
@endpush
