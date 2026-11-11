<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@sekolah.test')->first();
        $maya = User::where('email', 'maya@sekolah.test')->first();

        $logs = [
            [$admin, 'login', 'Administrator masuk ke sistem.'],
            [$admin, 'create_category', 'Administrator menambah kategori Olahraga.'],
            [$admin, 'create_item', 'Administrator menambah barang Bola Basket (OLR-001).'],
            [$maya, 'login', 'Maya masuk ke sistem.'],
            [$maya, 'request_loan', 'Maya mengajukan peminjaman Proyektor Epson.'],
            [$admin, 'verify_loan', 'Administrator memverifikasi peminjaman Proyektor Epson oleh Maya.'],
            [$admin, 'verify_return', 'Administrator memverifikasi pengembalian Mikroskop Binokuler.'],
        ];

        foreach ($logs as [$user, $action, $description]) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'description' => $description,
            ]);
        }
    }
}
