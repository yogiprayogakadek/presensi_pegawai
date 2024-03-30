<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>E-Reporting</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png" />
    <style>
        * {
            box-sizing: border-box;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
            padding: 10px;
            word-break: break-all;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        .h4-14 h4 {
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .img {
            margin-left: "auto";
            margin-top: "auto";
            height: 30px;
        }

        pre,
        p {
            /* width: 99%; */
            /* overflow: auto; */
            /* bpicklist: 1px solid #aaa; */
            padding: 0;
            margin: 0;
        }

        table {
            font-family: arial, sans-serif;
            width: 100%;
            border-collapse: collapse;
            padding: 1px;
        }

        .hm-p p {
            text-align: left;
            padding: 1px;
            padding: 5px 4px;
        }

        td,
        th {
            text-align: left;
            padding: 8px 6px;
        }

        .table-b td,
        .table-b th {
            border: 1px solid #ddd;
        }

        th {
            /* background-color: #ddd; */
        }

        .hm-p td,
        .hm-p th {
            padding: 3px 0px;
        }

        .cropped {
            float: right;
            margin-bottom: 20px;
            height: 100px;
            /* height of container */
            overflow: hidden;
        }

        .cropped img {
            width: 400px;
            margin: 8px 0px 0px 80px;
        }

        .main-pd-wrapper {
            box-shadow: 0 0 10px #ddd;
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>

<body>
    <section class="main-pd-wrapper" style="width: 100%;">
        <div>
            <h4 style="text-align: center; margin: 0">
                <b>Laporan Absensi</b>
            </h4>

            <table style="width: 100%; table-layout: fixed">
                <tr>
                    <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
                        <div style="
                  text-align: center;
                  margin: auto;
                  line-height: 1.5;
                  font-size: 14px;
                  color: #4a4a4a;
                ">
                            <img src="{{ public_path('assets/images/logo.png') }}" width="150px">

                            <p style="font-weight: bold; margin-top: 15px">
                                KOMISI PEMILIHAN UMUM - KABUPATEN NGADA
                            </p>
                        </div>
                    </td>
                    <td align="right" style="
                text-align: right;
                padding-left: 50px;
                line-height: 1.5;
                color: #323232;
              ">
                        <div>
                            <h4 style="margin-top: 5px; margin-bottom: 5px">
                                Laporan Absensi
                            </h4>
                            <p>Semoga informasi yang disajikan di sini membantu Anda dalam mengelola kehadiran karyawan
                                dengan lebih efisien.</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <table class="table table-hover table-bordered table-responsive">
            <thead>
                <tr style="margin: 0; background: #fcbd021f; padding: 15px; padding-left: 20px; -webkit-print-color-adjust: exact;">
                    <td colspan="20">
                        <h3>
                            E-Reporting Absensi
                        </h3>
                    </td>
                    <td colspan="7">
                        <p>Print Date:- {{ now() }}</p>
                    </td>
                    <td colspan="7" style="width: 300px">
                        <h4 style="margin: 0">Print By:</h4>
                        <p>
                            {{ auth()->user()->email }},<br />
                            {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </td>
                </tr>
                <tr class="text-center">
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2" class="text-center">Nama</th>
                    <th class="text-center" colspan="{{ count($dates) }}">Absensi {{ $kategori }}
                        <br>
                        <p class="font-italic">{{ date('d-m-Y', strtotime($fromDate)) }} s/d {{ date('d-m-Y', strtotime($toDate)) }}</p>
                    </th>
                    <th class="text-center" rowspan="2">
                        Total
                    </th>
                </tr>
                <tr class="text-center">
                    @foreach ($dateFormatted as $df)
                        {{-- <td>{{$i}}</td> --}}
                        <th class="text-center">
                            {!! $df !!}
                        </th>
                    @endforeach
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($pegawai as $pegawai)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        @for ($i = 0; $i < count($dates); $i++)
                            <td class="text-center">
                                @php
                                    $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$i]);
                                @endphp

                                @if ($absensiRecord)
                                    @if (
                                        ($kategori == 'Masuk' && $absensiRecord->jam_masuk !== null) ||
                                            ($kategori == 'Keluar' && $absensiRecord->jam_keluar !== null))
                                        <div class="jam">
                                            <span>Masuk</span>
                                        </div>
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        @endfor

                    </tr>
                @endforeach
            </tbody> --}}

            <tbody>
                @foreach ($pegawai as $pegawai)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        @php
                            $totalAbsensi = 0; // variabel untuk menyimpan total absensi
                        @endphp
                        @for ($i = 0; $i < count($dates); $i++)
                            <td class="text-center">
                                @php
                                    $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$i]);
                                @endphp

                                @if ($absensiRecord)
                                    @if (
                                        ($kategori == 'Masuk' && $absensiRecord->jam_masuk !== null) ||
                                        ($kategori == 'Keluar' && $absensiRecord->jam_keluar !== null))
                                        <div class="text-center">
                                            <img src="assets/uploads/check.png" style="width: 15px">
                                        </div>
                                        @php
                                            $totalAbsensi++;
                                        @endphp
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        @endfor
                        <td>{{ $totalAbsensi }}</td>
                    </tr>
                @endforeach
            </tbody>


        </table>

        {{-- <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
            <tr>
                <th rowspan="2">
                    Total Absensi
                </th>
                <th class="text-center" colspan="{{ count($dates) }}">
                    <b>{{ count($absensiRecord) }}</b>
                </th>
            </tr>
        </table> --}}

        {{-- <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
            <tr>
                <td class="text-center">
                    Total Absensi
                </td>
                @foreach ($pegawai as $pegawai)
                    <td class="text-center" colspan="{{ count($dates) }}">
                        @php
                            $totalAbsensi = 0;
                        @endphp
                        @if ($absensiRecord)
                            @if (($kategori == 'Masuk' && $absensiRecord->jam_masuk !== null) || ($kategori == 'Keluar' && $absensiRecord->jam_keluar !== null))
                                @php
                                    $totalAbsensi++;
                                @endphp
                            @endif
                        @endif
                        {{$totalAbsensi}}
                    </td>
                @endforeach --}}
                    {{-- @foreach ($pegawai as $pegawai)
                        @php
                            $totalAbsensi = 0;
                        @endphp
                        @if ($absensiRecord)
                            @if (($kategori == 'Masuk' && $absensiRecord->jam_masuk !== null) || ($kategori == 'Keluar' && $absensiRecord->jam_keluar !== null))
                                @php
                                    $totalAbsensi++;
                                @endphp
                            @endif
                        @endif
                        <td class="text-center">{{ $totalAbsensi }}</td>
                    @endforeach --}}
            {{-- </tr>
        </table> --}}
    </section>
</body>

</html>
