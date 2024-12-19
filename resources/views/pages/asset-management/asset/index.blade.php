@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="mb-3 page-breadcrumb d-none d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3">Asset {{ $unit->name }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('assetManagement.location.index') }}">Location Unit</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('assetManagement.unitPembangkit.index', $unit->location->name) }}">Unit
                                Pembangkit</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Aset Engine</li>
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
                    <button class="mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAsset">Add
                        Asset</button>

                    <!-- Modal -->
                    <div class="modal fade" id="addAsset" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('assetManagement.assets.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="addAsset">Tambah Asset</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3" style="display: none">
                                            <label for="nameAsset" class="form-label">Unit</label>
                                            <select name="unit_id" id="unit_id" class="form-select">
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="noAsset" class="form-label">Asset Group </label>
                                            <select name="assetGroup" id="assetGroup" class="form-select select2">
                                                <option selected>Pilih Asset Group</option>
                                                @foreach ($assetGroup as $ag)
                                                    <option value="{{ $ag->name }}">{{ $ag->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                        <div class="mb-3">
                                            <label for="nameAsset" class="form-label">Name Asset</label>
                                            <input type="text" class="form-control" id="nameAsset" name="nameAsset">
                                        </div>
                                        <div class="mb-3">
                                            <label for="noAsset" class="form-label">No Asset </label>
                                            <input type="text" class="form-control" id="noAsset" name="noAsset">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mpi" class="form-label">Mpi </label>
                                            <input type="number" class="form-control" id="mpi" name="mpi">
                                        </div>

                                        <div class="mb-3">
                                            <label for="systemName" class="form-label">Kondisi Saat ini</label>
                                            <select name="status" id="status" class="form-select">

                                                <option value="normal">Normal</option>
                                                <option value="abnormal">Abnormal</option>
                                                <option value="fault">fault</option>

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

                <div class="table-responsive" x-data="{ isDragging: false, startX: 0, scrollLeft: 0 }"
                    x-on:mousedown="isDragging = true; startX = $event.pageX - $el.offsetLeft; scrollLeft = $el.scrollLeft"
                    x-on:mousemove="if(isDragging) { $el.scrollLeft = scrollLeft - ($event.pageX - $el.offsetLeft - startX) }"
                    x-on:mouseup="isDragging = false" x-on:mouseleave="isDragging = false">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Asset Group</th>
                                <th>No Asset</th>
                                <th>Name Asset</th>
                                <th>MPI</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $asset->assetGroup->name }}</td>
                                    <td>{{ $asset->no_asset ?? '' }}</td>
                                    <td>{{ $asset->name ?? '' }}</td>
                                    <td>{{ $asset->mpi ?? '' }}</td>

                                    <td>
                                        <span class="badge bg-{{ $asset->status_class }}">
                                            {{ ucfirst($asset->status) }}
                                        </span>
                                    </td>
                                    <td class="gap-2 d-flex">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#editAsset_{{ $asset->id }}"><i
                                                class='text-white bx bxs-edit'></i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editAsset_{{ $asset->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('assetManagement.assets.update', $asset->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="unit_id"
                                                            value="{{ $unit->id }}">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="addAsset">Ubah Asset
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="unit_id" class="form-label">Unit</label>
                                                                <select name="unit_id" id="unit_id"
                                                                    class="form-select">
                                                                    <option value="" disabled
                                                                        {{ $asset->unit_id ? '' : 'selected' }}>Pilih Unit
                                                                    </option>
                                                                    <option value="{{ $asset->unit_id }}" selected>
                                                                        {{ $asset->unit->name ?? 'Unit Tidak Tersedia' }}
                                                                    </option>
                                                                    @foreach ($unitByLokasi as $unitLocation)
                                                                        @if ($unitLocation->id != $asset->unit_id)
                                                                            <option value="{{ $unitLocation->id }}">
                                                                                {{ $unitLocation->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="assetGroup" class="form-label">Asset
                                                                    Group</label>
                                                                <select name="assetGroup" id="assetGroup"
                                                                    class="form-select select2-edit">
                                                                    <option selected value="" disabled
                                                                        {{ !$asset->assetGroup ? 'selected' : '' }}>
                                                                        Select
                                                                        an Asset Group</option>
                                                                    @foreach ($assetGroup as $ag)
                                                                        <option value="{{ $ag->name }}"
                                                                            {{ $asset->assetGroup && $asset->assetGroup->id == $ag->id ? 'selected' : '' }}>
                                                                            {{ $ag->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="nameAsset" class="form-label">Name
                                                                    Asset</label>
                                                                <input type="text" class="form-control" id="nameAsset"
                                                                    name="nameAsset" value="{{ $asset->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="noAsset" class="form-label">No Asset
                                                                </label>
                                                                <input type="text" class="form-control" id="noAsset"
                                                                    name="noAsset" value="{{ $asset->no_asset }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mpi" class="form-label">Mpi </label>
                                                                <input type="number" class="form-control" id="mpi"
                                                                    name="mpi" value="{{ $asset->mpi }}">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Situasi Saat
                                                                    ini</label>
                                                                <select name="status" id="status"
                                                                    class="form-select">
                                                                    <option value="normal"
                                                                        {{ $asset->status == 'normal' ? 'selected' : '' }}>
                                                                        Normal</option>
                                                                    <option value="abnormal"
                                                                        {{ $asset->status == 'abnormal' ? 'selected' : '' }}>
                                                                        Abnormal</option>
                                                                    <option value="fault"
                                                                        {{ $asset->status == 'fault' ? 'selected' : '' }}>
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
                                        </div>
                                        <form action="{{ route('assetManagement.assets.destroy', $asset->id) }}"
                                            method="post" id="delete-form_{{ $asset->id }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="deleteConfirm(event,{{ $asset->id }})"><i
                                                    class='bx bxs-trash'></i></button>
                                        </form>




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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
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

            $('#addAsset').on('shown.bs.modal', function() {
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
            $(document).on('shown.bs.modal', '[id^="editAsset_"]', function() {
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
            $(document).on('hidden.bs.modal', '[id^="editAsset_"]', function() {
                $(this).find('.select2-edit').select2('destroy'); // Hapus Select2 dari elemen dalam modal
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
