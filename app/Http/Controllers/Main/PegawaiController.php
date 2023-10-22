<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRequest;
use App\Models\LogQrcode;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();

        return view('main.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $statusPerkawinan = ['', 'Belum kawin', 'Kawin', 'Cerai hidup', 'Cerai mati'];
        $pendidikanTerakhir = ['', 'SD', 'SMP', 'SMA atau sederajat', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Diploma 4', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S4)'];
        $jenisKelamin = ['', 'Laki-laki', 'Perempuan'];

        return view('main.pegawai.create')->with([
            'statusPerkawinan' => $statusPerkawinan,
            'pendidikanTerakhir' => $pendidikanTerakhir,
            'jenisKelamin' => $jenisKelamin,
        ]);
    }

    public function store(PegawaiRequest $request)
    {
        DB::beginTransaction();
        try {
            // tambah ke table user terlebih dahulu
            $dataUser = [
                'email' => $request->email,
                'password' => bcrypt(12345678),
                'role' => 'pegawai',
            ];

            if ($request->hasFile('foto')) {
                $fileName = str_replace(' ', '', $request->nama) . '-' . time() . '.' . $request->file('foto')->getClientOriginalExtension();
                $path = 'assets/uploads/users';

                if (!file_exists($path)) {
                    mkdir($path, 666, true);
                }

                $request->file('foto')->move($path, $fileName);
                $dataUser['foto'] = $path . '/' . $fileName;
            } else {
                $dataUser['foto'] = 'assets/uploads/users/default.png';
            }

            $user = User::create($dataUser);

            // kemudian save ke table pegawai
            $dataPegawai = [
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_perkawinan' => $request->status_perkawinan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
            ];

            $pegawai = Pegawai::create($dataPegawai);

            // selanjutnya tambahkan 1 data ke log qr code apabila data pegawai sukses ditambahkan
            $qrCode = $pegawai->id . '_' . date('Y-m-d H:i:s');
            $json_data[] = [
                'id' => 1,
                'tanggal' => date('Y-m-d'),
                'qr_code' => $qrCode,
                // 'status' => false

                // new update
                'status_masuk' => false,
                'status_keluar' => false
            ];

            $dataQr = [
                'pegawai_id' => $pegawai->id,
                'json_data' => json_encode($json_data)
            ];

            LogQrcode::create($dataQr);

            DB::commit();

            return redirect()->route('pegawai.index')->with([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data pegawai berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => $e->getMessage()
                // 'message' => 'Data pegawai gagal disimpan.'
            ]);
        }
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $statusPerkawinan = ['', 'Belum kawin', 'Kawin', 'Cerai hidup', 'Cerai mati'];
        $pendidikanTerakhir = ['', 'SD', 'SMP', 'SMA atau sederajat', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Diploma 4', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S4)'];
        $jenisKelamin = ['', 'Laki-laki', 'Perempuan'];

        return view('main.pegawai.edit')->with([
            'statusPerkawinan' => $statusPerkawinan,
            'pendidikanTerakhir' => $pendidikanTerakhir,
            'jenisKelamin' => $jenisKelamin,
            'pegawai' => $pegawai,
        ]);
    }

    public function update(PegawaiRequest $request)
    {
        try {
            $user = User::find($request->user_id);

            if ($request->hasFile('foto')) {
                $fileName = str_replace(' ', '', $request->nama) . '-' . time() . '.' . $request->file('foto')->getClientOriginalExtension();
                $path = 'assets/uploads/users';

                if (!file_exists($path)) {
                    mkdir($path, 666, true);
                }

                $request->file('foto')->move($path, $fileName);
                $user->update([
                    'foto' => $path . '/' . $fileName
                ]);
            }

            $user->update([
                'is_active' => $request->status
            ]);

            // kemudian save ke table pegawai
            $user->pegawai->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_perkawinan' => $request->status_perkawinan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'is_active' => $request->status
            ]);

            return redirect()->route('pegawai.index')->with([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data pegawai berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Data pegawai gagal diubah.'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('pegawai.index')->with([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }
}
