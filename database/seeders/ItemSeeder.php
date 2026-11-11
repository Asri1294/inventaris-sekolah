<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $items = [
            ['Olahraga', 'Bola Basket', 'OLR-001', 12, 'baik'],
            ['Olahraga', 'Raket Badminton', 'OLR-002', 20, 'baik'],
            ['Olahraga', 'Bola Voli', 'OLR-003', 10, 'rusak ringan'],
            ['Laboratorium', 'Mikroskop Binokuler', 'LAB-001', 8, 'baik'],
            ['Laboratorium', 'Gelas Ukur 100 ml', 'LAB-002', 25, 'baik'],
            ['Laboratorium', 'Tabung Reaksi', 'LAB-003', 40, 'baik'],
            ['Elektronik', 'Proyektor Epson', 'ELK-001', 5, 'baik'],
            ['Elektronik', 'Laptop Acer', 'ELK-002', 10, 'baik'],
            ['Elektronik', 'Speaker Portable', 'ELK-003', 3, 'rusak ringan'],
            ['Elektronik', 'Kabel HDMI', 'ELK-004', 15, 'baik'],
        ];

        foreach ($items as [$category, $name, $code, $stock, $condition]) {
            Item::create([
                'category_id' => $categories[$category],
                'name' => $name,
                'code' => $code,
                'stock' => $stock,
                'condition' => $condition,
            ]);
        }
    }
}
