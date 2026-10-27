@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Manage Role</h3>
        @can('role.create')
            <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Tambah Role</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="role-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Jumlah User</th>
                    <th>Permission</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    $('#role-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('roles.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'users_count', name: 'users_count', searchable: false, orderable: false },
            { data: 'permission_info', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endsection