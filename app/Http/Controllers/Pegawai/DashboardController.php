<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\LogQrcode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pegawai.dashboard.index');
    }

    public function generateQRCode()
    {
        $logQr = LogQrcode::where('pegawai_id', auth()->user()->pegawai->id)->first();
        $jsonData = json_decode($logQr->json_data, true);

        $qr = $jsonData[count($jsonData)-1]['qr_code'];
        $qrCode = QrCode::size(250)->generate($qr);
        return response($qrCode)->header('Content-type', 'image/png');
    }
}
