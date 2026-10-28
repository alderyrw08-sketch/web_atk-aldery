@extends('layouts.app')

@section('title', 'Daftar Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@php
    use App\Models\Barang;

    $totalBarang = Barang::count();

    $stokAman = Barang::where('status', true)
        ->whereColumn('stock', '>', 'minimum_stock')
        ->count();

    $stokMenipis = Barang::where('status', true)
        ->where('stock', '>', 0)
        ->whereColumn('stock', '<=', 'minimum_stock')
        ->count();

    $stokHabis = Barang::where('status', true)
        ->where('stock', '<=', 0)
        ->count();
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
/* =========================================
   DAFTAR BARANG - SISTEM ATK LEARNING CENTER
========================================= */

.barang-page {
    --primary: #006591;
    --blue: #0ea5e9;
    --background: #faf8ff;
    --surface: #ffffff;
    --soft: #f2f3ff;
    --container: #eaedff;
    --text: #131b2e;
    --muted: #667085;
    --border: #e5eaf0;
    --green: #006e2f;
    --red: #ba1a1a;

    min-height: calc(100vh - 72px);
    padding: 36px 40px;
    background: var(--background);
    color: var(--text);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
}

.barang-page *,
.barang-page *::before,
.barang-page *::after {
    box-sizing: border-box;
}

.barang-page .material-symbols-outlined {
    font-family: 'Material Symbols Outlined';
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    line-height: 1;
    display: inline-block;
    white-space: nowrap;
    direction: ltr;
    -webkit-font-smoothing: antialiased;
    font-feature-settings: 'liga';
}

/* Heading */

.barang-page .page-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 28px;
}

.barang-page .breadcrumb-line {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
    margin-bottom: 10px;
    color: var(--muted);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
}

.barang-page .breadcrumb-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--blue);
}

.barang-page .breadcrumb-current {
    color: var(--primary);
}

.barang-page .page-title {
    margin: 0 0 8px;
    color: var(--text);
    font-size: 29px;
    font-weight: 800;
    letter-spacing: -.8px;
}

.barang-page .page-subtitle {
    margin: 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.7;
}

.barang-page .top-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

/* Buttons */

.barang-page .btn-stitch {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border: 0;
    border-radius: 999px;
    background: var(--soft);
    color: var(--text);
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s ease, color .2s ease;
}

.barang-page .btn-stitch:hover {
    background: var(--container);
    color: var(--text);
}

.barang-page .btn-stitch .material-symbols-outlined {
    color: var(--primary);
    font-size: 19px;
}

.barang-page .btn-add {
    background: var(--blue);
    color: #fff;
}

.barang-page .btn-add .material-symbols-outlined {
    color: #fff;
}

.barang-page .btn-add:hover {
    background: var(--primary);
    color: #fff;
}

/* Statistic cards */

.barang-page .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.barang-page .stat-card {
    min-width: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 22px 20px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(19, 27, 46, .025);
}

.barang-page .stat-label {
    color: var(--muted);
    font-size: 11px;
    font-weight: 600;
}

.barang-page .stat-number {
    margin-top: 7px;
    color: var(--text);
    font-size: 25px;
    font-weight: 800;
    line-height: 1.2;
}

.barang-page .stat-unit {
    color: var(--muted);
    font-size: 11px;
    font-weight: 400;
}

.barang-page .stat-number.success {
    color: var(--green);
}

.barang-page .stat-number.danger {
    color: var(--red);
}

.barang-page .stat-icon {
    width: 45px;
    height: 45px;
    flex: 0 0 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #e2e7ff;
    color: var(--primary);
}

.barang-page .stat-icon .material-symbols-outlined {
    font-size: 23px;
}

.barang-page .stat-icon.success {
    background: #d5ffdb;
    color: var(--green);
}

.barang-page .stat-icon.warning {
    background: #dceafa;
    color: #004d6a;
}

.barang-page .stat-icon.danger {
    background: #ffdad6;
    color: var(--red);
}

/* Main catalog */

.barang-page .catalog-card {
    padding: 25px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(19, 27, 46, .025);
}

.barang-page .catalog-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 22px;
}

.barang-page .catalog-title-line {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 6px;
}

.barang-page .catalog-title {
    margin: 0;
    color: var(--text);
    font-size: 17px;
    font-weight: 800;
}

