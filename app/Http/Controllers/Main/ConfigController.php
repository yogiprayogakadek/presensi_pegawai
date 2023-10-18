<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::all();
        return view('main.config.index')->with([
            'config' => $config
        ]);
    }

    public function edit($id)
    {
        $config = Config::find($id);

        return view('main.config.edit', compact('config'));
    }

    public function update(Request $request)
    {
        try {
            $config = Config::findOrFail($request->id);
            $json = json_decode($config->json_data, true);

            $json['jam_masuk'] = [
                'batas_awal' => $request->jam_masuk_batas_awal,
                'batas_akhir' => $request->jam_masuk_batas_akhir,
            ];
            $json['jam_keluar'] = [
                'batas_awal' => $request->jam_keluar_batas_awal,
                'batas_akhir' => $request->jam_keluar_batas_akhir,
            ];

            $config->json_data = json_encode($json, JSON_PRETTY_PRINT);
            $config->save();

            return redirect()->route('config.index')->with([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data config berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => $e->getMessage()
                // 'message' => 'Data pegawai gagal disimpan.'
            ]);
        }
    }
}
