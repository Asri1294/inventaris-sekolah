<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoanRequest;
use App\Models\ActivityLog;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserLoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('item')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('my-loans.index', compact('loans'));
    }

    public function create()
    {
        $items = Item::where('stock', '>', 0)
            ->where('condition', '!=', 'rusak berat')
            ->orderBy('name')
            ->get();

        return view('my-loans.create', compact('items'));
    }

    public function store(UserLoanRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $item = Item::findOrFail($data['item_id']);

            if ($item->condition === 'rusak berat') {
                throw ValidationException::withMessages([
                    'item_id' => 'Barang rusak berat tidak dapat dipinjam.',
                ]);
            }

            if ($data['quantity'] > $item->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Jumlah melebihi stok tersedia ({$item->stock}).",
                ]);
            }

            Loan::create($data + [
                'user_id' => auth()->id(),
                'status' => 'diajukan',
            ]);

            ActivityLog::record(
                'request_loan',
                "Mengajukan peminjaman {$item->name} sejumlah {$data['quantity']}."
            );
        });

        return redirect()->route('my-loans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
