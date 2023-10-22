<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'nip' => 'required|numeric|unique:pegawai,nip,' . $this->id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'pendidikan_terakhir' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        // if (!Request::instance()->has('id')) {
        //     $rules = [
        //         'current_password' => 'required|min:8',
        //         'new_password' => 'required|same:confirm_password|min:8',
        //         'confirm_password' => 'required|same:new_password|min:8',
        //     ];
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute sudah ada pada database.',
            'same' => ':attribute tidak sama',
            'min' => ':attribute minimal :min karakter',
        ];
    }

    public function attributes()
    {
        return [
            'nip' => 'NIP',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'jenis_kelamin' => 'Jenis kelamin',
            'status_perkawinan' => 'Status perkawinan',
            'pendidikan_terakhir' => 'Pendidikan terakhir',
            'alamat' => 'Alamat',
            'telp' => 'No. telp',
            'email' => 'Email',
            'status' => 'Status',
            'foto' => 'Foto',

            'current_password' => 'Password saat ini',
            'new_password' => 'Password baru',
            'confirm_password' => 'Konfirmasi password',
        ];
    }
}
