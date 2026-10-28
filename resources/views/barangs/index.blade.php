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
    /* Styling khusus tabel katalog barang */
    #barang-table thead th {
        background-color: rgba(201, 230, 255, 0.45);
        color: #004c6e;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border: none;
        padding: 14px 16px;
    }
    #barang-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-color: rgba(190, 200, 210, 0.25);
        font-size: 13px;
    }
    #barang-table tbody tr:hover {
        background-color: rgba(234, 237, 255, 0.4);
    }
    .dataTables_paginate .pagination {
        gap: 4px;
        margin-top: 16px;
    }
    .dataTables_paginate .page-link {
        border-radius: 999px !important;
        border: 1px solid rgba(190, 200, 210, 0.5);
        color: #131b2e;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
    }
    .dataTables_paginate .page-item.active .page-link {
        background-color: #006591;
        border-color: #006591;
        color: #ffffff;
    }
    .dataTables_info {
        font-size: 12px;
        color: #667085;
        padding-top: 16px;
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-8 min-h-[calc(100vh-72px)] bg-surface flex flex-col gap-6">

    {{-- ALERTS / NOTIFIKASI --}}
    @if(session('success'))
        <div class="flex items-center justify-between p-4 bg-tertiary-fixed/40 border border-tertiary/20 text-on-tertiary-fixed rounded-2xl shadow-sm">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-tertiary text-[22px]">check_circle</span>
                <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
            </div>
            <button type="button" class="text-on-tertiary-fixed/60 hover:text-on-tertiary-fixed" onclick="this.parentElement.remove()">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="flex items-center justify-between p-4 bg-error-container text-on-error-container rounded-2xl shadow-sm">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-error text-[22px]">error</span>
                <span class="font-medium text-xs sm:text-sm">{{ session('error') ?? $errors->first() }}</span>
            </div>
            <button type="button" class="text-on-error-container/60 hover:text-on-error-container" onclick="this.parentElement.remove()">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Persediaan &amp; Logistik</span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span class="font-label-sm text-label-sm text-primary font-bold">Master Data</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-on-surface font-bold tracking-tight">Daftar Barang</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Pengelolaan Data Barang dan ATK Unit Kerja Learning Center</p>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <a href="{{ asset('templates/barang.zip') }}" download class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px] text-primary">cloud_download</span>
                <span>Unduh Template</span>
            </a>
            <button type="button" class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                <span class="material-symbols-outlined text-[18px] text-primary">upload_file</span>
                <span>Impor Data</span>
            </button>
            @can('barang.create')
                <a href="{{ route('barangs.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white font-label-lg text-label-lg font-semibold shadow-sm transition-all shrink-0">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang</span>
                </a>
            @endcan
        </div>
    </div>

    {{-- 4 STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {{-- Total Terdaftar --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Total Terdaftar</span>
                <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-1">{{ number_format($totalBarang) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Barang</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">inventory_2</span>
            </div>
        </div>

        {{-- Stok Aman --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Aman</span>
                <span class="font-headline-sm text-headline-sm text-tertiary font-bold mt-1">{{ number_format($stokAman) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
                <span class="material-symbols-outlined text-[24px]">check_circle</span>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Menipis</span>
                <span class="font-headline-sm text-headline-sm text-amber-600 font-bold mt-1">{{ number_format($stokMenipis) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined text-[24px]">warning</span>
            </div>
        </div>

        {{-- Stok Habis --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Habis</span>
                <span class="font-headline-sm text-headline-sm text-error font-bold mt-1">{{ number_format($stokHabis) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-error-container flex items-center justify-center text-error">
                <span class="material-symbols-outlined text-[24px]">error</span>
            </div>
        </div>
    </div>

    {{-- KATALOG DATA MASTER PANEL --}}
    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/20 flex flex-col gap-6">

        {{-- PANEL HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-surface-container">
            <div class="flex flex-col gap-0.5">
                <div class="flex items-center gap-2">
                    <span class="font-title-lg text-title-lg text-on-surface font-bold">Katalog Data Master</span>
                    <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant font-semibold" id="table-count-badge">{{ number_format($totalBarang) }} Data</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Master Data • Manajemen Gudang &amp; ATK</span>
            </div>

            @can('barang.create')
                <a href="{{ route('barangs.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white font-label-lg text-label-lg font-semibold shadow-sm transition-all shrink-0">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang</span>
                </a>
            @endcan
        </div>

        {{-- TOOLBAR / FILTER --}}
        <div class="bg-surface-container-low p-4 rounded-2xl flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
                {{-- Search --}}
                <div class="relative flex-1 min-w-[240px]">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">search</span>
                    <input
                        type="text"
                        id="custom-search"
                        class="w-full h-11 pl-10 pr-4 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-xl placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all border border-outline-variant/30"
                        placeholder="Cari kode atau nama barang..."
                    >
                </div>

                {{-- Status Stok Filter --}}
                <div class="relative min-w-[170px]">
                    <select id="filter-status-stok" class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-xl focus:outline-none border border-outline-variant/30 appearance-none cursor-pointer">
                        <option value="">Semua Status Stok</option>
                        <option value="aman">Aman</option>
                        <option value="menipis">Menipis</option>
                        <option value="habis">Habis</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                </div>

                {{-- Kategori Filter --}}
                <div class="relative min-w-[170px]">
                    <select id="filter-kategori" class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-xl focus:outline-none border border-outline-variant/30 appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                </div>
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                {{-- Page Length --}}
                <div class="relative min-w-[150px]">
                    <select id="custom-length" class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-xl focus:outline-none border border-outline-variant/30 appearance-none cursor-pointer">
                        <option value="10">Tampilkan 10 data</option>
                        <option value="25">Tampilkan 25 data</option>
                        <option value="50">Tampilkan 50 data</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2">
                    <button type="button" class="h-11 px-4 rounded-xl bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-md text-label-md flex items-center gap-2 transition-colors shadow-sm border border-outline-variant/30" onclick="window.print()" title="Cetak Daftar">
                        <span class="material-symbols-outlined text-[18px] text-primary">print</span>
                        <span class="hidden sm:inline">Cetak</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- DATA TABLE WRAPPER --}}
        <div class="overflow-x-auto rounded-2xl border border-outline-variant/20">
            <table id="barang-table" class="w-full text-left border-collapse table">
                <thead>
                    <tr>
                        <th class="text-center rounded-l-xl">No</th>
                        <th class="text-center">Kode</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Minimum</th>
                        <th class="text-center">Status Stok</th>
                        <th>Lokasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL IMPOR DATA --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <div class="h-1 bg-primary"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E0F2FE] text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">upload_file</span>
                    </div>
                    <div>
                        <h5 class="font-bold text-base text-on-surface m-0">Impor Data Barang</h5>
                        <p class="text-xs text-on-surface-variant m-0">Unggah file spreadsheet Excel / CSV</p>
                    </div>
                </div>

                <div class="p-4 bg-surface-container-low rounded-xl mb-4 text-xs text-on-surface-variant flex flex-col gap-2">
                    <p class="m-0">Format kolom yang didukung: <strong>Kode, Nama Barang, Kategori, Satuan, Stok Minimum, Lokasi, Deskripsi</strong>.</p>
                    <a href="{{ asset('templates/barang.zip') }}" download class="text-primary font-bold hover:underline inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">cloud_download</span>
                        <span>Unduh format template di sini</span>
                    </a>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="file" name="file" class="form-control rounded-xl text-xs py-2.5" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <button type="button" class="px-4 py-2 rounded-full border border-outline-variant/60 text-xs font-semibold" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="px-5 py-2 rounded-full bg-primary-container text-white text-xs font-bold hover:bg-primary transition-all">Mulai Impor</button>
                    </div>
                </form>
            </div>
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
    const table = $('#barang-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        pageLength: 10,
        dom: 'rt<"flex flex-col sm:flex-row items-center justify-between gap-4 p-4"<"dataTables_info"i><"dataTables_paginate"p>>',
        language: {
            processing: '<div class="py-3 text-primary font-semibold">Memuat data barang...</div>',
            emptyTable: 'Belum ada data barang.',
            zeroRecords: 'Data barang tidak ditemukan.',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data untuk ditampilkan',
            paginate: {
                previous: '‹ Sebelumnya',
                next: 'Berikutnya ›'
            }
        },
        ajax: {
            url: @json(route('barangs.data')),
            data: function (d) {
                d.status_stok = $('#filter-status-stok').val();
                d.category_id = $('#filter-kategori').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-semibold text-on-surface-variant' },
            { 
                data: 'code', 
                name: 'barangs.code', 
                className: 'text-center font-mono font-bold text-primary',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'name', 
                name: 'barangs.name', 
                className: 'font-semibold text-on-surface' 
            },
            { data: 'category_name', name: 'categories.name', className: 'text-center text-on-surface-variant' },
            { 
                data: 'unit_name', 
                name: 'units.name', 
                className: 'text-center',
                render: function (data) {
                    return '<span class="px-2 py-0.5 rounded-full bg-surface-container font-mono text-xs font-semibold text-on-surface-variant">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'stock', 
                name: 'barangs.stock', 
                className: 'text-center font-bold text-on-surface' 
            },
            { 
                data: 'minimum_stock', 
                name: 'barangs.minimum_stock', 
                className: 'text-center text-on-surface-variant' 
            },
            { data: 'stock_status', name: 'stock_status', orderable: false, searchable: false, className: 'text-center' },
            { 
                data: 'location', 
                name: 'barangs.location', 
                className: 'text-on-surface-variant',
                render: function (data) {
                    return data ? '<span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm text-primary">location_on</span>' + data + '</span>' : '-';
                }
            },
            { data: 'active_status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        drawCallback: function (settings) {
            const api = this.api();
            const total = api.page.info().recordsTotal;
            $('#table-count-badge').text(total + ' Data');
        }
    });

    // Custom Search
    $('#custom-search').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Filters
    $('#filter-status-stok, #filter-kategori').on('change', function () {
        table.draw();
    });

    // Length
    $('#custom-length').on('change', function () {
        table.page.len(parseInt(this.value)).draw();
    });
});
</script>
@endpush
