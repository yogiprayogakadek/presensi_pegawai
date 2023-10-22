<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => 'required|min:8',
            'new_password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required|same:new_password|min:8',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'mimes' => ':attribute harus berupa file :values',
            'image' => ':attribute harus berupa file gambar',
            'date' => ':attribute harus berupa tanggal',
            'numeric' => ':attribute harus berupa angka',
            'email' => ':attribute salah format',
            'same' => ':attribute tidak sama',
            'min' => ':attribute minimal :min karakter',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'Password saat ini',
            'new_password' => 'Password baru',
            'confirm_password' => 'Konfirmasi password',
        ];
    }
}
