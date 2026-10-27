@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Daftar Supplier</h3>
        @can('supplier.create')
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Tambah Supplier</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="supplier-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    $('#supplier-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('suppliers.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'pic', name: 'pic' },
            { data: 'status_badge', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection