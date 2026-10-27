<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index()
    {
        return view('units.index');
    }

    public function data()
    {
        $query = Unit::query()->select('units.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('symbol', fn ($u) => $u->symbol ?: '-')
            ->addColumn('action', function ($u) {
                $html = '';
                if (auth()->user()->can('satuan.update')) {
                    $html .= '<a href="' . route('units.edit', $u->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                }
                if (auth()->user()->can('satuan.delete')) {
                    $html .= '<form action="' . route('units.destroy', $u->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin hapus satuan ini?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button class="btn btn-sm btn-danger">Hapus</button></form>';
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|unique:units,name',
            'symbol' => 'nullable',
        ]);

        Unit::create($validated);

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name'   => 'required|unique:units,name,' . $unit->id,
            'symbol' => 'nullable',
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil diubah');
    }

    public function destroy(Unit $unit)
    {
        if (Barang::where('unit_id', $unit->id)->exists()) {
            return redirect()->route('units.index')
                ->withErrors(['unit' => 'Satuan masih dipakai oleh barang, tidak bisa dihapus.']);
        }

        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil dihapus');
    }
}