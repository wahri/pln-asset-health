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
            <div class="breadcrumb-title pe-3">Asset Health Report</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"> <a
                                href="{{ route('assetHealthReport.index') }}">Lokasi Unit Pembangkit</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('assetHealthReport.showLocation', $locationName) }}">
                                {{ $locationName }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="javascript:history.back()">
                                {{ $month }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="javascript:history.back()">
                                {{ $unit }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Report</li>
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
                                    : {{ $reportAsset->asset->assetGroup->name }}
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
                                    : {{ $reportAsset->asset->no_asset }}
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
                                    : {{ $reportAsset->asset->name }}
                                </td>

                            </tr>
                            <tr>


                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bxs-checkbox me-2 font-24" style="color: #f39c12;"></i>
                                        <div><strong>Status Asset :</strong></div>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-select form-select-md" name="status" id="status"
                                        onchange="changeStatus({{ $reportAsset->id }})">
                                        <option value="{{ $reportAsset->status }}" selected>
                                            {{ ucfirst($reportAsset->status) }}</option>

                                        @if ($reportAsset->status !== 'normal')
                                            <option value="normal">Normal</option>
                                        @endif
                                        @if ($reportAsset->status !== 'abnormal')
                                            <option value="abnormal">Abnormal</option>
                                        @endif
                                        @if ($reportAsset->status !== 'fault')
                                            <option value="fault">Fault</option>
                                        @endif
                                    </select>
                                    {{-- <div id="statusAlert" class="form-text text-danger">
                                    </div> --}}

                                </td>






                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="position-relative">
                        {{-- <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span
                            class="position-absolute top-50 product-show translate-middle-y"><i
                                class="bx bx-search"></i></span> --}}
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal"
                            data-bs-target="#addSR"><i class="bx bxs-plus-square"></i>Add SR</button>


                        <!-- Modal -->
                        <div class="modal fade" id="addSR" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('assetHealthReport.storeDetailReport', $reportAsset->id) }}"
                                    method="post">
                                    @csrf

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add SR</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label for="inputNoSR" class="form-label">No SR</label>
                                                    <input type="text" class="form-control" id="inputNoSR" name="no_sr"
                                                        placeholder="Enter No SR">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputNoWO" class="form-label">No WO</label>
                                                    <input type="text" class="form-control" id="inputNoWO"
                                                        name="no_wo" placeholder="Enter No WO">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputTanggalIdentifikasi" class="form-label">Tanggal
                                                        Identifikasi</label>
                                                    <input type="date" class="form-control"
                                                        id="inputTanggalIdentifikasi" name="tanggal_identifikasi">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status_sr" class="form-label">Status SR</label>
                                                    <select name="status_sr" id="status_sr" class="form-select select2">
                                                        <option selected value="">
                                                            Pilih Status SR
                                                        </option>

                                                        @foreach ($statusSR as $status)
                                                            <option value="{{ $status }}">{{ $status }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                                <div class="col-12">
                                                    <label for="kondisiAsset" class="form-label">Kondisi Asset</label>
                                                    <textarea class="form-control" id="kondisiAsset" name="kondisiAsset" placeholder="Enter Kondisi Asset..."
                                                        rows="3"></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="actionPlan" class="form-label">Action Plan</label>
                                                    <textarea class="form-control" name="actionPlan" id="actionPlan" rows="3" placeholder="Enter Action Plan..."></textarea>

                                                </div>
                                                <div class="col-md-12">
                                                    <label for="progresSaatIni" class="form-label">Progres Saat
                                                        Ini</label>
                                                    <select name="progresSaatIni" id="progresSaatIni"
                                                        class="form-select select2">
                                                        <option selected value="">
                                                            Pilih Progres Saat Ini
                                                        </option>


                                                        @foreach ($statusSR as $status)
                                                            <option value="{{ $status }}">{{ $status }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="targetSelesai" class="form-label">Target Selesai</label>
                                                    <input type="text" class="form-control" id="targetSelesai"
                                                        name="targetSelesai" placeholder="Enter Target Selesai">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="realisasiSelesai" class="form-label">Realisasi
                                                        Selesai</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            name="realisasiSelesai" id="realisasiSelesai"
                                                            placeholder="Enter Realisasi Selesai" min="0"
                                                            max="100">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="issue" class="form-label">issue</label>
                                                    <textarea class="form-control" id="issue" name="issue" placeholder="Enter issue..." rows="3"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Enter keterangan..." rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                <th>Action</th>
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
                                        <td>
                                            <div class="d-flex order-actions">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#editSR_{{ $dr->id }}"><i
                                                        class='bx bxs-edit'></i></button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="editSR_{{ $dr->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <form
                                                            action="{{ route('assetHealthReport.updateDetailReport', $dr->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Add SR
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row g-3">

                                                                        <div class="col-md-6">
                                                                            <label for="inputNoSR" class="form-label">No
                                                                                SR</label>
                                                                            <input type="text" class="form-control"
                                                                                id="inputNoSR" name="no_sr"
                                                                                placeholder="Enter No SR"
                                                                                value="{{ $dr->no_sr }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="inputNoWO" class="form-label">No
                                                                                WO</label>
                                                                            <input type="text" class="form-control"
                                                                                id="inputNoWO" name="no_wo"
                                                                                placeholder="Enter No WO"
                                                                                value="{{ $dr->no_wo }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="inputTanggalIdentifikasi"
                                                                                class="form-label">Tanggal
                                                                                Identifikasi</label>
                                                                            <input type="date" class="form-control"
                                                                                id="inputTanggalIdentifikasi"
                                                                                name="tanggal_identifikasi"
                                                                                value="{{ $dr->tanggal_identifikasi }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="status_sr"
                                                                                class="form-label">Status
                                                                                SR</label>
                                                                            <select name="status_sr" id="status_sr"
                                                                                class="form-select select2-edit">
                                                                                <option
                                                                                    value="{{ $dr->status_sr ? $dr->status_sr : '' }}">
                                                                                    {{ $dr->status_sr ? $dr->status_sr : 'Pilih Status SR' }}
                                                                                </option>

                                                                                @foreach ($statusSR as $status)
                                                                                    <option value="{{ $status }}">
                                                                                        {{ $status }}
                                                                                    </option>
                                                                                @endforeach

                                                                            </select>

                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="kondisiAsset"
                                                                                class="form-label">Kondisi Asset</label>
                                                                            <textarea class="form-control" id="kondisiAsset" name="kondisiAsset" placeholder="Enter Kondisi Asset..."
                                                                                rows="3">{{ $dr->kondisi_asset }}</textarea>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="actionPlan"
                                                                                class="form-label">Action
                                                                                Plan</label>

                                                                            <textarea class="form-control" name="actionPlan" id="actionPlan" rows="3" placeholder="Enter Action Plan...">{{ $dr->action_plan }}</textarea>

                                                                        </div>


                                                                        <div class="col-md-12">
                                                                            <label for="progresSaatIni"
                                                                                class="form-label">Progres Saat
                                                                                Ini</label>
                                                                            <select name="progresSaatIni"
                                                                                id="progresSaatIni"
                                                                                class="form-select  select2-edit-ProgresSaatini">
                                                                                <option
                                                                                    value="{{ $dr->progress_saat_ini ? $dr->progress_saat_ini : '' }}">
                                                                                    {{ $dr->progress_saat_ini ? $dr->progress_saat_ini : 'Pilih Progres Saat Ini' }}
                                                                                </option>

                                                                                @foreach ($statusSR as $status)
                                                                                    <option value="{{ $status }}">
                                                                                        {{ $status }}
                                                                                    </option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <label for="targetSelesai"
                                                                                class="form-label">Target Selesai</label>
                                                                            <input type="text" class="form-control"
                                                                                id="targetSelesai" name="targetSelesai"
                                                                                min="1900" max="2100"
                                                                                step="1" placeholder="YYYY"
                                                                                placeholder="Enter Target Selesai"
                                                                                value="{{ $dr->target_selesai }}">
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <label for="realisasiSelesai"
                                                                                class="form-label">Realisasi
                                                                                Selesai</label>
                                                                            <div class="input-group">
                                                                                <input type="number" class="form-control"
                                                                                    name="realisasiSelesai"
                                                                                    id="realisasiSelesai"
                                                                                    placeholder="Enter Realisasi Selesai"
                                                                                    min="0" max="100"
                                                                                    value="{{ $dr->realisasi_selesai }}">
                                                                                <span class="input-group-text">%</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="issue"
                                                                                class="form-label">issue</label>
                                                                            <textarea class="form-control" id="issue" name="issue" placeholder="Enter issue..." rows="3">{{ $dr->issue }}</textarea>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="keterangan"
                                                                                class="form-label">Keterangan</label>
                                                                            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Enter keterangan..." rows="3">{{ $dr->keterangan }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <form
                                                    action="{{ route('assetHealthReport.deleteDetailReportAsset', $dr->id) }}"
                                                    method="post" id="delete-form_{{ $dr->id }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        onclick="deleteConfirm(event, {{ $dr->id }})"
                                                        class="ms-3 btn btn-danger"><i class='bx bxs-trash'></i></button>
                                                </form>
                                            </div>
                                        </td>
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
