@extends('layouts.main')
@section('content')
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
    <div class="page-content">
        <!--breadcrumb-->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Asset Report</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"> <a href="javascript:history.back()">Asset
                                Report</a></li>


                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />

        @include('components.buttonBack')



        <div class="card radius-10">
            <div class="card-body">
                <div class="alert alert-success" role="alert" id="statusAlert" style="display: none">
                </div>
                <h6 class="mb-0 font-weight-bold">Detail Report</h6>
                <hr>

                <div class=" text-start">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive mt-4">
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
                                                : {{ $detailReport->reportAsset->asset->assetGroup->name }}
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
                                                : {{ $detailReport->reportAsset->asset->no_asset }}
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
                                                : {{ $detailReport->reportAsset->asset->name }}
                                            </td>

                                        </tr>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      
                        <div class="col">
                               <div id="chart1"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <div class="d-lg-flex align-items-center mb-4 gap-3">



                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No SR</th>
                                <th>No WO</th>
                                <th>Tanggal Identifikasi</th>
                                <th>Status SR</th>
                                <th>Kondisi Asset</th>
                                <th>Action Plan</th>
                                <th>Progres Saat ini</th>
                                <th>Target Selesai</th>
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
                                        <td>{{ $dr->progress_saat_ini }}</td>
                                        <td>{{ $dr->target_selesai }}</td>
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
@endsection


@push('script')
    <!-- Load jQuery and DataTables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



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

    <script>
        $(function() {
            "use strict";

            // chart 5
            Highcharts.chart('chart1', {
                chart: {
                    type: 'line',
                    styledMode: true
                },
                title: {
                    text: 'Status Asset per Bulan'
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
                        text: 'Jumlah'
                    },
                    min: 0 // Menetapkan nilai minimum untuk sumbu Y
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ],
                    title: {
                        text: 'Bulan'
                    }
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
                        // Menambahkan data labels untuk setiap titik
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}' // Menampilkan nilai di titik data
                        }
                    }
                },
                series: [{
                    name: 'Normal',
                    data: [30, 40, 25, 50, 60, 80, 90, 70, 60, 50, 45, 55]
                }, {
                    name: 'Abnormal',
                    data: [10, 15, 5, 20, 25, 30, 35, 20, 15, 10, 12, 18]
                }, {
                    name: 'Fault',
                    data: [5, 10, 15, 10, 8, 6, 5, 7, 8, 12, 15, 20]
                }],
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
        });
    </script>






    <script>
        async function changeStatus(id) {
            var status = document.getElementById('status').value;
            var statusAlert = document.getElementById('statusAlert');

            try {
                let response = await axios.post('{{ route('assetHealthReport.changeStatus') }}', {
                    id: id,
                    status: status
                });

                showAlert(response.data.message, 'success', statusAlert);
            } catch (error) {
                console.log(error);
                let errorMessage = error.response && error.response.data.message ?
                    error.response.data.message :
                    'Something went wrong';

                showAlert(errorMessage, 'error', statusAlert);
            }
        }

        function showAlert(message, type, element) {
            element.innerHTML = message;
            element.style.display = 'block';

            setTimeout(function() {
                element.style.display = 'none';
            }, 3000);
        }
    </script>



    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

        $(document).ready(function() {
            var table = $('#example2').DataTable();

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        $(document).ready(function() {
            // var table = $('#example2').DataTable();

            // table.buttons().container()
            //     .appendTo('#example2_wrapper .col-md-6:eq(0)');

            $('#addSR').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    theme: "bootstrap-5",
                    width: function() {
                        return $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                            'w-100') ? '100%' : 'style';
                    },
                    placeholder: function() {
                        return $(this).data('placeholder');
                    },
                    closeOnSelect: false,
                    tags: true,
                    dropdownParent: $(this).find('.modal-body')
                });
            });

            // Inisialisasi Select2 pada modal edit dengan ID dinamis
            $(document).on('shown.bs.modal', '[id^="editSR_"]', function() {
                $(this).find('.select2-edit').select2({
                    theme: "bootstrap-5",
                    width: function() {
                        return $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                            'w-100') ? '100%' : 'style';
                    },
                    placeholder: function() {
                        return $(this).data('placeholder');
                    },
                    closeOnSelect: false,
                    tags: true,
                    dropdownParent: $(this).find('.modal-body')
                });
                $(this).find('.select2-edit-ProgresSaatini').select2({
                    theme: "bootstrap-5",
                    width: function() {
                        return $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                            'w-100') ? '100%' : 'style';
                    },
                    placeholder: function() {
                        return $(this).data('placeholder');
                    },
                    closeOnSelect: false,
                    tags: true,
                    dropdownParent: $(this).find('.modal-body')
                });
            });

            // Reset Select2 ketika modal edit ditutup
            $(document).on('hidden.bs.modal', '[id^="editSR_"]', function() {
                $(this).find('.select2-edit').select2('destroy'); // Hapus Select2 dari elemen dalam modal
                $(this).find('.select2-edit-ProgresSaatini').select2(
                    'destroy'); // Hapus Select2 dari elemen dalam modal

            });



        });
    </script>

    <script>
        function deleteConfirm(event, id) {
            event.preventDefault(); // Mencegah submit form secara default

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form_' + id).submit(); // Kirim form setelah konfirmasi
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    );
                }
            });
        }
    </script>
@endpush
