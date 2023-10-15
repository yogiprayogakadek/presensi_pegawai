@extends('template.master')

@section('page-title', 'Absensi')
@section('page-sub-title', 'Data')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-5">
                            Data Absensi
                        </div>
                        <div class="col-7">
                            {{-- <div class="m-auto"></div> --}}
                            <div class="row">
                                <div class="col-4">
                                    <span>Dari Tanggal</span>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-4">
                                    <span>Sampai tanggal</span>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-2">
                                    <br>
                                    <button class="btn btn-outline-success btn-filter">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="col-2">
                                    <br>
                                    <button class="btn btn-outline-primary btn-print">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                            {{-- <a href="{{route('pegawai.print')}}">
                                <button type="button" class="btn btn-outline-success btn-print ml-2">
                                    <i class="nav-icon fa fa-print font-weight-bold"></i> Print
                                </button>
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="tableData">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="{{ count($dates) }}">Tanggal</th>
                            </tr>
                            <tr>
                                @foreach ($dateFormatted as $df)
                                    {{-- <td>{{$i}}</td> --}}
                                    <td class="text-center">
                                        {!! $df !!}
                                    </td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $pegawai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pegawai->nama }}</td>
                                    @for ($i = 0; $i < count($dates); $i++)
                                        <td class="text-center">
                                            @if (in_array($dates[$i], $pegawai->absensi->pluck('tanggal')->toArray()))
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-times" style="color: red;"></i>
                                            @endif
                                        </td>
                                    @endfor
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
                    [25, 50, 75, 100, -1],
                    [25, 50, 75, 100, "All"]
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
