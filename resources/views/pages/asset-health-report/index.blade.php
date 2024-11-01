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
                        <li class="breadcrumb-item active" aria-current="page">Lokasi Unit Pembangkit</li>
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
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <div><i class="bx bxs-file me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Pilih Lokasi Pembangkit</h5>
                        </div>
                        <div class="col">

                        </div>
                        <div class="col">
                            <button class="pt-2 mb-3 btn btn-secondary btn-md float-end me-3" data-bs-toggle="modal"
                                data-bs-target="#importExcel">Import Data Report</button>


                            <!-- Modal -->
                            <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('assetHealthReport.import.report') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Report</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label"> Choose Excel File</label>
                                                    <input class="form-control" type="file" id="formFile" required
                                                        name="fileReport">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-4 table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lokasi</th>
                                <th width="20%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($locations as $l)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $l->name }}</td>
                                    <td>
                                        <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                                            <a href="{{ route('assetHealthReport.showLocation', $l->name) }}"
                                                class="btn btn-info">
                                                Report <i class='bx bx-log-in-circle'></i>
                                            </a>
                                        </div>
                                        <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                                            <form action="{{ route('assetHealthReport.deleteLocation', $l->id) }}"
                                                method="post" id="delete-form_{{ $l->id }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="deleteConfirm(event, {{ $l->id }})"
                                                    class="btn btn-danger">
                                                    Delete <i class='bx bx-trash'></i>
                                                </button>
                                            </form>







                                        </div>


                                    </td>

                                </tr>
                            @endforeach

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
