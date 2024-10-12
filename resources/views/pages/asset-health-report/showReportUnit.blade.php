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
            <div class="breadcrumb-title pe-3">Asset Health Report</div>
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

                <div class="">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>System</th>
                                <th>Asset</th>
                                <th>Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $iteration = 1; @endphp
                            @foreach ($reportAssets as $assetGroupName => $reports)
                                @php $rowspan = count($reports); @endphp

                                @foreach ($reports as $index => $report)
                                    <tr>
                                        @if ($index == 0)
                                            <td class="align-middle" rowspan="{{ $rowspan }}">{{ $iteration }}</td>
                                            <td class="align-middle" rowspan="{{ $rowspan }}">{{ $assetGroupName }}
                                            </td>
                                        @endif
                                        <td>{{ $report->asset->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $report->status_class }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="gap-2 d-flex">
                                            {{-- <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editReport_{{ $report->id }}">
                                                <i class="bx bx-edit-alt"></i>
                                            </button> --}}

                                            {{-- modal edit --}}
                                            {{-- <div class="modal fade" id="editReport_{{ $report->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('assetHealthReport.updateReportAssets', $report->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit
                                                                    Data
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">




                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" id="status"
                                                                        class="form-select">
                                                                        <option value="normal"
                                                                            {{ $report->asset->status == 'normal' ? 'selected' : '' }}>
                                                                            Normal</option>
                                                                        <option value="abnormal"
                                                                            {{ $report->asset->status == 'abnormal' ? 'selected' : '' }}>
                                                                            Abnormal</option>
                                                                        <option value="fault"
                                                                            {{ $report->asset->status == 'fault' ? 'selected' : '' }}>
                                                                            Fault</option>
                                                                    </select>
                                                                </div>




                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- end --}}
                                            <a href="{{ route('assetHealthReport.detailReportAsset', $report->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bx bx-laptop"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @php $iteration++; @endphp
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
            $('#example').DataTable();
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
