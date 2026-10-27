@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Barang Keluar</h3>
        @can('barang-keluar.create')
            <a href="{{ route('stock-out.create') }}" class="btn btn-primary">+ Tambah Barang Keluar</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="stockout-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Departemen</th>
                    <th>Penerima</th>
                    <th>Keperluan</th>
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
    $('#stockout-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: '{{ route('stock-out.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'transaction_number', name: 'transaction_number' },
            { data: 'transaction_date', name: 'transaction_date', searchable: false },
            { data: 'department', name: 'department' },
            { data: 'recipient', name: 'recipient' },
            { data: 'purpose', name: 'purpose' },
            { data: 'user_name', orderable: false, searchable: false },
            { data: 'status_badge', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection