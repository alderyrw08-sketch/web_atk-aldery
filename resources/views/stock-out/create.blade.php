@extends('layouts.app')

@section('title', 'Tambah Barang Keluar | Sistem ATK')
@section('page-title', 'Barang Keluar')

@section('content')
<div class="inventory-page">
    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Transaksi</span></div>
            <h1 class="inv-title">Tambah Barang Keluar</h1>
            <p class="inv-subtitle">Catat distribusi ATK ke penerima atau unit kerja</p>
        </div>
        <a href="{{ route('stock-out.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
    </div>

    @if ($errors->any())
        <div class="inv-alert error" role="alert"><span class="material-symbols-outlined">error</span><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('stock-out.store') }}" method="POST">
        @csrf
        <div class="inv-layout">
            <section class="inv-card">
                <div class="inv-card-accent"></div>
                <div class="inv-card-heading"><span class="material-symbols-outlined">outbox</span><div><h2>Informasi Transaksi</h2><p class="inv-subtitle">Lengkapi detail pengeluaran dan barang</p></div></div>
                <div class="inv-form-grid">
                    <div class="inv-field">
                        <label for="transaction_date">Tanggal <span class="text-danger">*</span></label>
                        <input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="@error('transaction_date') is-invalid @enderror" required>
                        @error('transaction_date')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="department">Departemen <span class="text-danger">*</span></label>
                        <input id="department" type="text" name="department" value="{{ old('department') }}" placeholder="Nama departemen" class="@error('department') is-invalid @enderror" required>
                        @error('department')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="recipient">Penerima <span class="text-danger">*</span></label>
                        <input id="recipient" type="text" name="recipient" value="{{ old('recipient') }}" placeholder="Nama penerima" class="@error('recipient') is-invalid @enderror" required>
                        @error('recipient')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field">
                        <label for="purpose">Keperluan <span class="text-muted fw-normal">(opsional)</span></label>
                        <input id="purpose" type="text" name="purpose" value="{{ old('purpose') }}" placeholder="Keperluan penggunaan">
                        @error('purpose')<span class="inv-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="inv-field full">
                        <label for="notes">Catatan Tambahan <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Catatan untuk transaksi ini...">{{ old('notes') }}</textarea>
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

                <div class="inv-table-actions">
                    <a href="{{ route('stock-out.index') }}" class="inv-button inv-button-outline">Batal</a>
                    <button type="submit" class="inv-button inv-button-primary"><span class="material-symbols-outlined">check</span>Simpan Transaksi</button>
                </div>
            </section>

            <aside class="inv-summary">
                <h2><span class="material-symbols-outlined align-middle me-1">receipt_long</span>Ringkasan Pengeluaran</h2>
                <div class="inv-summary-line"><span>Jumlah Baris</span><strong id="summary-lines">0</strong></div>
                <div class="inv-summary-line"><span>Total Kuantitas</span><strong id="summary-quantity">0 Item</strong></div>
                <div class="inv-alert error mt-3 mb-0"><span class="material-symbols-outlined">info</span><span>Pastikan jumlah tidak melebihi stok tersedia.</span></div>
            </aside>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        const barangs = @json($barangs->map(fn ($barang) => ['id' => $barang->id, 'label' => $barang->code . ' - ' . $barang->name . ' (stok ' . $barang->stock . ' ' . ($barang->unit->name ?? '') . ')'])->values());
        let rowIndex = 0;

        function updateSummary() {
            const rows = $('#items-body .inv-item-row');
            const quantity = rows.toArray().reduce((total, row) => total + (Number($(row).find('[data-item-quantity]').val()) || 0), 0);
            $('#item-row-count').text(rows.length + ' Baris');
            $('#summary-lines').text(rows.length + ' Baris');
            $('#summary-quantity').text(quantity.toLocaleString('id-ID') + ' Item');
        }

        function addRow() {
            const select = $('<select required>').addClass('inv-control').attr('name', `items[${rowIndex}][item_id]`);
            select.append(new Option('Pilih barang', ''));
            barangs.forEach(barang => select.append(new Option(barang.label, barang.id)));
            const quantity = $('<input type="number" min="1" value="1" required>').addClass('inv-control').attr({ name: `items[${rowIndex}][quantity]`, 'data-item-quantity': '' });
            const remove = $('<button type="button" title="Hapus baris" aria-label="Hapus baris">').addClass('inv-icon-button delete').append($('<span>').addClass('material-symbols-outlined').text('close'));
            $('#items-body').append($('<div>').addClass('inv-item-row stock-out-row').append(select, quantity, remove));
            rowIndex++;
            updateSummary();
        }

        $('#add-item-row').on('click', addRow);
        $('#items-body').on('click', '.inv-icon-button', function () { $(this).closest('.inv-item-row').remove(); updateSummary(); });
        $('#items-body').on('input change', '[data-item-quantity]', updateSummary);
        addRow();
    });
</script>
@endpush
@endsection