<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Config;
use App\Models\LogQrcode;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $firstOfDate = Carbon::now()->startOfMonth();
        $lastOfDate = Carbon::now()->endOfMonth();

        $dates = [];
        $dateFormatted = [];

        for ($date = $firstOfDate; $date->lte($lastOfDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }

        return view('pegawai.absensi.index', compact('dates', 'dateFormatted'));
    }

    public function filter(Request $request)
    {
        $pegawai = Pegawai::with('absensi')->where('id', auth()->user()->pegawai->id)->first();

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
            'data' => view('pegawai.absensi.render')->with([
                'dateFormatted' => $dateFormatted,
                'dates' => $dates,
                'pegawai' => $pegawai,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
            ])-> render()
        ];

        return response()->json($data);
    }

    public function store($qrCode)
    {
        $config = Config::first();
        $configData = json_decode($config->json_data, true);
        $data = explode('_', $qrCode);
        $pegawai = Pegawai::find($data[0]);
        $logQr = LogQrcode::where('pegawai_id', $pegawai->id)->first();
        $currentTime = date('H:i:s');

        $jsonData = json_decode($logQr->json_data, true);

        if($qrCode === $jsonData[count($jsonData)-1]['qr_code']) {
            $absensi = Absensi::where('pegawai_id', $pegawai->id)
                                ->where('tanggal', date('Y-m-d'))->first();

            if(!$absensi) {
                if($currentTime < $configData['jam_keluar']['batas_akhir']) {
                    // NEW UPDATE
                    if($jsonData[count($jsonData)-1]['status_masuk'] === false) {
                        $jsonData[count($jsonData)-1]['status_masuk'] = true;
                        $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                        $logQr->save();
                    }
                    Absensi::create([
                        'pegawai_id' => $pegawai->id,
                        'jam_masuk' => date('H:i:s'),
                        'tanggal' => date('Y-m-d')
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => "Hai, selamat pagi " . $pegawai->nama . "! Absensimu berhasil disimpan",
                    ]);
                } else {
                    return response()->json([
                        'status' => 403,
                        'message' => "Maaf, waktu absensi telah habis"
                    ], 403);
                }
            } else {

                // if($configData['jam_masuk']['batas_awal'] < $currentTime || $currentTime < $configData['jam_keluar']['batas_awal']) {
                //     if($jsonData[count($jsonData)-1]['status_masuk'] === false) {
                //         $jsonData[count($jsonData)-1]['status_masuk'] = true;
                //         $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                //         $logQr->save();
                //     }
                //     Absensi::create([
                //         'pegawai_id' => $pegawai->id,
                //         'jam_masuk' => date('H:i:s'),
                //         'tanggal' => date('Y-m-d')
                //     ]);
                // } elseif($configData['jam_keluar']['batas_akhir'] < $currentTime || $configData['jam_keluar']['batas_awal'] > $currentTime) {
                //     if($jsonData[count($jsonData)-1]['status_keluar'] === false) {
                //         $jsonData[count($jsonData)-1]['status_keluar'] = true;
                //         $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                //         $logQr->save();
                //     }
                //     $absensi = Absensi::where('pegawai_id', $pegawai->id)->whereDate('tanggal', date('Y-m-d'))->first();
                //     $absensi->update([
                //         'jam_keluar' => date('H:i:s')
                //     ]);
                // }

                if($currentTime > $configData['jam_keluar']['batas_awal'] && $currentTime < $configData['jam_keluar']['batas_akhir']) {
                    $absensi = Absensi::where('pegawai_id', $pegawai->id)->whereDate('tanggal', date('Y-m-d'))->first();

                    if($absensi->jam_keluar == null) {
                        if($jsonData[count($jsonData)-1]['status_keluar'] === false) {
                            $jsonData[count($jsonData)-1]['status_keluar'] = true;
                            $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                            $logQr->save();
                        }

                        $absensi->update([
                            'jam_keluar' => date('H:i:s')
                        ]);

                        return response()->json([
                            'status' => 200,
                            'message' => "Absen keluar anda berhasil"
                        ]);
                    } else {
                        return response()->json([
                            'status' => 409,
                            'message' => "Anda sudah absen keluar hari ini"
                        ]);
                    }

                } else {
                    return response()->json([
                        'status' => 409,
                        'message' => "Belum waktunya absen keluar"
                    ]);

                }


                // return response()->json([
                //     'status' => 409,
                //     'message' => "Anda sudah melakukan absen hari ini"
                // ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Absen keluar anda berhasil"
                ]);
            }
        } else {
            return response()->json([
                'status' => 409,
                'message' => 'QR Code expired'
            ]);
        }
    }

    public function print(Request $request)
    {
        $pegawai = Pegawai::with('absensi')->where('id', auth()->user()->pegawai->id)->first();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);

        $dates = [];
        $dateFormatted = [];

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $formattedDate = '<span style="font-size: smaller;"><sup>' . $date->day . '</sup>/<sub>' . $date->month . '</sub>/<small>' . $date->year . '</small></span>';
            $dateFormatted[] = $formattedDate;
            $dates[] = $date->toDateString();
        }


        $pdf = \PDF::loadview('pegawai.absensi.print', compact('dateFormatted', 'dates', 'pegawai', 'fromDate', 'toDate'));
        $pdf->setPaper('a3', 'landscape');
        return $pdf->download('Absensi - ' . time() . '.pdf');
    }
}
