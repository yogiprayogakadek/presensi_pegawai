<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PegawaiRequest extends FormRequest
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
            // 'nip' => 'required|numeric|unique:pegawai,nip,' . $this->id,
            'nama' => 'required|unique:pegawai,nama,' . $this->id,
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'pendidikan_terakhir' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric|unique:pegawai,telp,' . $this->id,
        ];

        if (!Request::instance()->has('id')) {
            $rules += [
                'email' => 'required|unique:pegawai,telp,' . $this->id,
                // 'password' => 'required',
                'status' => 'nullable',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ];
        } else {
            $rules += [
                'email' => 'nullable',
                // 'password' => 'nullable',
                'status' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute sudah ada pada database.',
        ];
    }

    public function attributes()
    {
        return [
            // 'nip' => 'NIP',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'jenis_kelamin' => 'Jenis kelamin',
            'status_perkawinan' => 'Status perkawinan',
            'pendidikan_terakhir' => 'Pendidikan terakhir',
            'alamat' => 'Alamat',
            'telp' => 'No. telp',
            'email' => 'Email',
            // 'password' => 'Password',
            'status' => 'Status',
            'foto' => 'Foto',
        ];
    }
}
