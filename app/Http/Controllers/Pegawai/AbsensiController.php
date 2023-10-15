<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\LogQrcode;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // public function store($qrCode)
    // {
    //     $data = explode('_', $qrCode);
    //     $pegawai = Pegawai::find($data[0]);
    //     $logQr = LogQrcode::where('pegawai_id', $pegawai->id)->first();

    //     $jsonData = json_decode($logQr->json_data, true);
    //     if($qrCode === $jsonData[count($jsonData)-1]['qr_code']) {
    //         $absensi = Absensi::where('pegawai_id', $pegawai->id)
    //                             ->where('tanggal', date('Y-m-d'))->first();

    //         if(!$absensi) {
    //             Absensi::create([
    //                 'pegawai_id' => $pegawai->id,
    //                 'jam_masuk' => date('H:i:s'),
    //                 'tanggal' => date('Y-m-d')
    //             ]);

    //             // update status pada log qr code
    //             if($jsonData(count($jsonData)-1)['status'] === false) {
    //                 $jsonData(count($jsonData)-1)['status'] = true;
    //                 $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
    //                 $logQr->save();
    //             }

    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => "Hai, selamat pagi " . $pegawai->nama . "! Absensimu berhasil disimpan",
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 409,
    //                 'message' => "Anda sudah melakukan absen hari ini"
    //             ]);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 409,
    //             'message' => 'QR Code expired'
    //         ]);
    //     }
    // }

    public function store($qrCode)
    {
        $data = explode('_', $qrCode);
        $pegawai = Pegawai::find($data[0]);
        $logQr = LogQrcode::where('pegawai_id', $pegawai->id)->first();

        $jsonData = json_decode($logQr->json_data, true);

        if($qrCode === $jsonData[count($jsonData)-1]['qr_code']) {
            $absensi = Absensi::where('pegawai_id', $pegawai->id)
                                ->where('tanggal', date('Y-m-d'))->first();

            if(!$absensi) {
                Absensi::create([
                    'pegawai_id' => $pegawai->id,
                    'jam_masuk' => date('H:i:s'),
                    'tanggal' => date('Y-m-d')
                ]);
                // update status pada log qr code
                if($jsonData[count($jsonData)-1]['status'] === false) {
                    $jsonData[count($jsonData)-1]['status'] = true;
                    $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                    $logQr->save();
                }

                return response()->json([
                    'status' => 200,
                    'message' => "Hai, selamat pagi " . $pegawai->nama . "! Absensimu berhasil disimpan",
                ]);
            } else {
                return response()->json([
                    'status' => 409,
                    'message' => "Anda sudah melakukan absen hari ini"
                ]);
            }
        } else {
            return response()->json([
                'status' => 409,
                'message' => 'QR Code expired'
            ]);
        }
    }
}
