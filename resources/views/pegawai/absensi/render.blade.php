<table class="table table-hover table-bordered">
    <thead class="text-center">
        <tr>
            <th class="align-middle" rowspan="2">#</th>
            <th class="align-middle" rowspan="2">Tanggal</th>
            <th colspan="2">Absensi - {{ $pegawai->nama }}</th>
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
            @php
            $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$key]);
            @endphp
            <td class="text-center">
                @if ($absensiRecord && $absensiRecord->jam_masuk !== null)
                <div class="btn-detail" data-kategori="masuk" data-absensi="{{ $absensiRecord }}">
                    <i style="cursor: pointer;" class="fa fa-check"></i>
                </div>
                @else
                <i class="fa fa-times" style="color: red;"></i>
                @endif
            </td>
            <td class="text-center">
                @if ($absensiRecord && $absensiRecord->jam_keluar !== null)
                <div class="btn-detail-keluar" data-kategori="keluar" data-absensi="{{ $absensiRecord }}">
                    <i style="cursor: pointer;" class="fa fa-check"></i>
                </div>
                @else
                <i class="fa fa-times" style="color: red;"></i>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
