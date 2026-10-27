@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    <h3>Detail Barang Keluar</h3>

    <table class="table table-bordered mt-3 bg-white">
        <tr><th style="width: 30%">No. Transaksi</th><td>{{ $stockOut->transaction_number }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $stockOut->transaction_date->format('d-m-Y') }}</td></tr>
        <tr><th>Departemen</th><td>{{ $stockOut->department }}</td></tr>
        <tr><th>Penerima</th><td>{{ $stockOut->recipient }}</td></tr>
        <tr><th>Keperluan</th><td>{{ $stockOut->purpose ?: '-' }}</td></tr>
        <tr><th>Petugas</th><td>{{ $stockOut->user->name ?? '-' }}</td></tr>
        <tr><th>Catatan</th><td>{{ $stockOut->notes ?: '-' }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($stockOut->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Cancelled</span>
                @endif
            </td>
        </tr>
    </table>

    <h5>Barang</h5>
    <table class="table table-bordered bg-white">
        <thead>
            <tr><th>Kode</th><th>Nama</th><th>Jumlah</th></tr>
        </thead>
        <tbody>
            @foreach ($stockOut->details as $detail)
                <tr>
                    <td>{{ $detail->item->code ?? '-' }}</td>
                    <td>{{ $detail->item->name ?? '-' }}</td>
                    <td>{{ $detail->quantity }} {{ $detail->item->unit->name ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection