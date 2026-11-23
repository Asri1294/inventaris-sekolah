<?php

return [
    'required' => ':Attribute wajib diisi.',
    'string' => ':Attribute harus berupa teks.',
    'email' => 'Format :attribute tidak valid.',
    'unique' => ':Attribute ini sudah digunakan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'lowercase' => ':Attribute harus ditulis dengan huruf kecil.',
    'integer' => ':Attribute harus berupa bilangan bulat.',
    'numeric' => ':Attribute harus berupa angka.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'exists' => ':Attribute yang dipilih tidak valid.',
    'in' => ':Attribute yang dipilih tidak valid.',
    'current_password' => 'Kata sandi saat ini salah.',

    'max' => [
        'numeric' => ':Attribute maksimal :max.',
        'string' => ':Attribute maksimal :max karakter.',
    ],
    'min' => [
        'numeric' => ':Attribute minimal :min.',
        'string' => ':Attribute minimal :min karakter.',
    ],

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'current_password' => 'kata sandi saat ini',
    ],
];