@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <h3>Detail Stock Opname</h3>

    <table class="table table-bordered mt-3 bg-white">
        <tr><th style="width: 30%">No. Opname</th><td>{{ $stockOpname->opname_number }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $stockOpname->opname_date->format('d-m-Y') }}</td></tr>
        <tr><th>Petugas</th><td>{{ $stockOpname->user->name ?? '-' }}</td></tr>
        <tr><th>Catatan</th><td>{{ $stockOpname->notes ?: '-' }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($stockOpname->status === 'Confirmed')
                    <span class="badge bg-success">Confirmed</span>
                @else
                    <span class="badge bg-warning text-dark">Draft</span>
                @endif
            </td>
        </tr>
    </table>

    <h5>Hasil Perhitungan</h5>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik</th>
                <th>Selisih</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockOpname->details as $detail)
                <tr>
                    <td>{{ $detail->item->code ?? '-' }}</td>
                    <td>{{ $detail->item->name ?? '-' }}</td>
                    <td>{{ $detail->system_stock }}</td>
                    <td>{{ $detail->physical_stock }}</td>
                    <td class="{{ $detail->difference == 0 ? '' : ($detail->difference > 0 ? 'text-success' : 'text-danger') }} fw-bold">
                        {{ $detail->difference > 0 ? '+' : '' }}{{ $detail->difference }}
                    </td>
                    <td>{{ $detail->notes ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('stock-opname.index') }}" class="btn btn-secondary">Kembali</a>
</div>