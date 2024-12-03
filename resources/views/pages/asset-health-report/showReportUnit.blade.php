@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        /* Untuk membungkus teks di semua kolom tabel */
        #tableAssets th,
        #tableAssets td {
            white-space: pre-line;
            /* Membuat teks membungkus di dalam kolom */
            word-wrap: break-word;
            /* Menambah pembungkus kata */
        }
    </style>
@endpush
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="mb-3 page-breadcrumb d-none d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3">Asset Wellness Report</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"> <a
                                href="{{ route('assetHealthReport.index') }}">Lokasi Unit Pembangkit</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('assetHealthReport.showLocation', $location->name) }}">
                                {{ $location->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:history.back()">
                                {{ date('F Y', strtotime($report->date)) }}


                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $unit->name }}</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />
        @include('components.buttonBack')

        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    @include('components.alert')
                </div>

                <div class="table-responsive">
                    <table id="tableAssets" class="table table-striped table-bordered"
                    style="color: #ffffff; table-layout: fixed">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th width="100px">Action</th>
                                <th width="60px">Status</th>
                                <th width="250px">System</th>
                                <th width="250px">Asset</th>
                                <th width="100px">No SR</th>
                                <th width="100px">No WO</th>
                                <th width="100px">Tanggal Identifikasi</th>
                                <th width="100px">Status WO</th>
                                <th width="300px">Kondisi Asset</th>
                                <th width="300px">Action Plan</th>
                                <th width="100px">Target Selesai</th>
                                <th width="100px">Progres Saat Ini</th>
                                <th width="100px">Realisasi Selesai</th>
                                <th width="200px">Main Issue</th>
                                <th width="200px">Keterangan</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($assets as $ra)
                                @if ($ra->reportAssets->isEmpty())
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('assetHealthReport.detailReportAsset', $ra->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bx bx-plus-circle"></i> Report</a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $ra->status_class }}">
                                                {{ ucfirst($ra->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $ra->assetGroup->name }}</td>
                                        <td>{{ $ra->name }}</td>
                                        <td></td> <!-- No SR -->
                                        <td></td> <!-- No WO -->
                                        <td></td> <!-- Tanggal Identifikasi -->
                                        <td></td> <!-- Status WO -->
                                        <td></td> <!-- Kondisi Asset -->
                                        <td></td> <!-- Action Plan -->
                                        <td></td> <!-- Target Selesai -->
                                        <td></td> <!-- Progres Saat Ini -->
                                        <td></td> <!-- Realisasi Selesai -->
                                        <td></td> <!-- Main Issue -->
                                        <td></td> <!-- Keterangan -->
                                    </tr>
                                @else
                                    @foreach ($ra->reportAssets as $reportAsset)
                                        @foreach ($reportAsset->detailReports as $detail)
                                            <tr class="align-middle">
                                                <td class="text-center">
                                                    {{ $loop->parent->parent->iteration }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('assetHealthReport.detailReportAsset', $reportAsset->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="bx bx-plus-circle"></i> Report</a>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $reportAsset->status_class }}">
                                                        {{ ucfirst($reportAsset->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $ra->assetGroup->name }}</td>
                                                <td>{{ $ra->name }}</td>
                                                <td>{{ $detail->no_sr }}</td>
                                                <td>{{ $detail->no_wo }}</td>
                                                <td>{{ $detail->tanggal_identifikasi }}</td>
                                                <td>{{ $detail->status_sr }}</td>
                                                <td>{{ $detail->kondisi_asset }}</td>
                                                <td>{{ $detail->action_plan }}</td>
                                                <td>{{ $detail->target_selesai }}</td>
                                                <td>{{ $detail->progress_saat_ini }}</td>
                                                <td>{{ $detail->realisasi_selesai }}</td>
                                                <td>{{ $detail->issue }}</td>
                                                <td>{{ $detail->keterangan }}</td>
                                            </tr>
                                        @endforeach
                                        <!-- If reportAssets has no detailReports, still show a row with empty values -->
                                        @if ($reportAsset->detailReports->isEmpty())
                                            <tr class="align-middle">
                                                <td>{{ $loop->parent->iteration }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('assetHealthReport.detailReportAsset', $reportAsset->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="bx bx-plus-circle"></i> Report</a>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $reportAsset->status_class }}">
                                                        {{ ucfirst($reportAsset->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $ra->assetGroup->name }}</td>
                                                <td>{{ $ra->name }}</td>
                                                <td></td> <!-- No SR -->
                                                <td></td> <!-- No WO -->
                                                <td></td> <!-- Tanggal Identifikasi -->
                                                <td></td> <!-- Status WO -->
                                                <td></td> <!-- Kondisi Asset -->
                                                <td></td> <!-- Action Plan -->
                                                <td></td> <!-- Target Selesai -->
                                                <td></td> <!-- Progres Saat Ini -->
                                                <td></td> <!-- Realisasi Selesai -->
                                                <td></td> <!-- Main Issue -->
                                                <td></td> <!-- Keterangan -->
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
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


    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#tableAssets').DataTable({
                buttons: ['pageLength', 'colvis', 'excel'],
                dom: 'Bfrtip' // untuk menampilkan tombol di atas tabel
            });
        });


        // $(document).ready(function() {
        //     var table = $('#example2').DataTable();

        //     table.buttons().container()
        //         .appendTo('#example2_wrapper .col-md-6:eq(0)');
        // });

        // Inisialisasi Select2 pada modal edit dengan ID dinamis
        $(document).on('shown.bs.modal', '[id^="editReport_"]', function() {
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
        });

        // Reset Select2 ketika modal edit ditutup
        $(document).on('hidden.bs.modal', '[id^="editReport_"]', function() {
            $(this).find('.select2-edit').select2('destroy'); // Hapus Select2 dari elemen dalam modal
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
