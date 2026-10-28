@extends('layouts.app')

@section('title', 'Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<style>
    #stockin-table thead th {
        background-color: rgba(201, 230, 255, 0.45);
        color: #004c6e;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border: none;
        padding: 14px 16px;
    }
    #stockin-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-color: rgba(190, 200, 210, 0.25);
        font-size: 13px;
    }
    #stockin-table tbody tr:hover {
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
                <span class="font-label-sm text-label-sm text-primary font-bold">Transaksi</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-on-surface font-bold tracking-tight">Barang Masuk</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Pencatatan Penerimaan Stok Dari Supplier</p>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <button type="button" class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm" onclick="window.print()">
                <span class="material-symbols-outlined text-[18px] text-primary">print</span>
                <span>Cetak</span>
            </button>
            @can('barang-masuk.create')
                <a href="{{ route('stock-in.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white font-label-lg text-label-lg font-semibold shadow-sm transition-all shrink-0">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang Masuk</span>
                </a>
            @endcan
        </div>
    </div>

    {{-- 4 STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {{-- Total Transaksi --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Total Transaksi</span>
                <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-1">{{ number_format($totalTransactions) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Transaksi</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">move_to_inbox</span>
            </div>
        </div>

        {{-- Transaksi Aktif --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Transaksi Aktif</span>
                <span class="font-headline-sm text-headline-sm text-tertiary font-bold mt-1">{{ number_format($activeTransactions) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Transaksi</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
                <span class="material-symbols-outlined text-[24px]">check_circle</span>
            </div>
        </div>

        {{-- Dibatalkan --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Dibatalkan</span>
                <span class="font-headline-sm text-headline-sm text-error font-bold mt-1">{{ number_format($cancelledTransactions) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Transaksi</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-error-container flex items-center justify-center text-error">
                <span class="material-symbols-outlined text-[24px]">cancel</span>
            </div>
        </div>

        {{-- Total Barang Diterima --}}
        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex items-center justify-between border border-outline-variant/20">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Total Barang Diterima</span>
                <span class="font-headline-sm text-headline-sm text-secondary font-bold mt-1">{{ number_format($totalItemsReceived) }} <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item aktif</span></span>
            </div>
            <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">inventory_2</span>
            </div>
        </div>
    </div>

    {{-- RIWAYAT TRANSAKSI PANEL --}}
    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/20 flex flex-col gap-6">

        {{-- PANEL HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-surface-container">
            <div class="flex flex-col gap-0.5">
                <div class="flex items-center gap-2">
                    <span class="font-title-lg text-title-lg text-on-surface font-bold">Riwayat Barang Masuk</span>
                    <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant font-semibold" id="table-count-badge">{{ number_format($totalTransactions) }} Data</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Daftar pencatatan penerimaan stok dan barang dari supplier</span>
            </div>

            @can('barang-masuk.create')
                <a href="{{ route('stock-in.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white font-label-lg text-label-lg font-semibold shadow-sm transition-all shrink-0">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang Masuk</span>
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
                        placeholder="Cari transaksi, supplier, dokumen..."
                    >
                </div>

                {{-- Status Filter --}}
                <div class="relative min-w-[170px]">
                    <select id="filter-status" class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-xl focus:outline-none border border-outline-variant/30 appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="cancelled">Dibatalkan</option>
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
            </div>
        </div>

        {{-- DATA TABLE WRAPPER --}}
        <div class="overflow-x-auto rounded-2xl border border-outline-variant/20">
            <table id="stockin-table" class="w-full text-left border-collapse table">
                <thead>
                    <tr>
                        <th class="text-center rounded-l-xl">No</th>
                        <th class="text-center">No. Transaksi</th>
                        <th class="text-center">Tanggal</th>
                        <th>Supplier</th>
                        <th class="text-center">No. Dokumen</th>
                        <th class="text-center">Petugas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
    const table = $('#stockin-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        pageLength: 10,
        dom: 'rt<"flex flex-col sm:flex-row items-center justify-between gap-4 p-4"<"dataTables_info"i><"dataTables_paginate"p>>',
        language: {
            processing: '<div class="py-3 text-primary font-semibold">Memuat transaksi barang masuk...</div>',
            emptyTable: 'Belum ada transaksi barang masuk.',
            zeroRecords: 'Transaksi tidak ditemukan.',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data untuk ditampilkan',
            paginate: {
                previous: '‹ Sebelumnya',
                next: 'Berikutnya ›'
            }
        },
        ajax: {
            url: @json(route('stock-in.data')),
            data: function (d) {
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-semibold text-on-surface-variant' },
            { 
                data: 'transaction_number', 
                name: 'transaction_number', 
                className: 'text-center font-mono font-bold text-primary'
            },
            { data: 'transaction_date', name: 'transaction_date', className: 'text-center font-medium text-on-surface' },
            { data: 'supplier_name', name: 'supplier.name', className: 'font-semibold text-on-surface' },
            { data: 'document_number', name: 'document_number', className: 'text-center text-on-surface-variant' },
            { data: 'user_name', name: 'user.name', className: 'text-center text-on-surface-variant' },
            { data: 'status_badge', name: 'status', orderable: false, searchable: false, className: 'text-center' },
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

    // Status filter
    $('#filter-status').on('change', function () {
        table.draw();
    });

    // Length
    $('#custom-length').on('change', function () {
        table.page.len(parseInt(this.value)).draw();
    });
});
</script>
@endpush
