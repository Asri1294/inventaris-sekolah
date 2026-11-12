<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $statuses = ['diajukan', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak'];

        $loans = Loan::with(['user', 'item'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    })->orWhereHas('item', function ($i) use ($search) {
                        $i->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('loan_date')
            ->paginate(10)
            ->withQueryString();

        return view('loans.index', compact('loans', 'statuses'));
    }
}