.barang-page .data-count {
    padding: 5px 10px;
    border-radius: 999px;
    background: #c9e6ff;
    color: #004c6e;
    font-size: 10px;
    font-weight: 800;
}

.barang-page .catalog-description {
    color: var(--muted);
    font-size: 11px;
}

/* Filter and search */

.barang-page .filter-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 13px;
    padding: 15px;
    margin-bottom: 20px;
    background: var(--soft);
    border-radius: 14px;
}

.barang-page .filter-main {
    min-width: 0;
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.barang-page .search-wrap {
    position: relative;
    min-width: 180px;
    flex: 1;
}

.barang-page .search-wrap > .material-symbols-outlined {
    position: absolute;
    top: 50%;
    left: 13px;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 20px;
    pointer-events: none;
}

.barang-page .filter-control {
    width: 100%;
    height: 43px;
    padding: 0 13px;
    border: 1px solid transparent;
    border-radius: 10px;
    outline: none;
    background: #fff;
    color: var(--text);
    font-family: inherit;
    font-size: 11px;
}

.barang-page .search-input {
    padding-left: 42px;
}

.barang-page .filter-control:focus {
    border-color: #80c8ee;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, .09);
}

.barang-page .filter-select {
    min-width: 140px;
    max-width: 185px;
    cursor: pointer;
}

.barang-page .filter-tools {
    display: flex;
    align-items: center;
    gap: 8px;
}

.barang-page .page-size {
    width: 155px;
    min-width: 155px;
}

.barang-page .tool-button {
    height: 43px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 12px;
    border: 0;
    border-radius: 10px;
    background: #fff;
    color: var(--text);
    font-family: inherit;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
}

.barang-page .tool-button:hover {
    background: var(--container);
}

.barang-page .tool-button .material-symbols-outlined {
    color: var(--primary);
    font-size: 19px;
}

.barang-page .tool-button.excel .material-symbols-outlined {
    color: var(--green);
}

/* Table */

.barang-page .table-wrap {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
}

.barang-page table.dataTable {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0;
    color: var(--text);
    font-family: inherit;
    font-size: 12px;
}

.barang-page table.dataTable thead th {
    padding: 15px 13px !important;
    border: 0 !important;
    background: rgba(201, 230, 255, .42);
    color: #004c6e;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
    white-space: nowrap;
    vertical-align: middle;
}

.barang-page table.dataTable thead th:first-child {
    border-radius: 10px 0 0 10px;
}

.barang-page table.dataTable thead th:last-child {
    border-radius: 0 10px 10px 0;
}

.barang-page table.dataTable tbody td {
    padding: 16px 13px !important;
    border: 0 !important;
    border-bottom: 1px solid #edf0f5 !important;
    background: transparent;
    vertical-align: middle;
}

.barang-page table.dataTable tbody tr:nth-child(even) {
    background: rgba(242, 243, 255, .48);
}

.barang-page table.dataTable tbody tr:hover {
    background: var(--soft);
}

.barang-page table.dataTable tbody tr:last-child td {
    border-bottom: 0 !important;
}

.barang-page .item-code {
    color: var(--primary);
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.barang-page .item-name {
    min-width: 125px;
    display: inline-block;
    font-size: 12px;
    font-weight: 800;
}

.barang-page .unit-text {
    color: var(--muted);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.barang-page .stock-number {
    font-size: 13px;
    font-weight: 800;
}

.barang-page .stock-number.zero {
    color: var(--red);
}

.barang-page .muted-text {
    color: var(--muted);
    font-size: 11px;
}

.barang-page .category-pill {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 999px;
    background: var(--container);
    color: var(--muted);
    font-size: 10px;
    white-space: nowrap;
}

/* Stock status */

.barang-page .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap;
}

.barang-page .status-pill::before {
    content: '';
    width: 6px;
    height: 6px;
    flex: 0 0 6px;
    border-radius: 50%;
    background: currentColor;
}

.barang-page .status-pill.aman {
    color: var(--green);
    background: #d5ffdb;
}

.barang-page .status-pill.menipis {
    color: #004d6a;
    background: #dceafa;
}

.barang-page .status-pill.habis {
    color: var(--red);
    background: #ffdad6;
}

/* Active status */

.barang-page .active-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap;
}

.barang-page .active-pill.aktif {
    color: var(--green);
    background: #d5ffdb;
}

.barang-page .active-pill.nonaktif {
    color: var(--muted);
    background: #e2e7ff;
}

/* Row action buttons */

.barang-page .action-buttons {
    min-width: 112px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.barang-page .action-icon {
    width: 31px;
    height: 31px;
    flex: 0 0 31px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 !important;
    border: 0 !important;
    border-radius: 50% !important;
    text-decoration: none;
    box-shadow: none !important;
    cursor: pointer;
}

.barang-page .action-icon .material-symbols-outlined {
    font-size: 17px;
}

.barang-page .action-detail {
    color: #004c6e;
    background: #e3f2ff;
}

.barang-page .action-edit {
    color: var(--text);
    background: #e2e7ff;
}

.barang-page .action-delete {
    color: #93000a;
    background: #ffdad6;
}

.barang-page .action-activate {
    color: var(--green);
    background: #d5ffdb;
}

.barang-page .action-detail:hover {
    background: #c9e6ff;
}

.barang-page .action-edit:hover {
    background: #d1d9ff;
}

.barang-page .action-delete:hover {
    color: #fff;
    background: var(--red);
}

.barang-page .action-activate:hover {
    color: #fff;
    background: var(--green);
}

/* Footer and pagination */

.barang-page .table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding-top: 20px;
}

.barang-page .table-info {
    color: var(--muted);
    font-size: 11px;
}

.barang-page .table-info strong {
    color: var(--text);
}

.barang-page .dataTables_info {
    display: none !important;
}

.barang-page .dataTables_paginate {
    padding-top: 0 !important;
}

.barang-page .dataTables_paginate .pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin: 0 !important;
}

