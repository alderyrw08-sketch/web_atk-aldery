<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Unit;

class BarangController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('barangs.index', compact('categories'));
    }

    public function data(Request $request)
    {
        $query = Barang::with(['category', 'unit'])
            ->select('barangs.*');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status_stok === 'habis') {
            $query->where('stock', 0);
        } elseif ($request->status_stok === 'menipis') {
            $query->where('stock', '>', 0)
                ->whereColumn('stock', '<=', 'minimum_stock');
        } elseif ($request->status_stok === 'aman') {
            $query->whereColumn('stock', '>', 'minimum_stock');
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('category_name', fn ($b) => $b->category->name ?? '-')
            ->addColumn('unit_name', fn ($b) => $b->unit->name ?? '-')
            ->addColumn('stock_status', function ($b) {
                if ($b->stock == 0) {
                    return '<span class="badge bg-danger">Habis</span>';
                }

                if ($b->stock <= $b->minimum_stock) {
                    return '<span class="badge bg-warning text-dark">Menipis</span>';
                }

                return '<span class="badge bg-success">Aman</span>';
            })
            ->addColumn('active_status', fn ($b) => $b->status
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Nonaktif</span>')
            ->addColumn('action', function ($b) {
                $html = '<a href="' . route('barangs.show', $b->id)
                    . '" class="btn btn-sm btn-info">Detail</a> ';

                if (auth()->user()->can('barang.update')) {
                    $html .= '<a href="' . route('barangs.edit', $b->id)
                        . '" class="btn btn-sm btn-warning">Edit</a> ';
                }

                if ($b->status && auth()->user()->can('barang.delete')) {
                    $html .= '<form action="' . route('barangs.destroy', $b->id)
                        . '" method="POST" class="d-inline" '
                        . 'onsubmit="return confirm(\'Nonaktifkan barang ini?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button class="btn btn-sm btn-danger">'
                        . 'Nonaktifkan</button></form>';
                } elseif (!$b->status && auth()->user()->can('barang.update')) {
                    $html .= '<form action="' . route('barangs.activate', $b->id)
                        . '" method="POST" class="d-inline">'
                        . csrf_field() . method_field('PATCH')
                        . '<button class="btn btn-sm btn-success">'
                        . 'Aktifkan</button></form>';
                }

                return $html;
            })
            ->rawColumns(['stock_status', 'active_status', 'action'])
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
