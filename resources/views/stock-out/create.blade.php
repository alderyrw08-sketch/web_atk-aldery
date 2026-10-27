@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <h3>Tambah Barang Keluar</h3>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stock-out.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Departemen</label>
                <input type="text" name="department" value="{{ old('department') }}" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Penerima</label>
                <input type="text" name="recipient" value="{{ old('recipient') }}" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Keperluan</label>
                <input type="text" name="purpose" value="{{ old('purpose') }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <h5 class="mt-4">Detail Barang</h5>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Barang (stok tersedia)</th>
                    <th style="width: 20%">Jumlah</th>
                    <th style="width: 8%"></th>
                </tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>
        <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addRow()">+ Tambah Baris</button>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    const barangs = @json($barangs->map(fn ($b) => ['id' => $b->id, 'label' => $b->code . ' - ' . $b->name . ' (stok ' . $b->stock . ' ' . ($b->unit->name ?? '') . ')']));
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
                <td><input type="number" min="1" name="items[${rowIndex}][quantity]" class="form-control" value="1"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">X</button></td>
            </tr>`;
        document.getElementById('items-body').insertAdjacentHTML('beforeend', row);
        rowIndex++;
    }

    addRow();
</script>
@endsection