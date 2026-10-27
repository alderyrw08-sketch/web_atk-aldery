<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['category', 'unit'])->where('status', true);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->status_stok === 'habis') {
            $query->where('stock', 0);
        } elseif ($request->status_stok === 'menipis') {
            $query->where('stock', '>', 0)->whereColumn('stock', '<=', 'minimum_stock');
        } elseif ($request->status_stok === 'aman') {
            $query->whereColumn('stock', '>', 'minimum_stock');
        }

        $barangs = $query->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('monitoring.index', compact('barangs', 'categories'));
    }
}