<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('absensi')->get();

        $firstOfDate = Carbon::now()->startOfMonth();
        $lastOfDate = Carbon::now()->endOfMonth();

        $fromDate = Carbon::parse($firstOfDate);
        $toDate = Carbon::parse($lastOfDate);


        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }

        return view('main.absensi.all.index')->with([
            'dateFormatted' => $dateFormatted,
            'dates' => $dates,
            'pegawai' => $pegawai,
            'firstOfDate' => $firstOfDate,
            'lastOfDate' => $lastOfDate,
            'kategori' => 'Masuk'
        ]);
    }

    public function filter(Request $request)
    {
        $kategori = $request->kategori;
        $pegawai = Pegawai::with('absensi')->get();

        $fromDate = Carbon::parse($request->fromDate);
        $toDate = Carbon::parse($request->toDate);


        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }

        $data = [
            'data' => view('main.absensi.all.render')->with([
                'dateFormatted' => $dateFormatted,
                'dates' => $dates,
                'pegawai' => $pegawai,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'kategori' => $kategori,
            ])->render()
        ];

        return response()->json($data);
    }

    public function byNameIndex()
    {
        $pegawai = Pegawai::pluck('nama', 'id')->toArray();
        $firstOfDate = Carbon::now()->startOfMonth();
        $lastOfDate = Carbon::now()->endOfMonth();

        $dates = [];
        $dateFormatted = [];

        for ($date = $firstOfDate; $date->lte($lastOfDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }

        return view('main.absensi.by-name.index', compact('pegawai', 'dates', 'dateFormatted'));
    }

    public function byNameFilter(Request $request)
    {
        $kategori = $request->kategori;
        $pegawai = Pegawai::with('absensi')->where('id', $request->pegawaiID)->first();

        $fromDate = Carbon::parse($request->fromDate);
        $toDate = Carbon::parse($request->toDate);


        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }

        $data = [
            'data' => view('main.absensi.by-name.render')->with([
                'dateFormatted' => $dateFormatted,
                'dates' => $dates,
                'pegawai' => $pegawai,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
            ])->render()
        ];

        return response()->json($data);
    }

    public function print(Request $request)
    {
        $pegawai = Pegawai::with('absensi')->where('id', $request->pegawai)->first();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);

        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }


        $pdf = \PDF::loadview('main.absensi.by-name.print', compact('dateFormatted', 'dates', 'pegawai', 'fromDate', 'toDate'));
        $pdf->setPaper('a3', 'landscape');
        return $pdf->download('Absensi - ' . time() . '.pdf');
    }
}
