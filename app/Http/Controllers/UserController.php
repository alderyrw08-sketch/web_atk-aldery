<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        $query = User::with('roles')->select('users.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('role_name', fn ($u) => $u->roles->pluck('name')->join(', ') ?: '-')
            ->editColumn('created_at', fn ($u) => $u->created_at->format('d-m-Y'))
            ->addColumn('status_badge', fn ($u) => $u->status
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Nonaktif</span>')
            ->addColumn('action', function ($u) {
                $html = '';
                if (auth()->user()->can('user.update')) {
                    $html .= '<a href="' . route('users.edit', $u->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                }
                if ($u->status && $u->id !== auth()->id() && auth()->user()->can('user.delete')) {
                    $html .= '<form action="' . route('users.destroy', $u->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Nonaktifkan user ini?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button class="btn btn-sm btn-danger">Nonaktifkan</button></form>';
                }
                return $html;
            })
            ->filterColumn('role_name', fn ($q, $kw) => $q->whereHas('roles', fn ($r) => $r->where('name', 'like', "%{$kw}%")))
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'status'   => true,
        ]);
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role'     => 'required|exists:roles,name',
            'status'   => 'required|boolean',
        ]);

        if ($user->id === auth()->id() && !$validated['status']) {
            return back()->withErrors(['status' => 'Kamu tidak bisa menonaktifkan akunmu sendiri.']);
        }

        $data = [
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diubah');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Kamu tidak bisa menonaktifkan akunmu sendiri.']);
        }

        $user->update(['status' => false]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dinonaktifkan');
    }
}