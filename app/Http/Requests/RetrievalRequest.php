<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetrievalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Mengizinkan semua user untuk mengakses request ini
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'container_number' => 'required|string|max:255',
            'container_name' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'retrieval_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'container_number.required' => 'Nomor container harus diisi',
            'container_number.max' => 'Nomor container tidak boleh lebih dari 255 karakter',
            'container_name.required' => 'Nama container harus diisi',
            'container_name.max' => 'Nama container tidak boleh lebih dari 255 karakter',
            'license_plate.required' => 'Nomor plat kendaraan harus diisi',
            'license_plate.max' => 'Nomor plat kendaraan tidak boleh lebih dari 255 karakter',
            'retrieval_date.required' => 'Tanggal pengambilan harus diisi',
            'retrieval_date.date' => 'Format tanggal pengambilan tidak valid',
            'retrieval_date.after_or_equal' => 'Tanggal pengambilan harus hari ini atau setelahnya',
            'notes.string' => 'Catatan harus berupa teks'
        ];
    }
}
