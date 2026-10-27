<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    public function data()
    {
        $totalPermission = Permission::count();
        $query = Role::withCount(['users', 'permissions'])->select('roles.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('users_count', fn ($r) => $r->users_count)
            ->addColumn('permission_info', fn ($r) => $r->permissions_count == $totalPermission
                ? 'Full Access'
                : $r->permissions_count . ' permission')
            ->addColumn('action', function ($r) {
                if ($r->name === 'Admin') {
                    return '<span class="text-muted">Dilindungi</span>';
                }
                $html = '';
                if (auth()->user()->can('role.update')) {
                    $html .= '<a href="' . route('roles.edit', $r->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                }
                if (auth()->user()->can('role.delete')) {
                    $html .= '<form action="' . route('roles.destroy', $r->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin hapus role ini?\')">'
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
        $permissions = Permission::orderBy('name')->get()
            ->groupBy(fn ($p) => explode('.', $p->name)[0]);
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get()
            ->groupBy(fn ($p) => explode('.', $p->name)[0]);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'          => 'required|unique:roles,name,' . $role->id,
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($role->name === 'Admin') {
            $role->syncPermissions(Permission::all());
            return redirect()->route('roles.index')
                ->with('success', 'Role Admin selalu memiliki seluruh permission');
        }

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diubah');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Admin') {
            return back()->withErrors(['role' => 'Role Admin tidak boleh dihapus.']);
        }

        if ($role->users()->count() > 0) {
            return back()->withErrors(['role' => 'Role masih dipakai oleh user, tidak bisa dihapus.']);
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}