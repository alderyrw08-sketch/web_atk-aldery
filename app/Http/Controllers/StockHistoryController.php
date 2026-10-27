<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockHistoryController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('name')->get();
        return view('stock-history.index', compact('barangs'));
    }

    public function data(Request $request)
    {
        $query = StockHistory::with(['item', 'user'])->select('stock_histories.*')->orderByDesc('id');

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', fn ($h) => Carbon::parse($h->created_at)->format('d-m-Y H:i'))
            ->addColumn('item_name', fn ($h) => $h->item->name ?? '-')
            ->addColumn('user_name', fn ($h) => $h->user->name ?? '-')
            ->editColumn('quantity', fn ($h) => '<span class="fw-bold ' . ($h->quantity >= 0 ? 'text-success' : 'text-danger') . '">'
                . ($h->quantity > 0 ? '+' : '') . $h->quantity . '</span>')
            ->editColumn('notes', fn ($h) => $h->notes ?: '-')
            ->filterColumn('item_name', fn ($q, $kw) => $q->whereHas('item', fn ($i) => $i->where('name', 'like', "%{$kw}%")))
            ->rawColumns(['quantity'])
            ->make(true);
    }
}