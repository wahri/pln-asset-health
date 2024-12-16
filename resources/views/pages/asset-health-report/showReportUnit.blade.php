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
    <div class="page-content" x-data="alpineData">
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

                <div class="text-start">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    Column Visibility
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Action') ? 'active' : ''"
                                            @click="toggleColumn('Action')">Action</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Status') ? 'active' : ''"
                                            @click="toggleColumn('Status')">Status</button>
                                    </li>

                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('System') ? 'active' : ''"
                                            @click="toggleColumn('System')">System</button>
                                    </li>

                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Asset') ? 'active' : ''"
                                            @click="toggleColumn('Asset')">Asset</button>
                                    </li>


                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('No SR') ? 'active' : ''"
                                            @click="toggleColumn('No SR')">No SR</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('No WO') ? 'active' : ''"
                                            @click="toggleColumn('No WO')">No WO</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Tgl Identifikasi') ? 'active' : ''"
                                            @click="toggleColumn('Tgl Identifikasi')">Tgl Identifikasi</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Status Wo') ? 'active' : ''"
                                            @click="toggleColumn('Status Wo')">Status Wo</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Kondisi Asset') ? 'active' : ''"
                                            @click="toggleColumn('Kondisi Asset')">Kondisi Asset</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Action Plan') ? 'active' : ''"
                                            @click="toggleColumn('Action Plan')">Action Plan</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Target Selesai') ? 'active' : ''"
                                            @click="toggleColumn('Target Selesai')">Target Selesai</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Progres Saat ini') ? 'active' : ''"
                                            @click="toggleColumn('Progres Saat ini')">Progres Saat ini</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Realisasi selesai') ? 'active' : ''"
                                            @click="toggleColumn('Realisasi selesai')">Realisasi selesai</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Main Issue') ? 'active' : ''"
                                            @click="toggleColumn('Main Issue')">Main Issue</button>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm dropdown-item"
                                            :class="!isColumnHidden('Keterangan') ? 'active' : ''"
                                            @click="toggleColumn('Keterangan')">Keterangan</button>
                                    </li>
                                </ul>
                                {{-- <button class="btn btn-sm btn-success" @click="exportToExcel(dataAssets)" ><i class='bx bx-export'></i> Excel</button> --}}
                            </div>


                        </div>
                        <div class="col">

                        </div>
                        <div class="col">
                            <form action="{{ route('assetHealthReport.showReportUnit', [$location->id, $report->id, $unit->id]) }}" method="get">
                                @csrf
                            <div class="input-group flex-nowrap">
                                <input x-model="search" type="search" name="search" class="form-control"
                                    placeholder="Search Asset" aria-label="search" aria-describedby="addon-wrapping">
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4" x-data="{ isDragging: false, startX: 0, scrollLeft: 0 }"
                    x-on:mousedown="isDragging = true; startX = $event.pageX - $el.offsetLeft; scrollLeft = $el.scrollLeft"
                    x-on:mousemove="if(isDragging) { $el.scrollLeft = scrollLeft - ($event.pageX - $el.offsetLeft - startX) }"
                    x-on:mouseup="isDragging = false" x-on:mouseleave="isDragging = false">
                    <table id="tableAssets" class="table table-striped table-bordered table-hover"
                        style="color: #ffffff; table-layout: fixed;font-size:12px">
                        <thead>
                            <tr>

                                <th width="100px" x-show="!isColumnHidden('Action')">Action</th>
                                <th width="75px" x-show="!isColumnHidden('Status')">Status</th>
                                <th width="250px" x-show="!isColumnHidden('System')">System</th>
                                <th width="250px" x-show="!isColumnHidden('Asset')">Asset</th>
                                <th width="60px" x-show="!isColumnHidden('No SR')">No SR</th>
                                <th width="65px" x-show="!isColumnHidden('No WO')">No WO</th>
                                <th width="125px" x-show="!isColumnHidden('Tgl Identifikasi')">Tanggal Identifikasi</th>
                                <th width="100px" x-show="!isColumnHidden('Status Wo')">Status WO</th>
                                <th width="300px" x-show="!isColumnHidden('Kondisi Asset')">Kondisi Asset</th>
                                <th width="300px" x-show="!isColumnHidden('Action Plan')">Action Plan</th>
                                <th width="60px" x-show="!isColumnHidden('Target Selesai')">Target Selesai</th>
                                <th width="100px" x-show="!isColumnHidden('Progres Saat ini')">Progres Saat Ini</th>
                                <th width="70px" x-show="!isColumnHidden('Realisasi selesai')">Realisasi Selesai</th>
                                <th width="200px" x-show="!isColumnHidden('Main Issue')">Main Issue</th>
                                <th width="200px" x-show="!isColumnHidden('Keterangan')">Keterangan</th>

                            </tr>
                        </thead>









                        <tbody>
                            @foreach ($assets as $ra)
                                @foreach ($ra->reportAssets as $item)
                                    @foreach ($item->detailReports as $index => $detail)
                                        <tr>

                                            @if ($loop->first)
                                                <td rowspan="{{ $item->detailReports->count() }}" class="align-middle"
                                                    x-show="!isColumnHidden('Action')">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href="{{ route('assetHealthReport.detailReportAsset', $item->id) }}"
                                                            class="btn btn-primary btn-sm "><i
                                                                class="bx bx-plus-circle"></i>
                                                            Report</a>
                                                    </div>
                                                </td>
                                                <td rowspan="{{ $item->detailReports->count() }}" class="align-middle"
                                                    x-show="!isColumnHidden('Status')">
                                                    @if ($item->status == 'normal')
                                                        <span
                                                            class="badge bg-success text-uppercase fw-bold">{{ $item->status }}</span>
                                                    @elseif ($item->status == 'abnormal')
                                                        <span
                                                            class="badge bg-warning text-dark text-uppercase fw-bold">{{ $item->status }}</span>
                                                    @elseif ($item->status == 'fault')
                                                        <span
                                                            class="badge bg-danger text-uppercase fw-bold">{{ $item->status }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary text-uppercase fw-bold">{{ $item->status }}</span>
                                                    @endif
                                                </td>
                                                <td rowspan="{{ $item->detailReports->count() }}" class="align-middle"
                                                    x-show="!isColumnHidden('System')">
                                                    {{ $ra->assetGroup->name }}</td>
                                                <td rowspan="{{ $item->detailReports->count() }}" class="align-middle"
                                                    x-show="!isColumnHidden('Asset')">
                                                    {{ $ra->name }}</td>
                                            @endif
                                            <td class="align-middle" x-show="!isColumnHidden('No SR')">
                                                {{ $detail->no_sr }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('No WO')">
                                                {{ $detail->no_wo }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Tgl Identifikasi')">
                                                {{ $detail->tanggal_identifikasi }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Status Wo')">
                                                {{ $detail->status_sr }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Kondisi Asset')">
                                                {{ $detail->kondisi_asset }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Action Plan')">
                                                {{ $detail->action_plan }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Target Selesai')">
                                                {{ $detail->target_selesai }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Progres Saat ini')">
                                                {{ $detail->progress_saat_ini }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Realisasi selesai')">
                                                {{ $detail->realisasi_selesai }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Main Issue')">
                                                {{ $detail->issue }}</td>
                                            <td class="align-middle" x-show="!isColumnHidden('Keterangan')">
                                                {{ $detail->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                // State Variables
                isLoading: false,
                dataAssets: [],
                limit: 10,
                search: '',
                hiddenColumns: {},
                unit_id: @json($unit->id),
                report_id: @json($report->id),
                hiddenColumns: {},
                toggleColumn(column) {
                    this.hiddenColumns[column] = !this.hiddenColumns[column];
                },
                isColumnHidden(column) {
                    return this.hiddenColumns[column];
                },



                // Initialization


                // Fetch data from server

            }));
        });
    </script>




    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            //   $('#tableAssets').DataTable({
            //       buttons: ['pageLength', 'colvis', 'excel'],
            //       dom: 'Bfrtip' // untuk menampilkan tombol di atas tabel
            //   }); 
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
@endpush
