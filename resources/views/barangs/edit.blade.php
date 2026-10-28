@extends('layouts.app')

@section('title', 'Edit Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@section('content')
<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Master Data</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Barang</span></div>
            <h1 class="inv-title">Edit Barang</h1>
            <p class="inv-subtitle">Perbarui informasi master barang {{ $barang->code }}</p>
        </div>
        <a href="{{ route('barangs.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali ke Daftar</a>
    </div>

    <div class="inv-modebar">
        <div class="inv-modebar-title"><span class="material-symbols-outlined">folder</span>Mode Tampilan</div>
        <nav class="inv-mode-tabs" aria-label="Navigasi master barang">
            <a href="{{ route('barangs.create') }}"><span class="material-symbols-outlined">add</span>Tambah Barang</a>
            <a href="{{ route('barangs.edit', $barang) }}" class="active" aria-current="page"><span class="material-symbols-outlined">edit</span>Edit Barang</a>
            <a href="{{ route('barangs.show', $barang) }}"><span class="material-symbols-outlined">visibility</span>Detail Barang</a>
        </nav>
    </div>

    @if ($errors->any())
        <div class="inv-alert error" role="alert"><span class="material-symbols-outlined">error</span><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="inv-layout">
            <section class="inv-card">
                <div class="inv-card-accent"></div>
                <div class="inv-card-heading">
                    <span class="material-symbols-outlined">edit_note</span>
                    <div><h2>Informasi Master Barang</h2><p class="inv-subtitle">Kode dan nama harus unik serta mudah dikenali</p></div>
                    <span class="inv-badge {{ $barang->status ? '' : 'cancelled' }} ms-auto">{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</span>
                </div>

                <div class="inv-form-grid">
                    <div class="inv-field">
                        <label for="code">Kode Barang <span class="text-danger">*</span></label>
                        <input id="code" type="text" name="code" value="{{ old('code', $barang->code) }}" class="@error('code') is-invalid @enderror" required>
                        @error('code')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="name">Nama Barang <span class="text-danger">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name', $barang->name) }}" class="@error('name') is-invalid @enderror" required>
                        @error('name')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="category_id">Kategori <span class="text-danger">*</span></label>
                        <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $barang->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="unit_id">Satuan <span class="text-danger">*</span></label>
                        <select id="unit_id" name="unit_id" class="@error('unit_id') is-invalid @enderror" required>
                            <option value="">Pilih satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $barang->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field full">
                        <label for="stock">Stok Saat Ini</label>
                        <input id="stock" type="text" value="{{ number_format($barang->stock) }} {{ $barang->unit->name ?? '' }}" disabled>
                        <span class="text-muted small">Stok hanya berubah melalui Barang Masuk, Barang Keluar, atau Stock Opname.</span>
                    </div>
                    <div class="inv-field">
                        <label for="minimum_stock">Stok Minimum <span class="text-danger">*</span></label>
                        <input id="minimum_stock" type="number" min="0" name="minimum_stock" value="{{ old('minimum_stock', $barang->minimum_stock) }}" class="@error('minimum_stock') is-invalid @enderror" required>
                        @error('minimum_stock')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="location">Lokasi</label>
                        <input id="location" type="text" name="location" value="{{ old('location', $barang->location) }}" placeholder="Contoh: Gudang A, Rak 1">
                        @error('location')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field full">
                        <label for="description">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" placeholder="Spesifikasi atau keterangan barang...">{{ old('description', $barang->description) }}</textarea>
                        @error('description')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="inv-table-actions">
                    <a href="{{ route('barangs.index') }}" class="inv-button inv-button-outline">Batal</a>
                    <button type="submit" class="inv-button inv-button-primary"><span class="material-symbols-outlined">check</span>Simpan Perubahan</button>
                </div>
            </section>

            <aside class="inv-summary">
                <h2><span class="material-symbols-outlined align-middle me-1">inventory_2</span>Ringkasan Stok</h2>
                <div class="inv-summary-line"><span>Stok Saat Ini</span><strong>{{ number_format($barang->stock) }}</strong></div>
                <div class="inv-summary-line"><span>Stok Minimum</span><strong>{{ number_format($barang->minimum_stock) }}</strong></div>
                <div class="inv-summary-line"><span>Status</span><strong>{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</strong></div>
                <div class="inv-alert mt-3 mb-0"><span class="material-symbols-outlined">info</span><span>Informasi stok tidak dapat diedit dari halaman ini.</span></div>
            </aside>
        </div>
    </form>
</div>
@endsection