<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Barang
    Route::get('barangs', [BarangController::class, 'index'])->name('barangs.index')->middleware('permission:barang.view');
    Route::get('barangs/data', [BarangController::class, 'data'])->name('barangs.data')->middleware('permission:barang.view');
    Route::get('barangs/create', [BarangController::class, 'create'])->name('barangs.create')->middleware('permission:barang.create');
    Route::post('barangs', [BarangController::class, 'store'])->name('barangs.store')->middleware('permission:barang.create');
    Route::get('barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show')->middleware('permission:barang.view');
    Route::get('barangs/{barang}/edit', [BarangController::class, 'edit'])->name('barangs.edit')->middleware('permission:barang.update');
    Route::get('barangs/data', [BarangController::class, 'data'])->name('barangs.data');
    Route::put('barangs/{barang}', [BarangController::class, 'update'])->name('barangs.update')->middleware('permission:barang.update');
    Route::patch('barangs/{barang}/activate', [BarangController::class, 'activate'])->name('barangs.activate')->middleware('permission:barang.update');
    Route::patch('barangs/{barang}/toggle-status', [BarangController::class, 'toggleStatus'])->name('barangs.toggle-status');
    Route::delete('barangs/{barang}', [BarangController::class, 'destroy'])->name('barangs.destroy')->middleware('permission:barang.delete');
    Route::resource('barangs', BarangController::class);
    // Kategori
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('permission:kategori.view');
    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data')->middleware('permission:kategori.view');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:kategori.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:kategori.create');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:kategori.update');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:kategori.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:kategori.delete');

        // Satuan
    Route::get('units', [UnitController::class, 'index'])->name('units.index')->middleware('permission:satuan.view');
    Route::get('units/data', [UnitController::class, 'data'])->name('units.data')->middleware('permission:satuan.view');
    Route::get('units/create', [UnitController::class, 'create'])->name('units.create')->middleware('permission:satuan.create');
    Route::post('units', [UnitController::class, 'store'])->name('units.store')->middleware('permission:satuan.create');
    Route::get('units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit')->middleware('permission:satuan.update');
    Route::put('units/{unit}', [UnitController::class, 'update'])->name('units.update')->middleware('permission:satuan.update');
    Route::delete('units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy')->middleware('permission:satuan.delete');

    // Supplier
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('permission:supplier.view');
    Route::get('suppliers/data', [SupplierController::class, 'data'])->name('suppliers.data')->middleware('permission:supplier.view');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('permission:supplier.create');
    Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('permission:supplier.create');
    Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show')->middleware('permission:supplier.view');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('permission:supplier.update');
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update')->middleware('permission:supplier.update');
    Route::patch('suppliers/{supplier}/activate', [SupplierController::class, 'activate'])->name('suppliers.activate')->middleware('permission:supplier.update');
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('permission:supplier.delete');

    // Barang Masuk
    Route::get('stock-in', [StockInController::class, 'index'])->name('stock-in.index')->middleware('permission:barang-masuk.view');
    Route::get('stock-in/data', [StockInController::class, 'data'])->name('stock-in.data')->middleware('permission:barang-masuk.view');
    Route::get('stock-in/create', [StockInController::class, 'create'])->name('stock-in.create')->middleware('permission:barang-masuk.create');
    Route::post('stock-in', [StockInController::class, 'store'])->name('stock-in.store')->middleware('permission:barang-masuk.create');
    Route::get('stock-in/{stockIn}', [StockInController::class, 'show'])->name('stock-in.show')->middleware('permission:barang-masuk.view');
    Route::patch('stock-in/{stockIn}/cancel', [StockInController::class, 'cancel'])->name('stock-in.cancel')->middleware('permission:barang-masuk.delete');

    // Barang Keluar
    Route::get('stock-out', [StockOutController::class, 'index'])->name('stock-out.index')->middleware('permission:barang-keluar.view');
    Route::get('stock-out/data', [StockOutController::class, 'data'])->name('stock-out.data')->middleware('permission:barang-keluar.view');
    Route::get('stock-out/create', [StockOutController::class, 'create'])->name('stock-out.create')->middleware('permission:barang-keluar.create');
    Route::post('stock-out', [StockOutController::class, 'store'])->name('stock-out.store')->middleware('permission:barang-keluar.create');
    Route::get('stock-out/{stockOut}', [StockOutController::class, 'show'])->name('stock-out.show')->middleware('permission:barang-keluar.view');
    Route::patch('stock-out/{stockOut}/cancel', [StockOutController::class, 'cancel'])->name('stock-out.cancel')->middleware('permission:barang-keluar.delete');

    // Penggunaan ATK
    Route::get('usage', [UsageController::class, 'index'])->name('usage.index')->middleware('permission:barang-keluar.view');

    // Monitoring Stok
    Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index')->middleware('permission:barang.view');

    // Stock History
    Route::get('stock-history', [StockHistoryController::class, 'index'])->name('stock-history.index')->middleware('permission:barang.view');
    Route::get('stock-history/data', [StockHistoryController::class, 'data'])->name('stock-history.data')->middleware('permission:barang.view');

    // Stock Opname
    Route::get('stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index')->middleware('permission:stock-opname.view');
    Route::get('stock-opname/data', [StockOpnameController::class, 'data'])->name('stock-opname.data')->middleware('permission:stock-opname.view');
    Route::get('stock-opname/create', [StockOpnameController::class, 'create'])->name('stock-opname.create')->middleware('permission:stock-opname.create');
    Route::post('stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store')->middleware('permission:stock-opname.create');
    Route::get('stock-opname/{stockOpname}', [StockOpnameController::class, 'show'])->name('stock-opname.show')->middleware('permission:stock-opname.view');
    Route::patch('stock-opname/{stockOpname}/confirm', [StockOpnameController::class, 'confirm'])->name('stock-opname.confirm')->middleware('permission:stock-opname.update');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:laporan.view');
    Route::get('reports/{type}', [ReportController::class, 'show'])->name('reports.show')->middleware('permission:laporan.view');
    Route::get('reports/{type}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf')->middleware('permission:laporan.export');
    Route::get('reports/{type}/excel', [ReportController::class, 'excel'])->name('reports.excel')->middleware('permission:laporan.export');

    // User
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('permission:user.view');
    Route::get('users/data', [UserController::class, 'data'])->name('users.data')->middleware('permission:user.view');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:user.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:user.create');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:user.update');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:user.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:user.delete');

    // Role
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:role.view');
    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data')->middleware('permission:role.view');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:role.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:role.create');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:role.update');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:role.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role.delete');

    // Permission
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:role.view');
    Route::get('permissions/data', [PermissionController::class, 'data'])->name('permissions.data')->middleware('permission:role.view');
});