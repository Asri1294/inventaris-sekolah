<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\LoanRequest;
use App\Models\ActivityLog;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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

    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();

        $items = Item::where('stock', '>', 0)
            ->where('condition', '!=', 'rusak berat')
            ->orderBy('name')
            ->get();

        return view('loans.create', compact('users', 'items'));
    }

    public function store(LoanRequest $request)
    {
        $data = $request->validated();

            DB::transaction(function () use ($data) {
                $item = Item::lockForUpdate()->findOrFail($data['item_id']);

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

            Loan::create($data + ['status' => 'dipinjam']);

            $item->decrement('stock', $data['quantity']);

            ActivityLog::record(
                'create_loan',
                "Mencatat peminjaman {$item->name} sejumlah {$data['quantity']}."
            );
        });

        return redirect()->route('loans.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function approve(Loan $loan)
    {
        try {
            DB::transaction(function () use ($loan) {
                $locked = Loan::lockForUpdate()->findOrFail($loan->id);

                if ($locked->status !== 'diajukan') {
                    throw ValidationException::withMessages([
                        'status' => 'Pengajuan ini sudah diproses.',
                    ]);
                }

                $item = Item::lockForUpdate()->findOrFail($locked->item_id);

                if ($item->condition === 'rusak berat') {
                    throw ValidationException::withMessages([
                        'item_id' => 'Barang rusak berat tidak dapat dipinjamkan.',
                    ]);
                }

                if ($locked->quantity > $item->stock) {
                    throw ValidationException::withMessages([
                        'quantity' => "Stok tidak cukup. Tersedia {$item->stock}, diminta {$locked->quantity}.",
                    ]);
                }

                $locked->update(['status' => 'dipinjam']);

                $item->decrement('stock', $locked->quantity);

                ActivityLog::record(
                    'approve_loan',
                    "Menyetujui peminjaman {$item->name} sejumlah {$locked->quantity} untuk {$locked->user->name}."
                );
            });
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        }

        return back()->with('success', 'Pengajuan disetujui, stok barang dikurangi.');
    }

    public function reject(Loan $loan)
    {
        try {
            DB::transaction(function () use ($loan) {
                $locked = Loan::lockForUpdate()->findOrFail($loan->id);

                if ($locked->status !== 'diajukan') {
                    throw ValidationException::withMessages([
                        'status' => 'Pengajuan ini sudah diproses.',
                    ]);
                }

                $locked->update(['status' => 'ditolak']);

                ActivityLog::record(
                    'reject_loan',
                    "Menolak peminjaman {$locked->item->name} sejumlah {$locked->quantity} dari {$locked->user->name}."
                );
            });
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        }

        return back()->with('success', 'Pengajuan ditolak.');
    }
}
