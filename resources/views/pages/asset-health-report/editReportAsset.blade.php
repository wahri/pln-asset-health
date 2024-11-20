@extends('layouts.main')
@section('content')
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <div class="page-content">
        <!--breadcrumb-->
        <div class="mb-3 page-breadcrumb d-none d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3">Assets Wellness Monitoring System</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Asset {{ $reportAsset->asset->name }}</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="border-0 border-4 card border-top border-primary">
            <div class="p-5 card-body">
                <div class="card-title">
                    @include('components.alert')
                </div>
                
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bxs-file me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary">detail Report</h5>
                </div>
                <hr>
                <form class="row g-3" action="{{ route('assetHealthReport.reportAssets.UpdatedetailReports',$detailReports->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="inputNoSR" class="form-label">No SR</label>
                        <input type="text" class="form-control" id="inputNoSR" 
                        name="no_sr"
                        placeholder="Enter No SR" value="{{ $detailReports->no_sr }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputNoWO" class="form-label">No WO</label>
                        <input type="text" class="form-control" id="inputNoWO"
                        name="no_wo" placeholder="Enter No WO"
                        value="{{ $detailReports->no_wo }}"
                        >
                    </div>
                    <div class="col-md-6">
                        <label for="inputStatus" class="form-label">Status</label>
                        <input type="text" class="form-control" id="inputStatus" 
                        name="status"
                        placeholder="Enter Status"
                        value="{{ $detailReports->status }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputIssue" class="form-label">Issue</label>
                        <input type="text" class="form-control" id="inputIssue" 
                        name="issue"
                        placeholder="Enter Issue"
                        value="{{ $detailReports->issue }}">
                    </div>
                    <div class="col-12">
                        <label for="inputInformation" class="form-label">Information</label>
                        <textarea class="form-control" id="inputInformation" 
                        name="information"
                        placeholder="Enter Information..." rows="3">{{ $detailReports->information }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="inputProses" class="form-label">Proses</label>
                        <input type="text" class="form-control" id="inputProses" 
                        name="proses"
                        placeholder="Enter Proses"
                        value="{{ $detailReports->proses }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputKeterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="inputKeterangan"
                        name="keterangan"   
                        placeholder="Enter Keterangan"
                            value="{{ $detailReports->keterangan }}">
                    </div>
                    <div class="col-12">
                        <label for="inputDeskripsiAsset" class="form-label">Deskripsi Asset</label>
                        <textarea class="form-control" id="inputDeskripsiAsset" 
                        name="deskripsi_asset"
                        placeholder="Enter Deskripsi Asset..." rows="3">{{ $detailReports->deskripsi_asset }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="inputKondisiAsset" class="form-label">Kondisi Asset</label>
                        <input type="text" class="form-control" id="inputKondisiAsset"
                        name="kondisi_asset"   
                        placeholder="Enter Kondisi Asset"
                            value="{{ $detailReports->kondisi_asset }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTargetSelesai" class="form-label">Target Selesai</label>
                        <input type="date" class="form-control" 
                        name="target_selesai"
                        id="inputTargetSelesai"
                        value="{{ $detailReports->target_selesai }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPersentaseProgress" class="form-label">Persentase Progress</label>
                        <input type="number" class="form-control" id="inputPersentaseProgress"
                        name="persentase_progress"  
                        placeholder="Enter Persentase Progress"
                            value="{{ $detailReports->persentase_progress }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputRealisasiSelesai" class="form-label">Realisasi Selesai</label>
                        <input type="date" 
                        name="realisasi_selesai"
                        class="form-control" id="inputRealisasiSelesai"
                        value="{{ $detailReports->realisasi_selesai }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTanggalIdentifikasi" class="form-label">Tanggal Identifikasi</label>
                        <input type="date" class="form-control" id="inputTanggalIdentifikasi"
                        name="tanggal_identifikasi"
                        value="{{ $detailReports->tanggal_identifikasi }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="px-5 btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <!-- Load jQuery and DataTables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

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
