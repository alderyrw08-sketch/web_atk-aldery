@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3>Monitoring Stok</h3>

    <form method="GET" action="{{ route('monitoring.index') }}" class="row g-2 mt-2">
        <div class="col-md-2">
            <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Nama barang">
        </div>
        <div class="col-md-2">
            <input type="text" name="code" value="{{ request('code') }}" class="form-control" placeholder="Kode barang">
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-select">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status_stok" class="form-select">
                <option value="">Semua status</option>
                <option value="aman" {{ request('status_stok') == 'aman' ? 'selected' : '' }}>Aman</option>
                <option value="menipis" {{ request('status_stok') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                <option value="habis" {{ request('status_stok') == 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="location" value="{{ request('location') }}" class="form-control" placeholder="Lokasi">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark">Filter</button>
            <a href="{{ route('monitoring.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3 bg-white">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Status</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->code }}</td>
                        <td>{{ $barang->name }}</td>
                        <td>{{ $barang->category->name ?? '-' }}</td>
                        <td>{{ $barang->stock }} {{ $barang->unit->name ?? '' }}</td>
                        <td>{{ $barang->minimum_stock }} {{ $barang->unit->name ?? '' }}</td>
                        <td>
                            @if ($barang->stock == 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif ($barang->stock <= $barang->minimum_stock)
                                <span class="badge bg-warning text-dark">Menipis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>{{ $barang->location ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection