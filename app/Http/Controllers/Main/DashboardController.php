<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\LogQrcode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('main.dashboard.index');
    }

    public function absensi()
    {
        $config = Config::first();
        $json = json_decode($config->json_data, true);

        $jamMasuk_awal = $json['jam_masuk']['batas_awal'];
        $jamMasuk_akhir = $json['jam_masuk']['batas_akhir'];
        $jamKeluar_awal = $json['jam_keluar']['batas_awal'];
        $jamKeluar_akhir = $json['jam_keluar']['batas_akhir'];
        return view('main.dashboard.absensi', compact(
            'jamMasuk_awal','jamMasuk_akhir', 'jamKeluar_awal', 'jamKeluar_akhir'
        ));
    }

    public function configDB()
    {
        $config = Config::first();
        $json = json_decode($config->json_data, true);
        return response()->json($json);
    }

    public function updateLogQr()
    {
        $logQr = LogQrcode::all();

        try {
            foreach($logQr as $log) {
                $qrCode = $log->pegawai_id . '_' . date('Y-m-d H:i:s');
                $jsonData = json_decode($log->json_data, true);

                // get last data
                // if($jsonData[count($jsonData)-1]['status'] === false) {
                //     $jsonData[count($jsonData)-1]['qr_code'] = $qrCode;
                //     $log->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                //     $log->save();
                // }

                // NEW UPDATE
                if($jsonData[count($jsonData)-1]['status_masuk'] == false || $jsonData[count($jsonData)-1]['status_keluar'] === false) {
                    $jsonData[count($jsonData)-1]['qr_code'] = $qrCode;
                    $log->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                    $log->save();
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 200,
                // 'message' => 'Data gagal diubah'
                'message' => $th->getMessage()
            ]);
        }
    }

    // public function generateQRCode()
    // {
    //     $qrCode = QrCode::size(200)->generate('www.pondokmasadepan.com');
    //     return response($qrCode)->header('Content-type', 'image/png');
    // }
}
