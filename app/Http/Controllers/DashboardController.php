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

        return view('dashboard');
    }
}
