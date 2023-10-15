@extends('template.master')

@section('page-title', 'Pegawai')
@section('page-sub-title', 'Data')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Data Pegawai
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <div class="m-auto"></div>
                            @can('admin')
                                <a href="{{ route('pegawai.create') }}">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="nav-icon fa fa-plus font-weight-bold"></i> Tamabh
                                    </button>
                                </a>
                            @endcan

                            {{-- <a href="{{route('pegawai.print')}}">
                                <button type="button" class="btn btn-outline-success btn-print ml-2">
                                    <i class="nav-icon fa fa-print font-weight-bold"></i> Print
                                </button>
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="tableData">
                        <thead>
                            <th>No</th>
                            <th></th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan Terakhir</th>
                            <th>No. telp</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $pegawai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{asset($pegawai->user->foto)}}" width="150px">
                                    </td>
                                    <td>{{ $pegawai->nip }}</td>
                                    <td>{{ $pegawai->nama }}</td>
                                    <td>{{ $pegawai->jenis_kelamin }}</td>
                                    <td>{{ $pegawai->pendidikan_terakhir }}</td>
                                    <td>{{ $pegawai->telp }}</td>
                                    <td>{{ $pegawai->alamat }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $pegawai->is_active == true ? 'badge-primary' : 'badge-danger' }}">{{ $pegawai->is_active == true ? 'Aktif' : 'Tidak aktif' }}</span>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-2 text-right">
                                                <a href="{{ route('pegawai.edit', $pegawai->id) }}">
                                                    <button class="btn btn-edit btn-primary ml-5">
                                                        <i class="fa fa-pencil text-white mr-2 pointer"></i> Edit
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="col-9">
                                                <form method="POST"
                                                    action="{{ route('pegawai.delete', $pegawai->user_id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-delete btn-danger"
                                                        data-id="{{ $pegawai->user_id }}">
                                                        <i class="fa fa-trash-alt text-white mr-2 pointer"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
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
    <script src="{{ asset('assets/js/print/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('status'))
                Swal.fire(
                    "{{ session('title') }}",
                    "{{ session('message') }}",
                    "{{ session('status') }}",
                );
            @endif
            var table = $('#tableData').DataTable({
                language: {
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    },
                    info: "Showing _START_ to _END_ from _TOTAL_ data",
                    infoEmpty: "Showing 0 to 0 from 0 data",
                    lengthMenu: "Showing _MENU_ data",
                    search: "Search:",
                    emptyTable: "Data doesn't exists",
                    zeroRecords: "Data doesn't match",
                    loadingRecords: "Loading..",
                    processing: "Processing...",
                    infoFiltered: "(filtered from _MAX_ total data)"
                },
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                order: [
                    [0, 'desc']
                ],
                "rowCallback": function(row, data, index) {
                    // Set the row number as the first cell in each row
                    $('td:eq(0)', row).html(index + 1);
                }
            });

            // Update row numbers when the table is sorted
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $("body").on("click", ".btn-delete", function(event) {
                var form = $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: "Delete this item?",
                    text: "Data will be deleted",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, deleted!",
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
