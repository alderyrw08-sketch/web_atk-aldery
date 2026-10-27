<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function data()
    {
        $query = Supplier::query()->select('suppliers.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('phone', fn ($s) => $s->phone ?: '-')
            ->editColumn('email', fn ($s) => $s->email ?: '-')
            ->editColumn('pic', fn ($s) => $s->pic ?: '-')
            ->addColumn('status_badge', fn ($s) => $s->status
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Nonaktif</span>')
            ->addColumn('action', function ($s) {
                $html = '<a href="' . route('suppliers.show', $s->id) . '" class="btn btn-sm btn-info">Detail</a> ';
                if (auth()->user()->can('supplier.update')) {
                    $html .= '<a href="' . route('suppliers.edit', $s->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                }
                if ($s->status && auth()->user()->can('supplier.delete')) {
                    $html .= '<form action="' . route('suppliers.destroy', $s->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Nonaktifkan supplier ini?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button class="btn btn-sm btn-danger">Nonaktifkan</button></form>';
                } elseif (!$s->status && auth()->user()->can('supplier.update')) {
                    $html .= '<form action="' . route('suppliers.activate', $s->id) . '" method="POST" class="d-inline">'
                        . csrf_field() . method_field('PATCH')
                        . '<button class="btn btn-sm btn-success">Aktifkan</button></form>';
                }
                return $html;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required',
            'address' => 'nullable',
            'phone'   => 'nullable',
            'email'   => 'nullable|email',
            'pic'     => 'nullable',
        ]);

        $validated['status'] = true;
        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'    => 'required',
            'address' => 'nullable',
            'phone'   => 'nullable',
            'email'   => 'nullable|email',
            'pic'     => 'nullable',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil diubah');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->update(['status' => false]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil dinonaktifkan');
    }

    public function activate(Supplier $supplier)
    {
        $supplier->update(['status' => true]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil diaktifkan kembali');
    }
}