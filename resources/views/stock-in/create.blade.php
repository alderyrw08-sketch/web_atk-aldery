@extends('layouts.app')

@section('title', 'Tambah Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@section('content')
<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Transaksi</span></div>
            <h1 class="inv-title">Tambah Barang Masuk</h1>
            <p class="inv-subtitle">Catat barang yang diterima dari supplier</p>
        </div>
        <a href="{{ route('stock-in.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
    </div>

    @if ($errors->any())
        <div class="inv-alert error" role="alert">
            <span class="material-symbols-outlined">error</span>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('stock-in.store') }}" method="POST">
        @csrf
        <div class="inv-layout">
            <section class="inv-card">
                <div class="inv-card-accent"></div>
                <div class="inv-card-heading"><span class="material-symbols-outlined">move_to_inbox</span><div><h2>Informasi Transaksi</h2><p class="inv-subtitle">Isi penerimaan stok dan detail barang</p></div></div>

                <div class="inv-form-grid">
                    <div class="inv-field">
                        <label for="transaction_date">Tanggal <span class="text-danger">*</span></label>
                        <input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="@error('transaction_date') is-invalid @enderror" required>
                        @error('transaction_date')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                        <select id="supplier_id" name="supplier_id" class="@error('supplier_id') is-invalid @enderror" required>
                            <option value="">Pilih supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field full">
                        <label for="document_number">No. Dokumen <span class="text-muted fw-normal">(opsional)</span></label>
                        <input id="document_number" type="text" name="document_number" value="{{ old('document_number') }}" placeholder="Contoh: DO-2026/10/001" class="@error('document_number') is-invalid @enderror">
                        @error('document_number')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field full">
                        <label for="notes">Catatan <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Catatan penerimaan atau nomor surat jalan...">{{ old('notes') }}</textarea>
                        @error('notes')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="inv-section-head px-0 pb-2">
                    <h2 class="inv-section-title">Detail Barang <span class="inv-count" id="item-row-count">0 Baris</span></h2>
                    <button class="inv-button" type="button" id="add-item-row"><span class="material-symbols-outlined">add</span>Tambah Baris</button>
                </div>
                <div class="inv-item-list" id="items-body"></div>
                @error('items')<span class="inv-error">{{ $message }}</span>@enderror
                @error('items.*.item_id')<span class="inv-error">{{ $message }}</span>@enderror
                @error('items.*.quantity')<span class="inv-error">{{ $message }}</span>@enderror
                @error('items.*.price')<span class="inv-error">{{ $message }}</span>@enderror

                <div class="inv-table-actions">
                    <a href="{{ route('stock-in.index') }}" class="inv-button inv-button-outline">Batal</a>
                    <button type="submit" class="inv-button inv-button-primary"><span class="material-symbols-outlined">check</span>Simpan Transaksi</button>
                </div>
            </section>

            <aside class="inv-summary">
                <h2><span class="material-symbols-outlined align-middle me-1">receipt_long</span>Ringkasan Penerimaan</h2>
                <div class="inv-summary-line"><span>Jumlah Baris</span><strong id="summary-lines">0</strong></div>
                <div class="inv-summary-line"><span>Total Kuantitas</span><strong id="summary-quantity">0 Item</strong></div>
                <div class="inv-summary-line"><span>Estimasi Nilai</span><strong id="summary-value">Rp 0</strong></div>
            </aside>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        const barangs = @json($barangs->map(fn ($barang) => ['id' => $barang->id, 'label' => $barang->code . ' - ' . $barang->name . ' (' . ($barang->unit->name ?? '') . ')'])->values());
        let rowIndex = 0;

        function updateSummary() {
            const rows = $('#items-body .inv-item-row');
            let quantity = 0;
            let amount = 0;
            rows.each(function () {
                const row = $(this);
                const qty = Number(row.find('[data-item-quantity]').val()) || 0;
                const price = Number(row.find('[data-item-price]').val()) || 0;
                quantity += qty;
                amount += qty * price;
            });
            $('#item-row-count, #summary-lines').text(rows.length + ' Baris');
            $('#summary-quantity').text(quantity.toLocaleString('id-ID') + ' Item');
            $('#summary-value').text('Rp ' + amount.toLocaleString('id-ID'));
        }

        function addRow() {
            const select = $('<select required>').addClass('inv-control').attr('name', `items[${rowIndex}][item_id]`);
            select.append(new Option('Pilih barang', ''));
            barangs.forEach(barang => select.append(new Option(barang.label, barang.id)));

            const quantity = $('<input type="number" min="1" value="1" required>').addClass('inv-control').attr({ name: `items[${rowIndex}][quantity]`, 'data-item-quantity': '' });
            const price = $('<input type="number" min="0" step="0.01" value="0">').addClass('inv-control').attr({ name: `items[${rowIndex}][price]`, 'data-item-price': '', 'aria-label': 'Harga satuan' });
            const remove = $('<button type="button" title="Hapus baris" aria-label="Hapus baris">').addClass('inv-icon-button delete').append($('<span>').addClass('material-symbols-outlined').text('close'));
            const row = $('<div>').addClass('inv-item-row').append(select, quantity, price, remove);
            $('#items-body').append(row);
            rowIndex++;
            updateSummary();
        }

        $('#add-item-row').on('click', addRow);
        $('#items-body').on('click', '.inv-icon-button', function () {
            $(this).closest('.inv-item-row').remove();
            updateSummary();
        }).on('input change', '[data-item-quantity], [data-item-price]', updateSummary);

        addRow();
    });
</script>
@endpush
@endsection