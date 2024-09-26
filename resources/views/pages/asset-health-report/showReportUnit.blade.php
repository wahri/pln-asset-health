@extends('layouts.main')
@section('content')
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
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
                        <li class="breadcrumb-item">
                            <a href="">
                                {{ $location->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">
                                {{ $report->date }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $unit->name }}</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />
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
                                            <a href="{{ route('assetHealthReport.editReportAsset', $report->id) }}" class="btn btn-info btn-sm">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <button class="btn btn-primary btn-sm">
                                                <i class="bx bx-laptop"></i>
                                            </button>
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
