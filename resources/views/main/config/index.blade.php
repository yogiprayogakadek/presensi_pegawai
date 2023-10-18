@extends('template.master')

@section('page-title', 'Config')
@section('page-sub-title', 'Data')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Data Config
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <div class="m-auto"></div>
                            {{-- @can('admin')
                                <a href="{{ route('config.create') }}">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="nav-icon fa fa-plus font-weight-bold"></i> Tambah
                                    </button>
                                </a>
                            @endcan --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="tableData">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Config</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($config as $config)
                            @php
                                $json = json_decode($config->json_data, true);
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $config->nama }}</td>
                                    <td>
                                        <ol>
                                            <li>Jam Masuk</li>
                                            <ul>
                                                <li>Batas Awal : {{$json['jam_masuk']['batas_awal']}}</li>
                                                <li>Batas Akhir : {{$json['jam_masuk']['batas_akhir']}}</li>
                                            </ul>
                                            <li>Jam Keluar</li>
                                            <ul>
                                                <li>Batas Awal : {{$json['jam_keluar']['batas_awal']}}</li>
                                                <li>Batas Akhir : {{$json['jam_keluar']['batas_akhir']}}</li>
                                            </ul>
                                        </ol>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-2 text-right">
                                                <a href="{{ route('config.edit', $config->id) }}">
                                                    <button class="btn btn-edit btn-primary ml-5">
                                                        <i class="fa fa-pencil text-white mr-2 pointer"></i> Edit
                                                    </button>
                                                </a>
                                            </div>
                                            {{-- <div class="col-9">
                                                <form method="POST"
                                                    action="{{ route('config.delete', $config->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-delete btn-danger"
                                                        data-id="{{ $config->id }}">
                                                        <i class="fa fa-trash-alt text-white mr-2 pointer"></i> Hapus
                                                    </button>
                                                </form>
                                            </div> --}}
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
        });
    </script>
@endpush
