<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
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
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('items', 'code')->ignore($this->item),
            ],
            'stock' => ['required', 'integer', 'min:0'],
            'condition' => ['required', Rule::in(['baik', 'rusak ringan', 'rusak berat'])],
        ];
    }

        public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.max' => 'Nama barang maksimal 255 karakter.',
            'code.required' => 'Kode barang wajib diisi.',
            'code.max' => 'Kode barang maksimal 50 karakter.',
            'code.unique' => 'Kode barang sudah digunakan.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'condition.required' => 'Kondisi wajib dipilih.',
            'condition.in' => 'Kondisi tidak valid.',
        ];
    }
}
