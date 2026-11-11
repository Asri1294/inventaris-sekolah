<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\ReturnLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = ['baik', 'baik', 'rusak ringan'];
        $notes = [
            'Dikembalikan lengkap.',
            'Dikembalikan tepat waktu.',
            'Ada goresan kecil pada lensa.',
        ];

        $loans = Loan::where('status', 'dikembalikan')->orderBy('id')->get();

        foreach ($loans as $index => $loan) {
            ReturnLog::create([
                'loan_id' => $loan->id,
                'returned_at' => $loan->due_date->toDateString(),
                'condition_on_return' => $conditions[$index],
                'notes' => $notes[$index],
            ]);
        }
    }
}
