@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        /* Untuk membungkus teks di semua kolom tabel */
        #tableAssetsNew th,
        #tableAssetsNew td {
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
                            <a href="{{ route('assetHealthReport.showReport', [$location->id, $report->id]) }}">
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

      <a href="{{ route('assetHealthReport.showReport', [$location->id, $report->id]) }}" type="button" class="btn btn-secondary mb-3 ms-2">
    <i class='bx bx-arrow-back'></i> Kembali
</a>

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
                                <a href="{{ route('assetHealthReport.exportExcel', [$location->id, $report->id, $unit->id]) }}"
                                    class="btn btn-sm btn-success"><i class='bx bx-export'></i> Excel</a>
                            </div>



                        </div>
                        <div class="col">


                        </div>
                        <div class="col">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Search</span>
                                <input x-model="search" type="search" @input.debounce="getData()" class="form-control"
                                    placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="table-responsive mt-4" x-data="{ isDragging: false, startX: 0, scrollLeft: 0 }"
                    x-on:mousedown="isDragging = true; startX = $event.pageX - $el.offsetLeft; scrollLeft = $el.scrollLeft"
                    x-on:mousemove="if(isDragging) { $el.scrollLeft = scrollLeft - ($event.pageX - $el.offsetLeft - startX) }"
                    x-on:mouseup="isDragging = false" x-on:mouseleave="isDragging = false">
                    <table id="tableAssetsNew" class="table table-striped table-bordered table-hover table-sm"
                        style="color: #ffffff;font-size: 11px">
                        <thead>
                            <tr>
                                <th scope="col" x-show="!isColumnHidden('Action')">Action</th>
                                <th scope="col" x-show="!isColumnHidden('Status')">Status</th>


                                <th scope="col" x-show="!isColumnHidden('System')">System</th>
                                <th scope="col" x-show="!isColumnHidden('Asset')">Asset</th>
                                <th scope="col" x-show="!isColumnHidden('No SR')">No SR</th>
                                <th scope="col" x-show="!isColumnHidden('No WO')">No WO</th>
                                <th scope="col" x-show="!isColumnHidden('Tgl Identifikasi')">Tanggal
                                    Identifikasi</th>
                                <th scope="col" x-show="!isColumnHidden('Status Wo')">Status WO</th>
                                <th style="min-width: 400px" scope="col" x-show="!isColumnHidden('Kondisi Asset')">
                                    Kondisi Asset</th>
                                <th style="min-width: 400px" scope="col" x-show="!isColumnHidden('Action Plan')">
                                    Action Plan</th>
                                <th scope="col" x-show="!isColumnHidden('Target Selesai')">Target Selesai</th>
                                <th scope="col" x-show="!isColumnHidden('Progres Saat ini')">Progres Saat Ini
                                </th>
                                <th scope="col" x-show="!isColumnHidden('Realisasi selesai')">Realisasi Selesai
                                </th>
                                <th scope="col" x-show="!isColumnHidden('Main Issue')">Main Issue</th>
                                <th scope="col" x-show="!isColumnHidden('Keterangan')">Keterangan</th>
                            </tr>

                        </thead>
                        <tbody>

                           
                            <template x-for="(dataAsset, index) in dataAssets.data" :key="index">
                                <template x-for="(detail, detailIndex) in dataAsset.detail_reports"
                                    :key="detailIndex">
                                    <template x-if="dataAsset.detail_reports && dataAsset.detail_reports.length > 0">
                                        <tr>
                                            <template x-if="detailIndex === 0">
                                                <td :rowspan="dataAsset.detail_reports.length"
                                                    class="align-middle text-center">
                                                    <a :href="'{{ url('/asset-health-report/report/detail') }}/' + dataAsset.id"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </template>

                                            <!-- Main Asset Data (rowspan applied only once for the first row) -->
                                            <template x-if="['normal', 'abnormal', 'fault'].includes(dataAsset.status)">
                                                <td :class="{
                                                    'text-success': dataAsset.status === 'normal',
                                                    'text-warning': dataAsset.status === 'abnormal',
                                                    'text-danger': dataAsset.status === 'fault'
                                                }"
                                                    class="text-uppercase fw-bold" x-text="dataAsset.status"
                                                    :rowspan="dataAsset.detail_reports.length"
                                                    x-show="detailIndex === 0 && !isColumnHidden('Status')">
                                                </td>
                                            </template>


                                            <td x-text="dataAsset.asset.asset_group.name"
                                                :rowspan="dataAsset.detail_reports.length"
                                                x-show="detailIndex === 0 && !isColumnHidden('System')">
                                            </td>

                                            <td x-text="dataAsset.asset.name" :rowspan="dataAsset.detail_reports.length"
                                                x-show="detailIndex === 0 && !isColumnHidden('Asset')">
                                            </td>



                                            <!-- Detail Data (displayed for each detail report) -->
                                            <td x-text="detail.no_sr" x-show="!isColumnHidden('No SR')"></td>
                                            <td x-text="detail.no_wo" x-show="!isColumnHidden('No WO')"></td>
                                            <td x-text="detail.tanggal_identifikasi"
                                                x-show="!isColumnHidden('Tgl Identifikasi')"></td>
                                            <td x-text="detail.status_wo" x-show="!isColumnHidden('Status Wo')"></td>
                                            <td x-text="detail.kondisi_asset" x-show="!isColumnHidden('Kondisi Asset')">
                                            </td>
                                            <td x-text="detail.action_plan" x-show="!isColumnHidden('Action Plan')">
                                            </td>
                                            <td x-text="detail.target_selesai" x-show="!isColumnHidden('Target Selesai')">
                                            </td>
                                            <td x-text="detail.progress" x-show="!isColumnHidden('Progres Saat ini')">
                                            </td>
                                            <td x-text="detail.realisasi_selesai"
                                                x-show="!isColumnHidden('Realisasi selesai')"></td>
                                            <td x-text="detail.main_issue" x-show="!isColumnHidden('Main Issue')">
                                            </td>
                                            <td x-text="detail.keterangan" x-show="!isColumnHidden('Keterangan')">
                                            </td>


                                        </tr>
                                    </template>
                                </template>
                            </template>

                             <template x-for="(dataAsset, index) in dataAssets.data" :key="index">
                                <template x-if=" dataAsset.detail_reports.length == 0">

                                    <tr>
                                        <td class="align-middle text-center">
                                            <a :href="'{{ url('/asset-health-report/report/detail') }}/' + dataAsset.id"
                                                class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                        <td :class="{
                                            'text-success': dataAsset.status === 'normal',
                                            'text-warning': dataAsset.status === 'abnormal',
                                            'text-danger': dataAsset.status === 'fault'
                                        }"
                                            class="text-uppercase fw-bold" x-text="dataAsset.status"
                                            x-show="!isColumnHidden('Status')">
                                        </td>

                                        <td x-text="dataAsset.asset.asset_group.name" x-show="!isColumnHidden('System')">
                                        </td>

                                        <td x-text="dataAsset.asset.name" x-show="!isColumnHidden('Asset')">
                                        </td>
                                        <td colspan="11"></td>
                                    </tr>
                                </template>

                            </template>

                        </tbody>
                    </table>
                </div>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center">
                        <template x-for="(row, index) in dataAssets?.links" :key="index">
                            <li class="page-item" :class="row.active ? 'active' : ''">
                                <a class="page-link" href="#" @click.prevent="getData(row.url)">
                                    <span x-html="row.label"></span>
                                </a>
                            </li>

                        </template>
                    </ul>
                </nav>


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
                async applyFilter() {
                    const url =
                        '{{ route('assetHealthReport.getAssetReport') }}'; // Pastikan ini mengarah ke endpoint yang benar
                    await this.getData(url);
                },
                init() {
                    this.getData();


                },
                async getData(url = '{{ route('assetHealthReport.getAssetReport') }}') {

                    try {
                        this.isLoading = true;
                        const response = await axios.get(url, {
                            params: {
                                limit: this.limit,
                                unit_id: this.unit_id,
                                report_id: this.report_id,
                                search: this.search,

                            }
                        });

                        this.dataAssets = response.data;
                        console.log(this.dataAssets);



                    } catch (error) {
                        console.error("Error fetching data:", error);
                        this.isLoading = false;
                    }
                },


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
