@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <h3>Detail Supplier</h3>

    <table class="table table-bordered mt-3 bg-white">
        <tr><th style="width: 35%">Nama</th><td>{{ $supplier->name }}</td></tr>
        <tr><th>Alamat</th><td>{{ $supplier->address ?: '-' }}</td></tr>
        <tr><th>Telepon</th><td>{{ $supplier->phone ?: '-' }}</td></tr>
        <tr><th>Email</th><td>{{ $supplier->email ?: '-' }}</td></tr>
        <tr><th>PIC</th><td>{{ $supplier->pic ?: '-' }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($supplier->status)
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </td>
        </tr>
        <tr><th>Dibuat</th><td>{{ $supplier->created_at->format('d-m-Y H:i') }}</td></tr>
    </table>

    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection