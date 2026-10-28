@extends('layouts.app')

@section('title', 'Detail Barang Masuk | Sistem ATK')
@section('page-title', 'Barang Masuk')

@section('content')
@php
    $totalQuantity = $stockIn->details->sum('quantity');
    $totalValue = $stockIn->details->sum(fn ($detail) => $detail->quantity * $detail->price);
@endphp

<div class="p-4 sm:p-8 min-h-[calc(100vh-72px)] bg-surface flex flex-col gap-6 max-w-[1440px] mx-auto w-full">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Persediaan &amp; Logistik</span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span class="font-label-sm text-label-sm text-primary font-bold">Transaksi</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-on-surface font-bold tracking-tight">Detail Barang Masuk</h1>
            <nav class="flex items-center gap-1.5 text-body-sm font-body-sm text-on-surface-variant mt-0.5">
                <span>Transaksi</span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('stock-in.index') }}" class="text-primary font-semibold hover:underline">Barang Masuk</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-outline font-mono">{{ $stockIn->transaction_number }}</span>
            </nav>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm" onclick="window.print()">
                <span class="material-symbols-outlined text-[18px] text-primary">print</span>
                <span>Cetak Bukti</span>
            </button>
            <a href="{{ route('stock-in.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-surface-container-lowest text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm border border-outline-variant/30">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- TWO COLUMN WORKSPACE --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- LEFT COLUMN (~8 cols) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
                <div class="h-1.5 w-full bg-[#E5B93C]"></div>

                <div class="p-6 sm:p-8 flex flex-col gap-6">
                    {{-- Header Transaksi --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-surface-container">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#E0F2FE] text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">move_to_inbox</span>
                            </div>
                            <div>
                                <h2 class="font-title-lg text-title-lg font-mono font-bold text-primary">{{ $stockIn->transaction_number }}</h2>
                                <p class="text-xs text-on-surface-variant">Transaksi penerimaan persediaan barang</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $stockIn->status === 'Active' ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-error-container text-on-error-container' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $stockIn->status === 'Active' ? 'bg-tertiary' : 'bg-error' }}"></span>
                            {{ $stockIn->status === 'Active' ? 'Aktif' : 'Dibatalkan' }}
                        </span>
                    </div>

                    {{-- Metadata Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-[11px] font-semibold text-on-surface-variant uppercase">Tanggal Penerimaan</span>
                            <span class="text-xs font-bold text-on-surface">{{ $stockIn->transaction_date->format('d-m-Y') }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-[11px] font-semibold text-on-surface-variant uppercase">Supplier</span>
                            <span class="text-xs font-bold text-on-surface">{{ $stockIn->supplier->name ?? '-' }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-[11px] font-semibold text-on-surface-variant uppercase">Nomor Dokumen</span>
                            <span class="text-xs font-bold text-on-surface">{{ $stockIn->document_number ?: '-' }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/20 flex flex-col gap-1">
                            <span class="text-[11px] font-semibold text-on-surface-variant uppercase">Petugas Penerima</span>
                            <span class="text-xs font-bold text-on-surface">{{ $stockIn->user->name ?? '-' }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/20 flex flex-col gap-1 sm:col-span-2">
                            <span class="text-[11px] font-semibold text-on-surface-variant uppercase">Catatan</span>
                            <span class="text-xs font-medium text-on-surface">{{ $stockIn->notes ?: '-' }}</span>
                        </div>
                    </div>

                    {{-- Table Detail Barang --}}
                    <div class="flex flex-col gap-3 pt-2">
                        <div class="flex items-center justify-between">
                            <h3 class="font-title-md text-title-md font-bold text-on-surface">Daftar Barang Masuk</h3>
                            <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant font-semibold">{{ $stockIn->details->count() }} Baris</span>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-outline-variant/30">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead class="bg-primary-fixed/40 text-on-primary-fixed-variant uppercase font-bold text-[11px]">
                                    <tr>
                                        <th class="py-3 px-3 text-center w-12">No</th>
                                        <th class="py-3 px-3 w-28 text-center">Kode</th>
                                        <th class="py-3 px-3">Nama Barang</th>
                                        <th class="py-3 px-3 text-center w-28">Jumlah</th>
                                        <th class="py-3 px-3 text-right w-36">Harga Satuan</th>
                                        <th class="py-3 px-3 text-right w-36">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container">
                                    @forelse ($stockIn->details as $idx => $detail)
                                        <tr class="hover:bg-surface-container/30 transition-colors">
                                            <td class="py-3 px-3 text-center font-bold text-on-surface-variant">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-3 text-center font-mono font-bold text-primary">{{ $detail->item->code ?? '-' }}</td>
                                            <td class="py-3 px-3 font-semibold text-on-surface">{{ $detail->item->name ?? '-' }}</td>
                                            <td class="py-3 px-3 text-center font-bold text-on-surface">{{ number_format($detail->quantity) }} {{ $detail->item->unit->name ?? '' }}</td>
                                            <td class="py-3 px-3 text-right font-mono text-on-surface-variant">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td class="py-3 px-3 text-right font-mono font-bold text-primary">Rp {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-6 text-on-surface-variant">Tidak ada detail barang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-surface-container">
                        <a href="{{ route('stock-in.index') }}" class="px-5 py-2.5 rounded-full bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-all">
                            Kembali ke Daftar
                        </a>
                        @if ($stockIn->status === 'Active')
                            @can('barang-masuk.delete')
                                <form action="{{ route('stock-in.cancel', $stockIn->id) }}" method="POST"
                                    data-confirm-title="Batalkan transaksi barang masuk?"
                                    data-confirm-message="Kuantitas stok pada transaksi ini akan dikurangi dari persediaan."
                                    data-confirm-action="Batalkan Transaksi"
                                    data-confirm-icon="cancel"
                                    data-confirm-tone="warning"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-5 py-2.5 rounded-full bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold flex items-center gap-1.5 transition-all">
                                        <span class="material-symbols-outlined text-[17px]">cancel</span>
                                        <span>Batalkan Transaksi</span>
                                    </button>
                                </form>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN (~4 cols) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            {{-- Summary Card --}}
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4">
                <div class="flex items-center justify-between pb-3 border-b border-surface-container">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">receipt_long</span>
                        <h3 class="font-title-lg text-title-lg font-bold text-on-surface">Ringkasan</h3>
                    </div>
                    <span class="font-label-sm text-label-sm px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-bold">PENERIMAAN</span>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between text-xs py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant font-medium">Jumlah Baris</span>
                        <span class="font-bold text-on-surface">{{ $stockIn->details->count() }} Baris</span>
                    </div>
                    <div class="flex items-center justify-between text-xs py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant font-medium">Total Kuantitas</span>
                        <span class="font-bold text-secondary">{{ number_format($totalQuantity) }} Item</span>
                    </div>
                    <div class="flex items-center justify-between text-xs py-1">
                        <span class="text-on-surface-variant font-medium">Total Estimasi Nilai</span>
                        <span class="font-headline-sm text-headline-sm font-bold text-primary">Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
