@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <h3>Tambah Stock Opname</h3>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stock-opname.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tanggal Opname</label>
                <input type="date" name="opname_date" value="{{ old('opname_date', date('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">Catatan</label>
                <input type="text" name="notes" value="{{ old('notes') }}" class="form-control">
            </div>
        </div>

        <h5 class="mt-3">Detail Barang</h5>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Barang (stok sistem)</th>
                    <th style="width: 18%">Stok Fisik</th>
                    <th style="width: 28%">Catatan</th>
                    <th style="width: 8%"></th>
                </tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>
        <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addRow()">+ Tambah Baris</button>

        <div>
            <button type="submit" class="btn btn-primary">Simpan Draft</button>
            <a href="{{ route('stock-opname.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    const barangs = @json($barangs->map(fn ($b) => ['id' => $b->id, 'label' => $b->code . ' - ' . $b->name . ' (sistem: ' . $b->stock . ' ' . ($b->unit->name ?? '') . ')']));
    let rowIndex = 0;

    function addRow() {
        const options = barangs.map(b => `<option value="${b.id}">${b.label}</option>`).join('');
        const row = `
            <tr>
                <td>
                    <select name="items[${rowIndex}][item_id]" class="form-select">
                        <option value="">-- Pilih Barang --</option>${options}
                    </select>
                </td>
                <td><input type="number" min="0" name="items[${rowIndex}][physical_stock]" class="form-control" value="0"></td>
                <td><input type="text" name="items[${rowIndex}][notes]" class="form-control"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">X</button></td>
            </tr>`;
        document.getElementById('items-body').insertAdjacentHTML('beforeend', row);
        rowIndex++;
    }

    addRow();
</script>