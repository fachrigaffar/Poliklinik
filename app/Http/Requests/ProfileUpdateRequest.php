<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    $rules = [
        'nama' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255',
                   Rule::unique('users')->ignore($this->user()->id)],
        'alamat' => ['required', 'string', 'max:255'],
        'nik' => ['required', 'string', 'size:16'],
        'no_hp' => ['required', 'string', 'max:15'],
    ];

    // Validasi khusus untuk dokter
    if ($this->user()->role === 'dokter') {
        $rules['id_poli'] = ['nullable', 'exists:polis,id'];
    }

    // Validasi khusus untuk pasien
    if ($this->user()->role === 'pasien') {
        $rules['no_rm'] = ['nullable', 'string', 'max:16'];
    }

    return $rules;
}
}
