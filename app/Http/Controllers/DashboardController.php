<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        Loan::markOverdue();

        if (auth()->user()->isAdmin()) {
            $stats = [
                'items' => Item::count(),
                'borrowed' => Loan::where('status', 'dipinjam')->count(),
                'overdue' => Loan::where('status', 'terlambat')->count(),
                'pending' => Loan::where('status', 'diajukan')->count(),
            ];

            return view('dashboard.admin', compact('stats'));
        }

        $userId = auth()->id();

        $stats = [
            'borrowed' => Loan::where('user_id', $userId)->where('status', 'dipinjam')->count(),
            'overdue' => Loan::where('user_id', $userId)->where('status', 'terlambat')->count(),
            'pending' => Loan::where('user_id', $userId)->where('status', 'diajukan')->count(),
        ];

        $recentLoans = Loan::with('item')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard.user', compact('stats', 'recentLoans'));
    }
}
