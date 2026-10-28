<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('barangs.index', compact('categories'));
    }

    public function data(Request $request)
    {
        $query = Barang::query()
            ->leftJoin('categories', 'categories.id', '=', 'barangs.category_id')
            ->leftJoin('units', 'units.id', '=', 'barangs.unit_id')
            ->select([
                'barangs.id',
                'barangs.code',
                'barangs.name',
                'barangs.category_id',
                'barangs.unit_id',
                'barangs.stock',
                'barangs.minimum_stock',
                'barangs.location',
                'barangs.status',
                'categories.name as category_name',
                'units.name as unit_name',
            ]);

        if ($request->filled('category_id')) {
            $query->where('barangs.category_id', $request->category_id);
        }

        if ($request->filled('status_stok')) {
            match ($request->status_stok) {
                'habis' => $query->where('barangs.stock', '<=', 0),
                'menipis' => $query->where('barangs.stock', '>', 0)
                    ->whereColumn('barangs.stock', '<=', 'barangs.minimum_stock'),
                'aman' => $query->whereColumn('barangs.stock', '>', 'barangs.minimum_stock'),
                default => null,
            };
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('stock_status', function ($row) {
                if ($row->stock <= 0) {
                    return 'Habis';
                }

                if ($row->stock <= $row->minimum_stock) {
                    return 'Menipis';
                }

                return 'Aman';
            })
            ->addColumn('active_status', fn ($row) => $row->status ? 'Aktif' : 'Nonaktif')
            ->addColumn('action', function ($row) {
                $detail = '<a href="' . route('barangs.show', $row->id) . '">Detail</a>';
                $edit = '<a href="' . route('barangs.edit', $row->id) . '">Edit</a>';
                $label = $row->status ? 'Nonaktifkan' : 'Aktifkan';
                $toggle = '<form action="' . route('barangs.toggle-status', $row->id) . '" method="POST"'
                    . ' data-confirm-title="' . $label . ' barang ini?"'
                    . ' data-confirm-message="' . ($row->status
                        ? 'Barang akan disembunyikan dari transaksi, tetapi data dan riwayatnya tetap tersimpan.'
                        : 'Barang akan tersedia kembali untuk transaksi.') . '"'
                    . ' data-confirm-action="' . $label . '"'
                    . ' data-confirm-icon="' . ($row->status ? 'block' : 'power_settings_new') . '">'
                    . csrf_field() . method_field('PATCH')
                    . '<button type="submit">' . $label . '</button></form>';

                return $detail . $edit . $toggle;
            })
            ->filterColumn('stock_status', function ($query, $keyword) {
                $keyword = mb_strtolower($keyword);

                if (str_contains($keyword, 'habis')) {
                    $query->where('barangs.stock', '<=', 0);
                } elseif (str_contains($keyword, 'menipis')) {
                    $query->where('barangs.stock', '>', 0)
                        ->whereColumn('barangs.stock', '<=', 'barangs.minimum_stock');
                } elseif (str_contains($keyword, 'aman')) {
                    $query->whereColumn('barangs.stock', '>', 'barangs.minimum_stock');
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->filterColumn('status', function ($query, $keyword) {
                $keyword = mb_strtolower($keyword);

                if (str_contains($keyword, 'nonaktif')) {
                    $query->where('barangs.status', false);
                } elseif (str_contains($keyword, 'aktif')) {
                    $query->where('barangs.status', true);
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->filterColumn('category.name', fn ($query, $keyword) => $query->where('categories.name', 'like', "%{$keyword}%"))
            ->filterColumn('unit.name', fn ($query, $keyword) => $query->where('units.name', 'like', "%{$keyword}%"))
            ->orderColumn('category.name', 'categories.name $1')
            ->orderColumn('unit.name', 'units.name $1')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('barangs.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'          => 'required|unique:barangs,code',
            'name'          => 'required',
            'category_id'   => 'required|exists:categories,id',
            'unit_id'       => 'required|exists:units,id',
            'minimum_stock' => 'required|integer|min:0',
            'location'      => 'nullable',
            'description'   => 'nullable',
        ]);

        $validated['stock'] = 0;
        $validated['status'] = true;

        Barang::create($validated);

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        $barang->load(['category', 'unit']);

        return view('barangs.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('barangs.edit', compact('barang', 'categories', 'units'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'code'          => 'required|unique:barangs,code,' . $barang->id,
            'name'          => 'required',
            'category_id'   => 'required|exists:categories,id',
            'unit_id'       => 'required|exists:units,id',
            'minimum_stock' => 'required|integer|min:0',
            'location'      => 'nullable',
            'description'   => 'nullable',
        ]);

        $barang->update($validated);

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil diubah');
    }

    public function destroy(Barang $barang)
    {
        $barang->update(['status' => false]);

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil dinonaktifkan');
    }

    public function activate(Barang $barang)
    {
        $barang->update(['status' => true]);

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil diaktifkan kembali');
    }

    public function toggleStatus(Barang $barang)
    {
        $barang->update(['status' => ! $barang->status]);

        return redirect()->route('barangs.index')
            ->with('success', 'Status barang berhasil diperbarui');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_import.required' => 'Silakan pilih file untuk diimpor.',
            'file_import.mimes' => 'File harus berformat XLSX, XLS, atau CSV.',
            'file_import.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        try {
            $import = new BarangsImport();

            Excel::import($import, $request->file('file_import'));

            $jumlahBerhasil = $import->berhasil;
            $jumlahError = count($import->errors);

            if ($jumlahError > 0) {
                $pesan = $jumlahBerhasil
                    . ' data berhasil diimpor. '
                    . $jumlahError
                    . ' baris dilewati. '
                    . implode(' ', array_slice($import->errors, 0, 5));

                return redirect()->route('barangs.index')
                    ->with('error', $pesan);
            }

            return redirect()->route('barangs.index')
                ->with('success', $jumlahBerhasil
                    . ' data barang berhasil diimpor.');

        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('barangs.index')
                ->with('error',
                    'Impor gagal. Periksa format file dan susunan kolomnya.');
        }
    }
}
