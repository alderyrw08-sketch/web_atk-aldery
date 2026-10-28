<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
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
                    return '<div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-error-container text-on-error-container font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-error"></span>Habis</span></div>';
                }

                if ($row->stock <= $row->minimum_stock) {
                    return '<div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-amber-100 text-amber-800 font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Menipis</span></div>';
                }

                return '<div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>Aman</span></div>';
            })
            ->addColumn('active_status', function ($row) {
                return $row->status
                    ? '<div class="flex justify-center items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Aktif</span></div>'
                    : '<div class="flex justify-center items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant font-semibold">Nonaktif</span></div>';
            })
            ->addColumn('action', function ($row) {
                $detail = '<a href="'.route('barangs.show', $row->id).'" class="w-8 h-8 rounded-full bg-primary-fixed/50 hover:bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center transition-colors" title="Detail Barang"><span class="material-symbols-outlined text-[17px]">visibility</span></a>';

                $edit = '';
                if (auth()->user()?->can('barang.update') ?? true) {
                    $edit = '<a href="'.route('barangs.edit', $row->id).'" class="w-8 h-8 rounded-full bg-surface-container-high hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors" title="Edit Barang"><span class="material-symbols-outlined text-[17px]">edit</span></a>';
                }

                $label = $row->status ? 'Nonaktifkan' : 'Aktifkan';
                $toggleIcon = $row->status ? 'block' : 'power_settings_new';
                $toggleBg = $row->status ? 'bg-amber-100 hover:bg-amber-200 text-amber-800' : 'bg-tertiary-fixed/60 hover:bg-tertiary-fixed text-on-tertiary-fixed';

                $toggle = '';
                if (auth()->user()?->can('barang.update') ?? true) {
                    $toggle = '<form action="'.route('barangs.toggle-status', $row->id).'" method="POST" class="inline-block m-0"'
                        .' data-confirm-title="'.$label.' barang ini?"'
                        .' data-confirm-message="'.($row->status
                            ? 'Barang akan disembunyikan dari transaksi, tetapi data dan riwayatnya tetap tersimpan.'
                            : 'Barang akan tersedia kembali untuk transaksi.').'"'
                        .' data-confirm-action="'.$label.'"'
                        .' data-confirm-icon="'.$toggleIcon.'"'
                        .' data-confirm-tone="warning">'
                        .csrf_field().method_field('PATCH')
                        .'<button type="submit" class="w-8 h-8 rounded-full '.$toggleBg.' flex items-center justify-center transition-colors" title="'.$label.'"><span class="material-symbols-outlined text-[17px]">'.$toggleIcon.'</span></button></form>';
                }

                $delete = '';
                if (auth()->user()?->can('barang.delete') ?? true) {
                    $delete = '<form action="'.route('barangs.destroy', $row->id).'" method="POST" class="inline-block m-0"'
                        .' data-confirm-title="Hapus barang ini?"'
                        .' data-confirm-message="Barang akan dinonaktifkan dari sistem persediaan."'
                        .' data-confirm-action="Hapus"'
                        .' data-confirm-icon="delete"'
                        .' data-confirm-tone="danger">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit" class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[17px]">delete</span></button></form>';
                }

                return '<div class="flex items-center justify-center gap-1.5">'.$detail.$edit.$toggle.$delete.'</div>';
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
            'code' => 'required|unique:barangs,code',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'minimum_stock' => 'required|integer|min:0',
            'location' => 'nullable',
            'description' => 'nullable',
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
            'code' => 'required|unique:barangs,code,'.$barang->id,
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'minimum_stock' => 'required|integer|min:0',
            'location' => 'nullable',
            'description' => 'nullable',
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
            $import = new BarangsImport;

            Excel::import($import, $request->file('file_import'));

            $jumlahBerhasil = $import->berhasil;
            $jumlahError = count($import->errors);

            if ($jumlahError > 0) {
                $pesan = $jumlahBerhasil
                    .' data berhasil diimpor. '
                    .$jumlahError
                    .' baris dilewati. '
                    .implode(' ', array_slice($import->errors, 0, 5));

                return redirect()->route('barangs.index')
                    ->with('error', $pesan);
            }

            return redirect()->route('barangs.index')
                ->with('success', $jumlahBerhasil
                    .' data barang berhasil diimpor.');

        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('barangs.index')
                ->with('error',
                    'Impor gagal. Periksa format file dan susunan kolomnya.');
        }
    }
}
