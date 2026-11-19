<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected function perPage(Request $request,int $default = 10): int
    {
        $allowed = [5, 10, 25, 50];
        $value = (int) $request->input('per_page', $default);

        return in_array($value, $allowed, true) ? $value : $default;
    }
}
