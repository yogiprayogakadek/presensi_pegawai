@extends('template.master')

@section('page-title', 'Absensi')
@section('page-sub-title', 'Data')

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Data Absensi
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <div class="m-auto"></div>
                            <button type="button" class="btn btn-outline-success btn-filter">
                                <i class="nav-icon fa fa-search font-weight-bold"></i> Filter
                            </button>
                            <button class="btn btn-outline-primary btn-print ml-2">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="render">
                    {{-- <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="{{ count($dates) }}">Tanggal (Absensi Masuk 1 bulan terakhir)</th>
                            </tr>
                            <tr>
                                @foreach ($dateFormatted as $df)
                                    <td class="text-center">
                                        {!! $df !!}
                                    </td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="{{ count($dates) + 2 }}">No Data</td>
                            </tr>
                        </tbody>
                    </table> --}}

                    <table class="table table-hover table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th class="align-middle" rowspan="2">#</th>
                                <th class="align-middle" rowspan="2">Tanggal</th>
                                <th colspan="2">Absensi</th>
                            </tr>
                            <tr>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dateFormatted as $key => $df)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        {!! $df !!}
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Cari data absensi</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="from_date">Dari tanggal</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="form-group">
                            <label for="from_date">Sampai tanggal</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ date('Y-m-t') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-search">Search</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/print/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#modal'),
                width: '100%',
            });
            @if (session('status'))
                Swal.fire(
                    "{{ session('title') }}",
                    "{{ session('message') }}",
                    "{{ session('status') }}",
                );
            @endif

            $('body').on('click', '.btn-filter', function() {
                $('#modal').modal('show');
            })

            $('.btn-search').on('click', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let fromDate = $('#from_date').val();
                let toDate = $('#to_date').val();

                if (!isNaN(new Date(fromDate)) && !isNaN(new Date(toDate))) {
                    var intervalInMilliseconds = Math.abs(new Date(toDate) - new Date(fromDate));
                    var days = Math.floor(intervalInMilliseconds / (1000 * 60 * 60 * 24));

                    if ((days + 1) <= 31) {
                        $.ajax({
                            type: "POST",
                            url: "/staff/absensi/filter",
                            data: {
                                fromDate: fromDate,
                                toDate: toDate,
                            },
                            dataType: "JSON",
                            success: function(response) {
                                $('#render').html(response.data)
                                $('#modal').modal('hide');
                            }
                        });
                    } else {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": true,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr["error"]("Filter tidak boleh lebih dari 31 hari")
                    }
                }

            })

            $('#from_date').on('input', function() {
                var fromDate = $('#from_date').val();
                $('#to_date').attr('min', fromDate);
                $('#to_date').prop('disabled', false);
            });

            $('body').on('click', '.btn-detail-masuk', function() {
                let absensi = $(this).data('absensi');
                let kategori = $(this).data('kategori')

                let jam = absensi.jam_masuk;

                let divJam = '<div class="btn-jam-masuk" style="cursor: pointer">' + jam + '</div>';

                $('.jam-masuk').append(divJam)
                $('.btn-detail-masuk').prop('hidden', true);
            });

            $('body').on('click', '.btn-jam-masuk', function() {
                $('.btn-detail-masuk').prop('hidden', false);
                $('.btn-jam-masuk').prop('hidden', true);
            });

            $('body').on('click', '.btn-detail-keluar', function() {
                let absensi = $(this).data('absensi');
                let kategori = $(this).data('kategori')

                let jam = absensi.jam_keluar;

                let divJam = '<div class="btn-jam-keluar" style="cursor: pointer">' + jam + '</div>';

                $('.jam-keluar').append(divJam)
                $('.btn-detail-keluar').prop('hidden', true);
            });

            $('body').on('click', '.btn-jam-keluar', function() {
                $('.btn-detail-keluar').prop('hidden', false);
                $('.btn-jam-keluar').prop('hidden', true);
            });

        });
    </script>
@endpush
