<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockOutDetail;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function index(Request $request)
    {
        $query = StockOutDetail::with(['item.unit', 'stockOut.user'])
            ->whereHas('stockOut', function ($q) use ($request) {
                $q->where('status', 'Active');

                if ($request->filled('date_from')) {
                    $q->whereDate('transaction_date', '>=', $request->date_from);
                }
                if ($request->filled('date_to')) {
                    $q->whereDate('transaction_date', '<=', $request->date_to);
                }
                if ($request->filled('department')) {
                    $q->where('department', 'like', '%' . $request->department . '%');
                }
            });

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $details = $query->latest('id')->get();

        $perBarang = $details->groupBy('item_id')->map(fn ($rows) => [
            'name'  => $rows->first()->item->name ?? '-',
            'unit'  => $rows->first()->item->unit->name ?? '',
            'total' => $rows->sum('quantity'),
        ])->sortByDesc('total');

        $perDepartemen = $details->groupBy(fn ($d) => $d->stockOut->department)
            ->map(fn ($rows) => $rows->sum('quantity'))
            ->sortDesc();

        $barangs = Barang::orderBy('name')->get();

        return view('usage.index', compact('details', 'perBarang', 'perDepartemen', 'barangs'));
    }
}