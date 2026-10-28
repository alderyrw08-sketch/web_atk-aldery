@extends('layouts.app')

@section('title', 'Detail Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@section('content')
@php
    $stockStatus = $barang->stock <= 0 ? 'Habis' : ($barang->stock <= $barang->minimum_stock ? 'Menipis' : 'Aman');
@endphp

<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Master Data</span></div>
            <h1 class="inv-title">Detail Barang</h1>
            <p class="inv-subtitle">Informasi lengkap master barang dan status persediaan</p>
        </div>
        <div class="inv-actions">
            <a href="{{ route('barangs.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
            @can('barang.update')
                <a href="{{ route('barangs.edit', $barang) }}" class="inv-button inv-button-primary"><span class="material-symbols-outlined">edit</span>Edit Barang</a>
            @endcan
        </div>
    </div>

    <div class="inv-modebar">
        <div class="inv-modebar-title"><span class="material-symbols-outlined">folder</span>Mode Tampilan</div>
        <nav class="inv-mode-tabs" aria-label="Navigasi master barang">
            @can('barang.create')
                <a href="{{ route('barangs.create') }}"><span class="material-symbols-outlined">add</span>Tambah Barang</a>
            @endcan
            @can('barang.update')
                <a href="{{ route('barangs.edit', $barang) }}"><span class="material-symbols-outlined">edit</span>Edit Barang</a>
            @endcan
            <a href="{{ route('barangs.show', $barang) }}" class="active" aria-current="page"><span class="material-symbols-outlined">visibility</span>Detail Barang</a>
        </nav>
    </div>

    <div class="inv-layout">
        <section class="inv-card">
            <div class="inv-card-accent"></div>
            <div class="inv-card-heading">
                <span class="material-symbols-outlined">inventory_2</span>
                <div><h2>Informasi Master Barang</h2><p class="inv-subtitle">{{ $barang->name }}</p></div>
                <span class="inv-badge {{ $barang->status ? '' : 'cancelled' }} ms-auto">{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</span>
            </div>

            <div class="inv-details-grid">
                <div class="inv-meta-card"><span>Kode Barang</span><strong>{{ $barang->code }}</strong></div>
                <div class="inv-meta-card"><span>Nama Barang</span><strong>{{ $barang->name }}</strong></div>
                <div class="inv-meta-card"><span>Kategori</span><strong>{{ $barang->category->name ?? '-' }}</strong></div>
                <div class="inv-meta-card"><span>Satuan</span><strong>{{ $barang->unit->name ?? '-' }}</strong></div>
                <div class="inv-meta-card"><span>Stok Saat Ini</span><strong>{{ number_format($barang->stock) }} {{ $barang->unit->name ?? '' }}</strong></div>
                <div class="inv-meta-card"><span>Stok Minimum</span><strong>{{ number_format($barang->minimum_stock) }} {{ $barang->unit->name ?? '' }}</strong></div>
                <div class="inv-meta-card"><span>Status Stok</span><strong><span class="inv-badge {{ $stockStatus === 'Habis' ? 'danger' : ($stockStatus === 'Menipis' ? 'warning' : '') }}">{{ $stockStatus }}</span></strong></div>
                <div class="inv-meta-card"><span>Status Barang</span><strong>{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</strong></div>
                <div class="inv-meta-card"><span>Lokasi</span><strong>{{ $barang->location ?: '-' }}</strong></div>
                <div class="inv-meta-card"><span>Dibuat</span><strong>{{ $barang->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}</strong></div>
                <div class="inv-meta-card" style="grid-column: 1 / -1"><span>Deskripsi</span><strong>{{ $barang->description ?: '-' }}</strong></div>
            </div>

            <div class="inv-table-actions">
                <a href="{{ route('barangs.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali ke Daftar Barang</a>
            </div>
        </section>

        <aside class="inv-summary">
            <h2><span class="material-symbols-outlined align-middle me-1">inventory</span>Status Persediaan</h2>
            <div class="inv-summary-line"><span>Stok Saat Ini</span><strong>{{ number_format($barang->stock) }}</strong></div>
            <div class="inv-summary-line"><span>Batas Minimum</span><strong>{{ number_format($barang->minimum_stock) }}</strong></div>
            <div class="inv-summary-line"><span>Kondisi</span><strong>{{ $stockStatus }}</strong></div>
            <div class="inv-alert mt-3 mb-0"><span class="material-symbols-outlined">info</span><span>Perubahan stok tercatat melalui transaksi masuk, keluar, dan opname.</span></div>
        </aside>
    </div>
</div>
@endsection