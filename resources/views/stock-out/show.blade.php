@extends('layouts.app')

@section('title', 'Detail Barang Keluar | Sistem ATK')
@section('page-title', 'Barang Keluar')

@section('content')
@php
    $totalQuantity = $stockOut->details->sum('quantity');
@endphp

<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Transaksi</span></div>
            <h1 class="inv-title">Detail Barang Keluar</h1>
            <p class="inv-subtitle">Informasi lengkap distribusi barang dan ATK</p>
        </div>
        <a href="{{ route('stock-out.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
    </div>

    <div class="inv-layout">
        <section class="inv-card">
            <div class="inv-card-accent"></div>
            <div class="inv-card-heading">
                <span class="material-symbols-outlined">outbox</span>
                <div><h2>{{ $stockOut->transaction_number }}</h2><p class="inv-subtitle">Informasi lengkap transaksi barang keluar</p></div>
                <span class="inv-badge {{ $stockOut->status === 'Active' ? '' : 'cancelled' }} ms-auto">{{ $stockOut->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}</span>
            </div>

            <div class="inv-details-grid">
                <div class="inv-meta-card"><span>No. Transaksi</span><strong>{{ $stockOut->transaction_number }}</strong></div>
                <div class="inv-meta-card"><span>Tanggal</span><strong>{{ $stockOut->transaction_date->format('d-m-Y') }}</strong></div>
                <div class="inv-meta-card"><span>Departemen</span><strong>{{ $stockOut->department }}</strong></div>
                <div class="inv-meta-card"><span>Penerima</span><strong>{{ $stockOut->recipient }}</strong></div>
                <div class="inv-meta-card"><span>Keperluan</span><strong>{{ $stockOut->purpose ?: '-' }}</strong></div>
                <div class="inv-meta-card"><span>Petugas</span><strong>{{ $stockOut->user->name ?? '-' }}</strong></div>
                <div class="inv-meta-card"><span>Status</span><strong>{{ $stockOut->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}</strong></div>
                <div class="inv-meta-card"><span>Catatan</span><strong>{{ $stockOut->notes ?: '-' }}</strong></div>
            </div>

            <div class="inv-section-head px-0">
                <h2 class="inv-section-title">Barang <span class="inv-count">{{ $stockOut->details->count() }} Baris</span></h2>
            </div>
            <div class="inv-table-wrap px-0">
                <table class="table inv-table">
                    <thead><tr><th>Kode</th><th>Nama Barang</th><th>Jumlah</th></tr></thead>
                    <tbody>
                        @forelse ($stockOut->details as $detail)
                            <tr>
                                <td class="inv-number">{{ $detail->item->code ?? '-' }}</td>
                                <td>{{ $detail->item->name ?? '-' }}</td>
                                <td>{{ number_format($detail->quantity) }} {{ $detail->item->unit->name ?? '' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">Tidak ada detail barang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="inv-table-actions">
                <a href="{{ route('stock-out.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali ke Daftar</a>
            </div>
        </section>

        <aside class="inv-summary">
            <h2><span class="material-symbols-outlined align-middle me-1">receipt_long</span>Ringkasan Pengeluaran</h2>
            <div class="inv-summary-line"><span>Jumlah Baris</span><strong>{{ $stockOut->details->count() }}</strong></div>
            <div class="inv-summary-line"><span>Total Kuantitas</span><strong>{{ number_format($totalQuantity) }} Item</strong></div>
            <div class="inv-summary-line"><span>Status</span><strong>{{ $stockOut->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}</strong></div>
        </aside>
    </div>
</div>
@endsection