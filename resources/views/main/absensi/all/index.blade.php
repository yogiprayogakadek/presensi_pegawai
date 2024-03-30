@extends('template.master')

@section('page-title', 'Absensi')
@section('page-sub-title', 'Data')

@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <form action="{{ route('absensi.all.printAll') }}" method="POST">
                <div class="row">
                    <div class="col-5">
                        Data Absensi
                    </div>
                    <div class="col-7">
                        <div class="m-auto">
                            <div class="row">
                                <div class="col-3">
                                    <span>Dari Tanggal</span>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-3">
                                    <span>Sampai tanggal</span>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-t') }}">
                                </div>
                                <div class="col-2">
                                    <span>Kategori</span>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="Masuk">Masuk</option>
                                        <option value="Keluar">Keluar</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <br>
                                    <button class="btn btn-outline-success btn-filter" type="button">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="col-2">
                                    <br>
                                    @csrf
                                    <button class="btn btn-outline-primary btn-print" type="submit">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="{{route('pegawai.print')}}">
                        <button type="button" class="btn btn-outline-success btn-print ml-2">
                            <i class="nav-icon fa fa-print font-weight-bold"></i> Print
                        </button>
                        </a> --}}
                    </div>
                </div>
            </form>
            </div>
            <div class="card-body" id="render">
                <table class="table table-hover table-bordered table-responsive">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama</th>
                            <th colspan="{{ count($dates) }}">Tanggal (Absensi Masuk 1 bulan terakhir)</th>
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
                            @for ($i = 0; $i < count($dates); $i++) <td class="text-center">
                                @php
                                $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$i]);
                                @endphp

                                @if ($absensiRecord)
                                @if (
                                ($kategori == 'Masuk' && $absensiRecord->jam_masuk !== null) ||
                                ($kategori == 'Keluar' && $absensiRecord->jam_keluar !== null))
                                <div class="jam">
                                    <i style="cursor: pointer;" class="fa fa-check btn-detail" data-absensi="{{ $absensiRecord }}" data-kategori="{{ $kategori }}"></i>
                                </div>
                                @else
                                <i class="fa fa-times" style="color: red;"></i>
                                @endif
                                @else
                                <i class="fa fa-times" style="color: red;"></i>
                                @endif
                                </td>
                                @endfor

                                {{-- @for ($i = 0; $i < count($dates); $i++)
                                        <td class="text-center">
                                            @if (in_array($dates[$i], $pegawai->absensi->pluck('tanggal')->toArray()))
                                                <div class="{{$kategori == 'Masuk' ? 'masuk' : 'keluar'}}">
                                <i style="cursor: pointer;" class="fa fa-check btn-detail" data-absensi="{{ $pegawai->absensi }}"></i>
            </div>
            @else
            <i class="fa fa-times" style="color: red;"></i>
            @endif
            </td>
            @endfor --}}
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
        @if(session('status'))
        Swal.fire(
            "{{ session('title') }}", "{{ session('message') }}", "{{ session('status') }}", );
        @endif

        $('.btn-filter').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let fromDate = $('#from_date').val();
            let toDate = $('#to_date').val();
            let kategori = $('select[name=kategori] option').filter(':selected').val()

            if (!isNaN(new Date(fromDate)) && !isNaN(new Date(toDate))) {
                var intervalInMilliseconds = Math.abs(new Date(toDate) - new Date(fromDate));
                var days = Math.floor(intervalInMilliseconds / (1000 * 60 * 60 * 24));

                if ((days + 1) <= 31) {
                    $.ajax({
                        type: "POST"
                        , url: "/absensi/all/filter"
                        , data: {
                            fromDate: fromDate
                            , toDate: toDate
                            , kategori: kategori
                        }
                        , dataType: "JSON"
                        , success: function(response) {
                            $('#render').html(response.data)
                        }
                    });
                } else {
                    toastr.options = {
                        "closeButton": false
                        , "debug": false
                        , "newestOnTop": false
                        , "progressBar": false
                        , "positionClass": "toast-top-center"
                        , "preventDuplicates": true
                        , "onclick": null
                        , "showDuration": "300"
                        , "hideDuration": "1000"
                        , "timeOut": "5000"
                        , "extendedTimeOut": "1000"
                        , "showEasing": "swing"
                        , "hideEasing": "linear"
                        , "showMethod": "fadeIn"
                        , "hideMethod": "fadeOut"
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

        $('body').on('click', '.btn-detail', function() {
            let absensi = $(this).data('absensi');
            let kategori = $(this).data('kategori')
            // let jam = kategori == 'Masuk' ? absensi.jam_masuk : absensi.jam_keluar;

            let jam;

            if (kategori === 'Masuk') {
                jam = absensi.jam_masuk;
            } else if (kategori === 'Keluar') {
                jam = absensi.jam_keluar;
            }

            let parentContainer = $(this).closest('td');
            let divJam = '<div class="btn-jam-' + kategori + '" style="cursor: pointer">' + jam +
                '</div>';

            parentContainer.append(divJam);
            parentContainer.find('.btn-detail').hide();
        });

        $('body').on('click', '.btn-jam-Masuk', function() {
            let container = $(this).closest('td');
            container.find('.btn-detail').show();
            container.find('.btn-jam-Masuk').hide();
        });

        $('body').on('click', '.btn-jam-Keluar', function() {
            let container = $(this).closest('td');
            container.find('.btn-detail').show();
            container.find('.btn-jam-Keluar').hide();
        });

        // $('body').on('click', '.btn-print', function() {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     let fromDate = $('#from_date').val();
        //     let toDate = $('#to_date').val();
        //     let kategori = $('select[name=kategori] option').filter(':selected').val()
        //     $.ajax({
        //         type: "POST",
        //         url: "/absensi/all/printAll",
        //         data: {
        //             fromDate: fromDate
        //             , toDate: toDate
        //             , kategori: kategori
        //         }
        //         , dataType: "JSON",
        //         success: function (response) {
        //             console.log(response)
        //         }
        //     });
        // })
    });

</script>
@endpush
