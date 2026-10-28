<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StockInController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    public function index()
    {
        $totalTransactions = StockIn::count();
        $activeTransactions = StockIn::where('status', 'Active')->count();
        $cancelledTransactions = StockIn::where('status', 'Cancelled')->count();
        $totalItemsReceived = StockInDetail::whereHas('stockIn', fn ($query) => $query->where('status', 'Active'))
            ->sum('quantity');

        return view('stock-in.index', compact(
            'totalTransactions',
            'activeTransactions',
            'cancelledTransactions',
            'totalItemsReceived'
        ));
    }

    public function data(Request $request)
    {
        $query = StockIn::with(['supplier', 'user'])->select('stock_ins.*')
            ->orderByDesc('transaction_date')->orderByDesc('id');

        if ($request->input('status') === 'active') {
            $query->where('status', 'Active');
        } elseif ($request->input('status') === 'cancelled') {
            $query->where('status', 'Cancelled');
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('transaction_date', fn ($s) => $s->transaction_date->format('d-m-Y'))
            ->addColumn('supplier_name', fn ($s) => $s->supplier->name ?? '-')
            ->addColumn('user_name', fn ($s) => $s->user->name ?? '-')
            ->editColumn('document_number', fn ($s) => $s->document_number ?: '-')
            ->addColumn('status_badge', fn ($s) => $s->status === 'Active'
                ? '<span class="inv-badge">Aktif</span>'
                : '<span class="inv-badge cancelled">Dibatalkan</span>')
            ->addColumn('action', function ($s) {
                $html = '<a href="' . route('stock-in.show', $s->id) . '" class="btn btn-sm btn-info">Detail</a> ';
                if ($s->status === 'Active' && auth()->user()->can('barang-masuk.delete')) {
                    $html .= '<form action="' . route('stock-in.cancel', $s->id) . '" method="POST" class="d-inline" data-confirm-title="Batalkan transaksi ini?" data-confirm-message="Stok pada transaksi ini akan dikembalikan ke persediaan." data-confirm-action="Batalkan" data-confirm-icon="cancel" data-confirm-tone="danger">'
                        . csrf_field() . method_field('PATCH')
                        . '<button class="btn btn-sm btn-danger">Batalkan</button></form>';
                }
                return $html;
            })
            ->filterColumn('supplier_name', fn ($q, $kw) => $q->whereHas('supplier', fn ($s) => $s->where('name', 'like', "%{$kw}%")))
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $barangs = Barang::with('unit')->where('status', true)->orderBy('name')->get();

        return view('stock-in.create', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date'  => 'required|date',
            'supplier_id'       => 'required|exists:suppliers,id',
            'document_number'   => 'nullable',
            'notes'             => 'nullable',
            'items'             => 'required|array|min:1',
            'items.*.item_id'   => 'required|distinct|exists:barangs,id',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.price'     => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $stockIn = StockIn::create([
                'transaction_number' => $this->generateNumber(),
                'transaction_date'   => $validated['transaction_date'],
                'supplier_id'        => $validated['supplier_id'],
                'document_number'    => $validated['document_number'] ?? null,
                'user_id'            => auth()->id(),
                'notes'              => $validated['notes'] ?? null,
                'status'             => 'Active',
            ]);

            foreach ($validated['items'] as $item) {
                $stockIn->details()->create([
                    'item_id'  => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price'    => $item['price'] ?? 0,
                ]);

                $this->stockService->change(
                    (int) $item['item_id'],
                    (int) $item['quantity'],
                    'BARANG_MASUK',
                    $stockIn->id,
                    auth()->id(),
                    "Barang masuk {$stockIn->transaction_number}"
                );
            }
        });

        return redirect()->route('stock-in.index')
            ->with('success', 'Barang masuk berhasil dicatat dan stok bertambah');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['supplier', 'user', 'details.item.unit']);
        return view('stock-in.show', compact('stockIn'));
    }

    public function cancel(StockIn $stockIn)
    {
        if ($stockIn->status === 'Cancelled') {
            return back()->withErrors(['stock_in' => 'Transaksi sudah dibatalkan.']);
        }

        DB::transaction(function () use ($stockIn) {
            foreach ($stockIn->details as $detail) {
                $this->stockService->change(
                    $detail->item_id,
                    -$detail->quantity,
                    'BARANG_MASUK',
                    $stockIn->id,
                    auth()->id(),
                    "Pembatalan {$stockIn->transaction_number}"
                );
            }
            $stockIn->update(['status' => 'Cancelled']);
        });

        return redirect()->route('stock-in.index')
            ->with('success', 'Transaksi dibatalkan dan stok dikembalikan');
    }

    private function generateNumber(): string
    {
        $prefix = 'BM-' . now()->format('Ymd') . '-';
        $count = StockIn::where('transaction_number', 'like', $prefix . '%')->count() + 1;

        return $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}