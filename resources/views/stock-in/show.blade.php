@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    <h3>Detail Barang Masuk</h3>

    <table class="table table-bordered mt-3 bg-white">
        <tr><th style="width: 30%">No. Transaksi</th><td>{{ $stockIn->transaction_number }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $stockIn->transaction_date->format('d-m-Y') }}</td></tr>
        <tr><th>Supplier</th><td>{{ $stockIn->supplier->name ?? '-' }}</td></tr>
        <tr><th>No. Dokumen</th><td>{{ $stockIn->document_number ?: '-' }}</td></tr>
        <tr><th>Petugas</th><td>{{ $stockIn->user->name ?? '-' }}</td></tr>
        <tr><th>Catatan</th><td>{{ $stockIn->notes ?: '-' }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($stockIn->status === 'Active')
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
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockIn->details as $detail)
                <tr>
                    <td>{{ $detail->item->code ?? '-' }}</td>
                    <td>{{ $detail->item->name ?? '-' }}</td>
                    <td>{{ $detail->quantity }} {{ $detail->item->unit->name ?? '' }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection