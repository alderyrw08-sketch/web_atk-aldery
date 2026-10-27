@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3>Stock History</h3>
    <p class="text-muted">Riwayat setiap perubahan stok (audit trail).</p>

    <div class="row g-2">
        <div class="col-md-3">
            <select id="f-item" class="form-select">
                <option value="">Semua barang</option>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->id }}">{{ $barang->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="f-type" class="form-select">
                <option value="">Semua jenis</option>
                @foreach (['BARANG_MASUK', 'BARANG_KELUAR', 'STOCK_OPNAME', 'ADJUSTMENT'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><input type="date" id="f-from" class="form-control" title="Dari tanggal"></div>
        <div class="col-md-2"><input type="date" id="f-to" class="form-control" title="Sampai tanggal"></div>
    </div>

    <div class="table-responsive bg-white mt-3 p-2 border rounded">
        <table id="history-table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Jenis</th>
                    <th>Stok Sebelum</th>
                    <th>Jumlah</th>
                    <th>Stok Sesudah</th>
                    <th>Petugas</th>
                    <th>Catatan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.datatables')
<script>
    const table = $('#history-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: '{{ route('stock-history.data') }}',
            data: function (d) {
                d.item_id = $('#f-item').val();
                d.transaction_type = $('#f-type').val();
                d.date_from = $('#f-from').val();
                d.date_to = $('#f-to').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at', searchable: false },
            { data: 'item_name', name: 'item_name', orderable: false },
            { data: 'transaction_type', name: 'transaction_type' },
            { data: 'stock_before', name: 'stock_before', searchable: false },
            { data: 'quantity', name: 'quantity', searchable: false },
            { data: 'stock_after', name: 'stock_after', searchable: false },
            { data: 'user_name', orderable: false, searchable: false },
            { data: 'notes', name: 'notes' }
        ]
    });

    $('#f-item, #f-type, #f-from, #f-to').on('change', function () { table.draw(); });
</script>
@endsection