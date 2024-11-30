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
            <div class="breadcrumb-title pe-3">Manajemen Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:;">Manajemen Users</a>
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
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUsers">Tambah User
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addUsers" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('manajemenUser.store') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="addUsers">Add Users</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username">
                                        </div>
                                         <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                         <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
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




                <div class="mt-5 ">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>name</th>
                                <th>email</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $u)
                                @if (Auth::user()->id != $u->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editUsers_{{ $u->id }}"><i
                                                        class="bx bx-edit"></i></button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="editUsers_{{ $u->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('manajemenUser.update', $u->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="addUsers">Edit Users
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="noAsset"
                                                                            class="form-label">Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            value="{{ $u->name }}">
                                                                    </div>
                                                                     <div class="mb-3">
                                                                        <label for="noAsset"
                                                                            class="form-label">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" name="email"
                                                                            value="{{ $u->email }}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="noAsset"
                                                                            class="form-label">Password</label>
                                                                        <input type="password" class="form-control"
                                                                            id="password" name="password">
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

                                                <form action="{{ route('manajemenUser.destroy', $u->id) }}" method="post"
                                                    id="delete-form_{{ $u->id }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="deleteConfirm(event, {{ $u->id }})"><i
                                                            class='bx bx-trash'></i></button>
                                                </form>


                                            </div>
                                        </td>
                                    </tr>
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
