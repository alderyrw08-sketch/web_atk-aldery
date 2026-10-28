<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StockOutController extends Controller
{
    public function __construct(private StockService $stockService) {}

    public function index()
    {
        $totalTransactions = StockOut::count();
        $activeTransactions = StockOut::where('status', 'Active')->count();
        $cancelledTransactions = StockOut::where('status', 'Cancelled')->count();
        $totalItemsIssued = StockOutDetail::whereHas('stockOut', fn ($query) => $query->where('status', 'Active'))
            ->sum('quantity');

        return view('stock-out.index', compact(
            'totalTransactions',
            'activeTransactions',
            'cancelledTransactions',
            'totalItemsIssued'
        ));
    }

    public function data(Request $request)
    {
        $query = StockOut::with('user')->select('stock_outs.*')
            ->orderByDesc('transaction_date')->orderByDesc('id');

        if ($request->input('status') === 'active') {
            $query->where('status', 'Active');
        } elseif ($request->input('status') === 'cancelled') {
            $query->where('status', 'Cancelled');
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('transaction_date', fn ($s) => $s->transaction_date->format('d-m-Y'))
            ->editColumn('purpose', fn ($s) => $s->purpose ?: '-')
            ->addColumn('user_name', fn ($s) => $s->user->name ?? '-')
            ->addColumn('status_badge', fn ($s) => $s->status === 'Active'
                ? '<div class="flex justify-center items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Aktif</span></div>'
                : '<div class="flex justify-center items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-error-container text-on-error-container font-semibold">Dibatalkan</span></div>')
            ->addColumn('action', function ($s) {
                $detail = '<a href="'.route('stock-out.show', $s->id).'" class="w-8 h-8 rounded-full bg-primary-fixed/50 hover:bg-primary-fixed text-on-primary-fixed-variant inline-flex items-center justify-center transition-colors" title="Detail Transaksi"><span class="material-symbols-outlined text-[17px]">visibility</span></a>';
                $cancel = '';
                if ($s->status === 'Active' && (auth()->user()?->can('barang-keluar.delete') ?? true)) {
                    $cancel = '<form action="'.route('stock-out.cancel', $s->id).'" method="POST" class="inline-block m-0" data-confirm-title="Batalkan transaksi barang keluar?" data-confirm-message="Kuantitas stok pada transaksi ini akan dikembalikan ke persediaan gudang." data-confirm-action="Batalkan Transaksi" data-confirm-icon="cancel" data-confirm-tone="warning">'
                        .csrf_field().method_field('PATCH')
                        .'<button type="submit" class="w-8 h-8 rounded-full bg-amber-100 hover:bg-amber-200 text-amber-800 flex items-center justify-center transition-colors" title="Batalkan Transaksi"><span class="material-symbols-outlined text-[17px]">cancel</span></button></form>';
                }

                return '<div class="flex items-center justify-center gap-1.5">'.$detail.$cancel.'</div>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $barangs = Barang::with('unit')
            ->where('status', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('stock-out.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'department' => 'required',
            'recipient' => 'required',
            'purpose' => 'nullable',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|distinct|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $stockOut = StockOut::create([
                'transaction_number' => $this->generateNumber(),
                'transaction_date' => $validated['transaction_date'],
                'department' => $validated['department'],
                'recipient' => $validated['recipient'],
                'purpose' => $validated['purpose'] ?? null,
                'user_id' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
                'status' => 'Active',
            ]);

            foreach ($validated['items'] as $item) {
                $stockOut->details()->create([
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                ]);

                $this->stockService->change(
                    (int) $item['item_id'],
                    -((int) $item['quantity']),
                    'BARANG_KELUAR',
                    $stockOut->id,
                    auth()->id(),
                    "Barang keluar {$stockOut->transaction_number}"
                );
            }
        });

        return redirect()->route('stock-out.index')
            ->with('success', 'Barang keluar berhasil dicatat dan stok berkurang');
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load(['user', 'details.item.unit']);

        return view('stock-out.show', compact('stockOut'));
    }

    public function cancel(StockOut $stockOut)
    {
        if ($stockOut->status === 'Cancelled') {
            return back()->withErrors(['stock_out' => 'Transaksi sudah dibatalkan.']);
        }

        DB::transaction(function () use ($stockOut) {
            foreach ($stockOut->details as $detail) {
                $this->stockService->change(
                    $detail->item_id,
                    $detail->quantity,
                    'BARANG_KELUAR',
                    $stockOut->id,
                    auth()->id(),
                    "Pembatalan {$stockOut->transaction_number}"
                );
            }
            $stockOut->update(['status' => 'Cancelled']);
        });

        return redirect()->route('stock-out.index')
            ->with('success', 'Transaksi dibatalkan dan stok dikembalikan');
    }

    private function generateNumber(): string
    {
        $prefix = 'BK-'.now()->format('Ymd').'-';
        $count = StockOut::where('transaction_number', 'like', $prefix.'%')->count() + 1;

        return $prefix.str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
