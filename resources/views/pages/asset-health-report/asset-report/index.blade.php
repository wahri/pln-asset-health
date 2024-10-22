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
        <div class="mb-3 page-breadcrumb d-none d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3">Asset Report</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />

        <div class="border-0 border-4 card border-top border-primary">
            <div class="card-body">





                <div class="card-title">
                    @include('components.alert')
                    <form action="{{ route('assetHealthReport.assetReport.searchAssetReport') }}" method="get">
                        <div class="row">
                            <div class="col-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <select name="lokasi" id="lokasi" class="form-select select2" required>
                                    <option value="" disabled {{ is_null(Request::get('lokasi')) ? 'selected' : '' }}>
                                        Pilih Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->name }}"
                                            {{ Request::get('lokasi') == $location->name ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="" disabled {{ is_null(Request::get('status')) ? 'selected' : '' }}>
                                        Pilih Status</option>
                                    <option value="normal" {{ Request::get('status') == 'normal' ? 'selected' : '' }}>Normal
                                    </option>
                                    <option value="abnormal" {{ Request::get('status') == 'abnormal' ? 'selected' : '' }}>
                                        Abnormal</option>
                                    <option value="fault" {{ Request::get('status') == 'fault' ? 'selected' : '' }}>Fault
                                    </option>
                                </select>
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>



                </div>





                <div class="mt-5 ">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
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

                            @if (isset($assertReport))
                                @foreach ($assertReport as $ar)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ar->no_sr }}</td>
                                        <td>{{ $ar->no_wo }}</td>
                                        <td>{{ $ar->tanggal_identifikasi }}</td>
                                        <td>{{ $ar->status_sr }}</td>
                                        <td>{{ $ar->kondisi_asset }}</td>
                                        <td>{{ $ar->action_plan }}</td>
                                        <td>{{ $ar->progress_saat_ini }}</td>
                                        <td>{{ $ar->target_selesai }}</td>
                                        <td>{{ $ar->realisasi_selesai }}</td>
                                        <td>{{ $ar->issue }}</td>
                                        <td>{{ $ar->keterangan }}</td>

                                        <td>
                                            <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                                                <a href="{{ route('assetHealthReport.assetReport.showAssetReport', $ar->report_asset_id) }}" class="btn btn-info">
                                                    Detail <i class='bx bx-log-in-circle'></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                $('#lokasi').select2({
                    theme: "bootstrap-5",
                    width: '100%', // Sesuaikan dengan lebar elemen
                    placeholder: 'Pilih Lokasi', // Placeholder dapat disesuaikan
                    closeOnSelect: false,
                });
            });


        });
    </script>




    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable();

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
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
