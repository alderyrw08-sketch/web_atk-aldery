<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Barang;
use App\Models\StockHistory;
use App\Models\StockInDetail;
use App\Models\StockOpnameDetail;
use App\Models\StockOutDetail;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function show(Request $request, string $type)
    {
        $report = $this->build($type, $request);
        abort_if($report === null, 404);

        $barangs = Barang::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('reports.show', compact('report', 'type', 'barangs', 'suppliers'));
    }

    public function pdf(Request $request, string $type)
    {
        $report = $this->build($type, $request);
        abort_if($report === null, 404);

        return Pdf::loadView('reports.pdf', compact('report'))
            ->setPaper('a4', 'landscape')
            ->download("laporan-{$type}-" . now()->format('Ymd') . '.pdf');
    }

    public function excel(Request $request, string $type)
    {
        $report = $this->build($type, $request);
        abort_if($report === null, 404);

        return Excel::download(
            new ReportExport($report),
            "laporan-{$type}-" . now()->format('Ymd') . '.xlsx'
        );
    }

    private function build(string $type, Request $r): ?array
    {
        return match ($type) {
            'stock-in'  => $this->stockIn($r),
            'stock-out' => $this->stockOut($r),
            'stock'     => $this->stock($r),
            'usage'     => $this->usage($r),
            'opname'    => $this->opname($r),
            default     => null,
        };
    }

    private function period(Request $r): string
    {
        $from = $r->filled('date_from') ? Carbon::parse($r->date_from)->format('d-m-Y') : null;
        $to = $r->filled('date_to') ? Carbon::parse($r->date_to)->format('d-m-Y') : null;

        if (!$from && !$to) {
            return 'Periode: semua tanggal';
        }
        return 'Periode: ' . ($from ?? '...') . ' s/d ' . ($to ?? 'sekarang');
    }

    private function stockIn(Request $r): array
    {
        $q = StockInDetail::with(['stockIn.supplier', 'item.unit'])
            ->whereHas('stockIn', function ($q) use ($r) {
                $q->where('status', 'Active');
                if ($r->filled('date_from')) $q->whereDate('transaction_date', '>=', $r->date_from);
                if ($r->filled('date_to')) $q->whereDate('transaction_date', '<=', $r->date_to);
                if ($r->filled('supplier_id')) $q->where('supplier_id', $r->supplier_id);
            });
        if ($r->filled('item_id')) $q->where('item_id', $r->item_id);

        $details = $q->get()->sortBy(fn ($d) => $d->stockIn->transaction_date)->values();

        $rows = $details->map(fn ($d, $i) => [
            $i + 1,
            $d->stockIn->transaction_date->format('d-m-Y'),
            $d->stockIn->transaction_number,
            $d->stockIn->supplier->name ?? '-',
            $d->item->code ?? '-',
            $d->item->name ?? '-',
            $d->quantity . ' ' . ($d->item->unit->name ?? ''),
            number_format($d->price, 0, ',', '.'),
        ])->all();

        return [
            'title'    => 'Laporan Barang Masuk',
            'filters'  => ['date', 'supplier', 'item'],
            'period'   => $this->period($r),
            'headings' => ['No', 'Tanggal', 'No. Transaksi', 'Supplier', 'Kode', 'Barang', 'Jumlah', 'Harga (Rp)'],
            'rows'     => $rows,
            'summary'  => ['Total jumlah barang masuk' => $details->sum('quantity')],
        ];
    }

    private function stockOut(Request $r): array
    {
        $q = StockOutDetail::with(['stockOut', 'item.unit'])
            ->whereHas('stockOut', function ($q) use ($r) {
                $q->where('status', 'Active');
                if ($r->filled('date_from')) $q->whereDate('transaction_date', '>=', $r->date_from);
                if ($r->filled('date_to')) $q->whereDate('transaction_date', '<=', $r->date_to);
                if ($r->filled('department')) $q->where('department', 'like', '%' . $r->department . '%');
            });
        if ($r->filled('item_id')) $q->where('item_id', $r->item_id);

        $details = $q->get()->sortBy(fn ($d) => $d->stockOut->transaction_date)->values();

        $rows = $details->map(fn ($d, $i) => [
            $i + 1,
            $d->stockOut->transaction_date->format('d-m-Y'),
            $d->stockOut->transaction_number,
            $d->stockOut->department,
            $d->stockOut->recipient,
            $d->item->code ?? '-',
            $d->item->name ?? '-',
            $d->quantity . ' ' . ($d->item->unit->name ?? ''),
        ])->all();

        return [
            'title'    => 'Laporan Barang Keluar',
            'filters'  => ['date', 'item', 'department'],
            'period'   => $this->period($r),
            'headings' => ['No', 'Tanggal', 'No. Transaksi', 'Departemen', 'Penerima', 'Kode', 'Barang', 'Jumlah'],
            'rows'     => $rows,
            'summary'  => ['Total jumlah barang keluar' => $details->sum('quantity')],
        ];
    }

    private function stock(Request $r): array
    {
        $barangs = Barang::with('unit')->where('status', true)
            ->when($r->filled('item_id'), fn ($q) => $q->where('id', $r->item_id))
            ->orderBy('name')->get();

        $rows = [];
        foreach ($barangs as $i => $b) {
            $period = StockHistory::where('item_id', $b->id)
                ->when($r->filled('date_from'), fn ($q) => $q->whereDate('created_at', '>=', $r->date_from))
                ->when($r->filled('date_to'), fn ($q) => $q->whereDate('created_at', '<=', $r->date_to));

            $before = $r->filled('date_from')
                ? StockHistory::where('item_id', $b->id)->whereDate('created_at', '<', $r->date_from)->orderByDesc('id')->first()
                : null;
            $first = (clone $period)->orderBy('id')->first();

            $awal = $before ? $before->stock_after : ($first ? $first->stock_before : $b->stock);
            $masuk = (int) (clone $period)->where('transaction_type', 'BARANG_MASUK')->sum('quantity');
            $keluar = -1 * (int) (clone $period)->where('transaction_type', 'BARANG_KELUAR')->sum('quantity');
            $penyesuaian = (int) (clone $period)->whereNotIn('transaction_type', ['BARANG_MASUK', 'BARANG_KELUAR'])->sum('quantity');
            $akhir = $awal + $masuk - $keluar + $penyesuaian;

            $rows[] = [
                $i + 1, $b->code, $b->name, $b->unit->name ?? '-',
                $awal, $masuk, $keluar, $penyesuaian, $akhir,
            ];
        }

        return [
            'title'    => 'Laporan Stok',
            'filters'  => ['date', 'item'],
            'period'   => $this->period($r),
            'headings' => ['No', 'Kode', 'Barang', 'Satuan', 'Stok Awal', 'Masuk', 'Keluar', 'Penyesuaian Opname', 'Stok Akhir'],
            'rows'     => $rows,
            'summary'  => [],
        ];
    }

    private function usage(Request $r): array
    {
        $q = StockOutDetail::with(['stockOut', 'item.unit'])
            ->whereHas('stockOut', function ($q) use ($r) {
                $q->where('status', 'Active');
                if ($r->filled('date_from')) $q->whereDate('transaction_date', '>=', $r->date_from);
                if ($r->filled('date_to')) $q->whereDate('transaction_date', '<=', $r->date_to);
                if ($r->filled('department')) $q->where('department', 'like', '%' . $r->department . '%');
            });
        if ($r->filled('item_id')) $q->where('item_id', $r->item_id);

        $details = $q->get();
        $period = $this->period($r);

        $grouped = $details->groupBy(fn ($d) => $d->item_id . '|' . $d->stockOut->department)
            ->map(fn ($rows) => [
                'barang' => $rows->first()->item->name ?? '-',
                'dept'   => $rows->first()->stockOut->department,
                'total'  => $rows->sum('quantity'),
                'unit'   => $rows->first()->item->unit->name ?? '',
            ])->sortByDesc('total')->values();

        $rows = $grouped->map(fn ($g, $i) => [
            $i + 1, $g['barang'], $g['dept'], $g['total'] . ' ' . $g['unit'], str_replace('Periode: ', '', $period),
        ])->all();

        return [
            'title'    => 'Laporan Penggunaan ATK',
            'filters'  => ['date', 'item', 'department'],
            'period'   => $period,
            'headings' => ['No', 'Barang', 'Departemen', 'Jumlah Penggunaan', 'Periode'],
            'rows'     => $rows,
            'summary'  => ['Total penggunaan' => $details->sum('quantity')],
        ];
    }

    private function opname(Request $r): array
    {
        $q = StockOpnameDetail::with(['stockOpname', 'item'])
            ->whereHas('stockOpname', function ($q) use ($r) {
                if ($r->filled('date_from')) $q->whereDate('opname_date', '>=', $r->date_from);
                if ($r->filled('date_to')) $q->whereDate('opname_date', '<=', $r->date_to);
            });
        if ($r->filled('item_id')) $q->where('item_id', $r->item_id);

        $details = $q->get()->sortBy(fn ($d) => $d->stockOpname->opname_date)->values();

        $rows = $details->map(fn ($d, $i) => [
            $i + 1,
            $d->stockOpname->opname_date->format('d-m-Y'),
            $d->stockOpname->opname_number,
            $d->stockOpname->status,
            $d->item->code ?? '-',
            $d->item->name ?? '-',
            $d->system_stock,
            $d->physical_stock,
            ($d->difference > 0 ? '+' : '') . $d->difference,
        ])->all();

        return [
            'title'    => 'Laporan Stock Opname',
            'filters'  => ['date', 'item'],
            'period'   => $this->period($r),
            'headings' => ['No', 'Tanggal', 'No. Opname', 'Status', 'Kode', 'Barang', 'Stok Sistem', 'Stok Fisik', 'Selisih'],
            'rows'     => $rows,
            'summary'  => ['Total selisih' => $details->sum('difference')],
        ];
    }
}