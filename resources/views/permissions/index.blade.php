@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3>Manage Permission</h3>
    <p class="text-muted">
        Daftar permission sistem dan role yang memilikinya. Untuk mengatur permission tiap role,
        buka menu <a href="{{ route('roles.index') }}">Role</a>.
    </p>

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="permission-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Modul</th>
                    <th>Permission</th>
                    <th>Dipakai Role</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    $('#permission-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: '{{ route('permissions.data') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'module', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'roles_list', orderable: false, searchable: false }
        ]
    });
</script>
@endsection