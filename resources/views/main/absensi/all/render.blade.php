<table class="table table-hover table-bordered table-responsive">
    <thead>
        <tr class="text-center">
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th colspan="{{ count($dates) }}">Tanggal <p class="font-italic">{{date_format(date_create($fromDate), 'd-m-Y')}} s/d {{date_format(date_create($toDate), 'd-m-Y')}}</p></th>
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
