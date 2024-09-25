@extends('layouts.main')
@section('content')
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Unit Pembangkit {{ $location->name }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('assetManagement.location.index') }}">Location Unit</a></li>
                         <li class="breadcrumb-item active" aria-current="page">Data Table Unit Pembangkit</li>
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
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLocationUnit">Add
                        Unit Pembangkit</button>


                    <!-- Modal -->
                    <div class="modal fade" id="addLocationUnit" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('assetManagement.unitPembangkit.store') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="addLocationUnit">Add Unit Engine</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nameUnit" class="form-label">Name Unit</label>
                                            <input type="text" class="form-control" id="nameUnit" name="nameUnit">

                                        </div>
                                        <div class="mb-3">
                                            <label for="locaiton" class="form-label">Location</label>
                                            <select name="location" id="location" class="form-select">
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Name Unit</th>
                                <th width="20%">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unit as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td class="d-flex gap-2">
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#editUnit_{{ $u->id }}"><i
                                                    class='bx bxs-edit text-white'></i></button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editUnit_{{ $u->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('assetManagement.unitPembangkit.update', $u->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="addLocationUnit">Edit
                                                                    Unit Engine</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nameUnit" class="form-label">Name
                                                                        Unit</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nameUnit" name="nameUnit"
                                                                        value="{{ $u->name }}">

                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="location"
                                                                        class="form-label">Location</label>
                                                                    <select name="location" id="location"
                                                                        class="form-select">
                                                                         <option value="{{ $location->id }}">{{ $location->name }}</option>
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
                                            </div>
                                            <form action="{{ route('assetManagement.unitPembangkit.destroy', $u->id) }}" method="post" id="delete-form_{{ $u->id }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger" id="btn-delete"
                                                    onclick="deleteConfirm(event,{{ $u->id }})"><i
                                                        class='bx bxs-trash'></i></button>
                                            </form>

                                              <a href="{{ route('assetManagement.assets.index', $u->name) }}"  class="btn btn-primary">
                                                Asset <i class='bx bx-wrench'></i>
                                            </a>

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
        function deleteConfirm(event,id) {
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
                    $('#delete-form_'+id).submit(); // Kirim form setelah konfirmasi
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
