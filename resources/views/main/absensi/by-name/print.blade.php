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
                        <div
                            style="
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
                    <td align="right"
                        style="
                text-align: right;
                padding-left: 50px;
                line-height: 1.5;
                color: #323232;
              ">
                        <div>
                            <h4 style="margin-top: 5px; margin-bottom: 5px">
                                Laporan Absensi
                            </h4>
                            <p>Semoga informasi yang disajikan di sini membantu Anda dalam mengelola kehadiran karyawan dengan lebih efisien.</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <table class="table table-bordered h4-14" style="width: 100%; -fs-table-paginate: paginate; margin-top: 15px">
            <thead>
                {{-- <thead style="display: table-header-group"> --}}
                <tr
                    style="
              margin: 0;
              background: #fcbd021f;
              padding: 15px;
              padding-left: 20px;
              -webkit-print-color-adjust: exact;
            ">
                    <td colspan="4">
                        <h3>
                            E-Reporting Absensi
                            <p
                                style="
                    font-weight: 300;
                    font-size: 85%;
                    color: #626262;
                    margin-top: 7px;
                  ">
                                Nama Pegawai:
                                <span style="color: #000000">{{ $pegawai->nama }}</span><br />
                            </p>
                        </h3>
                    </td>
                    <td colspan="5">
                        <p>Print Date:- {{ now() }}</p>
                        <p style="margin: 5px 0">Filter Date:- {{ $fromDate }} until
                            {{ $toDate }}</p>
                    </td>
                    <td colspan="4" style="width: 300px">
                        <h4 style="margin: 0">Print By:</h4>
                        <p>
                            {{ auth()->user()->email }},<br />
                            {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </td>
                </tr>

                <tr>
                    <th style="width: 50px" rowspan="2" class="text-center">#</th>
                    <th style="width: 150px" rowspan="2" class="text-center">
                        <h4>Tanggal</h4>
                    </th>
                    <th style="width: 100px" colspan="12" class="text-center">Absensi - {{ $pegawai->nama }}</th>
                </tr>
                <tr>
                    <th colspan="6" class="text-center">Jam Masuk</th>
                    <th colspan="6" class="text-center">Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dateFormatted as $key => $df)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">
                            {!! $df !!}
                        </td>
                        @forelse ($pegawai->absensi as $item)
                            @php
                                $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$key]);
                            @endphp
                            <td class="text-center" colspan="6">
                                @if ($absensiRecord)
                                    @if ($absensiRecord->jam_masuk !== null)
                                        <div class="jam-masuk">
                                            {{ $absensiRecord->jam_masuk }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center" colspan="6">
                                @if ($absensiRecord)
                                    @if ($absensiRecord->jam_keluar !== null)
                                        <div class="jam-keluar">
                                            {{ $absensiRecord->jam_keluar }}
                                        </div>
                                    @else
                                    -
                                    @endif
                                @else
                                -
                                @endif
                            </td>
                        @empty
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        @endforelse
                    </tr>
                @endforeach
                {{-- @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td colspan="12">{{ $category->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" style="text-align: center">
                            <h3>No data</h3>
                        </td>
                    </tr>
                @endforelse --}}
            </tbody>
        </table>
    </section>
</body>

</html>
