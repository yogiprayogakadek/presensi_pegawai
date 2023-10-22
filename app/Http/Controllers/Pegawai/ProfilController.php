<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::find(auth()->user()->pegawai->id);
        $statusPerkawinan = ['', 'Belum kawin', 'Kawin', 'Cerai hidup', 'Cerai mati'];
        $pendidikanTerakhir = ['', 'SD', 'SMP', 'SMA atau sederajat', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Diploma 4', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S4)'];
        $jenisKelamin = ['', 'Laki-laki', 'Perempuan'];

        return view('pegawai.profil.index')->with([
            'pegawai' => $pegawai,
            'statusPerkawinan' => $statusPerkawinan,
            'pendidikanTerakhir' => $pendidikanTerakhir,
            'jenisKelamin' => $jenisKelamin,
        ]);
    }

    public function update(UpdateProfilRequest $request)
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
            ]);

            return redirect()->route('staff.profil.index')->with([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data pegawai berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => $e->getMessage()
                // 'message' => 'Data pegawai gagal diubah.'
            ]);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $user = User::where('id', auth()->user()->id)->first();

            if ($request->current_password != '') {
                if (!password_verify($request->current_password, $user->password)) {
                    return redirect()->back()->with([
                        'status' => 'error',
                        'message' => 'Password lama tidak sesuai',
                        'title' => 'Gagal'
                    ]);
                }

                // Update password baru jika sudah benar
                $user->update([
                    'password' => bcrypt($request->new_password)
                ]);
            }

            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'title' => 'Berhasil'
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
