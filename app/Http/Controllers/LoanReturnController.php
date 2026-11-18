<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanReturnRequest;
use App\Models\ActivityLog;
use App\Models\Item;
use App\Models\Loan;
use App\Models\ReturnLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanReturnController extends Controller
{
    public function create(Loan $loan)
    {
        if (! in_array($loan->status, ['dipinjam', 'terlambat'])) {
            return redirect()->route('loans.index')
                ->with('error', 'Peminjaman ini tidak dapat dikembalikan.');
        }

        $loan->load(['user', 'item']);

        return view('loans.return', compact('loan'));
    }

    public function store(LoanReturnRequest $request, Loan $loan)
    {
        $data = $request->validated();
        $returnedBroken = $data['condition_on_return'] === 'rusak berat';

        try {
            DB::transaction(function () use ($loan, $data, $returnedBroken) {
                $locked = Loan::lockForUpdate()->findOrFail($loan->id);

                if (! in_array($locked->status, ['dipinjam', 'terlambat'])) {
                    throw ValidationException::withMessages([
                        'status' => 'Peminjaman ini sudah diproses.',
                    ]);
                }

                $item = Item::lockForUpdate()->findOrFail($locked->item_id);

                ReturnLog::create([
                    'loan_id' => $locked->id,
                    'returned_at' => now('Asia/Makassar')->toDateString(),
                    'condition_on_return' => $data['condition_on_return'],
                    'notes' => $data['notes'] ?? null,
                ]);

                $locked->update(['status' => 'dikembalikan']);

                if (! $returnedBroken) {
                    $item->increment('stock', $locked->quantity);
                }

                ActivityLog::record(
                    'return_loan',
                    "Mencatat pengembalian {$item->name} sejumlah {$locked->quantity} dari {$locked->user->name}, kondisi {$data['condition_on_return']}."
                );
            });
        } catch (ValidationException $e) {
            return redirect()->route('loans.index')
                ->with('error', collect($e->errors())->flatten()->first());
        }

        $message = $returnedBroken
            ? 'Pengembalian dicatat. Barang rusak berat tidak ditambahkan ke stok.'
            : 'Pengembalian dicatat, stok barang bertambah.';

        return redirect()->route('loans.index')->with('success', $message);
    }
}
