<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Config;
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
                // Absensi::create([
                //     'pegawai_id' => $pegawai->id,
                //     'jam_masuk' => date('H:i:s'),
                //     'tanggal' => date('Y-m-d')
                // ]);

                // update status pada log qr code
                // if($jsonData[count($jsonData)-1]['status'] === false) {
                //     $jsonData[count($jsonData)-1]['status'] = true;
                //     $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                //     $logQr->save();
                // }

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
}
