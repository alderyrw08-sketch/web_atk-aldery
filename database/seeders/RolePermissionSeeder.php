<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'user'          => ['view', 'create', 'update', 'delete'],
            'role'          => ['view', 'create', 'update', 'delete'],
            'barang'        => ['view', 'create', 'update', 'delete'],
            'kategori'      => ['view', 'create', 'update', 'delete'],
            'satuan'        => ['view', 'create', 'update', 'delete'],
            'supplier'      => ['view', 'create', 'update', 'delete'],
            'barang-masuk'  => ['view', 'create', 'update', 'delete'],
            'barang-keluar' => ['view', 'create', 'update', 'delete'],
            'stock-opname'  => ['view', 'create', 'update'],
            'laporan'       => ['view', 'export'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$module.$action"]);
            }
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::all());

        $user = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name'     => 'Administrator',
                'password' => 'password123',
                'status'   => true,
            ]
        );
        $user->assignRole($admin);
    }
}