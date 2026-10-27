@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Barang Masuk</h3>
        @can('barang-masuk.create')
            <a href="{{ route('stock-in.create') }}" class="btn btn-primary">+ Tambah Barang Masuk</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="stockin-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>No. Dokumen</th>
                    <th>Petugas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    $('#stockin-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: '{{ route('stock-in.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'transaction_number', name: 'transaction_number' },
            { data: 'transaction_date', name: 'transaction_date', searchable: false },
            { data: 'supplier_name', name: 'supplier_name', orderable: false },
            { data: 'document_number', name: 'document_number' },
            { data: 'user_name', orderable: false, searchable: false },
            { data: 'status_badge', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection