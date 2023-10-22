<table class="table table-hover table-bordered">
    <thead class="text-center">
        <tr>
            <th class="align-middle" rowspan="2">#</th>
                                <th class="align-middle" rowspan="2">Tanggal</th>
                                <th colspan="2">Absensi - {{$pegawai->nama}}</th>
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
                @forelse ($pegawai->absensi as $item)
                    @php
                        $absensiRecord = $pegawai->getAbsensiRecordForDate($dates[$key]);
                    @endphp
                    <td class="text-center">
                        @if ($absensiRecord)
                            @if ($absensiRecord->jam_masuk !== null)
                                <div class="jam-masuk">
                                    <i style="cursor: pointer;" class="fa fa-check btn-detail-masuk"
                                        data-absensi="{{ $absensiRecord }}" data-kategori="Masuk"></i>
                                </div>
                            @else
                                <i class="fa fa-times" style="color: red;"></i>
                            @endif
                        @else
                            <i class="fa fa-times" style="color: red;"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($absensiRecord)
                            @if ($absensiRecord->jam_keluar !== null)
                                <div class="jam-keluar">
                                    <i style="cursor: pointer;" class="fa fa-check btn-detail-keluar"
                                        data-absensi="{{ $absensiRecord }}" data-kategori="Keluar"></i>
                                </div>
                            @else
                                <i class="fa fa-times" style="color: red;"></i>
                            @endif
                        @else
                            <i class="fa fa-times" style="color: red;"></i>
                        @endif
                    </td>
                @empty
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                @endforelse
            </tr>
        @endforeach
    </tbody>
</table>
