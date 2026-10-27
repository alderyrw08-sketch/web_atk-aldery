<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function data()
    {
        $query = Permission::with('roles')->select('permissions.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('module', fn ($p) => ucfirst(explode('.', $p->name)[0]))
            ->addColumn('roles_list', fn ($p) => $p->roles->pluck('name')->join(', ') ?: 'Belum dipakai role mana pun')
            ->make(true);
    }
}