<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maya = User::where('email', 'maya@sekolah.test')->first();
        $ratih = User::where('email', 'ratih@sekolah.test')->first();

        $loans = [
            [$maya, 'OLR-001', 2, 14, 7, 'dikembalikan'],
            [$ratih, 'OLR-002', 4, 12, 7, 'dikembalikan'],
            [$maya, 'LAB-001', 1, 10, 5, 'dikembalikan'],
            [$maya, 'ELK-001', 1, 2, 7, 'dipinjam'],
            [$ratih, 'ELK-002', 1, 10, 5, 'terlambat'],
        ];

        foreach ($loans as [$user, $code, $quantity, $daysAgo, $duration, $status]) {
            $loanDate = now()->subDays($daysAgo);

            Loan::create([
                'user_id' => $user->id,
                'item_id' => Item::where('code', $code)->first()->id,
                'quantity' => $quantity,
                'loan_date' => $loanDate->toDateString(),
                'due_date' => $loanDate->copy()->addDays($duration)->toDateString(),
                'status' => $status,
            ]);
        }
    }
}
