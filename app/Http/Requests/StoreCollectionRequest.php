<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'foto'=>'nullable|image|max:2048',
            'no_registrasi'=>'required',
            'nama_koleksi'=>'required',
            'asal'=>'required',
            'kondisi'=>'required',
        ];
    }
}