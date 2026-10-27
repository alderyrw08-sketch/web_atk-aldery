<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    public function data()
    {
        $query = Category::query()->select('categories.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('description', fn ($c) => $c->description ?: '-')
            ->addColumn('action', function ($c) {
                $html = '';
                if (auth()->user()->can('kategori.update')) {
                    $html .= '<a href="' . route('categories.edit', $c->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                }
                if (auth()->user()->can('kategori.delete')) {
                    $html .= '<form action="' . route('categories.destroy', $c->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin hapus kategori ini?\')">'
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
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|unique:categories,name',
            'description' => 'nullable',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diubah');
    }

    public function destroy(Category $category)
    {
        if (Barang::where('category_id', $category->id)->exists()) {
            return redirect()->route('categories.index')
                ->withErrors(['category' => 'Kategori masih dipakai oleh barang, tidak bisa dihapus.']);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}