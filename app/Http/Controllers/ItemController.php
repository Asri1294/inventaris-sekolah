<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest; 
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->condition, function ($query, $condition) {
                $query->where('condition', $condition);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('items.index', compact('items', 'categories'));
    }

        public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('items.create', compact('categories'));
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());

        ActivityLog::record('create_item', "Menambah barang {$item->name}.");

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }
}
