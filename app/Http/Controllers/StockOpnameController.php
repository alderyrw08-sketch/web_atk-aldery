<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockOpname;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StockOpnameController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    public function index()
    {
        return view('stock-opname.index');
    }

    public function data()
    {
        $query = StockOpname::with('user')->withCount('details')->select('stock_opnames.*')
            ->orderByDesc('opname_date')->orderByDesc('id');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('details_count', fn ($o) => $o->details_count)
            ->editColumn('opname_date', fn ($o) => $o->opname_date->format('d-m-Y'))
            ->addColumn('user_name', fn ($o) => $o->user->name ?? '-')
            ->addColumn('status_badge', fn ($o) => $o->status === 'Confirmed'
                ? '<span class="badge bg-success">Confirmed</span>'
                : '<span class="badge bg-warning text-dark">Draft</span>')
            ->addColumn('action', function ($o) {
                $html = '<a href="' . route('stock-opname.show', $o->id) . '" class="btn btn-sm btn-info">Detail</a> ';
                if ($o->status === 'Draft' && auth()->user()->can('stock-opname.update')) {
                    $html .= '<form action="' . route('stock-opname.confirm', $o->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Konfirmasi opname? Stok sistem akan disesuaikan dengan stok fisik.\')">'
                        . csrf_field() . method_field('PATCH')
                        . '<button class="btn btn-sm btn-success">Konfirmasi</button></form>';
                }
                return $html;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $barangs = Barang::with('unit')->where('status', true)->orderBy('name')->get();
        return view('stock-opname.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opname_date'            => 'required|date',
            'notes'                  => 'nullable',
            'items'                  => 'required|array|min:1',
            'items.*.item_id'        => 'required|distinct|exists:barangs,id',
            'items.*.physical_stock' => 'required|integer|min:0',
            'items.*.notes'          => 'nullable',
        ]);

        DB::transaction(function () use ($validated) {
            $opname = StockOpname::create([
                'opname_number' => $this->generateNumber(),
                'opname_date'   => $validated['opname_date'],
                'user_id'       => auth()->id(),
                'status'        => 'Draft',
                'notes'         => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['item_id']);
                $physical = (int) $item['physical_stock'];

                $opname->details()->create([
                    'item_id'        => $barang->id,
                    'system_stock'   => $barang->stock,
                    'physical_stock' => $physical,
                    'difference'     => $physical - $barang->stock,
                    'notes'          => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()->route('stock-opname.index')
            ->with('success', 'Stock opname tersimpan sebagai Draft. Konfirmasi untuk menyesuaikan stok.');
    }

    public function show(StockOpname $stockOpname)
    {
        $stockOpname->load(['user', 'details.item.unit']);
        return view('stock-opname.show', compact('stockOpname'));
    }

    public function confirm(StockOpname $stockOpname)
    {
        if ($stockOpname->status === 'Confirmed') {
            return back()->withErrors(['opname' => 'Opname sudah dikonfirmasi.']);
        }

        DB::transaction(function () use ($stockOpname) {
            foreach ($stockOpname->details as $detail) {
                $current = Barang::findOrFail($detail->item_id)->stock;
                $diff = $detail->physical_stock - $current;

                if ($diff !== 0) {
                    $this->stockService->change(
                        $detail->item_id,
                        $diff,
                        'STOCK_OPNAME',
                        $stockOpname->id,
                        auth()->id(),
                        "Penyesuaian opname {$stockOpname->opname_number}"
                    );
                }
            }
            $stockOpname->update(['status' => 'Confirmed']);
        });

        return redirect()->route('stock-opname.index')
            ->with('success', 'Opname dikonfirmasi dan stok sudah disesuaikan.');
    }

    private function generateNumber(): string
    {
        $prefix = 'SO-' . now()->format('Ymd') . '-';
        $count = StockOpname::where('opname_number', 'like', $prefix . '%')->count() + 1;

        return $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}