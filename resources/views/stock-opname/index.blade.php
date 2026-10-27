@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Stock Opname</h3>
        @can('stock-opname.create')
            <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">+ Tambah Opname</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="opname-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Opname</th>
                    <th>Tanggal</th>
                    <th>Jumlah Barang</th>
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
    $('#opname-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: '{{ route('stock-opname.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'opname_number', name: 'opname_number' },
            { data: 'opname_date', name: 'opname_date', searchable: false },
            { data: 'details_count', name: 'details_count', searchable: false },
            { data: 'user_name', orderable: false, searchable: false },
            { data: 'status_badge', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection