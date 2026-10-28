@extends('layouts.app')

@section('title', 'Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb">
                <span>Persediaan &amp; Logistik</span>
                <span class="inv-breadcrumb-dot"></span>
                <span class="inv-breadcrumb-current">Transaksi</span>
            </div>
            <h1 class="inv-title">Barang Masuk</h1>
            <p class="inv-subtitle">Pencatatan penerimaan stok dari supplier</p>
        </div>
        <div class="inv-actions">
            <button type="button" class="inv-button" id="stockin-print" title="Cetak daftar barang masuk">
                <span class="material-symbols-outlined">print</span>
                Cetak
            </button>
            @can('barang-masuk.create')
                <a href="{{ route('stock-in.create') }}" class="inv-button inv-button-primary">
                    <span class="material-symbols-outlined">add</span>
                    Tambah Barang Masuk
                </a>
            @endcan
        </div>
    </div>

    @if (session('success'))
        <div class="inv-alert" role="status">
            <span class="material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="inv-alert error" role="alert">
            <span class="material-symbols-outlined">error</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="inv-stats">
        <div class="inv-stat"><div><div class="inv-stat-label">Total Transaksi</div><div class="inv-stat-value">{{ number_format($totalTransactions) }} <small>Transaksi</small></div></div><div class="inv-stat-icon"><span class="material-symbols-outlined">move_to_inbox</span></div></div>
        <div class="inv-stat"><div><div class="inv-stat-label">Transaksi Aktif</div><div class="inv-stat-value success">{{ number_format($activeTransactions) }} <small>Transaksi</small></div></div><div class="inv-stat-icon success"><span class="material-symbols-outlined">check_circle</span></div></div>
        <div class="inv-stat"><div><div class="inv-stat-label">Dibatalkan</div><div class="inv-stat-value danger">{{ number_format($cancelledTransactions) }} <small>Transaksi</small></div></div><div class="inv-stat-icon danger"><span class="material-symbols-outlined">cancel</span></div></div>
        <div class="inv-stat"><div><div class="inv-stat-label">Total Barang Diterima</div><div class="inv-stat-value">{{ number_format($totalItemsReceived) }} <small>Item aktif</small></div></div><div class="inv-stat-icon"><span class="material-symbols-outlined">inventory_2</span></div></div>
    </div>

    <section class="inv-panel" aria-labelledby="stockin-list-title">
        <div class="inv-section-head">
            <h2 class="inv-section-title" id="stockin-list-title">Riwayat Barang Masuk <span class="inv-count" id="stockin-count">{{ number_format($totalTransactions) }} Data</span></h2>
            <button type="button" class="inv-button inv-button-outline" id="stockin-export" title="Ekspor halaman aktif sebagai CSV"><span class="material-symbols-outlined">table_view</span>Ekspor CSV</button>
        </div>
        <div class="inv-toolbar">
            <div class="inv-toolbar-main">
                <label class="inv-search-wrap"><span class="material-symbols-outlined">search</span><input type="search" class="inv-control inv-search" id="stockin-search" placeholder="Cari transaksi, supplier, atau dokumen..." autocomplete="off" aria-label="Cari transaksi barang masuk"></label>
                <select class="inv-control inv-filter" id="stockin-status" aria-label="Filter status"><option value="">Semua Status</option><option value="active">Aktif</option><option value="cancelled">Dibatalkan</option></select>
            </div>
            <div class="inv-toolbar-actions"><select class="inv-control inv-filter" id="stockin-length" aria-label="Jumlah data per halaman"><option value="10">Tampilkan 10 data</option><option value="25">Tampilkan 25 data</option><option value="50">Tampilkan 50 data</option></select></div>
        </div>
        <div class="inv-table-wrap">
            <table id="stockin-table" class="table inv-table">
                <thead><tr><th>No</th><th>No. Transaksi</th><th>Tanggal</th><th>Supplier</th><th>No. Dokumen</th><th>Petugas</th><th>Status</th><th class="text-center">Aksi</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    @include('layouts.datatables')
    <script>
        $(function () {
            const table = $('#stockin-table').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                pageLength: 10,
                lengthChange: false,
                dom: 'rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    processing: 'Memuat data...',
                    emptyTable: 'Belum ada transaksi barang masuk.',
                    zeroRecords: 'Transaksi tidak ditemukan.',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data untuk ditampilkan',
                    paginate: { previous: '‹ Sebelumnya', next: 'Berikutnya ›' }
                },
                ajax: {
                    url: @json(route('stock-in.data')),
                    data: request => { request.status = $('#stockin-status').val(); }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'transaction_number', name: 'transaction_number', className: 'inv-number' },
                    { data: 'transaction_date', name: 'transaction_date', searchable: false },
                    { data: 'supplier_name', name: 'supplier_name', orderable: false },
                    { data: 'document_number', name: 'document_number', defaultContent: '-' },
                    { data: 'user_name', orderable: false, searchable: false },
                    { data: 'status_badge', orderable: false, searchable: false },
                    {
                        data: 'action', orderable: false, searchable: false, className: 'text-center',
                        render: function (data, type) {
                            if (type !== 'display' || !data) return data || '';
                            const wrapper = $('<div>').html(data);
                            wrapper.find('a, button').each(function () {
                                const element = $(this);
                                const label = element.text().trim();
                                const cancel = label.toLowerCase().includes('batalkan');
                                element.attr({ title: label, 'aria-label': label })
                                    .removeClass('btn btn-sm btn-info btn-danger')
                                    .addClass('inv-icon-button' + (cancel ? ' cancel' : ''))
                                    .empty().append($('<span>').addClass('material-symbols-outlined').text(cancel ? 'cancel' : 'visibility'));
                            });
                            wrapper.find('form').addClass('d-inline');
                            return '<div class="inv-row-actions">' + wrapper.html() + '</div>';
                        }
                    }
                ],
                drawCallback: function () {
                    const info = this.api().page.info();
                    $('#stockin-count').text(info.recordsDisplay.toLocaleString('id-ID') + ' Data');
                }
            });

            $('#stockin-search').on('input', function () { table.search(this.value).draw(); });
            $('#stockin-status').on('change', function () { table.ajax.reload(); });
            $('#stockin-length').on('change', function () { table.page.len(Number(this.value)).draw(); });
            $('#stockin-print').on('click', function () { window.print(); });
            $('#stockin-export').on('click', function () {
                const columns = [['No', 'DT_RowIndex'], ['No. Transaksi', 'transaction_number'], ['Tanggal', 'transaction_date'], ['Supplier', 'supplier_name'], ['No. Dokumen', 'document_number'], ['Petugas', 'user_name'], ['Status', 'status_badge']];
                const rows = table.rows({ page: 'current' }).data().toArray();
                const text = value => $('<div>').html(value ?? '').text().trim().replace(/"/g, '""');
                const csv = [columns.map(([label]) => '"' + label + '"').join(','), ...rows.map(row => columns.map(([, key]) => '"' + text(row[key]) + '"').join(','))].join('\r\n');
                const link = document.createElement('a');
                link.href = URL.createObjectURL(new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8' }));
                link.download = 'barang-masuk.csv';
                link.click();
                URL.revokeObjectURL(link.href);
            });
        });
    </script>
@endpush