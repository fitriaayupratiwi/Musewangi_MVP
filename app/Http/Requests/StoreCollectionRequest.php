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
            'foto'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rekam_suara'=>'nullable|mimes:mp3,wav,ogg|max:10240',
            'no_registrasi'=>'required',
            'no_registrasi_lama'=>'nullable',
            'nama_koleksi'=>'required',
            'kategori'=>'nullable',
            'jenis_benda'=>'nullable',
            'tahun_pembuatan'=>'nullable',
            'asal'=>'required',
            'kondisi'=>'required',
            'deskripsi'=>'nullable',
        ];
    }
}