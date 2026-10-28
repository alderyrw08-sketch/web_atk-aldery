@extends('layouts.app')

@section('title', 'Detail Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@section('content')
@php
    $totalQuantity = $stockIn->details->sum('quantity');
    $totalValue = $stockIn->details->sum(fn ($detail) => $detail->quantity * $detail->price);
@endphp

<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Transaksi</span></div>
            <h1 class="inv-title">Detail Barang Masuk</h1>
            <p class="inv-subtitle">Informasi lengkap penerimaan stok dan barang</p>
        </div>
        <a href="{{ route('stock-in.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
    </div>

    <div class="inv-layout">
        <section class="inv-card">
            <div class="inv-card-accent"></div>
            <div class="inv-card-heading">
                <span class="material-symbols-outlined">move_to_inbox</span>
                <div><h2>{{ $stockIn->transaction_number }}</h2><p class="inv-subtitle">{{ $stockIn->status === 'Active' ? 'Transaksi aktif' : 'Transaksi dibatalkan' }}</p></div>
                <span class="inv-badge {{ $stockIn->status === 'Active' ? '' : 'cancelled' }} ms-auto">{{ $stockIn->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}</span>
            </div>

            <div class="inv-details-grid">
                <div class="inv-meta-card"><span>No. Transaksi</span><strong>{{ $stockIn->transaction_number }}</strong></div>
                <div class="inv-meta-card"><span>Tanggal</span><strong>{{ $stockIn->transaction_date->format('d-m-Y') }}</strong></div>
                <div class="inv-meta-card"><span>Supplier</span><strong>{{ $stockIn->supplier->name ?? '-' }}</strong></div>
                <div class="inv-meta-card"><span>No. Dokumen</span><strong>{{ $stockIn->document_number ?: '-' }}</strong></div>
                <div class="inv-meta-card"><span>Petugas</span><strong>{{ $stockIn->user->name ?? '-' }}</strong></div>
                <div class="inv-meta-card"><span>Status</span><strong>{{ $stockIn->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}</strong></div>
                <div class="inv-meta-card" style="grid-column: 1 / -1"><span>Catatan</span><strong>{{ $stockIn->notes ?: '-' }}</strong></div>
            </div>

            <div class="inv-section-head px-0">
                <h2 class="inv-section-title">Barang <span class="inv-count">{{ $stockIn->details->count() }} Baris</span></h2>
            </div>
            <div class="inv-table-wrap px-0">
                <table class="table inv-table">
                    <thead><tr><th>Kode</th><th>Nama Barang</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @forelse ($stockIn->details as $detail)
                            <tr>
                                <td class="inv-number">{{ $detail->item->code ?? '-' }}</td>
                                <td>{{ $detail->item->name ?? '-' }}</td>
                                <td>{{ number_format($detail->quantity) }} {{ $detail->item->unit->name ?? '' }}</td>
                                <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="fw-bold">Rp {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada detail barang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="inv-table-actions">
                <a href="{{ route('stock-in.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali ke Daftar</a>
            </div>
        </section>

        <aside class="inv-summary">
            <h2><span class="material-symbols-outlined align-middle me-1">receipt_long</span>Ringkasan Penerimaan</h2>
            <div class="inv-summary-line"><span>Jumlah Baris</span><strong>{{ $stockIn->details->count() }}</strong></div>
            <div class="inv-summary-line"><span>Total Kuantitas</span><strong>{{ number_format($totalQuantity) }} Item</strong></div>
            <div class="inv-summary-line"><span>Total Nilai</span><strong>Rp {{ number_format($totalValue, 0, ',', '.') }}</strong></div>
        </aside>
    </div>
</div>
@endsection