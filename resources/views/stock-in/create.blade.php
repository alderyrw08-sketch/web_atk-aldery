@extends('layouts.app')

@section('title', 'Tambah Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@section('content')
<div class="p-4 sm:p-8 min-h-[calc(100vh-72px)] bg-surface flex flex-col gap-6 max-w-[1440px] mx-auto w-full">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Persediaan &amp; Logistik</span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span class="font-label-sm text-label-sm text-primary font-bold">Transaksi</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-on-surface font-bold tracking-tight">Tambah Barang Masuk</h1>
            <nav class="flex items-center gap-1.5 text-body-sm font-body-sm text-on-surface-variant mt-0.5">
                <span>Transaksi</span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('stock-in.index') }}" class="text-primary font-semibold hover:underline">Barang Masuk</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-outline">Tambah Barang Masuk</span>
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('stock-in.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-surface-container-lowest text-on-surface-variant font-title-md text-title-md shadow-sm hover:bg-surface-container hover:text-on-surface transition-all border border-outline-variant/30">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-error-container text-on-error-container rounded-2xl shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-error text-[24px]">error</span>
            <div>
                <strong class="font-bold">Gagal menyimpan transaksi:</strong>
                <ul class="mb-0 mt-1 pl-4 text-xs list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('stock-in.store') }}" method="POST" id="stock-in-form">
        @csrf

        {{-- MAIN TWO COLUMN WORKSPACE --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- LEFT COLUMN: Main Form (~8 cols) --}}
            <div class="lg:col-span-8 flex flex-col gap-6">
                <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
                    <div class="h-1.5 w-full bg-[#E5B93C]"></div>

                    <div class="p-6 sm:p-8 flex flex-col gap-6">
                        {{-- Card Header --}}
                        <div class="flex items-center gap-3.5 pb-4 border-b border-surface-container">
                            <div class="w-10 h-10 rounded-xl bg-[#E0F2FE] text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">move_to_inbox</span>
                            </div>
                            <div>
                                <h2 class="font-title-lg text-title-lg font-bold text-on-surface leading-snug">Informasi Transaksi</h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Pencatatan penerimaan stok ATK dan logistik internal</p>
                            </div>
                        </div>

                        {{-- Metadata Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Tanggal --}}
                            <div>
                                <label for="transaction_date" class="block font-label-md text-label-md font-bold text-on-surface mb-1.5">Tanggal Penerimaan <span class="text-error">*</span></label>
                                <input
                                    type="date"
                                    id="transaction_date"
                                    name="transaction_date"
                                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                                    class="w-full px-3.5 py-2.5 rounded-xl border @error('transaction_date') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-xs font-semibold focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all"
                                    required
                                >
                            </div>

                            {{-- Supplier --}}
                            <div>
                                <label for="supplier_id" class="block font-label-md text-label-md font-bold text-on-surface mb-1.5">Supplier <span class="text-error">*</span></label>
                                <div class="relative">
                                    <select
                                        id="supplier_id"
                                        name="supplier_id"
                                        class="w-full px-3.5 py-2.5 rounded-xl border @error('supplier_id') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-xs font-medium appearance-none focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all pr-10 cursor-pointer"
                                        required
                                    >
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                                </div>
                            </div>

                            {{-- No Dokumen --}}
                            <div class="md:col-span-2">
                                <label for="document_number" class="block font-label-md text-label-md font-bold text-on-surface mb-1.5">Nomor Dokumen / Surat Jalan <span class="text-on-surface-variant font-normal">(opsional)</span></label>
                                <input
                                    type="text"
                                    id="document_number"
                                    name="document_number"
                                    value="{{ old('document_number') }}"
                                    placeholder="Contoh: SJ-2026/10/001 atau PO-998"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface text-xs font-medium focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                            </div>

                            {{-- Catatan --}}
                            <div class="md:col-span-2">
                                <label for="notes" class="block font-label-md text-label-md font-bold text-on-surface mb-1.5">Catatan Transaksi <span class="text-on-surface-variant font-normal">(opsional)</span></label>
                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="2"
                                    placeholder="Keterangan tambahan penerimaan barang atau kondisi kemasan..."
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface text-xs font-medium focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all resize-none"
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        {{-- DETAIL BARANG SECTION --}}
                        <div class="pt-4 border-t border-surface-container flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-title-md text-title-md font-bold text-on-surface">Detail Barang Diterima</h3>
                                    <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant font-semibold" id="badge-row-count">0 Baris</span>
                                </div>
                                <button type="button" id="btn-add-row" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant hover:bg-primary-container hover:text-white font-label-md text-label-md font-semibold transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    <span>Tambah Baris</span>
                                </button>
                            </div>

                            {{-- Items Table --}}
                            <div class="overflow-x-auto rounded-xl border border-outline-variant/30">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead class="bg-primary-fixed/40 text-on-primary-fixed-variant uppercase font-bold text-[11px]">
                                        <tr>
                                            <th class="py-3 px-3 w-12 text-center">No</th>
                                            <th class="py-3 px-3">Barang / ATK</th>
                                            <th class="py-3 px-3 w-28 text-center">Jumlah</th>
                                            <th class="py-3 px-3 w-36 text-right">Harga Satuan (Rp)</th>
                                            <th class="py-3 px-3 w-36 text-right">Subtotal (Rp)</th>
                                            <th class="py-3 px-3 w-16 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-tbody" class="divide-y divide-surface-container">
                                        {{-- Dynamic rows inserted by JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- FOOTER ACTION BUTTONS --}}
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container">
                            <a href="{{ route('stock-in.index') }}" class="px-6 py-2.5 rounded-full bg-surface-container-low hover:bg-surface-container text-on-surface-variant font-title-md text-title-md transition-all">
                                Batal
                            </a>
                            <button type="submit" class="px-7 py-3 rounded-full bg-primary-container hover:bg-primary text-white font-title-md text-title-md flex items-center gap-2 shadow-md transition-all active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]">check</span>
                                <span>Simpan Transaksi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Sticky Summary & SOP (~4 cols) --}}
            <div class="lg:col-span-4 flex flex-col gap-6 lg:sticky lg:top-24">
                {{-- Summary Card --}}
                <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4">
                    <div class="flex items-center justify-between pb-3 border-b border-surface-container">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[22px]">receipt_long</span>
                            <h3 class="font-title-lg text-title-lg font-bold text-on-surface">Ringkasan</h3>
                        </div>
                        <span class="font-label-sm text-label-sm px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-bold">PENERIMAAN</span>
                    </div>

                    {{-- Micro-stat tiles --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-on-surface-variant text-[11px] font-semibold">Jumlah Baris</span>
                            <span class="font-title-lg text-title-lg font-bold text-on-surface" id="summary-rows">0 Baris</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-on-surface-variant text-[11px] font-semibold">Total Kuantitas</span>
                            <span class="font-title-lg text-title-lg font-bold text-secondary" id="summary-qty">0 Item</span>
                        </div>
                    </div>

                    {{-- Total Value Hero Display --}}
                    <div class="p-4 rounded-xl bg-gradient-to-br from-surface-container-low to-surface-container border border-outline-variant/30 flex flex-col gap-1.5 shadow-inner">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-bold">Total Estimasi Nilai</span>
                            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-tertiary font-bold bg-tertiary-fixed/30 border border-tertiary/20 px-2 py-0.5 rounded-full">
                                <span class="material-symbols-outlined text-[13px]">verified</span>
                                <span>Valid</span>
                            </span>
                        </div>
                        <span class="font-headline-md text-headline-md text-primary font-bold tracking-tight" id="summary-total">Rp 0</span>
                    </div>
                </div>

                {{-- SOP / Guidance Card --}}
                <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-primary font-bold text-sm">
                        <span class="material-symbols-outlined text-[20px]">info</span>
                        <span>Petunjuk Penerimaan ATK</span>
                    </div>
                    <ul class="text-xs text-on-surface-variant space-y-2 list-disc pl-4 leading-relaxed">
                        <li>Pastikan fisik barang sesuai dengan surat jalan supplier.</li>
                        <li>Stok barang akan otomatis bertambah setelah transaksi disimpan.</li>
                        <li>Harga satuan digunakan untuk kalkulasi nilai aset persediaan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@php
    $barangsPayload = $barangs->map(function ($b) {
        return [
            'id' => $b->id,
            'code' => $b->code,
            'name' => $b->name,
            'unit' => $b->unit->name ?? 'UNIT',
        ];
    })->values();
@endphp
<script>
document.addEventListener('DOMContentLoaded', function () {
    const barangs = @json($barangsPayload);

    const tbody = document.getElementById('items-tbody');
    const btnAdd = document.getElementById('btn-add-row');
    let rowIndex = 0;

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function recalculateSummary() {
        const rows = tbody.querySelectorAll('tr');
        let totalLines = rows.length;
        let totalQuantity = 0;
        let grandTotal = 0;

        rows.forEach((row, idx) => {
            const noCell = row.querySelector('.row-number');
            if (noCell) noCell.textContent = idx + 1;

            const qty = Number(row.querySelector('.row-qty')?.value) || 0;
            const price = Number(row.querySelector('.row-price')?.value) || 0;
            const subtotal = qty * price;

            const subtotalEl = row.querySelector('.row-subtotal');
            if (subtotalEl) subtotalEl.textContent = formatRupiah(subtotal);

            totalQuantity += qty;
            grandTotal += subtotal;
        });

        document.getElementById('badge-row-count').textContent = totalLines + ' Baris';
        document.getElementById('summary-rows').textContent = totalLines + ' Baris';
        document.getElementById('summary-qty').textContent = totalQuantity.toLocaleString('id-ID') + ' Item';
        document.getElementById('summary-total').textContent = formatRupiah(grandTotal);
    }

    function addRow() {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-surface-container/30 transition-colors';

        let barangOptions = '<option value="">-- Pilih Barang --</option>';
        barangs.forEach(b => {
            barangOptions += `<option value="${b.id}" data-unit="${b.unit}">${b.code} - ${b.name} (${b.unit})</option>`;
        });

        tr.innerHTML = `
            <td class="py-3 px-3 text-center font-bold text-on-surface-variant row-number">${tbody.children.length + 1}</td>
            <td class="py-3 px-3">
                <select name="items[${rowIndex}][item_id]" class="w-full px-3 py-2 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-xs font-medium focus:outline-none focus:border-primary-container" required>
                    ${barangOptions}
                </select>
            </td>
            <td class="py-3 px-3">
                <div class="relative">
                    <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" class="row-qty w-full px-3 py-2 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-xs font-bold text-center focus:outline-none focus:border-primary-container" required>
                </div>
            </td>
            <td class="py-3 px-3">
                <input type="number" name="items[${rowIndex}][price]" value="0" min="0" step="100" class="row-price w-full px-3 py-2 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-xs font-semibold text-right focus:outline-none focus:border-primary-container" required>
            </td>
            <td class="py-3 px-3 text-right font-mono font-bold text-primary row-subtotal">Rp 0</td>
            <td class="py-3 px-3 text-center">
                <button type="button" class="btn-remove-row w-8 h-8 rounded-full bg-error-container text-error hover:bg-error hover:text-white inline-flex items-center justify-center transition-colors" title="Hapus Baris">
                    <span class="material-symbols-outlined text-[17px]">delete</span>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        rowIndex++;

        // Attach event listeners
        tr.querySelector('.row-qty').addEventListener('input', recalculateSummary);
        tr.querySelector('.row-price').addEventListener('input', recalculateSummary);
        tr.querySelector('.btn-remove-row').addEventListener('click', function () {
            tr.remove();
            recalculateSummary();
        });

        recalculateSummary();
    }

    btnAdd.addEventListener('click', addRow);

    // Initial first row
    addRow();
});
</script>
@endpush
