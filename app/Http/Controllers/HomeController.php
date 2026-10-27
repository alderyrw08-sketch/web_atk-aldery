<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $totalBarang = Barang::count();
        $totalKategori = Category::count();
        $totalStok = (int) Barang::sum('stock');

        $barangHabis = Barang::where('stock', 0)->count();
        $barangMenipis = Barang::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        $totalSupplier = Schema::hasTable('suppliers') ? DB::table('suppliers')->count() : 0;

        $peringatan = Barang::with('unit')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        // Kartu hari ini dan bulan ini (hanya transaksi Active)
        $today = Carbon::today();
        $masukHariIni = (int) StockInDetail::whereHas('stockIn', fn ($q) => $q->where('status', 'Active')->whereDate('transaction_date', $today))->sum('quantity');
        $keluarHariIni = (int) StockOutDetail::whereHas('stockOut', fn ($q) => $q->where('status', 'Active')->whereDate('transaction_date', $today))->sum('quantity');
        $penggunaanBulanIni = (int) StockOutDetail::whereHas('stockOut', fn ($q) => $q->where('status', 'Active')
            ->whereYear('transaction_date', $today->year)->whereMonth('transaction_date', $today->month))->sum('quantity');

        // Grafik masuk vs keluar
        $filter = in_array($request->filter, ['mingguan', 'bulanan', 'tahunan']) ? $request->filter : 'bulanan';
        [$labels, $dataMasuk, $dataKeluar] = $this->chartData($filter);

        // Barang paling banyak digunakan (bulan ini)
        $terbanyak = StockOutDetail::select('item_id', DB::raw('SUM(quantity) as total'))
            ->whereHas('stockOut', fn ($q) => $q->where('status', 'Active'))
            ->groupBy('item_id')
            ->orderByDesc('total')
            ->with('item.unit')
            ->limit(5)
            ->get();

        return view('home', compact(
            'totalBarang', 'totalKategori', 'totalStok', 'barangHabis', 'barangMenipis',
            'totalSupplier', 'peringatan', 'masukHariIni', 'keluarHariIni', 'penggunaanBulanIni',
            'filter', 'labels', 'dataMasuk', 'dataKeluar', 'terbanyak'
        ));
    }

    private function chartData(string $filter): array
    {
        $labels = [];
        $masuk = [];
        $keluar = [];

        if ($filter === 'mingguan') {
            // 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $d = Carbon::today()->subDays($i);
                $labels[] = $d->format('d/m');
                $masuk[] = $this->sumIn(fn ($q) => $q->whereDate('transaction_date', $d));
                $keluar[] = $this->sumOut(fn ($q) => $q->whereDate('transaction_date', $d));
            }
        } elseif ($filter === 'tahunan') {
            // 12 bulan di tahun ini
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = Carbon::create(null, $m, 1)->format('M');
                $y = Carbon::today()->year;
                $masuk[] = $this->sumIn(fn ($q) => $q->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m));
                $keluar[] = $this->sumOut(fn ($q) => $q->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m));
            }
        } else {
            // bulanan: tiap hari di bulan ini
            $start = Carbon::today()->startOfMonth();
            for ($d = 0; $d < $start->daysInMonth; $d++) {
                $date = $start->copy()->addDays($d);
                $labels[] = $date->format('d');
                $masuk[] = $this->sumIn(fn ($q) => $q->whereDate('transaction_date', $date));
                $keluar[] = $this->sumOut(fn ($q) => $q->whereDate('transaction_date', $date));
            }
        }

        return [$labels, $masuk, $keluar];
    }

    private function sumIn(callable $filter): int
    {
        return (int) StockInDetail::whereHas('stockIn', function ($q) use ($filter) {
            $q->where('status', 'Active');
            $filter($q);
        })->sum('quantity');
    }

    private function sumOut(callable $filter): int
    {
        return (int) StockOutDetail::whereHas('stockOut', function ($q) use ($filter) {
            $q->where('status', 'Active');
            $filter($q);
        })->sum('quantity');
    }
}