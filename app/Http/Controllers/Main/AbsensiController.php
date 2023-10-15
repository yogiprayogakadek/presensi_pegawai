<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function all()
    {
        $pegawai = Pegawai::with('absensi')->get();

        $fromDate = Carbon::parse("2023-10-10");
        $toDate = Carbon::parse("2023-10-20");


        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }


        return view('main.absensi.all')->with([
            'dateFormatted' => $dateFormatted,
            'dates' => $dates,
            'pegawai' => $pegawai
        ]);
    }

    public function byName()
    {
        return view('main.absensi.by-name');
    }
}
