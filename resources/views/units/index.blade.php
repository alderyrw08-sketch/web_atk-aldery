@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Daftar Satuan</h3>
        @can('satuan.create')
            <a href="{{ route('units.create') }}" class="btn btn-primary">+ Tambah Satuan</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="unit-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Simbol</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    $('#unit-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('units.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'symbol', name: 'symbol' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection