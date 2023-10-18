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
        $firstOfDate = Carbon::now()->startOfMonth();
        $lastOfDate = Carbon::now()->endOfMonth();

        $pegawai = Pegawai::with('absensi')->get();

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
        ]);
    }

    public function filter(Request $request)
    {
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
            ])-> render()
        ];

        return response()->json($data);
    }

    public function byName()
    {
        return view('main.absensi.by-name');
    }
}