.barang-page .dataTables_paginate .page-link {
    min-width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 12px;
    border: 0 !important;
    border-radius: 999px !important;
    background: var(--soft);
    color: var(--muted);
    font-family: inherit;
    font-size: 11px;
    font-weight: 700;
    box-shadow: none !important;
}

.barang-page .dataTables_paginate .page-item.active .page-link {
    background: var(--blue);
    color: #fff;
}

.barang-page .dataTables_paginate .page-item.disabled .page-link {
    opacity: .45;
}

.barang-page .dataTables_length,
.barang-page .dataTables_filter {
    display: none;
}

/* Notifications */

.barang-page .alert {
    margin-bottom: 20px;
    border: 0;
    border-radius: 12px;
    font-size: 12px;
}

/* Responsive */

@media (max-width: 1350px) {
    .barang-page {
        padding: 30px 26px;
    }

    .barang-page .filter-panel {
        align-items: stretch;
        flex-direction: column;
    }

    .barang-page .filter-tools {
        justify-content: flex-end;
        flex-wrap: wrap;
    }
}

@media (max-width: 1050px) {
    .barang-page .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .barang-page .page-heading {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .barang-page {
        padding: 22px 15px;
    }

    .barang-page .page-title {
        font-size: 25px;
    }

    .barang-page .top-actions {
        width: 100%;
    }

    .barang-page .top-actions .btn-stitch {
        flex: 1;
    }

    .barang-page .stat-card {
        padding: 15px 13px;
    }

    .barang-page .stat-icon {
        width: 36px;
        height: 36px;
        flex-basis: 36px;
    }

    .barang-page .stat-number {
        font-size: 22px;
    }

    .barang-page .catalog-card {
        padding: 16px 12px;
    }

    .barang-page .catalog-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .barang-page .filter-main {
        align-items: stretch;
        flex-direction: column;
    }

    .barang-page .search-wrap,
    .barang-page .filter-select {
        width: 100%;
        max-width: none;
        min-width: 0;
    }

    .barang-page .filter-tools {
        justify-content: flex-start;
    }

    .barang-page .page-size {
        width: 100%;
        min-width: 150px;
        flex: 1;
    }

    .barang-page .table-footer {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 420px) {
    .barang-page .stats-grid {
        grid-template-columns: 1fr;
    }

    .barang-page .filter-tools .tool-button {
        flex: 1;
    }
}

/* Print */

@media print {
    body * {
        visibility: hidden;
    }

    .barang-page,
    .barang-page * {
        visibility: visible;
    }

    .barang-page {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 0;
        background: #fff;
    }

    .barang-page .top-actions,
    .barang-page .filter-panel,
    .barang-page .action-buttons,
    .barang-page .dataTables_paginate {
        display: none !important;
    }

    .barang-page .catalog-card,
    .barang-page .stat-card {
        box-shadow: none;
    }
}
</style>
@endpush

@section('content')
<div class="barang-page">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="material-symbols-outlined align-middle me-1">check_circle</span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Page heading --}}
    <div class="page-heading">
        <div>
            <div class="breadcrumb-line">
                <span>Persediaan &amp; Logistik</span>
                <span class="breadcrumb-dot"></span>
                <span class="breadcrumb-current">Master Data</span>
            </div>

            <h1 class="page-title">Daftar Barang</h1>

            <p class="page-subtitle">
                Pengelolaan Data Barang dan ATK Unit Kerja Learning Center
            </p>
        </div>

        <div class="top-actions">
            <button type="button" class="btn-stitch" id="btn-template">
                <span class="material-symbols-outlined">cloud_download</span>
                Unduh Template
            </button>

            <button type="button" class="btn-stitch" id="btn-import-info">
                <span class="material-symbols-outlined">upload_file</span>
                Impor Data
            </button>
        </div>
    </div>

    {{-- Statistic cards --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div>
                <div class="stat-label">Total Terdaftar</div>
                <div class="stat-number">
                    {{ number_format($totalBarang) }}
                    <span class="stat-unit">Barang</span>
                </div>
            </div>

            <div class="stat-icon">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-label">Stok Aman</div>
                <div class="stat-number success">
                    {{ number_format($stokAman) }}
                    <span class="stat-unit">Item</span>
                </div>
            </div>

            <div class="stat-icon success">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-label">Stok Menipis</div>
                <div class="stat-number">
                    {{ number_format($stokMenipis) }}
                    <span class="stat-unit">Item</span>
                </div>
            </div>

            <div class="stat-icon warning">
                <span class="material-symbols-outlined">warning</span>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-label">Stok Habis</div>
                <div class="stat-number danger">
                    {{ number_format($stokHabis) }}
                    <span class="stat-unit">Item</span>
                </div>
            </div>

            <div class="stat-icon danger">
                <span class="material-symbols-outlined">error</span>
            </div>
        </div>

    </div>

    {{-- Catalog --}}
    <div class="catalog-card">

        <div class="catalog-heading">
            <div>
                <div class="catalog-title-line">
                    <h2 class="catalog-title">Katalog Data Master</h2>

                    <span class="data-count" id="catalog-count">
                        {{ number_format($totalBarang) }} Data
                    </span>
                </div>

                <div class="catalog-description">
                    Master Data • Manajemen Gudang &amp; ATK
                </div>
            </div>

            @can('barang.create')
                <a href="{{ route('barangs.create') }}" class="btn-stitch btn-add">
                    <span class="material-symbols-outlined">add</span>
                    Tambah Barang
                </a>
            @endcan
        </div>

        {{-- Filters --}}
        <div class="filter-panel">
            <div class="filter-main">

                <div class="search-wrap">
                    <span class="material-symbols-outlined">search</span>

                    <input
                        type="search"
                        id="search-barang"
                        class="filter-control search-input"
                        placeholder="Cari kode atau nama barang..."
                        autocomplete="off"
                    >
                </div>

                <select id="filter-category" class="filter-control filter-select">
                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select id="filter-status" class="filter-control filter-select">
                    <option value="">Semua Status Stok</option>
                    <option value="aman">Aman</option>
                    <option value="menipis">Menipis</option>
                    <option value="habis">Habis</option>
                </select>

            </div>

            <div class="filter-tools">
                <select id="page-length" class="filter-control page-size" aria-label="Jumlah data">
                    <option value="10">Tampilkan 10 data</option>
                    <option value="25">Tampilkan 25 data</option>
                    <option value="50">Tampilkan 50 data</option>
                </select>

                <button type="button" class="tool-button excel" id="btn-excel" title="Ekspor CSV">
                    <span class="material-symbols-outlined">table_view</span>
                    Excel
                </button>

                <button type="button" class="tool-button" id="btn-print" title="Cetak daftar barang">
                    <span class="material-symbols-outlined">print</span>
                    Cetak
                </button>
            </div>
        </div>

        {{-- Data table --}}
        <div class="table-wrap">
            <table id="barang-table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th class="text-end">Stok</th>
                        <th class="text-end">Minimum</th>
                        <th class="text-center">Status Stok</th>
                        <th>Lokasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- Custom pagination footer --}}
        <div class="table-footer">
            <div id="custom-table-info" class="table-info">
                Memuat data barang...
            </div>

            <div id="custom-table-pagination"></div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    const table = $('#barang-table').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        pageLength: 10,
        lengthChange: false,
        searching: true,
        ordering: true,
        responsive: false,
        dom: 'rt<"bottom"ip>',

        language: {
            processing: 'Memuat data...',
            emptyTable: 'Belum ada data barang.',
            zeroRecords: 'Data barang tidak ditemukan.',
            info: '',
            infoEmpty: '',
            infoFiltered: '',
            paginate: {
                previous: '‹ Sebelumnya',
                next: 'Berikutnya ›'
            }
        },

        ajax: {
            url: @json(route('barangs.data')),
            type: 'GET',

            data: function (d) {
                d.category_id = $('#filter-category').val();
                d.status_stok = $('#filter-status').val();
            },

            error: function (xhr) {
                console.error('Gagal memuat data barang:', xhr.responseText);

                $('#custom-table-info').text(
                    'Gagal memuat data. Periksa koneksi atau server.'
                );
            }
        },

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'muted-text'
            },
            {
                data: 'code',
                name: 'code',
                render: function (data, type) {
                    if (type !== 'display') return data ?? '';

                    return '<span class="item-code">' +
                        escapeHtml(data || '-') +
                        '</span>';
                }
            },
            {
                data: 'name',
                name: 'name',
                render: function (data, type) {
                    if (type !== 'display') return data ?? '';

                    return '<span class="item-name">' +
                        escapeHtml(data || '-') +
                        '</span>';
                }
            },
            {
                data: 'category_name',
                name: 'category.name',
                defaultContent: '-',
                render: function (data, type) {
                    if (type !== 'display') return data ?? '';

                    return '<span class="category-pill">' +
                        escapeHtml(data || '-') +
                        '</span>';
                }
            },
            {
                data: 'unit_name',
                name: 'unit.name',
                defaultContent: '-',
                render: function (data, type) {
                    if (type !== 'display') return data ?? '';

                    return '<span class="unit-text">' +
                        escapeHtml(data || '-') +
                        '</span>';
                }
            },
            {
                data: 'stock',
                name: 'stock',
                className: 'text-end',
                render: function (data, type) {
                    if (type !== 'display') return data ?? 0;

                    const value = Number(data ?? 0);

                    return '<span class="stock-number' +
                        (value <= 0 ? ' zero' : '') + '">' +
                        escapeHtml(value) +
                        '</span>';
                }
            },
            {
                data: 'minimum_stock',
                name: 'minimum_stock',
                className: 'text-end muted-text'
            },
            {
                data: 'stock_status',
                name: 'stock_status',
                orderable: false,
                className: 'text-center',
                render: function (data, type) {
                    const text = $('<div>').html(data || '').text().trim();

                    if (type !== 'display') return text;

                    let css = 'aman';

                    if (text.toLowerCase().includes('habis')) {
                        css = 'habis';
                    } else if (text.toLowerCase().includes('menipis')) {
                        css = 'menipis';
                    }

                    return '<span class="status-pill ' + css + '">' +
                        escapeHtml(text || '-') +
                        '</span>';
                }
            },
            {
                data: 'location',
                name: 'location',
                defaultContent: '-',
                render: function (data, type) {
                    if (type !== 'display') return data ?? '';

                    return '<span class="muted-text">' +
                        escapeHtml(data || '-') +
                        '</span>';
                }
            },
            {
                data: 'active_status',
                name: 'status',
                orderable: false,
                className: 'text-center',
                render: function (data, type) {
                    const text = $('<div>').html(data || '').text().trim();

                    if (type !== 'display') return text;

                    const css = text.toLowerCase().includes('nonaktif')
                        ? 'nonaktif'
                        : 'aktif';

                    return '<span class="active-pill ' + css + '">' +
                        escapeHtml(text || '-') +
                        '</span>';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type) {
                    if (type !== 'display' || !data) {
                        return data ?? '';
                    }

                    const wrapper = $('<div>').html(data);

                    wrapper.find('a, button').each(function () {
                        const element = $(this);
                        const label = element.text().trim().replace(/\s+/g, ' ');
                        const lower = label.toLowerCase();

                        let icon = 'visibility';
                        let css = 'action-detail';

                        if (lower.includes('edit')) {
                            icon = 'edit';
                            css = 'action-edit';
                        } else if (
                            lower.includes('nonaktifkan') ||
                            lower.includes('hapus')
                        ) {
                            icon = 'block';
                            css = 'action-delete';
                        } else if (lower.includes('aktifkan')) {
                            icon = 'power_settings_new';
                            css = 'action-activate';
                        }

                        element
                            .attr('title', label || 'Lihat detail')
                            .attr('aria-label', label || 'Lihat detail')
                            .removeClass(
                                'btn btn-sm btn-info btn-warning btn-danger btn-success'
                            )
                            .addClass('action-icon ' + css)
                            .empty()
                            .append(
                                $('<span>')
                                    .addClass('material-symbols-outlined')
                                    .text(icon)
                            );
                    });

                    wrapper.find('form').addClass('d-inline');

                    return '<div class="action-buttons">' +
                        wrapper.html() +
                        '</div>';
                }
            }
        ],

        drawCallback: function () {
            const info = this.api().page.info();

            $('#custom-table-info').html(
                'Menampilkan <strong>' +
                (info.recordsDisplay ? info.start + 1 : 0) +
                '</strong> sampai <strong>' +
                info.end +
                '</strong> dari <strong>' +
                info.recordsDisplay +
                '</strong> data'
            );

            $('#catalog-count').text(info.recordsDisplay + ' Data');

            $('#custom-table-pagination').empty().append(
                $('#barang-table_paginate').detach()
            );
        }
    });

    // Search
    $('#search-barang').on('input', function () {
        table.search(this.value).draw();
    });

    // Category and stock-status filters
    $('#filter-category, #filter-status').on('change', function () {
        table.ajax.reload();
    });

    // Rows per page
    $('#page-length').on('change', function () {
        table.page.len(Number(this.value)).draw();
    });

    // Print
    $('#btn-print').on('click', function () {
        window.print();
    });

    // Template button: backend download endpoint has not been connected yet
    $('#btn-template').on('click', function () {
        alert('Fitur unduh template belum tersedia.');
    });

    // Export current page to CSV
    $('#btn-excel').on('click', function () {
        const rows = table.rows({ page: 'current' }).data().toArray();

        if (!rows.length) {
            alert('Tidak ada data barang untuk diekspor.');
            return;
        }

        const headers = [
            'No',
            'Kode',
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Stok',
            'Minimum',
            'Status Stok',
            'Lokasi',
            'Status'
        ];

        function csvEscape(value) {
            const text = String(value ?? '')
                .replace(/<[^>]*>/g, '')
                .trim();

            return '"' + text.replace(/"/g, '""') + '"';
        }

        const lines = [headers.map(csvEscape).join(',')];

        rows.forEach(function (row) {
            lines.push([
                row.DT_RowIndex,
                row.code,
                row.name,
                row.category_name,
                row.unit_name,
                row.stock,
                row.minimum_stock,
                $('<div>').html(row.stock_status || '').text().trim(),
                row.location,
                $('<div>').html(row.active_status || '').text().trim()
            ].map(csvEscape).join(','));
        });

        const blob = new Blob(
            ['\uFEFF' + lines.join('\r\n')],
            { type: 'text/csv;charset=utf-8;' }
        );

        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = url;
        link.download = 'daftar-barang.csv';

        document.body.appendChild(link);
        link.click();
        link.remove();

        setTimeout(function () {
            URL.revokeObjectURL(url);
        }, 1000);
    });

    // Import button: backend import feature has not been connected yet
    $('#btn-import-info').on('click', function () {
        alert('Fitur impor data belum terhubung ke backend.');
    });
});
</script>
@endpush
