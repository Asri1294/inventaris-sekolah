<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'condition_on_return' => ['required', 'in:baik,rusak ringan,rusak berat'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'condition_on_return.required' => 'Kondisi saat dikembalikan wajib dipilih.',
            'condition_on_return.in' => 'Kondisi yang dipilih tidak valid.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ];
    }
}
