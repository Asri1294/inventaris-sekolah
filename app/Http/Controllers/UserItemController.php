<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with('category')
            ->where('stock', '>', 0)
            ->where('condition', '!=', 'rusak berat')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderBy('name')
            ->paginate($this->perPage($request))
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('available-items.index', compact('items', 'categories'));
    }
}
