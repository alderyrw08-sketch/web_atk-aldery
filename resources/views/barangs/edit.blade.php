@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h3>Edit Barang</h3>

    <form action="{{ route('barangs.update', $barang->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="code" value="{{ old('code', $barang->code) }}"
                   class="form-control @error('code') is-invalid @enderror">
            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" value="{{ old('name', $barang->name) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $barang->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Satuan</label>
            <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">
                <option value="">-- Pilih Satuan --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('unit_id', $barang->unit_id) == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
            @error('unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Stok Saat Ini</label>
            <input type="text" value="{{ $barang->stock }}" class="form-control" disabled>
            <div class="form-text">Stok hanya berubah lewat Barang Masuk, Barang Keluar, atau Stock Opname.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok Minimum</label>
            <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $barang->minimum_stock) }}"
                   class="form-control @error('minimum_stock') is-invalid @enderror">
            @error('minimum_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $barang->location) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $barang->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection